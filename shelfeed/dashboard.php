<?php
// Pegar dados do POST
$email = $_POST['email'] ?? '';
$senha = $_POST['senha'] ?? '';
$username = $_POST['username'] ?? '';

// Caso venha do registro, mostrar boas-vindas personalizadas
$nomeExibido = !empty($username) ? $username : $email;
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Dashboard</title>
  <link rel="stylesheet" href="style.css">
  <style>
    .dashboard {
      background: rgba(156, 137, 129, 0.95);
      width: 600px;
      margin: 100px auto;
      padding: 30px;
      border-radius: 20px;
      text-align: center;
      color: #f2e8e4;
    }
    .dashboard h2 {
      margin-bottom: 20px;
    }
    .dashboard a {
      color: #f2e8e4;
      text-decoration: none;
      font-weight: bold;
    }
  </style>
</head>
<body>
  <div class="dashboard">
    <h2>Bem-vindo(a), <?php echo htmlspecialchars($nomeExibido); ?>!</h2>
    <p>Você entrou no sistema com sucesso.</p>
    <a href="login.html">Sair</a>
  </div>
</body>
</html>
