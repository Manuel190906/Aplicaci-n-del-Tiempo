<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Historial de consultas</title>
    <link rel="stylesheet" href="public/css/estilo.css">
</head>
<body>
<div class="contenedor">
    <h1>Historial de consultas</h1>

    <div class="navegacion">
        <a href="index.php">Volver al inicio</a>
    </div>

    <?php if (empty($consultas)): ?>
        <p style="color: #778899;">Todavia no hay consultas registradas.</p>
    <?php else: ?>
    <div class="bloque">
        <table>
            <tr>
                <th>ID</th>
                <th>Ciudad</th>
                <th>Tipo</th>
                <th>Fecha</th>
            </tr>
            <?php foreach ($consultas as $c): ?>
            <tr>
                <td><?php echo $c['id']; ?></td>
                <td><?php echo htmlspecialchars($c['ciudad']); ?></td>
                <td><?php echo htmlspecialchars($c['tipo_consulta']); ?></td>
                <td><?php echo $c['fecha']; ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <p style="color: #778899; font-size: 0.85em;">Total de consultas: <?php echo count($consultas); ?></p>
    <?php endif; ?>

</div>
</body>
</html>
