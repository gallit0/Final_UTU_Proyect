<?php
	include "conexion.php";
	if(isset($_GET['codigoRep']) && !empty($_GET['codigoRep'])){
		$codigoRep=$_GET['codigoRep'];
	} else {
		echo "Error";
		header("Location: controlStock.php");
	}
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
	<title>MadMotors - Adm Stock</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="estilo.css?v=<?php echo time(); ?>">
</head>
<script type="text/javascript">
	function confEliminar() {
		
		var respuesta=confirm("¿Está seguro de que quiere eliminar el repuesto de la reparacion?");
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
			Administrar Stock <?php echo "<b>".$codigoRep."</b>"; ?>

		</div>
		<div id= "cuerpoAdmUsuarios" class= "cuerpo">
			<form for = "" method = "">	
				<p>
					<div id = "filtroBusquedaUser">
						<label for = "tipoFiltroAdmUsuarios">Buscar por
							<select name ="tipoFiltroAdmUsuarios">
								<option value="nombre">Nombre</option>
								<option value="marca">Marca</option>
								<option value="proveedor">proveedor</option>
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
				            <th>ID</th>
				            <th>Nombre</th>
				            <th>Marca</th>
				            <th>Cantidad</th>
				            <th>Precio Unitario</th>
							<th>Precio Total</th>
							<th>Conf</th>
				        </tr>
				    </thead>
				    <tbody>
				    	<?php
						$consulta= "SELECT repuestousado.*, repuesto.* FROM repuestousado INNER JOIN repuesto USING(idRepuesto) WHERE codigoReparacion='$codigoRep'";
						$res=mysqli_query($conexion, $consulta) or die ("error");
						while($fila=mysqli_fetch_array($res)){
							if ($fila['idRepuesto'] != 0){


							echo "<tr>";
							echo "<td>".$fila['idRepuesto']."</td>";
							echo "<td>".$fila['nombreRepuesto']."</td>";
							echo "<td>".$fila['marcaRepuesto']."</td>";
							echo "<td>".$fila['cantidadusada']."</td>";
							echo "<td>".$fila['precioMomento']."&nbsp"."&nbsp"."</td>";
							$precioTot=number_format($fila['precioMomento']*$fila['cantidadusada'],2);
							echo "<td>".$precioTot."&nbsp"."&nbsp"."</td>";
							echo "<td>"."<a href = 'rmvStockMod.php?codigo=".$fila['idRepuesto']."&rep=".$codigoRep."' onclick='return confEliminar()'><i class='fas fa-trash-alt'></i></a>"."</td>";
							echo "</tr>";
						} 
						}

						?>
				    </tbody>
				</table>
				<?php
					$consulta="SELECT * FROM repuesto";
					$res=mysqli_query($conexion, $consulta) or die ("error");
					echo "<form method='post' action='addStockMod.php?rep=".$codigoRep."'>";
						echo "<select name ='repSeleccion'>";
						while($filaR=mysqli_fetch_array($res)){
							if ($filaR['idRepuesto'] != 0){
								echo "<option value='".$filaR['idRepuesto']."'>Nombre: ".$filaR['nombreRepuesto']." -- Marca: ".$filaR['marcaRepuesto']." -- Precio: ".$filaR['precioRepuesto'].' $U'."</option>";
								}
								 }
						echo "</select>"."&nbsp"."&nbsp";
						echo "<input type='number' name='cantidadU' value='1' min='0' />"."&nbsp"."&nbsp";
						echo "<input type='submit' value='Add to Cart'/>";
					echo "</form>";
				?>
			</div>
		</div>
	</div>
	<!-------------Footer------------->
	<?php
			include 'footer.php';
		?>
</body>
</html>