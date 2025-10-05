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
