<?php
// db.php
$host = 'localhost'; // Your database host (usually localhost)

$db   = 'apgadmin_apgdb';  // Name of your database
$user = 'apgadmin_admin';    // Your database username
$pass = '691$Kloj5';// Your database password

/*
$db = 'apgdb';  // Name of your database
$user = 'root';    // Your database username
$pass = ''; // Your database password
*/
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
?>
