<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Prevision por horas - <?php echo htmlspecialchars($nombre); ?></title>
    <link rel="stylesheet" href="public/css/estilo.css">
</head>
<body>
<div class="contenedor">
    <h1>Prevision por horas en <?php echo htmlspecialchars($nombre); ?>, <?php echo htmlspecialchars($pais); ?></h1>

    <div class="navegacion">
        <a href="index.php">Inicio</a>
        <?php
        $params = http_build_query(['lat' => $lat, 'lon' => $lon, 'nombre' => $nombre, 'pais' => $pais]);
        ?>
        <a href="index.php?accion=actual&<?php echo $params; ?>">Tiempo actual</a>
        <a href="index.php?accion=semana&<?php echo $params; ?>">Semanal</a>
    </div>

    <?php if (!empty($datos['list'])): ?>

    <!-- Tabla de datos por horas -->
    <div class="bloque">
        <h2>Proximas 24 horas (cada 3 horas)</h2>
        <?php foreach ($datos['list'] as $item): ?>
        <div class="fila-hora">
            <div><?php echo date('H:i', $item['dt']); ?> h</div>
            <div><?php echo ucfirst($item['weather'][0]['description']); ?></div>
            <div><?php echo $item['main']['temp']; ?> C</div>
            <div>Humedad: <?php echo $item['main']['humidity']; ?>%</div>
            <div>Viento: <?php echo $item['wind']['speed']; ?> m/s</div>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Grafica de temperaturas por horas -->
    <h2>Grafica de temperaturas</h2>
    <div class="bloque grafica">
        <?php
        $temps = array_map(function($item) { return $item['main']['temp']; }, $datos['list']);
        $maxTemp = max($temps);
        $minTemp = min($temps);
        $rango = ($maxTemp - $minTemp);
        if ($rango == 0) $rango = 1;
        ?>
        <?php foreach ($datos['list'] as $item): ?>
        <div class="barra-fila">
            <div class="barra-etiqueta"><?php echo date('H:i', $item['dt']); ?>h</div>
            <div class="barra-contenedor">
                <div class="barra-relleno" style="width: <?php echo max(5, round((($item['main']['temp'] - $minTemp) / $rango) * 100)); ?>%;">
                    <?php echo $item['main']['temp']; ?> C
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <?php else: ?>
        <div class="error">No se pudieron obtener los datos. Comprueba tu API key.</div>
    <?php endif; ?>

</div>
</body>
</html>
