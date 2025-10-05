<?php
require 'supabase.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $sinopse = $_POST['sinopse'];
    $genero = $_POST['genero'];
    $autor = $_POST['autor'];

    $data = [
        "titulo" => $titulo,
        "sinopse" => $sinopse,
        "genero" => $genero,
        "autor" => $autor
    ];

    $response = supabaseRequest("livros", "POST", $data);

    if ($response) {
        echo "<p style='color:green'>Livro cadastrado com sucesso!</p>";
    } else {
        echo "<p style='color:red'>Erro ao cadastrar o livro!</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Cadastrar Livro</title>
</head>
<body>
<h2>Cadastrar Novo Livro</h2>
<form method="POST">
    <label>Título:</label><br>
    <input type="text" name="titulo" required><br><br>

    <label>Sinopse:</label><br>
    <textarea name="sinopse" rows="5" cols="40" required></textarea><br><br>

    <label>Gênero:</label><br>
    <input type="text" name="genero" required><br><br>

    <label>Autor:</label><br>
    <input type="text" name="autor" required><br><br>

    <button type="submit">Salvar Livro</button>
</form>

<a href="livros_list.php">📚 Ver Todos os Livros</a>
</body>
</html>
