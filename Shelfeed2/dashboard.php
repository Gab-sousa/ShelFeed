<?php
// dashboard.php
session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}

$usuario = $_SESSION['usuario'];
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <link rel="stylesheet" type="text/css" href="style.css" media="screen"/>
  <style>
    .dashboard-container {
      background-color: #9C8981;
      width: 400px;
      padding: 40px;
      border-radius: 20px;
      box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.3);
      text-align: center;
      margin: 80px auto;
      color: #f2e8e4;
    }
    
    .logout-btn {
      background: #f2e8e4;
      color: #8b695e;
      padding: 10px 20px;
      border: none;
      border-radius: 25px;
      cursor: pointer;
      text-decoration: none;
      display: inline-block;
      margin-top: 20px;
    }
  </style>
</head>
<body>
  <div class="dashboard-container">
    <h2>Bem-vindo, <?php echo htmlspecialchars($usuario['username']); ?>!</h2>
    <p>Email: <?php echo htmlspecialchars($usuario['email']); ?></p>
    <p>ID: <?php echo htmlspecialchars($usuario['id_user']); ?></p>
    
    <a href="logout.php" class="logout-btn">Sair</a>
  </div>
</body>
</html>