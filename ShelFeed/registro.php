<?php
session_start();
require 'supabase.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $username = $_POST['username'];
    $senha = $_POST['senha'];
    $senha2 = $_POST['senha2'];

    if ($senha !== $senha2) {
        $erro = "As senhas não coincidem!";
    } elseif (strlen($senha) < 6) {
        $erro = "A senha deve ter pelo menos 6 caracteres!";
    } else {
        // Verifica se email já existe
        $existing = supabaseRequest("usuarios?email=eq.$email");
        if (!empty($existing)) {
            $erro = "Este email já está cadastrado!";
        } else {
            // Verifica se username já existe
            $existingUser = supabaseRequest("usuarios?username=eq.$username");
            if (!empty($existingUser)) {
                $erro = "Este nome de usuário já está em uso!";
            } else {
                // Cria usuário
                $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
                $novo = supabaseRequest("usuarios", "POST", [
                    "email" => $email,
                    "username" => $username,
                    "password" => $senha_hash
                ]);
                $sucesso = "Cadastro realizado com sucesso! <a href='login.php'>Faça login aqui</a>";
            }
        }
    }
}
?>



<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registro</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="login-container">
    <h2>Registro</h2>

    <?php
    session_start();
    if (isset($_SESSION['erro'])) {
        echo '<div style="color:red;margin-bottom:20px;">'.$_SESSION['erro'].'</div>';
        unset($_SESSION['erro']);
    }
    if (isset($_SESSION['sucesso'])) {
        echo '<div style="color:green;margin-bottom:20px;">'.$_SESSION['sucesso'].'</div>';
        unset($_SESSION['sucesso']);
    }
    ?>

    <form action="registro.php" method="POST">
      <label>Email:</label>
      <input type="email" name="email" required>
      <label>Nome de usuário:</label>
      <input type="text" name="username" required>
      <label>Senha:</label>
      <input type="password" name="senha" required>
      <label>Repita a senha:</label>
      <input type="password" name="senha2" required>
      <button type="submit">Registrar-se</button>
    </form>
    <p>Já possui cadastro? <a href="login.php">Clique aqui</a></p>
  </div>
</body>
</html>
