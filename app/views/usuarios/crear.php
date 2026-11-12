<?php
/**
 * app/views/Usuarios/crear.php
 * Vista del formulario de alta de usuarios.
 *
 * Variables que inyecta UsuarioController::crear() / guardar():
 *   $datos   (array) valores de los campos (vacíos, o lo que el usuario ya escribió)
 *   $errores (array) errores de validación por campo
 */

$tituloPagina  = 'Nuevo usuario';
$seccionActiva = 'usuarios';
$urlAccion     = BASE_URL . '/index.php?ctrl=usuarios&accion=guardar';
$textoBoton    = 'Crear usuario';

require_once __DIR__ . '/../partials/header.php';
require_once __DIR__ . '/../partials/navbar.php';
require_once __DIR__ . '/../partials/encabezado2.php';
?>

<main class="container-fluid px-3 px-lg-4">

    <div class="page-header">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= BASE_URL ?>/index.php" class="text-decoration-none">Inicio</a></li>
                <li class="breadcrumb-item"><a href="<?= BASE_URL ?>/index.php?ctrl=usuarios&accion=index" class="text-decoration-none">Usuarios</a></li>
                <li class="breadcrumb-item active" aria-current="page">Nuevo usuario</li>
            </ol>
        </nav>
        <h1>Nuevo usuario</h1>
        <p class="text-muted mb-0" style="font-size:0.88rem;">Completá los datos para dar de alta un usuario en el sistema</p>
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
