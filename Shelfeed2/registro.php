<?php
// registro.php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $username = $_POST['username'];
    $senha = $_POST['senha'];
    $senha2 = $_POST['senha2'];
    
    // Validações
    if ($senha !== $senha2) {
        $erro = "As senhas não coincidem!";
    } else if (strlen($senha) < 6) {
        $erro = "A senha deve ter pelo menos 6 caracteres!";
    } else {
        try {
            // Verifica se email já existe
            $stmt = $pdo->prepare("SELECT id_user FROM usuarios WHERE email = ?");
            $stmt->execute([$email]);
            
            if ($stmt->rowCount() > 0) {
                $erro = "Este email já está cadastrado!";
            } else {
                // Verifica se username já existe
                $stmt = $pdo->prepare("SELECT id_user FROM usuarios WHERE username = ?");
                $stmt->execute([$username]);
                
                if ($stmt->rowCount() > 0) {
                    $erro = "Este nome de usuário já está em uso!";
                } else {
                    // Insere novo usuário
                    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
                    $stmt = $pdo->prepare("INSERT INTO usuarios (email, username, password) VALUES (?, ?, ?)");
                    $stmt->execute([$email, $username, $senha_hash]);
                    
                    $sucesso = "Cadastro realizado com sucesso! <a href='login.php'>Faça login aqui</a>";
                }
            }
        } catch (PDOException $e) {
            $erro = "Erro ao cadastrar: " . $e->getMessage();
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
  <link rel="stylesheet" type="text/css" href="style.css" media="screen"/>
</head>
<body>
  <div class="login-container">
    <h2>Registro</h2>
    
    <?php if (isset($erro)): ?>
        <div style="color: red; margin-bottom: 20px;"><?php echo $erro; ?></div>
    <?php endif; ?>
    
    <?php if (isset($sucesso)): ?>
        <div style="color: green; margin-bottom: 20px;"><?php echo $sucesso; ?></div>
    <?php endif; ?>
    
    <form method="POST">
      <label for="email">Email:</label>
      <input type="email" name="email" id="email" placeholder="Digite seu email" required value="<?php echo isset($email) ? $email : ''; ?>">
            
      <label for="username">Nome de usuário:</label>
      <input type="text" name="username" id="username" placeholder="Digite seu nome de usuário" required value="<?php echo isset($username) ? $username : ''; ?>">

      <label for="senha">Senha:</label>
      <input type="password" name="senha" id="senha" placeholder="Digite sua senha" required>
            
      <label for="senha2">Repita a senha:</label>
      <input type="password" name="senha2" id="senha2" placeholder="Repita sua senha" required>

      <button type="submit" class="login-btn">Registrar-se</button>
    </form>

    <a href="login.php">
      <p class="login-text">Já possui cadastro?</p>
    </a>
  </div>
</body>
</html>