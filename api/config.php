<?php
// config.php
$host = 'localhost';
$db_name = 'db_teste';
$username = 'root';
$password = 'L30N4rdo078%27';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $exception) {
    die("Erro de conexão: " . $exception->getMessage());
}
?>
