<?php
$conn = new mysqli('localhost', 'root', '', 'smoothcarebd');

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

$username = $_POST['username'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

$sql = "INSERT INTO usuarios (username, email, password) VALUES ('$username', '$email', '$password')";

if ($conn->query($sql) === TRUE) {
    echo "<script>alert('Usuário cadastrado com sucesso!'); window.location.href='registro.html';</script>";
} else {
    echo "Erro: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
