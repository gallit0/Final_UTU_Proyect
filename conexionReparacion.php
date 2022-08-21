<?php
	session_start();
	include "conexion.php";
	$empleadoCi=$_SESSION['idUsuario'];
	$ciVerif = " /^[0-9]{0,12}$/ "; // numeros
	$matriculaVerif = " /^[a-zA-Z0-9\s]{0,10}$/ "; // Letras y espacios, pueden llevar acentos.
	$kmVerif=" /^[0-9]{0,7}$/ "; 
	$marcaVerif = " /[a-zA-ZÀ-ÿ0-9\s]{0,35}$/ "; // 8 a 20 digitos.
	$fechaVerif = " /^[0-9-]{0,11}$/ "; 
	$colorVerif = " /^[a-zA-ZÀ-ÿ]{0,20}$/ "; // 15 numeros.
	$combustibleVerif = " /^[0-9]{0,3}$/ "; // 15 numeros.
	$presupuestoVerif = " /^[0-9.]{0,8}$/ "; // 15 numeros.
	$descripcionVerif = " /^[a-zA-ZÀ-ÿ0-9,.\s]{0,400}$/ "; // 15 numeros.

	$vacio = array();
	$err = array();

	//Verifica si existe Vehículo
	if(isset($_POST['matriculaIngresoVehiculo'])) {
		$matriculaV=$_POST['matriculaIngresoVehiculo'];
		$consulta="SELECT * FROM vehiculo WHERE matriculaVehiculo = '$matriculaV'";
		$res=mysqli_query($conexion, $consulta) or die ("Error:"." Error en la consulta");
		$numero = mysqli_num_rows($res);
		if ($numero==1) {
	//Guardar las variables de post en variables php con nombre igual al del formulario
			foreach($_POST as $nombre_campo => $valor){
			$asignacion = "\$" . $nombre_campo . "='" . $valor . "';";
			eval($asignacion);
			}
	//Verificacion: 
			
			if(empty($ci)){
				array_push($vacio, "La cédula no puede estar vacía");
			}
			if(!preg_match($ciVerif, $ci)){
				array_push($err, "El campo solo debe contener numeros, un máximo de 12");
			}
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
				$idReparacion = uniqid('MAD', false);
				$numero=1;
				do{
					$consulta="SELECT * FROM reparacion WHERE codigoReparacion = '$idReparacion'";
					$res=mysqli_query($conexion, $consulta) or die ("Error:"." Error en la consulta");
					$numero = mysqli_num_rows($res);
				} while($numero==1);
	//Realiza las consultas a la base de datos
				if(strlen($ci)==8){


					$consulta="SELECT * FROM llevataller WHERE matriculaVehiculo = '$matriculaIngresoVehiculo' AND ciCliente = '$ci'";
					$res=mysqli_query($conexion, $consulta) or die ("Error:"." Error en la consulta");
					$numero = mysqli_num_rows($res);
					//Si existe realción
					if ($numero==1){
						//Crea id únic

						$consulta="INSERT INTO reparacion(codigoReparacion, descReparacion, presupuestoReparacion, CombustibleIngresoVehiculo, kilometrajeVehiculo, fechaingreso, matriculaVehiculo) VALUES ('$idReparacion', '$descIngresoVehiculo', '$presupuestoIngresoVehiculo', '$combustibleIngresoVehiculo', '$kmIngresoVehiculo', '$fechaIngresoVehiculo', '$matriculaIngresoVehiculo')";
						mysqli_query($conexion, $consulta) or die ("Error:"." Error al subir los datos");
						$consulta="INSERT INTO empleadoasignado (ciEmpleado, codigoReparacion) VALUES ('$empleadoCi', '$idReparacion') ";
						mysqli_query($conexion, $consulta) or die ("Error:"." Error al subir los datos Empleado");
						echo "ok";	
					} else {
						//Si no existe realción
						$consulta="SELECT ciCliente FROM cliente WHERE ciCliente = '$ci'";
						$res=mysqli_query($conexion, $consulta) or die ("Error:"." Error en la consulta cliente");
						$numero = mysqli_num_rows($res);
						//Si existe cliente
						if($numero==1){
							//Relaciona Cliente con Vehiculo
							$consulta="INSERT INTO llevataller(ciCliente, matriculaVehiculo) VALUES ('$ci', '$matriculaIngresoVehiculo')";
							mysqli_query($conexion, $consulta) or die ("Error:"." Error al subir los datos");
							$consulta="INSERT INTO reparacion(codigoReparacion, descReparacion, presupuestoReparacion, CombustibleIngresoVehiculo, kilometrajeVehiculo, fechaingreso, matriculaVehiculo) VALUES ('$idReparacion', '$descIngresoVehiculo', '$presupuestoIngresoVehiculo', '$combustibleIngresoVehiculo', '$kmIngresoVehiculo', '$fechaIngresoVehiculo', '$matriculaIngresoVehiculo')";
							mysqli_query($conexion, $consulta) or die ("Error:"." Error al subir los datos");
							$consulta="INSERT INTO empleadoasignado (ciEmpleado, codigoReparacion) VALUES ('$empleadoCi', '$idReparacion') ";
							mysqli_query($conexion, $consulta) or die ("Error:"." <br>"."Error al subir los datos");	
							echo "ok";	
						//si no existe cliente
						} else {
							//Comprueba si existe usuario
							$consulta="SELECT idUsuario FROM usuario WHERE idUsuario = '$ci'";
							$res=mysqli_query($conexion, $consulta) or die ("Error:"." Error en la consulta usuario");
							$numero = mysqli_num_rows($res);
							//si existe
							if ($numero==1){
								$consulta="INSERT INTO cliente(ciCliente) VALUES ('$ci')";
								mysqli_query($conexion, $consulta) or die ("Error:"." Error al subir los datos");
								$consulta="INSERT INTO llevataller(ciCliente, matriculaVehiculo) VALUES ('$ci', '$matriculaIngresoVehiculo')";
								mysqli_query($conexion, $consulta) or die ("Error:"." Error al subir los datos");
								$consulta="INSERT INTO reparacion(codigoReparacion, descReparacion, presupuestoReparacion, CombustibleIngresoVehiculo, kilometrajeVehiculo, fechaingreso, matriculaVehiculo) VALUES ('$idReparacion', '$descIngresoVehiculo', '$presupuestoIngresoVehiculo', '$combustibleIngresoVehiculo', '$kmIngresoVehiculo', '$fechaIngresoVehiculo', '$matriculaIngresoVehiculo')";
								mysqli_query($conexion, $consulta) or die ("Error:"." Error al subir los datos");
								$consulta="INSERT INTO empleadoasignado (ciEmpleado, codigoReparacion) VALUES ('$empleadoCi', '$idReparacion') ";
								mysqli_query($conexion, $consulta) or die ("Error:"." Error al subir los datos");	
								echo "ok";	

							//si no existe usuario
							} else {
								$consulta="INSERT INTO usuario(idUsuario) VALUES ('$ci')";
								mysqli_query($conexion, $consulta) or die ("Error:"." Error al subir los datos Usuario");
								$consulta="INSERT INTO cliente(ciCliente) VALUES ('$ci')";
								mysqli_query($conexion, $consulta) or die ("Error:"." Error al subir los datos");
								$consulta="INSERT INTO llevataller(ciCliente, matriculaVehiculo) VALUES ('$ci', '$matriculaIngresoVehiculo')";
								mysqli_query($conexion, $consulta) or die ("Error:"." Error al subir los datos");
								$consulta="INSERT INTO reparacion(codigoReparacion, descReparacion, presupuestoReparacion, CombustibleIngresoVehiculo, kilometrajeVehiculo, fechaingreso, matriculaVehiculo) VALUES ('$idReparacion', '$descIngresoVehiculo', '$presupuestoIngresoVehiculo', '$combustibleIngresoVehiculo', '$kmIngresoVehiculo', '$fechaIngresoVehiculo', '$matriculaIngresoVehiculo')";
								mysqli_query($conexion, $consulta) or die ("Error:"." Error al subir los datos");
								$consulta="INSERT INTO empleadoasignado (ciEmpleado, codigoReparacion) VALUES ('$empleadoCi', '$idReparacion') ";
								mysqli_query($conexion, $consulta) or die ("Error:"." Error al subir los datos");	
								echo "ok";	
							}
						}
					}
				} else {
					$consulta="SELECT * FROM clientecorporativo WHERE rutCliente = '$ci'";
					$res=mysqli_query($conexion, $consulta) or die ("Error:"." Error en la consulta");
					$numero = mysqli_num_rows($res);
					if($numero==0){
						echo "Error:"."<br>"."Ingrese al cliente Corporativo Primero";
					} else {
						$consulta="SELECT * FROM llevacorporacion WHERE matriculaVehiculo = '$matriculaIngresoVehiculo' AND rutCliente = '$ci'";
						$res=mysqli_query($conexion, $consulta) or die ("Error:"." Error en la consultaA");
						$numero = mysqli_num_rows($res);
						//Si existe realción
						if ($numero==1){
							//Crea id único

							$consulta="INSERT INTO reparacion(codigoReparacion, descReparacion, presupuestoReparacion, CombustibleIngresoVehiculo, kilometrajeVehiculo, fechaingreso, matriculaVehiculo) VALUES ('$idReparacion', '$descIngresoVehiculo', '$presupuestoIngresoVehiculo', '$combustibleIngresoVehiculo', '$kmIngresoVehiculo', '$fechaIngresoVehiculo', '$matriculaIngresoVehiculo')";
							mysqli_query($conexion, $consulta) or die ("Error:"." <br>"."Error al subir los datos");
							$consulta="INSERT INTO empleadoasignado (ciEmpleado, codigoReparacion) VALUES ('$empleadoCi', '$idReparacion') ";
							mysqli_query($conexion, $consulta) or die ("Error:"." <br>"."Error al subir los datos Empleado");
							echo "ok";		
						} else {
							$consulta="INSERT INTO llevacorporacion(rutCliente, matriculaVehiculo) VALUES ('$ci', '$matriculaIngresoVehiculo')";
							mysqli_query($conexion, $consulta) or die ("Error:"." Error al subir los datos");
							$consulta="INSERT INTO reparacion(codigoReparacion, descReparacion, presupuestoReparacion, CombustibleIngresoVehiculo, kilometrajeVehiculo, fechaingreso, matriculaVehiculo) VALUES ('$idReparacion', '$descIngresoVehiculo', '$presupuestoIngresoVehiculo', '$combustibleIngresoVehiculo', '$kmIngresoVehiculo', '$fechaIngresoVehiculo', '$matriculaIngresoVehiculo')";
							mysqli_query($conexion, $consulta) or die ("Error:"." Error al subir los datos");
							$consulta="INSERT INTO empleadoasignado (ciEmpleado, codigoReparacion) VALUES ('$empleadoCi', '$idReparacion') ";
							mysqli_query($conexion, $consulta) or die ("Error:"." Error al subir los datos Empleado");
							echo "ok";	
						}
					}
				}
				
				mysqli_close($conexion);
			} 
		} else {
			echo "Error:"." No existe vehiculo, ingreselo primero";
		}
	} else {
		echo "Error:"." error carga de datos";
	}

?>
