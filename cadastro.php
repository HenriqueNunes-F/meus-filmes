<?php
// Inclui o arquivo de conexão e inicia a sessão para mensagens de feedback
require_once 'includes/conexao.php';
session_start();

$msg = ''; // Variável para armazenar mensagens de erro para o usuário

// Processa o formulário apenas se o método for POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1. LIMPEZA E VALIDAÇÃO DOS DADOS DE ENTRADA
    $login = trim($_POST['login'] ?? '');
    $senha = $_POST['senha'] ?? '';
    $email = trim($_POST['email'] ?? '');

    // Validações básicas
    if (empty($login) || empty($senha) || empty($email)) {
        $msg = "Por favor, preencha todos os campos.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $msg = "O formato do e-mail é inválido.";
    } elseif (strlen($senha) < 6) {
        $msg = "A senha deve ter no mínimo 6 caracteres.";
    } else {
        try {
            // 2. VERIFICAÇÃO DE DUPLICIDADE (LOGIN E E-MAIL)
            $stmt = $conn->prepare("SELECT login, email FROM usuarios WHERE login = ? OR email = ?");
            $stmt->bind_param("ss", $login, $email);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                // Se encontrou algum resultado, verifica qual campo é o duplicado
                $existingUser = $result->fetch_assoc();
                if ($existingUser['login'] === $login) {
                    $msg = "Este nome de login já está em uso. Por favor, escolha outro.";
                } elseif ($existingUser['email'] === $email) {
                    $msg = "Este e-mail já está cadastrado. Por favor, use outro.";
                }
            } else {
                // 3. INSERÇÃO DO NOVO USUÁRIO (SE NÃO HOUVER DUPLICIDADE)
                // Criptografa a senha com o algoritmo mais recomendado atualmente
                $senhaHash = password_hash($senha, PASSWORD_ARGON2ID);

                $stmt_insert = $conn->prepare("INSERT INTO usuarios (login, senha, email) VALUES (?, ?, ?)");
                $stmt_insert->bind_param("sss", $login, $senhaHash, $email);
                
                if ($stmt_insert->execute()) {
                    // Após o sucesso, redireciona para a página de login (index.php)
                    $_SESSION['msg_sucesso'] = "Cadastro realizado com sucesso! Faça o login.";
                    header("Location: index.php");
                    exit();
                }
            }
            $stmt->close(); // Fecha o statement de verificação
        } catch (mysqli_sql_exception $e) {
            // Captura erros inesperados do banco de dados
            // Em ambiente de produção, logar o erro em um arquivo, não exibir para o usuário
            error_log($e->getMessage());
            $msg = "Ocorreu um erro no servidor. Tente novamente mais tarde.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - Meus Filmes</title>
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
    <nav>
        <a href="index.php">Ir para a Home</a>
    </nav>

    <div class="form-container">
        <h2>Cadastrar Novo Usuário</h2>
        <form method="post" action="cadastro.php">
            <input type="text" name="login" placeholder="Login" required value="<?= htmlspecialchars($login ?? '') ?>">
            <input type="password" name="senha" placeholder="Senha" required>
            <input type="email" name="email" placeholder="Email" required value="<?= htmlspecialchars($email ?? '') ?>">
            <button type="submit">Cadastrar</button>
        </form>
        <?php if ($msg): ?>
            <p class="mensagem-erro"><?= $msg ?></p>
        <?php endif; ?>
    </div>
</body>
</html>