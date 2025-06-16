<?php
require_once 'includes/funcoes.php';
protegerPagina();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = trim($_POST['titulo']);
    $descricao = trim($_POST['descricao']);

    if ($titulo && $descricao) {
        require_once 'includes/conexao.php';
        $stmt = $conn->prepare("INSERT INTO filmes (usuario_id, titulo, descricao) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $_SESSION['usuario_id'], $titulo, $descricao);
        $stmt->execute();
        header("Location: filmes.php");
        exit();
    } else {
        $msg = "Preencha todos os campos.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>Novo Filme</title>
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
    <h2>Cadastrar Novo Filme</h2>
    <form method="post">
        <input type="text" name="titulo" placeholder="Título"><br>
        <textarea name="descricao" placeholder="Descrição"></textarea><br>
        <button type="submit">Salvar</button>
    </form>
    <p><?= $msg ?? '' ?></p>
    <a href="dashboard.php">Voltar</a>
</body>
</html>
