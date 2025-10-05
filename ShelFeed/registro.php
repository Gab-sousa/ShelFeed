<?php
session_start();
require 'supabase.php';


$email_val = $username_val = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = strtolower(trim($_POST['email']));
    $username = trim($_POST['username'] ?? '');
    $senha = $_POST['senha'] ?? '';
    $senha2 = $_POST['senha2'] ?? '';

    // manter valores para repopular o form em caso de erro
    $email_val = $email;
    $username_val = $username;

    // validações básicas
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erro = "Email inválido.";
    } elseif ($senha !== $senha2) {
        $erro = "As senhas não coincidem!";
    } elseif (strlen($senha) < 6) {
        $erro = "A senha deve ter pelo menos 6 caracteres!";
    } elseif (empty($username) || strlen($username) < 3) {
        $erro = "Nome de usuário inválido (mín 3 caracteres).";
    } else {
        // checar email existente (valor entre aspas e urlencoded)
        $endpointEmail = 'usuarios?email=eq.' . urlencode('"' . $email . '"');
        $existing = supabaseRequest($endpointEmail);

        if (!empty($existing)) {
            $erro = "Este email já está cadastrado!";
        } else {
            // checar username existente
            $endpointUser = 'usuarios?username=eq.' . urlencode('"' . $username . '"');
            $existingUser = supabaseRequest($endpointUser);

            if (!empty($existingUser)) {
                $erro = "Este nome de usuário já está em uso!";
            } else {
                // cria usuário
                $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
                $payload = [
                    "email" => $email,
                    "username" => $username,
                    "password" => $senha_hash
                ];

                $novo = supabaseRequest("usuarios", "POST", $payload);

                // supabaseRequest retorna representação por causa do header Prefer: return=representation
                if ($novo && is_array($novo) && count($novo) > 0) {
                    $_SESSION['sucesso'] = "Cadastro realizado com sucesso! Faça login.";
                    header('Location: login.php');
                    exit();
                } else {
                    $erro = "Erro ao cadastrar. Tente novamente mais tarde.";
                }
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
    // Mensagens vindas de redirect ou do próprio processamento
    if (!empty($erro)) {
        echo '<div style="color:red;margin-bottom:20px;">' . htmlspecialchars($erro) . '</div>';
    }
    if (isset($_SESSION['sucesso'])) {
        echo '<div style="color:green;margin-bottom:20px;">' . htmlspecialchars($_SESSION['sucesso']) . '</div>';
        unset($_SESSION['sucesso']);
    }
    ?>

    <form action="registro.php" method="POST">
      <label>Email:</label>
      <input type="email" name="email" required value="<?php echo htmlspecialchars($email_val); ?>">
      <label>Nome de usuário:</label>
      <input type="text" name="username" required value="<?php echo htmlspecialchars($username_val); ?>">
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
