<?php
include 'supabase.php'; // seu arquivo de conexão

// Dados do usuário que você quer inserir
$novoUsuario = [
    "email" => "teste@example.com",
    "password" => "123456",
    "username" => "usuario_teste"
];

// Inserindo no Supabase
$resultado = supabaseRequest("usuarios", "POST", $novoUsuario);

// Exibindo resultado
echo "<pre>";
print_r($resultado);
echo "</pre>";
?>

