<?php
	
	include "conexion.php";
	$matriculaVerif = " /^[a-zA-Z0-9\s]{0,10}$/ "; // Letras y espacios, pueden llevar acentos.
	$kmVerif=" /^[0-9]{0,7}$/ ";
	$fechaVerif = " /^[0-9-]{0,11}$/ "; 
	$combustibleVerif = " /^[0-9]{0,3}$/ "; // 15 numeros.
	$presupuestoVerif = " /^[0-9.]{0,6}$/ "; // 15 numeros.
	$descripcionVerif = " /^[a-zA-ZÀ-ÿ0-9,.\s]{0,400}$/ "; // 15 numeros.

	$vacio = array();
	$err = array();

	//Verifica si existe Vehículo
	if(isset($_POST['CodigoReparacion'])) {
		$CodigoReparacion=$_POST['CodigoReparacion'];
		$matriculaIngresoVehiculo=$_POST['matriculaIngresoVehiculo'];
		$consulta="SELECT * FROM reparacion WHERE codigoReparacion = '$CodigoReparacion' && matriculaVehiculo='$matriculaIngresoVehiculo' ";
		$res=mysqli_query($conexion, $consulta) or die ("Error:"."<br>"."Error en la consulta");
		$numero = mysqli_num_rows($res);
		if ($numero==1) {
	//Guardar las variables de post en variables php con nombre igual al del formulario
			foreach($_POST as $nombre_campo => $valor){
			$asignacion = "\$" . $nombre_campo . "='" . $valor . "';";
			eval($asignacion);
			}
	//Verificacion: 
			
			if(empty($matriculaIngresoVehiculo)){
				array_push($vacio, "La matrícula no puede estar vacía");
			}
			if(!preg_match($matriculaVerif, $matriculaIngresoVehiculo)){
				array_push($err, "El campo no puede tener caracteres especiales, solo letras y numeros");
			}
			if(empty($kmIngresoVehiculo)){
				array_push($vacio, "El kilometraje no puede estar vacío");
			}
			if(!preg_match($kmVerif, $kmIngresoVehiculo)){
				array_push($err, "El campo solo debe de contener numeros y 7 digitos máximo");
			}
			if(empty($combustibleIngresoVehiculo)){
				array_push($vacio, "El combustible no puede estar vacío");
			}
			if(!preg_match($combustibleVerif, $combustibleIngresoVehiculo)){
				array_push($err, "El campo solo debe contener numeros enteros con un máximo de 3 digitos");
			}
			if(empty($fechaIngresoVehiculo)){
				array_push($vacio, "La fecha no puede estar vacía");
			}
			if(!preg_match($fechaVerif, $fechaIngresoVehiculo)){
				array_push($err, "Carácteres no permitidos");
			}
			if(!preg_match($fechaVerif, $fechaEgresoVehiculo)){
				array_push($err, "Carácteres no permitidos");
			}
			if (empty($presupuestoIngresoVehiculo)){
				$presupuestoVerif=0;
			} else {
				if(!preg_match($presupuestoVerif, $presupuestoIngresoVehiculo)){
					array_push($err, "Solo es permitido un máximo de 8 digitos");
				}
			}
			
			if(empty($descIngresoVehiculo)){
				array_push($vacio, "La descripcion no puede estar vacía");
			}
			if(!preg_match($descripcionVerif, $descIngresoVehiculo)){
				array_push($err, "Solo es permitido un máximo de 400 caracteres");
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
				$sql = "UPDATE reparacion SET descReparacion = '$descIngresoVehiculo', presupuestoReparacion= '$presupuestoIngresoVehiculo', CombustibleIngresoVehiculo= '$combustibleIngresoVehiculo', kilometrajeVehiculo='$kmIngresoVehiculo', fechaingreso='$fechaIngresoVehiculo', fechaegreso=  NULLIF('$fechaEgresoVehiculo', '') WHERE codigoReparacion = '$CodigoReparacion'";
				mysqli_query($conexion, $sql) or die ( "Error:"."<br>"."No modificado");
				echo "ok";
				mysqli_close($conexion);
			} 
		} else {
			echo  "Error:"."<br>"."No existe Reparacion";
		}
	} else {
		echo  "Error:"."<br>"."error en la carga de datos";
	}

?>
