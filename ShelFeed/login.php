<?php
session_start();
require 'supabase.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = strtolower(trim($_POST['email'] ?? ''));
    $senha = $_POST['senha'] ?? '';

    if (empty($email) || empty($senha)) {
        $erro = "Preencha todos os campos!";
    } else {
        // Endpoint sem aspas, já que funcionou no teste
        $endpoint = 'usuarios?email=eq.' . rawurlencode($email);
        $usuarios = supabaseRequest($endpoint);

        if (!empty($usuarios) && isset($usuarios[0]['password'])) {
            $usuario = $usuarios[0];

            if (password_verify($senha, $usuario['password'])) {
                session_regenerate_id(true);
                $_SESSION['user_id'] = $usuario['id_user'];
                $_SESSION['username'] = $usuario['username'];
                $_SESSION['email'] = $usuario['email'];

                header('Location: home.html');
                exit();
            } else {
                $erro = "Email ou senha incorretos!";
            }
        } else {
            $erro = "Email ou senha incorretos!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="login-container">
    <h2>Login</h2>

    <?php
    if (!empty($erro)) {
        echo '<div style="color:red;margin-bottom:20px;">' . htmlspecialchars($erro) . '</div>';
    }
    ?>

    <form action="login.php" method="POST">
      <label>Email:</label>
      <input type="email" name="email" placeholder="Digite seu email" required>
      <label>Senha:</label>
      <input type="password" name="senha" placeholder="Digite sua senha" required>
      <button type="submit">Logar</button>
    </form>

    <p>Ainda não possui cadastro? <a href="registro.php">Clique aqui</a></p>
  </div>
</body>
</html>
