<?php
/**
 * app/views/usuarios/editar.php
 * Vista del formulario de modificación de usuarios.
 *
 * Variables que inyecta UsuarioController::editar() / actualizar():
 *   $id      (int)   id del usuario que se está editando
 *   $datos   (array) valores de los campos (los de la base, o lo que el usuario corrigió)
 *   $errores (array) errores de validación por campo
 */

$tituloPagina  = 'Editar usuario';
$seccionActiva = 'usuarios';
$urlAccion     = '/ProyectoIntegradorPOOM2026/public/index.php?ctrl=usuarios&accion=actualizar';
$textoBoton    = 'Guardar cambios';

require_once __DIR__ . '/../partials/header.php';
require_once __DIR__ . '/../partials/navbar.php';
?>

<main class="container-fluid px-3 px-lg-4">

    <div class="page-header">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/ProyectoIntegradorPOOM2026/public/index.php" class="text-decoration-none">Inicio</a></li>
                <li class="breadcrumb-item"><a href="/ProyectoIntegradorPOOM2026/public/index.php?ctrl=usuarios&accion=index" class="text-decoration-none">Usuarios</a></li>
                <li class="breadcrumb-item active" aria-current="page">Editar usuario</li>
            </ol>
        </nav>
        <h1>Editar usuario <span class="text-muted fw-normal">#<?= (int) $id ?></span></h1>
        <p class="text-muted mb-0" style="font-size:0.88rem;">Modificá los datos y guardá los cambios</p>
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