<?php
	include "conexion.php";
	if(isset($_GET["codigo"])){
		$id=$_GET["codigo"];
		$consultaI="SELECT * FROM repuesto WHERE idRepuesto='$id'";
		$resI=mysqli_query($conexion,$consultaI) or die ("Error");
		$filaI=mysqli_fetch_array($resI);
		unlink('imagenStock/'.$filaI['urlimagen']);
		$consulta="DELETE FROM repuesto WHERE idRepuesto='$id'";
		mysqli_query($conexion, $consulta) or die ("Error al Eliminar");

		header("Location: controlStock.php");
	} else {
		echo "ERROR";
		echo "<a href='controlStock.php'> VOLVER </a>";
	} 



?>