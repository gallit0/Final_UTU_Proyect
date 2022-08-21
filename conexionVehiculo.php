<?php
	
	include "conexion.php";

	$ciVerif = " /^[0-9]{0,12}$/ "; // numeros
	$matriculaVerif = " /^[a-zA-Z0-9\s]{0,10}$/ "; // Letras y espacios, pueden llevar acentos.
	$kmVerif=" /^[0-9]{0,7}$/ "; 
	$marcaVerif = " /[a-zA-ZÀ-ÿ0-9\s]{0,35}$/ "; // 8 a 20 digitos.
	$fechaVerif = " /^[0-9-]{0,11}$/ "; 
	$colorVerif = " /^[a-zA-ZÀ-ÿ]{0,20}$/ "; // 15 numeros.
	$combustibleVerif = " /^[0-9]{0,3}$/ "; // 15 numeros.
	$presupuestoVerif = " /^[0-9.]{0,6}$/ "; // 15 numeros.
	$descripcionVerif = " /^[a-zA-ZÀ-ÿ0-9,.\s]{0,400}$/ "; // 15 numeros.

	$vacio = array();
	$err = array();

	//Verifica si existe registro
	if(isset($_POST['ci'])) {

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
		if(empty($matriculaIngresoVehiculoForm)){
			array_push($vacio, "La matrícula no puede estar vacía");
		}
		if(!preg_match($matriculaVerif, $matriculaIngresoVehiculoForm)){
			array_push($err, "El campo no puede tener caracteres especiales, solo letras y numeros");
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
			if(strlen($ci)==8){
				$consulta="SELECT idUsuario FROM usuario WHERE idUsuario = '$ci'";
				$res=mysqli_query($conexion, $consulta) or die ("Error:"." Error en la consulta usuario");
				$numero = mysqli_num_rows($res);
				//Si exite Usuario
				if ($numero==1) {
					$consulta="SELECT ciCliente FROM cliente WHERE ciCliente = '$ci'";
					$res=mysqli_query($conexion, $consulta) or die ("Error:"." Error en la consulta cliente");
					$numero = mysqli_num_rows($res);
					//Si no existe cliente
					if ($numero==0){
						$consulta="INSERT INTO cliente(ciCliente) VALUES ('$ci')";
						mysqli_query($conexion, $consulta) or die ("Error:"." Error al subir los datos");
						$consulta="SELECT matriculaVehiculo FROM vehiculo WHERE matriculaVehiculo = '$matriculaIngresoVehiculoForm'";
						$res=mysqli_query($conexion, $consulta) or die ("Error:"." Error en la consulta vehiculo");
						$numero = mysqli_num_rows($res);
						//Si no existe Vehiculo
						if($numero==0){
							$consulta="INSERT INTO vehiculo(matriculaVehiculo, tipoVehiculo, marcaVehiculo, colorVehiculo) VALUES ('$matriculaIngresoVehiculoForm', '$tipoIngresoVehiculoForm', '$marcaIngresoVehiculoForm', '$colorIngresoVehiculoForm')";
							mysqli_query($conexion, $consulta) or die ("Error:"." Error al subir los datos");	
							$consulta="INSERT INTO llevataller(ciCliente, matriculaVehiculo) VALUES ('$ci', '$matriculaIngresoVehiculoForm')";
							mysqli_query($conexion, $consulta) or die ("Error:"." Error al subir los datos");
							echo "ok";
						//Si ya existe vehiculo
						} else {
							$consulta="INSERT INTO llevataller(ciCliente, matriculaVehiculo) VALUES ('$ci', '$matriculaIngresoVehiculoForm')";
							mysqli_query($conexion, $consulta) or die ("Error:"." Error al subir los datos");
							echo "ok";
						}
						
					//Si existe cliente
					} else {
						$consulta="SELECT ciCliente, matriculaVehiculo FROM llevataller WHERE ciCliente = '$ci' AND matriculaVehiculo='$matriculaIngresoVehiculoForm' ";
						$res=mysqli_query($conexion, $consulta) or die ("Error:"." Error en la consulta");
						$numero = mysqli_num_rows($res);
						//Si no estan relacionados la cedula y el Vehiculo
						if($numero==0){
							$consulta="SELECT matriculaVehiculo FROM vehiculo WHERE matriculaVehiculo = '$matriculaIngresoVehiculoForm'";
							$res=mysqli_query($conexion, $consulta) or die ("Error:"." Error en la consulta");
							$numero = mysqli_num_rows($res);
							//Si no existe Vehiculo
							if($numero==0){
								$consulta="INSERT INTO vehiculo(matriculaVehiculo, tipoVehiculo, marcaVehiculo, colorVehiculo) VALUES ('$matriculaIngresoVehiculoForm', '$tipoIngresoVehiculoForm', '$marcaIngresoVehiculoForm', '$colorIngresoVehiculoForm')";
								mysqli_query($conexion, $consulta) or die ("Error:"." Error al subir los datos");	
								$consulta="INSERT INTO llevataller(ciCliente, matriculaVehiculo) VALUES ('$ci', '$matriculaIngresoVehiculoForm')";
								mysqli_query($conexion, $consulta) or die ("Error:"." Error al subir los datos");
								echo "ok";
							//Si ya existe vehiculo
							} else {
								$consulta="INSERT INTO llevataller(ciCliente, matriculaVehiculo) VALUES ('$ci', '$matriculaIngresoVehiculoForm')";
								mysqli_query($conexion, $consulta) or die ("Error:"." Error al subir los datos");
								echo "ok";
							}
						//Si ya están relacionados el vehiculo y la cédula
						} else {
							echo "Error:"." Ya ingreso el vehículo con el mismo cliente ";
						}
					
				}
			
					mysqli_close($conexion);
					//No existe Usuario, crea usuario cliente, verifica si existe matricula
				} else {
					$consulta="INSERT INTO usuario(idUsuario) VALUES ('$ci')";
					mysqli_query($conexion, $consulta) or die ("Error:"." Error al subir los datos Usuario");
					$consulta="INSERT INTO cliente(ciCliente) VALUES ('$ci')";
					mysqli_query($conexion, $consulta) or die ("Error:"." Error al subir los datos cliente sin U");
					$consulta="INSERT INTO vehiculo(matriculaVehiculo, tipoVehiculo, marcaVehiculo, colorVehiculo) VALUES ('$matriculaIngresoVehiculoForm', '$tipoIngresoVehiculoForm', '$marcaIngresoVehiculoForm', '$colorIngresoVehiculoForm')";
					$consulta="SELECT matriculaVehiculo FROM vehiculo WHERE matriculaVehiculo = '$matriculaIngresoVehiculoForm'";
					$res=mysqli_query($conexion, $consulta) or die ("Error:"." Error en la consulta existencia");
					$numero = mysqli_num_rows($res);
					//Si no existe Vehiculo
					if($numero==0){
						$consulta="INSERT INTO vehiculo(matriculaVehiculo, tipoVehiculo, marcaVehiculo, colorVehiculo) VALUES ('$matriculaIngresoVehiculoForm', '$tipoIngresoVehiculoForm', '$marcaIngresoVehiculoForm', '$colorIngresoVehiculoForm')";
						mysqli_query($conexion, $consulta) or die ("Error:"." Error al subir los datos vehiculo sin U");	
						$consulta="INSERT INTO llevataller(ciCliente, matriculaVehiculo) VALUES ('$ci', '$matriculaIngresoVehiculoForm')";
						mysqli_query($conexion, $consulta) or die ("Error:"." Error al subir los datos");
						echo "ok";
					//Si ya existe vehiculo
					} else {
						$consulta="INSERT INTO llevataller(ciCliente, matriculaVehiculo) VALUES ('$ci', '$matriculaIngresoVehiculoForm')";
						mysqli_query($conexion, $consulta) or die ("Error:"." Error al subir los datos");
						echo "ok";
					}
				}
			}

			else {
				$consulta="SELECT idUsuario FROM usuario WHERE idUsuario = '$ci'";
				$res=mysqli_query($conexion, $consulta) or die ("Error:"." Error en la consulta usuario");
				$numero = mysqli_num_rows($res);
				//Si no exite Usuario
				if ($numero==0) {
					echo "Error:"."<br>"."Ingrese primero el cliente Corporativo";
				} else {
					$consulta="SELECT rutCliente, matriculaVehiculo FROM llevacorporacion WHERE rutCliente = '$ci' AND matriculaVehiculo='$matriculaIngresoVehiculoForm' ";
					$res=mysqli_query($conexion, $consulta) or die ("Error:"." Error en la consulta");
					$numero = mysqli_num_rows($res);
					//Si estan relacionados la cedula y el Vehiculo
					if($numero==1){
						echo "Error:"." Ya ingreso el vehiculo con el mismo RUT";
					} else {
						$consulta="SELECT matriculaVehiculo FROM vehiculo WHERE matriculaVehiculo = '$matriculaIngresoVehiculoForm'";
						$res=mysqli_query($conexion, $consulta) or die ("Error:"." Error en la consulta");
						$numero = mysqli_num_rows($res);
						if($numero==1){
							$consulta="INSERT INTO llevacorporacion(rutCliente, matriculaVehiculo) VALUES ('$ci', '$matriculaIngresoVehiculoForm')";
							mysqli_query($conexion, $consulta) or die ("Error:"." Error al subir los datos");
							echo "ok";
						} else {
							$consulta="INSERT INTO vehiculo(matriculaVehiculo, tipoVehiculo, marcaVehiculo, colorVehiculo) VALUES ('$matriculaIngresoVehiculoForm', '$tipoIngresoVehiculoForm', '$marcaIngresoVehiculoForm', '$colorIngresoVehiculoForm')";
							mysqli_query($conexion, $consulta) or die ("Error:"." Error al subir los datosS");
							$consulta="INSERT INTO llevacorporacion(rutCliente, matriculaVehiculo) VALUES ('$ci', '$matriculaIngresoVehiculoForm')";
							mysqli_query($conexion, $consulta) or die ("Error:"." Error al subir los datos");
							echo "ok";
						}
						
					}

			}
		} 
		}
	} else {
			echo "Error:"."<br>"."error";
		}

?>
