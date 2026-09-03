
<?php
$tituloPagina = "Usuarios Editar";
$seccionActiva = "usuarios";
include("../partials/header.php");
include("../partials/encabezado2.php");
include("../partials/navbar.php");
?>
<div class="card" style="width: 18rem;">
  <div class="card-body">
    <h5 class="card-title">Editar</h5>
    <p class="card-text">
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="nombre" placeholder="Nombre" value="Tiger Nixon">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Puesto</label>
            <input type="text" class="form-control" id="puesto" placeholder="Puesto" value="System Architect">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Oficina</label>
            <input type="text" class="form-control" id="oficina" placeholder="Nombre" value="Edinburgh">
        </div>
    </p>
    <a href="index.php" class="btn btn-primary">Guardar</a>
  </div>
</div>


<?php
include("../partials/footer.php");
?>