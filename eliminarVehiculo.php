<?php
	include "conexion.php";
	if(isset($_GET["matricula"])){
		$matricula=$_GET["matricula"];
		$consulta="DELETE FROM vehiculo WHERE matriculaVehiculo='$matricula'";
		mysqli_query($conexion, $consulta) or die ("Error al Eliminar");
		header("Location: vehiculosTaller.php");
	} else {
		echo "ERROR";
		echo "<a href='vehiculosTaller.php'> VOLVER </a>";
	} 
?>