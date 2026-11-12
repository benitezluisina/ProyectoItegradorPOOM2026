<?php
if(!isset($tituloPagina)){
    $tituloPagina = "Sistema ABM";
}
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?= htmlspecialchars($tituloPagina) ?></title>

        <!--Google Fonts (antes: "gstatics" y "qght" mal escritos, y Google rechazaba toda la hoja de fuentes)-->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Poppins:wght@500;600;700&display=swap" rel="stylesheet">

        <!-- Boostrap -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

        <!--Boostrap icon-->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

        <!--Data Tables-->
        <link href="https://cdn.datatables.net/v/dt/dt-3.0.2/datatables.min.css" rel="stylesheet">

        <!--Estilos propios: la ruta la resuelve el NAVEGADOR, por eso parte de BASE_URL (config/config.php)-->
        <link href="<?= BASE_URL ?>/css/estilos.css" rel="stylesheet">
    </head>
    <body>
