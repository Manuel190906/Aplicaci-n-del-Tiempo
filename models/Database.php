<?php
require_once __DIR__ . '/../config/database.php';

class Database {
    private static $conexion = null;

    public static function getConexion() {
        if (self::$conexion === null) {
            try {
                $dsn = 'mysql:host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_NAME . ';charset=utf8';
                self::$conexion = new PDO($dsn, DB_USER, DB_PASS);
                self::$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die('Error de conexion a la base de datos: ' . $e->getMessage());
            }
        }
        return self::$conexion;
    }
}
