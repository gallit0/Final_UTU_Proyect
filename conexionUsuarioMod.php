<?php
	
	include "conexion.php";

	$ciVerif = " /^[0-9]{0,12}$/ "; // numeros
	$permVerif = " /^[1-3]{1}$/ ";
	$nombreVerif = " /^[a-zA-ZÀ-ÿ\s]{0,40}$/ "; // Letras y espacios, pueden llevar acentos.
	$direccionUsuarioVerif=" /^[a-zA-ZÀ-ÿ0-9\s\_.+-]{0,100}$/ "; 
	$passwordVerif = " /^(?=\w*\d)(?=\w*[A-Z])(?=\w*[a-z])\S{8,16}$/ "; // 8 a 20 digitos.
	$correoVerif = " /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/ "; 
	$telefonoVerif = " /^\d{0,15}$/ "; // 15 numeros.
	$fechaVerif = " /^[0-9-]{0,11}$/ "; 
	$vacio = array();
	$err = array();

	//Verifica si existe registro
	if(isset($_POST['id'])) {
		
	//Guardar las variables de post en variables php con nombre igual al del formulario
		foreach($_POST as $nombre_campo => $valor){
			$asignacion = "\$" . $nombre_campo . "='" . $valor . "';";
			eval($asignacion);
		}
	//Verificacion: 

		if(!preg_match($nombreVerif, $nombreApellidoUsuario)){
			array_push($err, "El campo no debe contener números o caracteres especiales");
		}
		if(empty($id)){
			array_push($vacio, "La cédula no puede estar vacía");
		}
		if(!preg_match($ciVerif, $id)){
			array_push($err, "El campo solo debe de contener numeros y 12 digitos máximo");
		}
		if(empty($direccionUsuario)){
			array_push($vacio, "La dirección no puede estar vacía");
		}
		if(!preg_match($direccionUsuarioVerif, $direccionUsuario)){
			array_push($err, "Caracteres no permitidos");
		}
		if(empty($contrasenaUsuario)){
			array_push($vacio, "La contraseña no puede estar vacía");
		}
		if(strlen($id)==8){

		
			if(empty($emailUsuario)){
				array_push($vacio, "El correo no puede estar vacío");
			}
			if(!preg_match($correoVerif, $emailUsuario)){
				array_push($err, "El campo no debe tener formato de email: ejemplo@correo.com");
			}
			if(empty($permiso)){
				array_push($vacio, "El permiso no puede estar vacío");
			}
			if(!preg_match($permVerif, $permiso)){
				array_push($err, "El permiso sólo puede valer 1, 2 o 3");
			}
			if($permiso==2||$permiso==3){
				if(empty($ocupacion)){
					array_push($vacio, "La ocupacion no puede estar vacía");
				}
				if(!preg_match($nombreVerif, $ocupacion)){
					array_push($err, "El campo no debe contener números o caracteres especiales");
				}
				if(empty($fechaNacimiento)){
					array_push($vacio, "La fecha de Nacimiento no puede estar vacía");
				}
				if(!preg_match($fechaVerif, $fechaNacimiento)){
					array_push($err, "El campo solo debe contener números");
				}
			}
		} else {
			if(empty($razonSocial)){
					array_push($vacio, "La razon social no puede estar vacía");
			}
			if(!preg_match($nombreVerif, $razonSocial)){
				array_push($err, "El campo no debe contener números o caracteres especiales");
			}
		}


	//Verfifica si existen errores
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
			//Elije Usuario Con Cedula
			if(strlen($id)==8){
				$sql = "UPDATE usuario SET emailUsuario = '$emailUsuario', nombreApellidoUsuario= '$nombreApellidoUsuario', direccionUsuario= '$direccionUsuario', contrasenaUsuario='$contrasenaUsuario', permisoUsuario='$permiso' WHERE idUsuario = '$id'";
    			mysqli_query($conexion, $sql) or die ("Error: No modificado");
    			$consulta= "SELECT * FROM empleado WHERE ciEmpleado='$id'";
    			$res=mysqli_query($conexion, $consulta) or die ("Error:"." No consultado");
    			if(mysqli_num_rows($res)>0){
    				$sql= "UPDATE empleado SET ocupacionEmpleado='$ocupacion', fechaNacimiento='$fechaNacimiento' WHERE ciEmpleado='$id'";
    				mysqli_query($conexion, $sql) or die ("Error:"." No modificado");
    				echo "ok";
    			} else {
    				if($permiso==2||$permiso==3){
    					$sql = "INSERT INTO empleado(ciEmpleado, ocupacionEmpleado, fechaNacimiento) VALUES ('$id', '$ocupacion','$fechaNacimiento')";
    					mysqli_query($conexion, $sql) or die ("Error:"." No creado");
    					echo "ok";
    				} else{
    					echo "ok";
    				}
    			}
			} else {
				$sql = "UPDATE usuario SET nombreApellidoUsuario= '$nombreApellidoUsuario', direccionUsuario= '$direccionUsuario', contrasenaUsuario='$contrasenaUsuario'WHERE idUsuario = '$id'";
				mysqli_query($conexion, $sql) or die ("Error:"." No modificaDdo");
				$sql = "UPDATE clientecorporativo SET razonSocial='$razonSocial'";
				mysqli_query($conexion, $sql) or die ("Error:"." No modificado");
				echo "ok";
			}
		 }
	  } else {
		echo "Error:"." Error en la carga";
	}

?>