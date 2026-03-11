<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Prevision semanal - <?php echo htmlspecialchars($nombre); ?></title>
    <link rel="stylesheet" href="public/css/estilo.css">
</head>
<body>
<div class="contenedor">
    <h1>Prevision semanal en <?php echo htmlspecialchars($nombre); ?>, <?php echo htmlspecialchars($pais); ?></h1>

    <div class="navegacion">
        <a href="index.php">Inicio</a>
        <?php
        $params = http_build_query(['lat' => $lat, 'lon' => $lon, 'nombre' => $nombre, 'pais' => $pais]);
        ?>
        <a href="index.php?accion=actual&<?php echo $params; ?>">Tiempo actual</a>
        <a href="index.php?accion=horas&<?php echo $params; ?>">Por horas</a>
    </div>

    <?php
    // Nombres de dias en castellano
    $diasEs = [
        'Monday'    => 'Lunes',
        'Tuesday'   => 'Martes',
        'Wednesday' => 'Miercoles',
        'Thursday'  => 'Jueves',
        'Friday'    => 'Viernes',
        'Saturday'  => 'Sabado',
        'Sunday'    => 'Domingo',
    ];
    ?>

    <?php if (!empty($datos['list'])): ?>

    <!-- Tabla de datos diarios -->
    <div class="bloque">
        <h2>Proximos dias</h2>
        <?php foreach ($datos['list'] as $item): ?>
        <?php $dia = $diasEs[date('l', $item['dt'])]; ?>
        <div class="fila-dia">
            <div><?php echo $dia; ?> <?php echo date('d/m', $item['dt']); ?></div>
            <div><?php echo ucfirst($item['weather'][0]['description']); ?></div>
            <div>Max: <?php echo $item['main']['temp_max']; ?> C</div>
            <div>Min: <?php echo $item['main']['temp_min']; ?> C</div>
            <div>Humedad: <?php echo $item['main']['humidity']; ?>%</div>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Grafica de temperaturas maximas por dia -->
    <h2>Grafica de temperaturas maximas</h2>
    <div class="bloque grafica">
        <?php
        $temps = array_map(function($item) { return $item['main']['temp_max']; }, $datos['list']);
        $maxTemp = max($temps);
        $minTemp = min($temps);
        $rango = ($maxTemp - $minTemp);
        if ($rango == 0) $rango = 1;
        ?>
        <?php foreach ($datos['list'] as $item): ?>
        <?php $dia = substr($diasEs[date('l', $item['dt'])], 0, 3); ?>
        <div class="barra-fila">
            <div class="barra-etiqueta"><?php echo $dia; ?> <?php echo date('d/m', $item['dt']); ?></div>
            <div class="barra-contenedor">
                <div class="barra-relleno" style="width: <?php echo max(5, round((($item['main']['temp_max'] - $minTemp) / $rango) * 100)); ?>%;">
                    <?php echo $item['main']['temp_max']; ?> C
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
