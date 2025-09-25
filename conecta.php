<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


$host = 'localhost';
$db   = 'sistema'; 
$user = 'root';              
$pass = 'root';                  

try {
    $conn = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro na conexão com o banco de dados: " . $e->getMessage());
}
