<?php
// login.php
session_start();
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    
    try {
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($usuario && password_verify($senha, $usuario['password'])) {
            $_SESSION['usuario'] = $usuario;
            header('Location: dashboard.php');
            exit();
        } else {
            $erro = "Email ou senha incorretos!";
        }
    } catch (PDOException $e) {
        $erro = "Erro ao fazer login: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" type="text/css" href="style.css" media="screen"/>
</head>
<body>
  <div class="login-container">
    <h2>Login</h2>
    
    <?php if (isset($erro)): ?>
        <div style="color: red; margin-bottom: 20px;"><?php echo $erro; ?></div>
    <?php endif; ?>
    
    <form method="POST">
      <label for="email">Email:</label>
      <input type="email" name="email" id="email" placeholder="Digite seu email" required>

      <label for="senha">Senha:</label>
      <input type="password" name="senha" id="senha" placeholder="Digite sua senha" required>

      <div class="forgot-password">Esqueci a senha</div>

      <button type="submit" class="login-btn">Logar</button>
    </form>
    <a href="registro.php">
      <p class="signup-text">Ainda não possui cadastro?</p>
    </a>
  </div>
</body>
</html>