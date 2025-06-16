<?php
session_start();
require_once 'includes/conexao.php';
require_once 'includes/funcoes.php';

$msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login']);
    $senha = $_POST['senha'];

    if ($login && $senha) {
        $usuario_id = validarLogin($login, $senha, $conn);
        if ($usuario_id) {
            $_SESSION['usuario_id'] = $usuario_id;
            header("Location: dashboard.php");
            exit();
        } else {
            $msg = "Login ou senha inválidos.";
        }
    } else {
        $msg = "Preencha todos os campos.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>Login - Meus Filmes</title>
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
    <h2>Login</h2>
    <form method="post">
        <input type="text" name="login" placeholder="Login"><br>
        <input type="password" name="senha" placeholder="Senha"><br>
        <a href="cadastro.php">Cadastrar novo usuário</a>
        <button type="submit">Entrar</button>
    </form>
    <p><?= $msg ?></p>
    
</body>
</html>
