
<?php
$tituloPagina = "Usuarios Agregar";
$seccionActiva = "usuarios";
include("../partials/header.php");
include("../partials/encabezado2.php");
include("../partials/navbar.php");
?>
<div class="card" style="width: 18rem;">
  <div class="card-body">
    <h5 class="card-title">Agregar</h5>
    <p class="card-text">
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Nro</label>
            <input type="number" class="form-control" id="nro">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Fecha hora</label>
            <input type="datetime-local" class="form-control" id="fechahora">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Sección</label>
            <input type="text" class="form-control" id="seccion">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Novedad</label>
            <textarea class="form-control" id="novedad" rows="3"></textarea>
        </div>
    </p>
    <a href="index.php" class="btn btn-primary">Guardar</a>
  </div>
</div>


<?php
include("../partials/footer.php");
?>