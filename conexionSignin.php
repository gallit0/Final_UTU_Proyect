<?php
	session_start();
	include "conexion.php";

	$ciVerif = " /^[0-9]{0,8}$/ "; // numeros
	$nombreVerif = " /^[a-zA-ZÀ-ÿ\s]{0,40}$/ "; // Letras y espacios, pueden llevar acentos.
	$direccionUsuarioVerif=" /^[a-zA-ZÀ-ÿ0-9\s\_.+-]{0,100}$/ "; 
	$passwordVerif = " /^(?=\w*\d)(?=\w*[A-Z])(?=\w*[a-z])\S{8,16}$/ "; // 8 a 16 digitos.
	$correoVerif = " /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/ "; 
	$telefonoVerif = " /^\d{0,15}$/ "; // 15 numeros.
	$vacio = array();
	$err = array();

	//Verifica si existe registro
	if(isset($_POST['idUsuario'])) {
		
		//Guardar las variables de post en variables php con nombre igual al del formulario
		foreach($_POST as $nombre_campo => $valor){
			$asignacion = "\$" . $nombre_campo . "='" . $valor . "';";
			eval($asignacion);
		}
		//Verificacion: 
		
		if(empty($nombreApellidoUsuario)){
			array_push($vacio, "El nombre no puede estar vacío");
		}
		if(!preg_match($nombreVerif, $nombreApellidoUsuario)){
			array_push($err, "El campo no debe contener números o caracteres especiales");
		}
		if(empty($emailUsuario)){
			array_push($vacio, "El correo no puede estar vacío");
		}
		if(!preg_match($correoVerif, $emailUsuario)){
			array_push($err, "El campo no debe tener formato de email: ejemplo@correo.com");
		}
		$consulta="SELECT * FROM usuario WHERE emailUsuario  = '$emailUsuario'";
		$res=mysqli_query($conexion, $consulta) or die ("Error: Error en la consulta");
		$numero = mysqli_num_rows($res);
		if($numero==1){
			array_push($err, "El correo ya existe");
		}
		if(empty($idUsuario)){
			array_push($vacio, "La cédula no puede estar vacía");
		}
		if(!preg_match($ciVerif, $idUsuario)){
			array_push($err, "El campo solo debe de contener numeros y 8 digitos máximo");
		}
		if(empty($direccionUsuario)){
			array_push($vacio, "La dirección no puede estar vacía");
		}
		if(!preg_match($direccionUsuarioVerif, $direccionUsuario)){
			array_push($err, "Caracteres no permitidos");
		}
		if(empty($telefonosUsuario1)){
			array_push($vacio, "El telefono no puede estar vacío");
		}
		if(!preg_match($telefonoVerif, $telefonosUsuario1)){
			array_push($err, "El campo solo debe contener numeros con un máximo de 15 digitos");
		}
		if(empty($contrasenaUsuario)){
			array_push($vacio, "La contraseña no puede estar vacía");
		}
		if(!preg_match($passwordVerif, $contrasenaUsuario)){
			array_push($err, "El campo debe contener entre 8 a 20 caractertes y debe haber almenos 1 mayúscula, 1 minúscula y un número");
		}
		if($contrasenaUsuario != $confirmarContrasena){
			array_push($err, "Las contraseñas no coinciden");
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
			//compruebo si ya existe el usuario
			$consulta="SELECT * FROM usuario WHERE idUsuario = '$idUsuario'";
			$res=mysqli_query($conexion, $consulta) or die ("Error: Error en la consulta");
			$numero = mysqli_num_rows($res);
			//si no existe
			if($numero==0){


		//Realiza las consultas a la base de datos
				$consulta="INSERT INTO usuario(idUsuario, emailUsuario, contrasenaUsuario, nombreApellidoUsuario, direccionUsuario) VALUES ('$idUsuario', '$emailUsuario','$contrasenaUsuario', '$nombreApellidoUsuario', '$direccionUsuario')";
				mysqli_query($conexion, $consulta) or die ("Error: Error al subir los datosS");
				$consulta="INSERT INTO telefonosUsuario(idUsuario, telefonosUsuario) VALUES ('$idUsuario', '$telefonosUsuario1')";
				mysqli_query($conexion, $consulta) or die ("Error: Error al subir los datOos");
				echo "ok";
				$permisoUsuario=1;
				
				$_SESSION['idUsuario'] = $idUsuario;
				$_SESSION['nombreApellidoUsuario'] = $nombreApellidoUsuario;
				$_SESSION['emailUsuario'] = $emailUsuario;
				$_SESSION['direccionUsuario'] = $direccionUsuario;
				$_SESSION['permisoUsuario'] = $permisoUsuario;
			} else {
			//Si existe le cambia los datos que faltan
			$linea=mysqli_fetch_array($res);
			if(empty($linea['contrasenaUsuario'])){
				$consulta="UPDATE usuario SET emailUsuario='$emailUsuario', contrasenaUsuario='$contrasenaUsuario', nombreApellidoUsuario='$nombreApellidoUsuario', direccionUsuario='$direccionUsuario' WHERE idUsuario='$idUsuario'";
				mysqli_query($conexion, $consulta) or die ("Error: Error al subir los datos");
				$consulta="INSERT INTO telefonosUsuario(idUsuario, telefonosUsuario) VALUES ('$idUsuario', '$telefonosUsuario1')";
				mysqli_query($conexion, $consulta) or die ("Error: Error al subir los datos");
				echo "ok";
				$permisoUsuario=1;
				$_SESSION['idUsuario'] = $idUsuario;
				$_SESSION['nombreApellidoUsuario'] = $nombreApellidoUsuario;
				$_SESSION['emailUsuario'] = $emailUsuario;
				$_SESSION['direccionUsuario'] = $direccionUsuario;
				$_SESSION['permisoUsuario'] = $permisoUsuario;
			} else {
				echo "Error: Usuario ya existe";
			}

		}
			mysqli_close($conexion);
			} 
		
		
	} else {
		echo "Error: error";
	}

?>