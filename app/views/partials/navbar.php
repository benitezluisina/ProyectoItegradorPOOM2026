<?php
if(!isset($seccionActiva)){
    $seccionActiva = '';
}

if(!function_exists('claseActiva')){
    function claseActiva(string $seccion, string $activa){
        return $seccion === $activa ? 'active' : '';
    }
}
?>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="<?= BASE_URL ?>/index.php">Barra Navegación</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link <?= claseActiva('usuarios', $seccionActiva) ?>" href="<?= BASE_URL ?>/index.php?ctrl=usuarios&accion=index">Usuarios</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= claseActiva('novedades', $seccionActiva) ?>" href="<?= BASE_URL ?>/index.php?ctrl=novedades&accion=index">Novedades</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
