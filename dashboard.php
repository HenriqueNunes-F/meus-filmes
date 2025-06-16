<?php
require_once 'includes/funcoes.php';
protegerPagina();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>Dashboard - Meus Filmes</title>
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
    <h2>Bem-vindo ao Gerenciador de Filmes 🎬</h2>
    <nav>
        <a href="novo_filme.php">➕ Cadastrar Filme</a> |
        <a href="filmes.php">🎥 Ver Meus Filmes</a> |
        <a href="logout.php">🚪 Logout</a>
    </nav>
</body>
</html>
