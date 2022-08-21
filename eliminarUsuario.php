<?php
	include "conexion.php";
	if(isset($_GET["identificador"])){
		$id=$_GET["identificador"];
		$consulta="DELETE FROM usuario WHERE idUsuario='$id'";
		mysqli_query($conexion, $consulta) or die ("Error al Eliminar");
		header("Location: admUsuarios.php");
	} else {
		echo "ERROR";
		echo "<a href='admUsuarios.php'> VOLVER </a>";
	} 



?>