<?php
	
	include "conexion.php";

	
	$marcaVerif = " /[a-zA-ZÀ-ÿ0-9\s]{0,35}$/ "; // 8 a 20 digitos.
	$colorVerif = " /^[a-zA-ZÀ-ÿ]{0,20}$/ "; // 15 numeros.
	

	$vacio = array();
	$err = array();

	//Verifica si existe registro
	if(isset($_POST['matriculaIngresoVehiculo'])) {
		$matriculaIngresoVehiculo=$_POST['matriculaIngresoVehiculo'];
		$consulta="SELECT * FROM vehiculo WHERE matriculaVehiculo='$matriculaIngresoVehiculo'";
		$res=mysqli_query($conexion, $consulta) or die ("Error:"." Error en la consulta");
		$numero = mysqli_num_rows($res);
		if ($numero==1){


			//Guardar las variables de post en variables php con nombre igual al del formulario
			foreach($_POST as $nombre_campo => $valor){
				$asignacion = "\$" . $nombre_campo . "='" . $valor . "';";
				eval($asignacion);
			}
			//Verificacion: 
			
			if(empty($cedula)){
				array_push($vacio, "La cédula no puede estar vacía");
			}

			if(empty($matriculaIngresoVehiculo)){
				array_push($vacio, "La matrícula no puede estar vacía");
			}
			
			if(empty($tipoIngresoVehiculoForm)){
				array_push($vacio, "El tipo no puede estar vacío");
			}
			if(!preg_match($marcaVerif, $tipoIngresoVehiculoForm)){
				array_push($err, "Caracteres especiales no son permitidos");
			}
			if(empty($marcaIngresoVehiculoForm)){
				array_push($vacio, "La marca no puede esar vacía");
			}
			if(!preg_match($marcaVerif, $marcaIngresoVehiculoForm)){
				array_push($err, "Caracteres especiales no son permitidos");
			}
			if(empty($colorIngresoVehiculoForm)){
				array_push($vacio, "El color no puede estar vacío");
			}
			if(!preg_match($colorVerif, $colorIngresoVehiculoForm)){
				array_push($err, "El campo solo debe contener letras");
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
				$sql = "UPDATE vehiculo SET colorVehiculo = '$colorIngresoVehiculoForm', tipoVehiculo= '$tipoIngresoVehiculoForm', marcaVehiculo= '$marcaIngresoVehiculoForm' WHERE matriculaVehiculo = '$matriculaIngresoVehiculo'";
				mysqli_query($conexion, $sql) or die ("Error:"." No modificado");
				echo "ok";
				mysqli_close($conexion);
			}
		} else {
			echo "Error:"." Vehículo no existe";
		}
	} else {
		echo "Error:"." error";
	}

?>
