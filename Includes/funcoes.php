<?php
// Verifica se a sessão foi iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Inicia a sessão se não estiver ativa
}

// Função para proteger páginas e redirecionar usuários não autenticados
function protegerPagina() {
    // Verifica se o usuário não está autenticado
    if (empty($_SESSION['usuario_id'])) {
        header("Location: index.php"); // Redireciona para o login se não estiver autenticado
        exit();
    }
}

// Função para validar o login do usuário
function validarLogin($login, $senha, $conn) {
    // Preparando a consulta para pegar o id e a senha criptografada
    $stmt = $conn->prepare("SELECT id, senha FROM usuarios WHERE login = ?");
    if (!$stmt) {
        die("Erro na preparação da consulta: " . $conn->error); // Verifica se houve erro ao preparar a consulta
    }

    // Ligando o parâmetro do login
    $stmt->bind_param("s", $login);
    $stmt->execute();
    $stmt->store_result();

    $id = null;
    $hash = null;

    // Verifica se o login existe no banco
    if ($stmt->num_rows === 1) {
        $stmt->bind_result($id, $hash);
        $stmt->fetch();

        // Verifica se a senha fornecida corresponde ao hash armazenado
        if (password_verify($senha, $hash)) {
            $stmt->close();
            return $id; // Retorna o ID do usuário caso a senha esteja correta
        }
    }
    
    $stmt->close();
    
    // Se o login ou senha estiverem incorretos
    return false;
}
?>