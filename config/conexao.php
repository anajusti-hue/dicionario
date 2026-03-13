<?php
$host = "localhost";
$user = "root";
$pass = ""; 
$db   = "dicionario";

$conn = new mysqli($host, $user, $pass, $db);
$conn->set_charset("utf8mb4");

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}
?>