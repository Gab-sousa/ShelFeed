<?php
require 'supabase.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    die("ID inválido.");
}

// Apaga o livro pelo ID
$response = supabaseRequest("livros?id=eq.$id", "DELETE");

if ($response === null) {
    echo "<p style='color:green'>Livro excluído com sucesso!</p>";
} else {
    echo "<p style='color:red'>Erro ao excluir o livro!</p>";
}

echo "<a href='livros_list.php'>⬅ Voltar</a>";
?>
