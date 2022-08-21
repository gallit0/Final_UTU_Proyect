<?php
	include "conexion.php";
	session_start();
    if(!isset($_SESSION['idUsuario'])){
		header("Location: login.php");
    }
	$nombre = $_SESSION['nombreApellidoUsuario'];
	$ci = $_SESSION['idUsuario'];
	$email = $_SESSION['emailUsuario'];
	$permiso = $_SESSION['permisoUsuario'];
?>

<!DOCTYPE html>
<html lang ="es">
<head>
	<meta charset = "UTF-8">
	<title>MadMotors - User</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="estilo.css?v=<?php echo time(); ?>">
	<link rel="icon" type="image/x-icon" href="imagenes_contenido/favicon.ico">
</head>
<script type="text/javascript">
	function confEliminar() {
		
		var respuesta=confirm("¿Confirma su opción elegida?");
		if(respuesta==true){
			return true;
		} else {
			return false;
		}
	}
</script>
<body>
<?php include 'cambioModoOscuro.php'?>
	<div id = "user">
	<!-----------------------------------------------Barra homepage----------------------------------------------->
		<?php
			include 'barraHeader.php';
		?>

		<!-----------------------------------------------Perfil----------------------------------------------->

		<div id = "perfilUser" class="cuerpo">
			<div class = "seccionPerfilUser">
				<div class = "infoSeccionPerfilUser">
					<?php
						echo "<p id = 'nombreUsuarioPerfilUser'>".$nombre."</p>";
						if($permiso == 3){
							echo "<p>Tipo de usuario: <strong>Administrador</strong></p>";
						}
						elseif($permiso == 2){
							echo "<p>Tipo de usuario: <strong>Mecánico</strong></p>";
						}
						else{
							echo "<p>Tipo de usuario: <strong>Cliente</strong></p>";
						}
						echo "<p>".$ci."</p>";
						echo "<p>".$email."</p>";
					?>
				</div>
			</div>
			<div class = "seccionPerfilUser">
				<p><i class="fa fa-user-circle"></i></p>
				<?php
					if($permiso == 3){
						echo '<p><a href="controlStock.php">Administrar stock</a></p>';
						echo '<p><a href="admUsuarios.php">Administrar usuarios</a></p>';
					}
					elseif($permiso == 2){
						echo '<p><a href="controlStock.php">Administrar stock</a></p>';
					}
					else{
						
					}
				?>
				<p><a href="cambiarContrasena.php">Cambiar contraseña</a></p>
				<p><a href="logout.php">Cerrar sesión</a></p>
			</div>
		</div>

		<!-----------------------------------------------Reparaciones en curso----------------------------------------------->
		<div class ="titulos">
			<?php
			if($permiso == 3){
				echo 'Administrar reparaciones en curso';
			}
			elseif($permiso == 2){
				echo 'Reparaciones a terminar';
			}
			else{
				echo 'Reparaciones en curso';
			}
			?>
		</div>
		<div id = "reparacionesUser" class="cuerpo">
			<div id ="filtroBusquedaReparacionesUser">
				<form action="">
					<input type="text" name="codigoReparacion" id="codigoReparacion" placeholder="Código de reparación">
					<input type="submit" value="Buscar">
				</form>

				<?php
					if($permiso>1){
						echo '<div id = "ingresoRepVehMecanico">';
						echo "<a href='ingresoReparacionMecanico.php'>Ingresar reparación</a>";
						echo "<br>";
						echo "<a href='ingresoVehiculoMecanico.php'>Ingresar vehículo</a>";
						echo "<br>";
						echo "<a href='ingresoUsuarioCorpMecanico.php' target='_blank'>Ingresar usuario corporativo</a>";
						echo '</div>';
					}
					else{}
				?>
			</div>
			
			<div id = "busquedaReparacionesUser"class="cuerpo">
				<?php
				if($permiso == 2 || $permiso == 3 ){
					echo "<table>";
						echo "<thead>";
						echo "<tr>";
							echo "<th>Código</th>";
							echo "<th>Descripción</th>";
							echo "<th>Presupuesto</th>";
							echo "<th>Combustible</th>";
							echo "<th>Km</th>";
							echo "<th>Fecha ingreso</th>";
							echo "<th>Fecha egreso</th>";
							echo "<th>Matrícula</th>";
							echo "<th>CI o RUT del cliente</th>";
							echo "<th>Estado</th>";
							echo "<th>Configuracion</th>";
						echo "</tr>";
						echo "</thead>";
						echo "<tbody>";
							$consulta="SELECT * FROM reparacion ";
							$res=mysqli_query($conexion, $consulta) or die ("error");
							while($fila=mysqli_fetch_array($res)){
								echo "<tr>";
								
								echo "<td>".$fila['codigoReparacion']."</td>";
								echo "<td>".$fila['descReparacion']."</td>";
								echo "<td>".$fila['presupuestoReparacion']." \$</td>";
								echo "<td>".$fila['CombustibleIngresoVehiculo']." L</td>";
								echo "<td>".$fila['kilometrajeVehiculo']."</td>";
								echo "<td>".$fila['fechaingreso']."</td>";
								if(is_null($fila['fechaegreso'])){
									echo "<td> - </td>";
								} else {
									echo "<td>".$fila['fechaegreso']."</td>";
								}
								echo "<td><a href='vehiculosTaller.php' target='_blank'>".$fila['matriculaVehiculo']."</td>";
								$alg=$fila['matriculaVehiculo'];
								$consultaC="SELECT * FROM llevataller
								WHERE matriculaVehiculo='$alg'";
								$resC=mysqli_query($conexion, $consultaC) or die ("error CON");
								$numC=mysqli_num_rows($resC);
								if($numC>0){
									echo "<td>";
									while($filaC=mysqli_fetch_array($resC)){
										echo $filaC['ciCliente']."&nbsp"."&nbsp";
									}
									echo "</td>";
								} else {
									$consultaC="SELECT * FROM llevacorporacion
									WHERE matriculaVehiculo='$alg'";
									$resC=mysqli_query($conexion, $consultaC) or die ("error CON");
									echo "<td>";
									while($filaC=mysqli_fetch_array($resC)){
										echo $filaC['rutCliente']."&nbsp"."&nbsp";
									}
									echo "</td>";
								}
								$codigo=$fila['codigoReparacion'];
								$consultaF="SELECT * FROM reparacionfactura WHERE codigoReparacion='$codigo'";
								$resF=mysqli_query($conexion, $consultaF);
								if($fila['presupuestoReparacion']==0 && mysqli_num_rows($resF)==0){
									echo "<td>"."En presupuestación"."</td>";
								} elseif ($fila['presupuestoReparacion']!=0 && mysqli_num_rows($resF)==0 && is_null($fila['aprobadaRep']) && is_null($fila['fechaegreso'])) {
									echo "<td>"."A espera de aprobación"."</td>";
								} elseif ($fila['presupuestoReparacion']!=0 && mysqli_num_rows($resF)==0 && $fila['aprobadaRep']==0 && is_null($fila['fechaegreso'])){
									echo "<td>"."Reparación denegada"."</td>";
								} elseif ($fila['presupuestoReparacion']!=0 && mysqli_num_rows($resF)==0 && $fila['aprobadaRep']==1 && is_null($fila['fechaegreso'])){
									echo "<td>"."Reparación aceptada"."</td>";
								} elseif ($fila['presupuestoReparacion']!=0 && mysqli_num_rows($resF)!=0 && is_null($fila['fechaegreso'])) {
									echo "<td>"."Reparación facturada"."</td>";
								} elseif(!is_null($fila['fechaegreso'])){
									echo "<td>"."Reparacion finalizada"."</td>";
								} else {
									echo "<td>"."Facturada"."</td>";
								}
								if(mysqli_num_rows($resF)==0){


								echo "<td class = 'centrarTextoTabla'>"."<a href='modificarReparacionMecanico.php?codigo=".$fila['codigoReparacion']."'><i class='fas fa-edit'></i></a> "."&nbsp"."&nbsp"."<a href='eliminarReparacionMecanico.php?codigo=".$fila['codigoReparacion']."' onclick='return confEliminar()'><i class='fas fa-trash-alt'></i></a>"."&nbsp"."&nbsp"."<a href='crearFacturaReparacion.php?codigo=".$fila['codigoReparacion']."' target='_blank'><i class='fas fa-file-alt'></i></a> "."</td>";
								} else  {
									echo "<td class = 'centrarTextoTabla'>"."<a href='modificarReparacionMecanico.php?codigo=".$fila['codigoReparacion']."'><i class='fas fa-edit'></i></a> "."&nbsp"."&nbsp"."<a href='eliminarReparacionMecanico.php?codigo=".$fila['codigoReparacion']."' onclick='return confEliminar()'><i class='fas fa-trash-alt'></i></a>"."&nbsp"."&nbsp"."<a href='facturasFin.php?codigo=".$fila['codigoReparacion']."' target='_blank'><i class='fas fa-file-alt'></i></a> "."</td>";
							}
							echo "</tr>";
							}
					
					echo "</tbody>";
				echo "</table>";
				} else {
					echo "<table>";
						echo "<thead>";
						echo "<tr>";
							echo "<th>Codigo Reparación</th>";
							echo "<th>Descripcion Reparación</th>";
							echo "<th>Presupuesto</th>";
							echo "<th>Combustible Ingreso</th>";
							echo "<th>Kilometraje</th>";
							echo "<th>Fecha Ingreso</th>";
							echo "<th>Fecha Egreso</th>";
							echo "<th>Matricula Vehiculo</th>";
							echo "<th>Estado</th>";
						echo "</tr>";
						echo "</thead>";
						echo "<tbody>";
							if(strlen($ci)==8){
								$consulta="SELECT reparacion.*, llevataller.* FROM reparacion 
										LEFT JOIN llevataller ON reparacion.matriculaVehiculo=llevataller.matriculaVehiculo 
										WHERE llevataller.ciCliente='$ci'";
								$res=mysqli_query($conexion, $consulta) or die ("error");
								while($fila=mysqli_fetch_array($res)){
									echo "<tr>";
									echo "<td>".$fila['codigoReparacion']."</td>";
									echo "<td>".$fila['descReparacion']."</td>";
									echo "<td>".$fila['presupuestoReparacion']."\$</td>";
									echo "<td>".$fila['CombustibleIngresoVehiculo']."</td>";
									echo "<td>".$fila['kilometrajeVehiculo']."</td>";
									echo "<td>".$fila['fechaingreso']."</td>";
									if(is_null($fila['fechaegreso'])){
										echo "<td>-</td>";
									} else {
										echo "<td>".$fila['fechaegreso']."</td>";
									}
									echo "<td>".$fila['matriculaVehiculo']."</td>";
									$codigo=$fila['codigoReparacion'];
									$consultaF="SELECT * FROM reparacionfactura WHERE codigoReparacion='$codigo'";
									$resF=mysqli_query($conexion, $consultaF);
									if($fila['presupuestoReparacion']==0 && mysqli_num_rows($resF)==0){
										echo "<td>"."En presupuestación"."</td>";
									} elseif ($fila['presupuestoReparacion']!=0 && mysqli_num_rows($resF)==0 && is_null($fila['aprobadaRep']) && is_null($fila['fechaegreso'])) {
										echo "<td class = 'centrarTextoTabla'>"."<a href='aprobarReparacion.php?codigo=".$fila['codigoReparacion']."&op=1' onclick='return confEliminar()'><i class='fas fa-check'></i></a> "."&nbsp"."&nbsp"."<a href='aprobarReparacion.php?codigo=".$fila['codigoReparacion']."&op=0' onclick='return confEliminar()'><i class='fas fa-times'></i></a>"."</td>";
									} elseif ($fila['presupuestoReparacion']!=0 && mysqli_num_rows($resF)==0 && $fila['aprobadaRep']==0 && is_null($fila['fechaegreso'])){
										echo "<td>"."Reparación denegada"."</td>";
									} elseif ($fila['presupuestoReparacion']!=0 && mysqli_num_rows($resF)==0 && $fila['aprobadaRep']==1 && is_null($fila['fechaegreso'])){
										echo "<td>"."Reparación aceptada"."</td>";
									} elseif ($fila['presupuestoReparacion']!=0 && mysqli_num_rows($resF)!=0 && is_null($fila['fechaegreso'])) {
										echo "<td>"."Reparación facturada"."</td>";
									} elseif(!is_null($fila['fechaegreso'])){
										echo "<td>"."Reparacion finalizada"."</td>";
									} else {
										echo "<td>"."Facturada"."</td>";
									}
						

								if(mysqli_num_rows($resF)==0){

							} else  {
								echo "<td class = 'centrarTextoTabla'>"."<a href='facturasFin.php?codigo=".$fila['codigoReparacion']."' target='_blank'><i class='fas fa-file-alt' ></i></a> "."</td>";
							}
									echo "</tr>";
								}
							} else {
								$consulta="SELECT reparacion.*, llevacorporacion.* FROM reparacion 
										LEFT JOIN llevacorporacion ON reparacion.matriculaVehiculo=llevacorporacion.matriculaVehiculo 
										WHERE llevacorporacion.rutCliente='$ci'";
								$res=mysqli_query($conexion, $consulta) or die ("error");
								while($fila=mysqli_fetch_array($res)){
									echo "<tr>";
									echo "<td>".$fila['codigoReparacion']."</td>";
									echo "<td>".$fila['descReparacion']."</td>";
									echo "<td>".$fila['presupuestoReparacion']."\$</td>";
									echo "<td>".$fila['CombustibleIngresoVehiculo']."</td>";
									echo "<td>".$fila['kilometrajeVehiculo']."</td>";
									echo "<td>".$fila['fechaingreso']."</td>";
									if(is_null($fila['fechaegreso'])){
										echo "<td>-</td>";
									} else {
										echo "<td>".$fila['fechaegreso']."</td>";
									}
									echo "<td>".$fila['matriculaVehiculo']."</td>";
									$codigo=$fila['codigoReparacion'];
									$consultaF="SELECT * FROM reparacionfactura WHERE codigoReparacion='$codigo'";
									$resF=mysqli_query($conexion, $consultaF);
									if($fila['presupuestoReparacion']==0 && mysqli_num_rows($resF)==0){
										echo "<td>"."En presupuestación"."</td>";
									} elseif ($fila['presupuestoReparacion']!=0 && mysqli_num_rows($resF)==0 && is_null($fila['aprobadaRep']) && is_null($fila['fechaegreso'])) {
										echo "<td class = 'centrarTextoTabla'>"."<a href='aprobarReparacion.php?codigo=".$fila['codigoReparacion']."&op=1' onclick='return confEliminar()'><i class='fas fa-check'></i></a> "."&nbsp"."&nbsp"."<a href='aprobarReparacion.php?codigo=".$fila['codigoReparacion']."&op=0' onclick='return confEliminar()'><i class='fas fa-times'></i></a>"."</td>";
									} elseif ($fila['presupuestoReparacion']!=0 && mysqli_num_rows($resF)==0 && $fila['aprobadaRep']==0 && is_null($fila['fechaegreso'])){
										echo "<td>"."Reparación denegada"."</td>";
									} elseif ($fila['presupuestoReparacion']!=0 && mysqli_num_rows($resF)==0 && $fila['aprobadaRep']==1 && is_null($fila['fechaegreso'])){
										echo "<td>"."Reparación aceptada"."</td>";
									} elseif ($fila['presupuestoReparacion']!=0 && mysqli_num_rows($resF)!=0 && is_null($fila['fechaegreso'])) {
										echo "<td>"."Reparación facturada"."</td>";
									} elseif(!is_null($fila['fechaegreso'])){
										echo "<td>"."Reparacion finalizada"."</td>";
									} else {
										echo "<td>"."Facturada"."</td>";
									}
									if(is_null($fila['aprobadaRep'])){
										echo "<td class = 'centrarTextoTabla'>"."<a href='aprobarReparacion.php?codigo=".$fila['codigoReparacion']."&op=1' onclick='return confEliminar()'><i class='fas fa-check'></i></a> "."&nbsp"."&nbsp"."<a href='aprobarReparacion.php?codigo=".$fila['codigoReparacion']."&op=0' onclick='return confEliminar()'><i class='fas fa-times'></i></a>"."</td>";} 
									else {
										if($fila['aprobadaRep']==1){
											echo "<td> Reparación Aprobada </td>";
										} else {
											echo "<td> Reparación Denegada </td>";
										}
									}
									
									if(mysqli_num_rows($resF)==0){

									} else  {
										echo "<td class = 'centrarTextoTabla'>"."<a href='facturasFin.php?codigo=".$fila['codigoReparacion']." ' target='_blank'><i class='fas fa-file-alt'></i></a> "."</td>";
									}
									echo "</tr>";
							}
						 }
					echo "</tbody>";
				echo "</table>";
				}
				?>
			</div>
		</div>
		
	</div>
<!-----------------------------------------------Footer----------------------------------------------->
	<?php
		include 'footer.php';
	?>
</body>
</html>