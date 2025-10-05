<?php
require 'supabase.php';

// Se o usuário pesquisou
$pesquisa = $_GET['busca'] ?? '';

if ($pesquisa) {
    $pesquisa = urlencode("%$pesquisa%");
    $livros = supabaseRequest("livros?titulo=ilike.$pesquisa");
} else {
    $livros = supabaseRequest("livros");
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Lista de Livros</title>
</head>
<body>
<h2>📚 Lista de Livros</h2>

<form method="GET">
    <input type="text" name="busca" placeholder="Pesquisar livro..." value="<?= htmlspecialchars($_GET['busca'] ?? '') ?>">
    <button type="submit">🔍 Buscar</button>
</form>

<a href="livros_create.php">➕ Adicionar Novo Livro</a>
<br><br>

<?php if ($livros): ?>
    <?php foreach ($livros as $livro): ?>
        <div style="border:1px solid #ccc; padding:10px; margin:10px;">
            <h3><?= htmlspecialchars($livro['titulo']) ?></h3>
            <p><strong>Autor:</strong> <?= htmlspecialchars($livro['autor']) ?></p>
            <p><strong>Gênero:</strong> <?= htmlspecialchars($livro['genero']) ?></p>
            <p><?= htmlspecialchars($livro['sinopse']) ?></p>
            <a href="livros_view.php?id=<?= $livro['id'] ?>">👁 Ver Detalhes</a> |
            <a href="livros_delete.php?id=<?= $livro['id'] ?>" onclick="return confirm('Tem certeza que deseja excluir este livro?')">🗑 Excluir</a>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p>Nenhum livro encontrado.</p>
<?php endif; ?>
</body>
</html>
