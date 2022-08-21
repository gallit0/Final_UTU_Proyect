<?php
	
	include "conexion.php";
	$nombreVerif = " /^[a-zA-ZÀ-ÿ0-9.,\s]{0,50}$/ ";
	$rutVerif = " /^[0-9]{12}$/ ";
	$telefonoVerif = " /^\d{0,15}$/ "; // 15 numeros.
	$direccionVerif=" /^[a-zA-ZÀ-ÿ0-9\s\_.+-]{0,100}$/ ";
	$vacio=array();
	$err=array();

	if(isset($_POST['rutUsuario'])) {

		//Guardar las variables de post en variables php con nombre igual al del formulario
		foreach($_POST as $nombre_campo => $valor){
		$asignacion = "\$" . $nombre_campo . "='" . $valor . "';";
		eval($asignacion);
		}
		if(empty($rutUsuario)){
			array_push($vacio, "El rut no puede estar vacío");
		}
		if(!preg_match($rutVerif, $rutUsuario)){
			array_push($err, "El rut no debe contener espaciado y tan solo 12 digitos");
		}
		if(empty($razonSocialUsuario)){
			array_push($vacio, "La razon social no puede estar vacía");
		}
		if(!preg_match($nombreVerif, $razonSocialUsuario)){
			array_push($err, "El campo no debe contener caracteres especiales");
		}

		if(empty($telefonoUsuario)){
			array_push($vacio, "El telefono no puede estar vacío");
		}
		if(!preg_match($telefonoVerif, $telefonoUsuario)){
			array_push($err, "El campo solo debe contener numeros con un máximo de 15 digitos");
		}
		if(empty($direccionUsuario)){
			array_push($vacio, "La direccion no puede estar vacía");
		}
		if(!preg_match($direccionVerif, $direccionUsuario)){
			array_push($err, "Caracteres no permitidos en la direccion");
		}
		if (count($vacio)>0 || count($err)>0){
			echo "Vacío: "."<br>";
			for($i = 0; $i < count($vacio); $i++){
				echo $vacio[$i].", ";
			}
			echo "<br>"."Error: "."<br>";
			for($i = 0; $i < count($err); $i++){
				echo $err[$i].", ";
			}
		} else {
			$consulta= "SELECT * FROM usuario WHERE idUsuario='$rutUsuario'";
			$res=mysqli_query($conexion, $consulta) or die ("Error:"." Error en la consulta");
			$numero = mysqli_num_rows($res);
			if($numero==1){
				echo "Error:"." Cliente corporativo existe";
			} else{
				$contrasenaUsuario = substr(md5(rand()),0,10);
				echo "Su contraseña es: ". $contrasenaUsuario;
				$consulta="INSERT INTO usuario(idUsuario, contrasenaUsuario, direccionUsuario) VALUES ('$rutUsuario', '$contrasenaUsuario', '$direccionUsuario')";
				mysqli_query($conexion, $consulta) or die ("Error:"." Error en la consulta");
				$consulta="INSERT INTO telefonosUsuario(idUsuario, telefonosUsuario) VALUES ('$rutUsuario', '$telefonoUsuario')";
				mysqli_query($conexion, $consulta) or die ("Error:"." Error en la consultAa");
				$consulta="INSERT INTO clientecorporativo (rutCliente, razonSocial) VALUES ('$rutUsuario', '$razonSocialUsuario')";
				mysqli_query($conexion, $consulta) or die ("Error:"." Error en la consultaA");
			}
		}
	} else {
		echo "Error:"." Error en la carga de datos";
	}
?>