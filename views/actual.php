<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Tiempo actual - <?php echo htmlspecialchars($nombre); ?></title>
    <link rel="stylesheet" href="public/css/estilo.css">
</head>
<body>
<div class="contenedor">
    <h1>Tiempo actual en <?php echo htmlspecialchars($nombre); ?>, <?php echo htmlspecialchars($pais); ?></h1>

    <div class="navegacion">
        <a href="index.php">Inicio</a>
        <?php
        $params = http_build_query(['lat' => $lat, 'lon' => $lon, 'nombre' => $nombre, 'pais' => $pais]);
        ?>
        <a href="index.php?accion=horas&<?php echo $params; ?>">Por horas</a>
        <a href="index.php?accion=semana&<?php echo $params; ?>">Semanal</a>
    </div>

    <?php if (!empty($datos) && isset($datos['main'])): ?>
    <div class="bloque">
        <div class="dato"><span>Descripcion:</span> <?php echo ucfirst($datos['weather'][0]['description']); ?></div>
        <div class="dato"><span>Temperatura:</span> <?php echo $datos['main']['temp']; ?> C</div>
        <div class="dato"><span>Sensacion termica:</span> <?php echo $datos['main']['feels_like']; ?> C</div>
        <div class="dato"><span>Temperatura minima:</span> <?php echo $datos['main']['temp_min']; ?> C</div>
        <div class="dato"><span>Temperatura maxima:</span> <?php echo $datos['main']['temp_max']; ?> C</div>
        <div class="dato"><span>Humedad:</span> <?php echo $datos['main']['humidity']; ?> %</div>
        <div class="dato"><span>Presion:</span> <?php echo $datos['main']['pressure']; ?> hPa</div>
        <div class="dato"><span>Viento:</span> <?php echo $datos['wind']['speed']; ?> m/s</div>
        <div class="dato"><span>Visibilidad:</span> <?php echo isset($datos['visibility']) ? ($datos['visibility'] / 1000) . ' km' : 'No disponible'; ?></div>
        <div class="dato"><span>Nubosidad:</span> <?php echo $datos['clouds']['all']; ?> %</div>
    </div>

    <!-- Grafica de barras sencilla con los datos mas importantes -->
    <h2>Grafica de datos principales</h2>
    <div class="bloque grafica">
        <?php
        // Calcular el maximo para escalar las barras
        $valores = [
            'Temp (C)'     => $datos['main']['temp'],
            'Humedad (%)'  => $datos['main']['humidity'],
            'Nubosidad (%)' => $datos['clouds']['all'],
        ];
        $max = max(array_values($valores));
        if ($max == 0) $max = 1;
        ?>
        <?php foreach ($valores as $etiqueta => $valor): ?>
        <div class="barra-fila">
            <div class="barra-etiqueta"><?php echo $etiqueta; ?></div>
            <div class="barra-contenedor">
                <div class="barra-relleno" style="width: <?php echo max(5, round(($valor / $max) * 100)); ?>%;">
                    <?php echo $valor; ?>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <?php else: ?>
        <div class="error">No se pudieron obtener los datos del tiempo. Comprueba tu API key.</div>
    <?php endif; ?>

</div>
</body>
</html>
