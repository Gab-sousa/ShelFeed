<?php
session_start();
require 'supabase.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Busca usuário no Supabase
    $usuarios = supabaseRequest("usuarios?email=eq.$email");

    if (!empty($usuarios)) {
        $usuario = $usuarios[0];
        if (password_verify($senha, $usuario['password'])) {
            $_SESSION['usuario'] = $usuario;
            header('Location: dashboard.php');
            exit();
        } else {
            $erro = "Email ou senha incorretos!";
        }
    } else {
        $erro = "Email ou senha incorretos!";
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
    session_start();
    if (isset($_SESSION['erro'])) {
        echo '<div style="color:red;margin-bottom:20px;">'.$_SESSION['erro'].'</div>';
        unset($_SESSION['erro']);
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
