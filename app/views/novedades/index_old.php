<?php
$tituloPagina = "Novedades";
$seccionActiva = "novedades";
//require_once __DIR__ . '../partials/header.php';
include("../partials/header.php");
//require_once __DIR__ . '../partials/navbar.php';
include("../partials/encabezado2.php");
include("../partials/navbar.php");
?>
<div class="container">
    <div class="row">
        <?php
        include("tabla-dt.php");
        ?>
    </div>
</div>
<?php
include("../partials/footer.php");
?>