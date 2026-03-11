<?php
require_once __DIR__ . '/../models/WeatherModel.php';
require_once __DIR__ . '/../dao/ConsultaDAO.php';

class WeatherController {

    private $model;

    public function __construct() {
        $this->model = new WeatherModel();
    }

    // Pagina principal con el formulario
    public function index() {
        require __DIR__ . '/../views/index.php';
    }

    // Busca la ciudad y redirige o muestra error
    public function buscar() {
        $nombre = isset($_GET['ciudad']) ? trim($_GET['ciudad']) : '';

        if (empty($nombre)) {
            $error = 'Escribe el nombre de una ciudad.';
            require __DIR__ . '/../views/index.php';
            return;
        }

        $ciudad = $this->model->buscarCiudad($nombre);

        if ($ciudad === null) {
            $error = 'Ciudad no encontrada. Prueba con otro nombre.';
            require __DIR__ . '/../views/index.php';
            return;
        }

        // Pasamos los datos a la vista de resultados
        require __DIR__ . '/../views/ciudad.php';
    }

    // Muestra el tiempo actual
    public function actual() {
        $lat    = isset($_GET['lat'])    ? $_GET['lat']    : null;
        $lon    = isset($_GET['lon'])    ? $_GET['lon']    : null;
        $nombre = isset($_GET['nombre']) ? $_GET['nombre'] : '';
        $pais   = isset($_GET['pais'])   ? $_GET['pais']   : '';

        if (!$lat || !$lon) {
            header('Location: index.php');
            exit;
        }

        $datos = $this->model->getTiempoActual($lat, $lon);
        ConsultaDAO::guardar($nombre . ', ' . $pais, $lat, $lon, 'actual');

        require __DIR__ . '/../views/actual.php';
    }

    // Muestra la prevision por horas
    public function horas() {
        $lat    = isset($_GET['lat'])    ? $_GET['lat']    : null;
        $lon    = isset($_GET['lon'])    ? $_GET['lon']    : null;
        $nombre = isset($_GET['nombre']) ? $_GET['nombre'] : '';
        $pais   = isset($_GET['pais'])   ? $_GET['pais']   : '';

        if (!$lat || !$lon) {
            header('Location: index.php');
            exit;
        }

        $datos = $this->model->getPrevisionHoras($lat, $lon);
        ConsultaDAO::guardar($nombre . ', ' . $pais, $lat, $lon, 'horas');

        require __DIR__ . '/../views/horas.php';
    }

    // Muestra la prevision semanal
    public function semana() {
        $lat    = isset($_GET['lat'])    ? $_GET['lat']    : null;
        $lon    = isset($_GET['lon'])    ? $_GET['lon']    : null;
        $nombre = isset($_GET['nombre']) ? $_GET['nombre'] : '';
        $pais   = isset($_GET['pais'])   ? $_GET['pais']   : '';

        if (!$lat || !$lon) {
            header('Location: index.php');
            exit;
        }

        $datos = $this->model->getPrevisionSemana($lat, $lon);
        ConsultaDAO::guardar($nombre . ', ' . $pais, $lat, $lon, 'semana');

        require __DIR__ . '/../views/semana.php';
    }

    // Historial de consultas (OPCIONAL)
    public function historial() {
        $consultas = ConsultaDAO::obtenerTodas();
        require __DIR__ . '/../views/historial.php';
    }
}
