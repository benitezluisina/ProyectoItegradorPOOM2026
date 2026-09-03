<?php
include("../partials/header.php");
?>
<a href="FormularioAgregar.php"><button type="button" class="btn btn-info">Agregar</button></a>
<table id="example" class="display">
		<thead>
			<tr>
				<th>Nro</th>
				<th>Fecha hora</th>
				<th>Sección</th>
				<th>Acciones</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>1</td>
				<td>03/09/2026 11:00:00</td>
				<td>Máquina</td>
				<td><a href="FormularioVer.php"><button type="button" class="btn btn-primary">Ver</button></a><a href="FormularioEditar.php"><button type="button" class="btn btn-warning">Editar</button></a><a href="FormularioEliminar.php"><button type="button" class="btn btn-danger">Eliminar</button></a></td>
			</tr>
			<tr>
				<td>2</td>
				<td>03/09/2026 11:00:00</td>
				<td>Cubierta</td>
				<td><a href="FormularioVer.php"><button type="button" class="btn btn-primary">Ver</button></a><a href="FormularioEditar.php"><button type="button" class="btn btn-warning">Editar</button></a><a href="FormularioEliminar.php"><button type="button" class="btn btn-danger">Eliminar</button></a></td>
			</tr>
			<tr>
				<td>3</td>
				<td>03/09/2026 11:00:00</td>
				<td>Comunicaciones</td>
				<td><a href="FormularioVer.php"><button type="button" class="btn btn-primary">Ver</button></a><a href="FormularioEditar.php"><button type="button" class="btn btn-warning">Editar</button></a><a href="FormularioEliminar.php"><button type="button" class="btn btn-danger">Eliminar</button></a></td>
			</tr>
			
			
		</tbody>
		<tfoot>
			<tr>
				<th>Nro</th>
				<th>Fecha hora</th>
				<th>Sección</th>
				<th>Acciones</th>
			</tr>
		</tfoot>
	</table>

    <script>
        new DataTable("#example");
    </script>