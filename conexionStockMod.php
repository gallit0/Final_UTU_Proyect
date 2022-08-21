<?php
	
	include "conexion.php";
	$nombreVerif = " /^[a-zA-ZÀ-ÿ0-9.,\s]{0,50}$/ ";
	$descVerif = " /^[a-zA-ZÀ-ÿ0-9.,\s]{0,120}$/ ";
	$cantidadVerif = " /^[0-9.]{0,6}$/ ";
	$rutVerif = " /^[0-9]{12}$/ ";
	$telefonoVerif = " /^\d{0,15}$/ "; // 15 numeros.
	$direccionVerif=" /^[a-zA-ZÀ-ÿ0-9\s\_.+-]{0,100}$/ ";
	$vacio=array();
	$err=array();

	if(isset($_POST['nombreRepuesto'])) {
		//Guardar las variables de post en variables php con nombre igual al del formulario
		foreach($_POST as $nombre_campo => $valor){
   			$asignacion = "\$" . $nombre_campo . "='" . $valor . "';";
   			eval($asignacion);
		}
		if(empty($nombreRepuesto) || empty($rutProveedor)){
			echo "Error:"."<br>"."Ingrese nombre de repuesto y rut del proveedor ";
		} else {
			//Verificacion: 
			
			if(empty($nombreRepuesto)){
				array_push($vacio, "El nombre no puede estar vacío");
			}
			if(!preg_match($nombreVerif, $nombreRepuesto)){
				array_push($err, "El campo no debe contener caracteres especiales");
			}
			if(empty($marcaRepuesto)){
				array_push($vacio, "La marca no puede estar vacía");
			}
			if(!preg_match($nombreVerif, $marcaRepuesto)){
				array_push($err, "El campo no debe contener caracteres especiales");
			}
			if(empty($desRepuesto)){
				array_push($vacio, "La descripción no puede estar vacía");
			}
			if(!preg_match($descVerif, $desRepuesto)){
				array_push($err, "Solo es permitido un máximo de 120 caracteres y no son permitidos caracteres especiales");
			}
			if(empty($limiteRepuesto)){
				array_push($vacio, "El límite no puede estar vacío");
			} elseif ($limiteRepuesto<0){
				array_push($err, "El límite no puede ser negativo");
			}
			if(!preg_match($cantidadVerif, $limiteRepuesto)){
				array_push($err, "Tan solo se permiten numeros y una cantidad maxima de 999.999 en el recordatorio");
			}
			if(empty($cantidadRepuesto)){
				array_push($vacio, "La cantidad no puede estar vacía");
			} elseif ($cantidadRepuesto<0){
				array_push($err, "La cantidad no puede ser negativa");
			}
			if(!preg_match($cantidadVerif, $cantidadRepuesto)){
				array_push($err, "Tan solo se permiten numeros y una cantidad maxima de 999.999");
			}
			if(empty($precioRepuesto)){
				array_push($vacio, "El precio no puede estar vacío");
			} elseif ($precioRepuesto<0){
				array_push($err, "El precio no puede ser negativo");
			}
			if(!preg_match($cantidadVerif, $precioRepuesto)){
				array_push($err, "Tan solo se permiten numeros y una cantidad maxima de 999.999");
			}
			if(!isset($cambImg)){

				if ($_FILES['imagenStock']['name']!=""){
					$img_name = $_FILES['imagenStock']['name'];
					$img_size = $_FILES['imagenStock']['size'];
					$tmp_name = $_FILES['imagenStock']['tmp_name'];
					$error = $_FILES['imagenStock']['error'];
				} else {
					array_push($err, "Error en la carga de la imagen");
				}
			}
			//Verificar si existe el proveedor para no volver a ingresarlo
			$consultaP="SELECT rutProveedor FROM proveedor WHERE rutProveedor = '$rutProveedor'";
			$resP=mysqli_query($conexion, $consultaP) or die ("Error:"."<br>"."Error en la consulta del proveedor");
			$numero = mysqli_num_rows($resP);
			if(!empty($numero)){

				if(empty($rutProveedor)){
					array_push($vacio, "El proveedor no puede estar vacío");
				}
				if(!preg_match($rutVerif, $rutProveedor)){
					array_push($err, "El rut no debe contener espaciado y tan solo 12 digitos");
				}
				if(empty($nombreProveedor)){
					array_push($vacio, "El proveedor no puede estar vacío");
				}
				if(!preg_match($nombreVerif, $nombreProveedor)){
					array_push($err, "El campo no debe contener caracteres especiales");
				}

				if(empty($telefonoProveedor)){
					array_push($vacio, "El telefono no puede estar vacío");
				}
				if(!preg_match($telefonoVerif, $telefonoProveedor)){
					array_push($err, "El campo solo debe contener numeros con un máximo de 15 digitos");
				}
				if(empty($direccionSucursalCercana)){
					array_push($vacio, "La direccion no puede estar vacía");
				}
				if(!preg_match($direccionVerif, $direccionSucursalCercana)){
					array_push($err, "Caracteres no permitidos");
				}
			 } else {
			 	array_push($err, "El rut no existe");
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
				if(!isset($cambImg)){
				//Verificar la imagen
				//Verifica si hay error en la subida
				if ($error === 0) {
					//Extrae la extension del archivo
					$img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
					$img_ex_lc = strtolower($img_ex);
					//Extensiones permitidas de imagen
					$allowed_exs = array("jpg", "jpeg", "png"); 

					if (in_array($img_ex_lc, $allowed_exs)) {
						$new_img_name = uniqid("IMG-", true).'.'.$img_ex_lc;
						$img_upload_path = 'imagenStock/'.$new_img_name;
						//mover archivo de la carpeta temporal a la carpeta de imagenes
						move_uploaded_file($tmp_name, $img_upload_path);
					} else {
						echo "Error:"."<br>"."No puedes ingresar archivos de este tipo";
					}
				
				} 
				else {
						echo "Error:"."<br>"."Error desconocido ha ocurrido";
				} 
			}
				$consultaI="SELECT * FROM repuesto WHERE idRepuesto='$id'";
				$resI=mysqli_query($conexion,$consultaI) or die ("Error");
				$filaI=mysqli_fetch_array($resI);
				//Realiza las consultas a la base de datos
				if(!empty($numero)){
					if(!empty($new_img_name)){

					$consulta="UPDATE repuesto SET nombreRepuesto='$nombreRepuesto', marcaRepuesto='$marcaRepuesto', desRepuesto='$desRepuesto', cantidadRepuesto='$cantidadRepuesto', precioRepuesto='$precioRepuesto', urlImagen='$new_img_name', rutProveedor='$rutProveedor', recordatorio='$limiteRepuesto' WHERE idRepuesto='$id'";
					mysqli_query($conexion, $consulta) or die ("Error:"."<br>"."Error al subir los datos repuesto");
					unlink('imagenStock/'.$filaI['urlimagen']);
					} else {
						$consulta="UPDATE repuesto SET nombreRepuesto='$nombreRepuesto', marcaRepuesto='$marcaRepuesto', desRepuesto='$desRepuesto', cantidadRepuesto='$cantidadRepuesto', precioRepuesto='$precioRepuesto', rutProveedor='$rutProveedor', recordatorio='$limiteRepuesto' WHERE idRepuesto='$id'";
						mysqli_query($conexion, $consulta) or die ("Error:"."<br>"."Error al subir los datos repuesto");
					}
					$consulta="UPDATE proveedor SET nombreProveedor='$nombreProveedor', direccionSucursalCercana='$direccionSucursalCercana' WHERE rutProveedor='$rutProveedor'";
					mysqli_query($conexion, $consulta) or die ("Error:"."<br>"."Error al subir los datos repuesto");
					$consulta="UPDATE telefonospoveedor SET telefonosProveedor='$telefonoProveedor'WHERE rutProveedor='$rutProveedor'";
					mysqli_query($conexion, $consulta) or die ("Error:"."<br>"."Error al subir los datos repuesto");
					
					echo "ok";
					} else {
						echo "Error:"."<br>"."Error en la carga de Proveedor";
					}
				} 
			
				
			

		} 
	} else { 
		echo "Error:"."<br>"."Error en la carga de datos";
}

?>