<?php
	
	include "conexion.php";

	$rutVerif = " /^[0-9]{12}$/ ";
	$vacio = array();

	//Verifica si el post recavo los datos
	if(isset($_POST['rutUsuario'])) {
		$rutUsuario=$_POST['rutUsuario'];
		$contrasenaUsuario=$_POST['contrasenaUsuario'];
		//Verifica si la cédula o contraseña está vacia
		if(empty($rutUsuario)){
			array_push($vacio, "El RUT no puede estar vacío");
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
			$consulta="SELECT * FROM usuario WHERE idUsuario = '$rutUsuario'";
			$res=mysqli_query($conexion, $consulta) or die ("Error: Error en la consulta");
			$numero = mysqli_num_rows($res);
			//Verifica si existe usuario
			if (!empty($numero)){ 
				$fila=mysqli_fetch_array($res);
				//Compara lo ingresado por el usuario con lo guardado en la base
				if($rutUsuario==$fila["idUsuario"] && $contrasenaUsuario==$fila["contrasenaUsuario"]){
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