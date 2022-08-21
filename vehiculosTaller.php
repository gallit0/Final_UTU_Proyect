<?php
	include "conexion.php";
	session_start();
	if(isset($_SESSION['idUsuario'])){
		if($_SESSION['permisoUsuario']==1){
			header("Location: usuarioPerfil.php");
		} 
	} else {
		header("Location: index.php");
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset = "UTF-8">
	<title>MadMotors - Adm Users</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="estilo.css?v=<?php echo time(); ?>">
	<link rel="icon" type="image/x-icon" href="imagenes_contenido/favicon.ico">
</head>
<script type="text/javascript">
	function confEliminar() {
		
		var respuesta=confirm("¿Está seguro de que quiere eliminar al vehículo permanentemente?");
		if(respuesta==true){
			return true;
		} else {
			return false;
		}
	}
</script>
<body>
<?php include 'cambioModoOscuro.php'?>
	<div id = "admUsuarios">
		<!-------------Header------------->
		<?php
			include 'barraHeader.php';
		?>
		<div class="titulos">
			Administrar Vehículos
		</div>
		<div id= "cuerpoAdmUsuarios" class= "cuerpo">
			<form for = "" method = "">	
				<p>
					<div id = "filtroBusquedaUser">
						<label for = "tipoFiltroAdmUsuarios">Buscar por
							<select name ="tipoFiltroAdmUsuarios">
								<option value="matricula">Matricula</option>
								<option value="modelo">Tipo</option>
								<option value="marca">Marca</option>
							</select>
						</label>
						
						<input type="text" name="textoAdmUsuarios">

						<input type="submit" value="Buscar">

					</div>
				</p>
			</form>
			<div id = "busquedaUser" class= "cuerpo">
				<table>
					<thead>
				        <tr>
				            <th>Matricula</th>
				            <th>Tipo</th>
				            <th>Marca</th>
				            <th>Color</th>
				            <th>Cedula o RUT Cliente</th>
							<th>Configurar</th>
				        </tr>
				    </thead>
				    <tbody>
				    	<?php
						$consulta= "SELECT * FROM vehiculo";
						$res=mysqli_query($conexion, $consulta) or die ("error");
						while($fila=mysqli_fetch_array($res)){

							echo "<tr>";
							echo "<td>".$fila['matriculaVehiculo']."</td>";
							echo "<td>".$fila['tipoVehiculo']."</td>";
							echo "<td>".$fila['marcaVehiculo']."</td>";
							echo "<td>".$fila['colorVehiculo']."</td>";
							$alg=$fila['matriculaVehiculo'];
							$consultaC="SELECT * FROM llevataller 
							WHERE matriculaVehiculo='$alg'";
							$resC=mysqli_query($conexion, $consultaC) or die ("error CON");
							$numC=mysqli_num_rows($resC);
							if($numC>0){
								while($filaC=mysqli_fetch_array($resC)){
								echo "<td>".$filaC['ciCliente']."&nbsp"."&nbsp"."</td>";
								}	
							} else {
								$consultaC="SELECT * FROM llevacorporacion
								WHERE matriculaVehiculo='$alg'";
								$resC=mysqli_query($conexion, $consultaC) or die ("error CON");
								while($filaC=mysqli_fetch_array($resC)){
								echo "<td>".$filaC['rutCliente']."&nbsp"."&nbsp"."</td>";
								}	

							}
							$matricula=urlencode($fila['matriculaVehiculo']);
							echo "<td class = 'centrarTextoTabla'>"."<a href='modificarVehiculoMecanico.php?matricula=".$matricula."'><i class='fas fa-edit'></i></a>"."&nbsp"."&nbsp"."<a href = 'eliminarVehiculo.php?matricula=".$matricula."' onclick='return confEliminar()'><i class='fas fa-trash-alt'></i></a>"."</td>";	
							echo "</tr>";
						}
						?>
				    </tbody>
				</table>
				
			</div>
		</div>
	</div>
	<!-------------Footer------------->
	<?php
			include 'footer.php';
		?>
</body>
</html>