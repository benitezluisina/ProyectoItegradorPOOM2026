
<?php
$tituloPagina = "Usuarios Eliminar";
$seccionActiva = "usuarios";
include("../partials/header.php");
include("../partials/encabezado2.php");
include("../partials/navbar.php");
?>
<div class="card" style="width: 18rem;">
    <i class="bi bi-exclamation-triangle"></i>
  <div class="card-body">
    <h5 class="card-title">Eliminar registro</h5>
    <p class="card-text">¿Estás seguro que queres eliminar el registro?</p>
    <a href="index.php" class="btn btn-danger">Eliminar</a>
  </div>
</div>


<?php
include("../partials/footer.php");
?>