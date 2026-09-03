<?php
include("../partials/header.php");
?>
<table id="example" class="display">
		<thead>
			<tr>
				<th>Nombre</th>
				<th>Puesto</th>
				<th>Oficina</th>
				<th>Edad</th>
				<th>Fecha de inicio</th>
				<th>Salario</th>
				<th>Acciones</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>Tiger Nixon</td>
				<td>System Architect</td>
				<td>Edinburgh</td>
				<td>61</td>
				<td>2011-04-25</td>
				<td>$320,800</td>
				<td><a href="FormularioVer.php"><button type="button" class="btn btn-primary">Ver</button></a><a href="FormularioEditar.php"><button type="button" class="btn btn-warning">Editar</button></a><a href="FormularioEliminar.php"><button type="button" class="btn btn-danger">Eliminar</button></a></td>
			</tr>
			<tr>
				<td>Garrett Winters</td>
				<td>Accountant</td>
				<td>Tokyo</td>
				<td>63</td>
				<td>2011-07-25</td>
				<td>$170,750</td>
				<td><a href="FormularioVer.php"><button type="button" class="btn btn-primary">Ver</button></a><a href="FormularioEditar.php"><button type="button" class="btn btn-warning">Editar</button></a><a href="FormularioEliminar.php"><button type="button" class="btn btn-danger">Eliminar</button></a></td>
			</tr>
			<tr>
				<td>Ashton Cox</td>
				<td>Junior Technical Author</td>
				<td>San Francisco</td>
				<td>66</td>
				<td>2009-01-12</td>
				<td>$86,000</td>
				<td><a href="FormularioVer.php"><button type="button" class="btn btn-primary">Ver</button></a><a href="FormularioEditar.php"><button type="button" class="btn btn-warning">Editar</button></a><a href="FormularioEliminar.php"><button type="button" class="btn btn-danger">Eliminar</button></a></td>
			</tr>
			<tr>
				<td>Cedric Kelly</td>
				<td>Senior JavaScript Developer</td>
				<td>Edinburgh</td>
				<td>22</td>
				<td>2012-03-29</td>
				<td>$433,060</td>
				<td><a href="FormularioVer.php"><button type="button" class="btn btn-primary">Ver</button></a><a href="FormularioEditar.php"><button type="button" class="btn btn-warning">Editar</button></a><a href="FormularioEliminar.php"><button type="button" class="btn btn-danger">Eliminar</button></a></td>
			</tr>
			<tr>
				<td>Airi Satou</td>
				<td>Accountant</td>
				<td>Tokyo</td>
				<td>33</td>
				<td>2008-11-28</td>
				<td>$162,700</td>
				<td><a href="FormularioVer.php"><button type="button" class="btn btn-primary">Ver</button></a><a href="FormularioEditar.php"><button type="button" class="btn btn-warning">Editar</button></a><a href="FormularioEliminar.php"><button type="button" class="btn btn-danger">Eliminar</button></a></td>
			</tr>
			<tr>
				<td>Brielle Williamson</td>
				<td>Integration Specialist</td>
				<td>New York</td>
				<td>61</td>
				<td>2012-12-02</td>
				<td>$372,000</td>
				<td><a href="FormularioVer.php"><button type="button" class="btn btn-primary">Ver</button></a><a href="FormularioEditar.php"><button type="button" class="btn btn-warning">Editar</button></a><a href="FormularioEliminar.php"><button type="button" class="btn btn-danger">Eliminar</button></a></td>
			</tr>
			<tr>
				<td>Herrod Chandler</td>
				<td>Sales Assistant</td>
				<td>San Francisco</td>
				<td>59</td>
				<td>2012-08-06</td>
				<td>$137,500</td>
				<td><a href="FormularioVer.php"><button type="button" class="btn btn-primary">Ver</button></a><a href="FormularioEditar.php"><button type="button" class="btn btn-warning">Editar</button></a><a href="FormularioEliminar.php"><button type="button" class="btn btn-danger">Eliminar</button></a></td>
			</tr>
			<tr>
				<td>Rhona Davidson</td>
				<td>Integration Specialist</td>
				<td>Tokyo</td>
				<td>55</td>
				<td>2010-10-14</td>
				<td>$327,900</td>
				<td><a href="FormularioVer.php"><button type="button" class="btn btn-primary">Ver</button></a><a href="FormularioEditar.php"><button type="button" class="btn btn-warning">Editar</button></a><a href="FormularioEliminar.php"><button type="button" class="btn btn-danger">Eliminar</button></a></td>
			</tr>
			<tr>
				<td>Colleen Hurst</td>
				<td>JavaScript Developer</td>
				<td>San Francisco</td>
				<td>39</td>
				<td>2009-09-15</td>
				<td>$205,500</td>
				<td><a href="FormularioVer.php"><button type="button" class="btn btn-primary">Ver</button></a><a href="FormularioEditar.php"><button type="button" class="btn btn-warning">Editar</button></a><a href="FormularioEliminar.php"><button type="button" class="btn btn-danger">Eliminar</button></a></td>
			</tr>
			
		</tbody>
		<tfoot>
			<tr>
				<th>Nombre</th>
				<th>Puesto</th>
				<th>Oficina</th>
				<th>Edad</th>
				<th>Fecha de inicio</th>
				<th>Salario</th>
				<th>Acciones</th>
			</tr>
		</tfoot>
	</table>

    <script>
        new DataTable("#example");
    </script>