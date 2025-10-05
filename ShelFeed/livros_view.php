<?php
require 'supabase.php';

session_start();
if (!isset($_SESSION['user_id'])) {
    die("Você precisa estar logado para comentar.");
}

$id = $_GET['id'] ?? null;
if (!$id) {
    die("Livro não encontrado!");
}

// Buscar livro
$livro = supabaseRequest("livros?id=eq.$id")[0] ?? null;

// Novo comentário
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comentario'])) {
    $comentario = substr(trim($_POST['comentario']), 0, 500);
    $avaliacao = max(0, min(5, (int)$_POST['avaliacao']));

    $data = [
        "livro_id" => $id,
        "comentario" => $comentario,
        "avaliacao" => $avaliacao,
        "user_id" => $_SESSION['user_id'],
        "username" => $_SESSION['username']
    ];
    supabaseRequest("comentarios", "POST", $data);

    header("Location: livros_view.php?id=$id"); // evita reenvio
    exit();
}

// Buscar comentários
$comentarios = supabaseRequest("comentarios?livro_id=eq.$id");
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title><?= htmlspecialchars($livro['titulo'] ?? 'Livro não encontrado') ?></title>
</head>
<body>
<?php if ($livro): ?>
    <h2><?= htmlspecialchars($livro['titulo']) ?></h2>
    <p><strong>Autor:</strong> <?= htmlspecialchars($livro['autor']) ?></p>
    <p><strong>Gênero:</strong> <?= htmlspecialchars($livro['genero']) ?></p>
    <p><?= htmlspecialchars($livro['sinopse']) ?></p>

    <hr>
    <h3>💬 Comentários e Avaliações</h3>

    <form method="POST">
        <textarea name="comentario" rows="3" cols="50" required placeholder="Deixe seu comentário..."></textarea><br>
        <label>Avaliação (0-5):</label>
        <input type="number" name="avaliacao" min="0" max="5" required><br><br>
        <button type="submit">Enviar</button>
    </form>

    <br>
    <?php if ($comentarios): ?>
        <?php foreach ($comentarios as $c): ?>
    <div style="border:1px solid #ddd; padding:10px; margin:10px;">
        <p><strong><?= htmlspecialchars($c['username'] ?? 'Anônimo') ?>:</strong> <?= htmlspecialchars($c['comentario']) ?></p>
        <p>⭐ <?= $c['avaliacao'] ?>/5</p>
    </div>
<?php endforeach; ?>
    <?php else: ?>
        <p>Nenhum comentário ainda.</p>
    <?php endif; ?>

<?php else: ?>
    <p>Livro não encontrado!</p>
<?php endif; ?>

<br>
<a href="livros_list.php">⬅ Voltar</a>
</body>
</html>
