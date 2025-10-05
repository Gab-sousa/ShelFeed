<?php
require 'supabase.php';

// Substitua pelo email que você cadastrou
$email_teste = "gab.sousa0208@gmail.com";

// Faz a query correta com aspas e URL encode
$endpoint = 'usuarios?email=eq.' . rawurlencode('"' . strtolower($email_teste) . '"');

// Chamada ao Supabase
$usuarios = supabaseRequest($endpoint);

// Debug completo
echo "<h2>Debug Supabase</h2>";

// Mostra toda a resposta
echo "<pre>";
print_r($usuarios);
echo "</pre>";

// Mensagem amigável
if (!empty($usuarios)) {
    echo "<p>Usuário encontrado! ID: " . ($usuarios[0]['id_user'] ?? 'N/A') . "</p>";
} else {
    echo "<p>Nenhum usuário encontrado. Verifique:</p>";
    echo "<ul>
            <li>Nome da tabela: 'usuarios'</li>
            <li>Colunas: 'id_user', 'email', 'password', 'username'</li>
            <li>RLS ativo/desativado</li>
            <li>Email digitado igual ao cadastrado (minúsculas)</li>
          </ul>";
}
?>
