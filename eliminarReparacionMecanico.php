<?php
	include "conexion.php";
	if(isset($_GET["codigo"])){
		$codigo=$_GET["codigo"];
		$consulta="DELETE FROM reparacion WHERE codigoReparacion='$codigo'";
		mysqli_query($conexion, $consulta) or die ("Error al Eliminar");
		 header("Location: usuarioPerfil.php");
	} else {
		echo "ERROR";
		echo "<a href='usuarioPerfil.php'> VOLVER </a>";
	}  
?>