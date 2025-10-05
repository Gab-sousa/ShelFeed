<?php
if (isset($_POST['nomeLivro'])) {
    $nomeLivro = urlencode($_POST['nomeLivro']);
    $url = "https://www.googleapis.com/books/v1/volumes?q={$nomeLivro}";

    $json = file_get_contents($url);
    $data = json_decode($json, true);

    if ($data['totalItems'] === 0) {
        echo "<p>Nenhum livro encontrado.</p>";
        exit;
    }

    $livro = $data['items'][0]['volumeInfo'];
    $titulo = $livro['title'] ?? 'Sem título';
    $autores = isset($livro['authors']) ? implode(', ', $livro['authors']) : 'Autor desconhecido';
    $descricao = $livro['description'] ?? 'Sem descrição disponível';

    echo "<h2>{$titulo}</h2>";
    echo "<p><strong>Autor(es):</strong> {$autores}</p>";
    echo "<p><strong>Descrição:</strong> {$descricao}</p>";
} else {
    echo "<p>Por favor, envie o nome do livro.</p>";
}
?>
