-- Base de datos para la aplicacion del tiempo
CREATE DATABASE IF NOT EXISTS weather_db CHARACTER SET utf8 COLLATE utf8_general_ci;

USE weather_db;

-- Tabla para guardar todas las consultas realizadas
CREATE TABLE IF NOT EXISTS consultas (
    id            INT AUTO_INCREMENT PRIMARY KEY,
    ciudad        VARCHAR(200) NOT NULL,
    lat           DECIMAL(10, 6) NOT NULL,
    lon           DECIMAL(10, 6) NOT NULL,
    tipo_consulta ENUM('actual', 'horas', 'semana') NOT NULL,
    fecha         DATETIME NOT NULL
);
