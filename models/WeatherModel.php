<?php
require_once __DIR__ . '/../config/database.php';

class WeatherModel {

    // Funcion privada para hacer llamadas a la API con cURL
    private function llamarAPI($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $respuesta = curl_exec($ch);
        curl_close($ch);
        return $respuesta;
    }

    // Busca la ciudad y devuelve lat/lon usando la API de geocoding
    public function buscarCiudad($nombre) {
        $url = API_BASE . '/geo/1.0/direct?q=' . urlencode($nombre) . '&limit=1&appid=' . API_KEY;
        $respuesta = $this->llamarAPI($url);
        $datos = json_decode($respuesta, true);

        if (empty($datos)) {
            return null;
        }

        return [
            'nombre'  => $datos[0]['name'],
            'pais'    => $datos[0]['country'],
            'lat'     => $datos[0]['lat'],
            'lon'     => $datos[0]['lon'],
        ];
    }

    // Tiempo actual
    public function getTiempoActual($lat, $lon) {
        $url = API_BASE . '/data/2.5/weather?lat=' . $lat . '&lon=' . $lon . '&appid=' . API_KEY . '&units=metric&lang=es';
        $respuesta = $this->llamarAPI($url);
        return json_decode($respuesta, true);
    }

    // Prevision por horas (las proximas 24h, cada 3h)
    public function getPrevisionHoras($lat, $lon) {
        $url = API_BASE . '/data/2.5/forecast?lat=' . $lat . '&lon=' . $lon . '&appid=' . API_KEY . '&units=metric&lang=es&cnt=8';
        $respuesta = $this->llamarAPI($url);
        return json_decode($respuesta, true);
    }

    // Prevision para la semana (agrupamos por dia)
    public function getPrevisionSemana($lat, $lon) {
        $url = API_BASE . '/data/2.5/forecast?lat=' . $lat . '&lon=' . $lon . '&appid=' . API_KEY . '&units=metric&lang=es&cnt=40';
        $respuesta = $this->llamarAPI($url);
        $datos = json_decode($respuesta, true);

        // Agrupar por dia cogiendo el dato del mediodia de cada dia
        $porDia = [];
        if (!empty($datos['list'])) {
            foreach ($datos['list'] as $item) {
                $dia = date('Y-m-d', $item['dt']);
                $hora = date('H', $item['dt']);
                if (!isset($porDia[$dia]) || abs($hora - 12) < abs(date('H', $porDia[$dia]['dt']) - 12)) {
                    $porDia[$dia] = $item;
                }
            }
        }

        return ['list' => array_values($porDia)];
    }
}