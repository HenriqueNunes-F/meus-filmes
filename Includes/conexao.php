

<?php
$host = 'localhost';
$usuario = 'root';
$senha = ''; // Deixe em branco se o root não tiver senha
$banco = 'meus_filmes';

// Criação da conexão
$conn = new mysqli('localhost:3307', 'root', '', 'meus_filmes');

// Verifique se houve erro na conexão
if ($conn->connect_error) {
    die("Erro ao conectar: " . $conn->connect_error); // Exibe mensagem de erro se houver falha na conexão
}
?>
