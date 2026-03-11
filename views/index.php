<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Consulta del tiempo</title>
    <link rel="stylesheet" href="public/css/estilo.css">
</head>
<body>
<div class="contenedor">
    <h1>Consulta del tiempo</h1>

    <?php if (!empty($error)): ?>
        <div class="error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <div class="formulario">
        <form action="index.php" method="get">
            <input type="hidden" name="accion" value="buscar">
            <input type="text" name="ciudad" placeholder="Escribe una ciudad..." value="<?php echo isset($_GET['ciudad']) ? htmlspecialchars($_GET['ciudad']) : ''; ?>">
            <button type="submit">Buscar</button>
        </form>
    </div>

    <div class="navegacion">
        <a href="index.php?accion=historial">Ver historial de consultas</a>
    </div>

    <p style="color: #778899; font-size: 0.9em;">Escribe el nombre de cualquier ciudad del mundo para consultar su prevision meteorologica.</p>
</div>
</body>
</html>
