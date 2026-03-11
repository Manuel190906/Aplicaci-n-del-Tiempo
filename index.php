<?php
require_once __DIR__ . '/controllers/WeatherController.php';

$controller = new WeatherController();

// Router sencillo basado en el parametro "accion"
$accion = isset($_GET['accion']) ? $_GET['accion'] : 'index';

switch ($accion) {
    case 'buscar':
        $controller->buscar();
        break;
    case 'actual':
        $controller->actual();
        break;
    case 'horas':
        $controller->horas();
        break;
    case 'semana':
        $controller->semana();
        break;
    case 'historial':
        $controller->historial();
        break;
    default:
        $controller->index();
        break;
}
