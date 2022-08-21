<?php
include "conexion.php";
session_start();
if(isset($_SESSION['idUsuario'])){
	if($_SESSION['permisoUsuario']==2 || $_SESSION['permisoUsuario']==1){
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
		
		var respuesta=confirm("¿Está seguro de que quiere eliminar al usuario permanentemente?");
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
			Administrar usuarios
		</div>
		<div id= "cuerpoAdmUsuarios" class= "cuerpo">
			<form for = "" method = "">	
				<p>
					<div id = "filtroBusquedaUser">
						<label for = "tipoFiltroAdmUsuarios">Buscar por
							<select name ="tipoFiltroAdmUsuarios">
								<option value="nombre">Nombre</option>
								<option value="email">Email</option>
								<option value="id">Identificador</option>
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
				            <th>CI o RUT</th>
				            <th>Email</th>
				            <th>Nombre</th>
				            <th>Direccion</th>
				            <th>Permiso</th>
				            <th>Telefonos</th>
				            <th>Ocupacion Empleado</th>
				            <th>Razon Social</th>
							<th>Configurar</th>
				        </tr>
				    </thead>
				    <tbody>
				    	<?php
						$consulta= "SELECT * FROM usuario";
						$res=mysqli_query($conexion, $consulta) or die ("error");
						while($fila=mysqli_fetch_array($res)){

							echo "<tr>";
							echo "<td>".$fila['idUsuario']."</td>";
							echo "<td>".$fila['emailUsuario']."</td>";
							echo "<td>".$fila['nombreApellidoUsuario']."</td>";
							echo "<td>".$fila['direccionUsuario']."</td>";
							echo "<td>".$fila['permisoUsuario']."</td>";
							$ci=$fila['idUsuario'];
							$consultaT="SELECT * FROM telefonosUsuario WHERE idUsuario='$ci'";
							$resT=mysqli_query($conexion, $consultaT) or die ("error");
							echo "<td>";
							while($filaT=mysqli_fetch_array($resT)){
								echo $filaT['telefonosUsuario']."&nbsp"."&nbsp";
							}
							echo "</td>";
							if($fila['permisoUsuario']>1){
								$consultaE="SELECT * FROM empleado WHERE ciEmpleado='$ci'";
								$resE=mysqli_query($conexion, $consultaE) or die ("error");
								if(mysqli_num_rows($resE)>0){
									$filaE=mysqli_fetch_array($resE);
									echo "<td>".$filaE['ocupacionEmpleado']."</td>";
								}
							} else {
								echo "<td></td>";
							}
							if(strlen($fila['idUsuario'])>8){
								$consultaC="SELECT * FROM clientecorporativo WHERE rutCliente='$ci'";
								$resC=mysqli_query($conexion, $consultaC) or die ("error");
								$filaC=mysqli_fetch_array($resC);
								echo "<td>".$filaC['razonSocial']."</td>";
							}  else {
								echo "<td></td>";
							}
							echo "<td class = 'centrarTextoTabla'>"."<a href='modificacionUsuario.php?identificador=".$fila['idUsuario']."'><i class='fas fa-edit'></i></a>"."&nbsp"."&nbsp"."<a href = 'eliminarUsuario.php?identificador=".$fila['idUsuario']."' onclick='return confEliminar()'><i class='fas fa-trash-alt'></i></a>"."</td>";	
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