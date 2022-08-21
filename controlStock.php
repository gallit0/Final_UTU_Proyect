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
<html lang ="es">
<head>
	<meta charset = "UTF-8">
	<title>MadMotors - Stock</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="estilo.css?v=<?php echo time(); ?>">
	<link rel="icon" type="image/x-icon" href="imagenes_contenido/favicon.ico">
</head>
<script type="text/javascript">
	function confEliminar() {
		
		var respuesta=confirm("¿Está seguro de querer eliminar el repuesto permanentemente?");
		if(respuesta==true){
			return true;
		} else {
			return false;
		}
	}
</script>
<body>
<?php include 'cambioModoOscuro.php'?>
	<div id = "controlDeStock">
		<!-----------------------------------------------Barra homepage----------------------------------------------->
		<?php
			include 'barraHeader.php';
		?>
		<!-----------------------------------------------Control de stock----------------------------------------------->
		<div id = "cuerpoStock">
			<div id = "muestraStock" class="cuerpo">
				<div id = "titulo_AB_Stock">
					<div class="titulos">
						Stock
					</div>
					<div id = "AB_Stock">
						<input type="button" name="aStock" value = "Ingresar stock" onclick="location.href='admStock.php'">
					</div>
					<form action="addStock.php" mathod="get" target='_blank'>
						<input type="text" name="codigoRep" size=16 placeholder="Reparación" >
						<input type="submit" name="btnSubmit" value="Agregar Stock a la reparacion">
					</form>
				</div>


				<div id = "stockCatalogo" class="cuerpo">

					
					<!--EJEMPLO-->
					<?php
					$consulta="SELECT * FROM repuesto";
					$res=mysqli_query($conexion, $consulta) or die ("error");
					while($fila=mysqli_fetch_array($res)){
						if($fila['idRepuesto'] != 0){

						echo"<div class = 'stock'>";
						echo"<div class = 'stock_imagen'>";
						
						echo"<img src='imagenStock/".$fila['urlimagen']."'>";
						echo"</div>";
						echo"<div class = 'stock_descripcion'>";
						echo"<div class = 'stock_descripcion_titulo'>";
						echo "<b>".$fila['nombreRepuesto']."</b><br>";
						echo "Marca: ".$fila['marcaRepuesto']."<br>";
						echo"</div>";
						echo"<div class = 'stock_descripcion_texto'>";
						echo $fila['desRepuesto']."<br>";
						echo "Cantidad Restante: ".$fila['cantidadRepuesto']."<br>";
						echo "Precio unitario: ".$fila['precioRepuesto'].'$';
						echo "<br><br>";
						echo "<a href='modificarAdmStock.php?codigo=".$fila['idRepuesto']."'><i class='fas fa-edit'></i></a>"."&nbsp"."&nbsp"."<a href = 'eliminarRepuesto.php?codigo=".$fila['idRepuesto']."' onclick='return confEliminar()'><i class='fas fa-trash-alt'></i></a>";
						echo "<br>";
						echo"<div style=color:#BB0000>";
						if($fila['cantidadRepuesto']<$fila['recordatorio']){
							echo "Quedan pocos en stock";
						}
						echo"</div>";
						echo"</div>";
						echo"</div>";
						echo"</div>";
						} 
					}
					?>
					<!--EJEMPLO-->
					

				</div>
			</div>
		</div>
	</div>
		<!-----------------------------------------------Footer----------------------------------------------->
		<?php
			include 'footer.php';
		?>
	

</body>
</html>