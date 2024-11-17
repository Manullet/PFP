<?php

require_once __DIR__ . '/vendor/autoload.php'; // Cargar las dependencias de Composer

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__); // Cargar el archivo .env
$dotenv->load();

// Crear una función para obtener la conexión a la base de datos
function getConnection() {
    try {
        $host = $_ENV['DB_HOST'];
        $port = $_ENV['DB_PORT'];
        $database = $_ENV['DB_DATABASE'];
        $username = $_ENV['DB_USERNAME'];
        $password = $_ENV['DB_PASSWORD'];

        $dsn = "mysql:host=$host;port=$port;dbname=$database;charset=utf8mb4";
        $pdo = new PDO($dsn, $username, $password);

        // Configurar PDO para manejar errores
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $pdo;
    } catch (PDOException $e) {
        die("Error en la conexión a la base de datos: " . $e->getMessage());
    }
}
