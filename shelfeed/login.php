<?php
session_start();

$conn = new mysqli('localhost', 'root', '', 'smoothcarebd');

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

$email = $_POST['email'];
$password = $_POST['password'];

$sql = "SELECT * FROM usuarios WHERE email = '$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $id_user = $result->fetch_assoc();
    
    if (password_verify($senha, $id_user['password'])) {
        $_SESSION['id_user'] = $id_user['id_user'];
        echo "<script>alert('Login bem-sucedido!'); window.location.href='dashboard.php';</script>";
    } else {
        echo "<script>alert('Senha incorreta!'); window.location.href='login.html';</script>";
    }    
} else {
    echo "<script>alert('Usuário não encontrado!'); window.location.href='login.html';</script>";
}

$conn->close();
?>
