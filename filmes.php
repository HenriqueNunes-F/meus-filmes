<?php
require_once 'includes/funcoes.php';
protegerPagina();
require_once 'includes/conexao.php';

$usuario_id = $_SESSION['usuario_id'];
$result = $conn->query("SELECT * FROM filmes WHERE usuario_id = $usuario_id ORDER BY data_criacao DESC");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>Meus Filmes</title>
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
    <h2>🎞️ Meus Filmes</h2>
    <ul>
        <?php while ($filme = $result->fetch_assoc()): ?>
            <li>
                <strong><?= htmlspecialchars($filme['titulo']) ?></strong><br>
                <?= nl2br(htmlspecialchars($filme['descricao'])) ?><br>
                <a href="excluir_filme.php?id=<?= $filme['id'] ?>" onclick="return confirm('Excluir este filme?')">🗑️ Excluir</a>
            </li>
        <?php endwhile; ?>
    </ul>
    <a href="dashboard.php">Voltar</a>
</body>
</html>
