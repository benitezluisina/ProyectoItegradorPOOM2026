<?php
/**
 * app/views/novedades/crear.php
 * Variables: $datos, $errores, $responsables
 */
$tituloPagina  = 'Nueva novedad';
$seccionActiva = 'novedades';
$urlAccion     = BASE_URL . '/index.php?ctrl=novedades&accion=guardar';
$textoBoton    = 'Registrar novedad';

require_once __DIR__ . '/../partials/header.php';
require_once __DIR__ . '/../partials/navbar.php';
require_once __DIR__ . '/../partials/encabezado2.php';
?>

<main class="container-fluid px-3 px-lg-4">

    <div class="page-header">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= BASE_URL ?>/index.php" class="text-decoration-none">Inicio</a></li>
                <li class="breadcrumb-item"><a href="<?= BASE_URL ?>/index.php?ctrl=novedades&accion=index" class="text-decoration-none">Novedades</a></li>
                <li class="breadcrumb-item active" aria-current="page">Nueva novedad</li>
            </ol>
        </nav>
        <h1>Nueva novedad</h1>
        <p class="text-muted mb-0" style="font-size:0.88rem;">Completá los datos para registrar una novedad</p>
    </div>

    <div class="row">
        <div class="col-12 col-xl-8">
            <div class="app-card p-3 p-lg-4">
                <?php require __DIR__ . '/Formulario.php'; ?>
            </div>
        </div>
    </div>

</main>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>
