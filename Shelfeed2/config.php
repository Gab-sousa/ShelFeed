<?php

$host = 'db.emizkrlbmchylwtgmrmr.supabase.co';
$port = '5432';
$dbname = 'postgres';
$user = 'postgres';
$password = 'Shelfeed35_';

try {
    $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro na conexão: " . $e->getMessage());
}
?>