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
