<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ciudad encontrada - <?php echo htmlspecialchars($ciudad['nombre']); ?></title>
    <link rel="stylesheet" href="public/css/estilo.css">
</head>
<body>
<div class="contenedor">
    <h1>Ciudad encontrada</h1>

    <div class="navegacion">
        <a href="index.php">Volver al inicio</a>
    </div>

    <div class="bloque">
        <div class="dato"><span>Ciudad:</span> <?php echo htmlspecialchars($ciudad['nombre']); ?></div>
        <div class="dato"><span>Pais:</span> <?php echo htmlspecialchars($ciudad['pais']); ?></div>
        <div class="dato"><span>Latitud:</span> <?php echo $ciudad['lat']; ?></div>
        <div class="dato"><span>Longitud:</span> <?php echo $ciudad['lon']; ?></div>
    </div>

    <h2>Que quieres consultar?</h2>

    <?php
    $params = http_build_query([
        'lat'    => $ciudad['lat'],
        'lon'    => $ciudad['lon'],
        'nombre' => $ciudad['nombre'],
        'pais'   => $ciudad['pais'],
    ]);
    ?>

    <p style="margin-bottom: 15px;">
        <a class="btn" href="index.php?accion=actual&<?php echo $params; ?>">Tiempo actual</a>
    </p>
    <p style="margin-bottom: 15px;">
        <a class="btn" href="index.php?accion=horas&<?php echo $params; ?>">Prevision por horas</a>
    </p>
    <p style="margin-bottom: 15px;">
        <a class="btn" href="index.php?accion=semana&<?php echo $params; ?>">Prevision semanal</a>
    </p>
</div>
</body>
</html>
