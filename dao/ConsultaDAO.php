<?php
require_once __DIR__ . '/../models/Database.php';

class ConsultaDAO {

    // Guarda una consulta en la base de datos
    public static function guardar($ciudad, $lat, $lon, $tipo_consulta) {
        $db = Database::getConexion();
        $sql = "INSERT INTO consultas (ciudad, lat, lon, tipo_consulta, fecha) VALUES (?, ?, ?, ?, NOW())";
        $stmt = $db->prepare($sql);
        $stmt->execute([$ciudad, $lat, $lon, $tipo_consulta]);
    }

    // Devuelve todas las consultas ordenadas por fecha
    public static function obtenerTodas() {
        $db = Database::getConexion();
        $sql = "SELECT * FROM consultas ORDER BY fecha DESC";
        $stmt = $db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
