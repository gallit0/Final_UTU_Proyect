<?php
	
	include "conexion.php";

	$direccionUsuarioVerif=" /^[a-zA-ZÀ-ÿ0-9\s\_.+-]{0,100}$/ ";
	$passwordVerif = " /^(?=\w*\d)(?=\w*[A-Z])(?=\w*[a-z])\S{8,16}$/ "; // 8 a 20 digitos.
	$vacio = array();

	//Verifica si el post recavo los datos
	if(isset($_POST['emailUsuario'])) {
		$emailUsuario=$_POST['emailUsuario'];
		$contrasenaUsuario=$_POST['contrasenaUsuario'];
		//Verifica si la cédula o contraseña está vacia
		if(empty($emailUsuario)){
			array_push($vacio, "el email no puede estar vacío");
			}
		if(empty($contrasenaUsuario)){
			array_push($vacio, "La contraseña no puede estar vacía");
			}
		if (count($vacio)>0){
			echo "Vacío: "."<br>";
			for($i = 0; $i < count($vacio); $i++){
				echo $vacio[$i].", ";
			}
		} else {
			//Realiza la consulta a la base de datos
			$consulta="SELECT * FROM usuario WHERE emailUsuario = '$emailUsuario'";
			$res=mysqli_query($conexion, $consulta) or die ("Error: Error en la consulta");
			$numero = mysqli_num_rows($res);
			//Verifica si existe usuario
			if (!empty($numero)){ 
				$fila=mysqli_fetch_array($res);
				//Compara lo ingresado por el usuario con lo guardado en la base
				if($emailUsuario==$fila["emailUsuario"] && $contrasenaUsuario==$fila["contrasenaUsuario"]){
					echo "ok";
					session_start();
					$_SESSION['idUsuario'] = $fila['idUsuario'];
					$_SESSION['nombreApellidoUsuario'] = $fila['nombreApellidoUsuario'];
					$_SESSION['emailUsuario'] = $fila['emailUsuario'];
					$_SESSION['direccionUsuario'] = $fila['direccionUsuario'];
					$_SESSION['permisoUsuario'] = $fila['permisoUsuario'];
				} else {
					echo "Error: Contraseña incorrecta";
				}
			
			} else {
				echo "Error: No existe el Usuario";
			}
		}
	} else {
			echo "Error: Erroro";
	}

?>