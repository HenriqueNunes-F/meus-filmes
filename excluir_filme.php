<?php
require_once 'includes/funcoes.php';
protegerPagina();
require_once 'includes/conexao.php';

$id = (int)$_GET['id'];
$usuario_id = $_SESSION['usuario_id'];

// Verifica se o filme pertence ao usuário
$stmt = $conn->prepare("DELETE FROM filmes WHERE id = ? AND usuario_id = ?");
$stmt->bind_param("ii", $id, $usuario_id);
$stmt->execute();

header("Location: filmes.php");
exit();
