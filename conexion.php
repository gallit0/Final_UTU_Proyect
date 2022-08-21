<?php

	//Conexion a base de datos madmotors
	$conexion = mysqli_connect("localhost","root","","madmotorsP") or die(mysql_error($mysqli));
	if (!$conexion) {
	echo "Connection failed!";
	exit();
	}

?>