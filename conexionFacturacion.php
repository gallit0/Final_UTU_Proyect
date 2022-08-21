<?php
	$timezone = "America/Montevideo";
    date_default_timezone_set($timezone);
	include "conexion.php";
	$vacio = array();
	$err = array();
	if(isset($_POST['codigo'])) {
		$CodigoReparacion=$_POST['codigo'];
		$matriculaIngresoVehiculo=$_POST['matricula'];
		$consulta="SELECT * FROM reparacionfactura WHERE codigoReparacion='$CodigoReparacion'";
		$res=mysqli_query($conexion, $consulta);
		if(mysqli_num_rows($res)==0){


			$consulta="SELECT * FROM reparacion WHERE codigoReparacion = '$CodigoReparacion' && matriculaVehiculo='$matriculaIngresoVehiculo' ";
			$res=mysqli_query($conexion, $consulta) or die ("Error:"." Error en la consulta");
			$numero = mysqli_num_rows($res);
			if($numero>0){
				foreach($_POST as $nombre_campo => $valor){
				$asignacion = "\$" . $nombre_campo . "='" . $valor . "';";
				eval($asignacion);
				}
				$consulta="SELECT * FROM llevataller WHERE  matriculaVehiculo='$matriculaIngresoVehiculo' && ciCliente='$idSeleccion'";
				$res=mysqli_query($conexion, $consulta) or die ("Error:"." Error en la consulta");
				if(mysqli_num_rows($res)==0){
					$consultaV="SELECT * FROM llevacorporacion WHERE matriculaVehiculo='$matriculaV' && rutCliente='$idSeleccion'";
	                $resV=mysqli_query($conexion, $consultaV);
	                if(mysqli_num_rows($resV)==0){
	                	echo "ok";

	                	
	                } else {
	                	if($tipoPago=='contado' || $tipoPago=='debito'){
						if($moneda=='UYU' && is_numeric($obra) && is_numeric($repuestosTot && strtotime($vencimiento))){
							$subTotal=$obra+$repuestosTot;
							$totalIva=$subTotal*0.22;
							$total=$subTotal+$totalIva;
							$fecha=date('Y-m-d');
							$consulta= "SELECT direccionUsuario FROM usuario WHERE idUsuario='$idSeleccion'";
							$res=mysqli_query($conexion, $consulta);
							$fila=mysqli_fetch_array($res);
							$direccion=$fila['direccionUsuario'];
							$consulta= "SELECT razonSocial FROM clientecorporativo WHERE rutCliente='$idSeleccion'";
							$res=mysqli_query($conexion, $consulta);
							$fila=mysqli_fetch_array($res);
							$razon=$fila['razonSocial'];
							$consulta="INSERT INTO facturacion(subtotal, totalIva, total, fecha, moneda, direccionCliente, tipoImporte, tipoFactura, vencimientoFactura, manoObra, codigoQr) VALUES ('$subTotal','$totalIva','$total','$fecha','$moneda','$direccion','$tipoPago', 'e-Factura', '$vencimiento', '$obra', '$codigoQr')";
							mysqli_query($conexion, $consulta) or die ("Error:"." Error");
							$id=mysqli_insert_id($conexion);
							$consulta="INSERT INTO efactura(idFactura, rutCliente, razonSocial) VALUES ('$id', '$idSeleccion', '$razon')";
							mysqli_query($conexion, $consulta) or die ("Error:"." Error");
							$consulta="SELECT * FROM repuestousado WHERE codigoReparacion='$codigo'";
							$res=mysqli_query($conexion, $consulta);
							while($fila=mysqli_fetch_array($res)){
									$rep=$fila['idRepuesto'];
									$precio=$fila['precioMomento'];
									$cantidad=$fila['cantidadusada'];
									$consulta="INSERT INTO reparacionfactura(codigoReparacion, idRepuesto, idFactura, precio, cantidad) VALUES ('$CodigoReparacion', '$rep', '$id', '$precio', '$cantidad')";
							}
							echo "next";
						} else {
							echo "ok";
						}
	                	}
	                 }
					} else {
						if($tipoPago=='contado' || $tipoPago =='debito'){
							if($moneda=='UYU' && is_numeric($obra) && is_numeric($repuestosTot) && strtotime($vencimiento)){
								$subTotal=$obra+$repuestosTot;
								$totalIva=$subTotal*0.22;
								$total=$subTotal+$totalIva;
								$fecha=date('Y-m-d');
								$consulta= "SELECT direccionUsuario, nombreApellidoUsuario FROM usuario WHERE idUsuario='$idSeleccion'";
								$res=mysqli_query($conexion, $consulta);
								$fila=mysqli_fetch_array($res);
								$direccion=$fila['direccionUsuario'];
								$nombre=$fila['nombreApellidoUsuario'];
								$codigoQr="localhost/damagecode/facturasFin.php?codigo=".$CodigoReparacion;
								$consulta="INSERT INTO facturacion(subtotal, totalIva, total, fecha, moneda, direccionCliente, tipoImporte, tipoFactura, vencimientoFactura, manoObra, codigoQR) VALUES ('$subTotal','$totalIva','$total','$fecha','$moneda','$direccion','$tipoPago', 'e-Ticket', '$vencimiento', '$obra', '$codigoQr')";
								mysqli_query($conexion, $consulta) or die ("Error:"." Error");
								$id=mysqli_insert_id($conexion);
								$consulta="INSERT INTO eticket(idFactura, ciCliente, nombreCliente) VALUES ('$id', '$idSeleccion', '$nombre')";
								mysqli_query($conexion, $consulta) or die ("Error:"." Error");
								$consulta="SELECT * FROM repuestousado WHERE codigoReparacion='$CodigoReparacion'";
								$res=mysqli_query($conexion, $consulta);
								if(mysqli_num_rows($res)==0){
									$consulta="INSERT INTO reparacionfactura(codigoReparacion, idRepuesto, idFactura, precio, cantidad) VALUES ('$CodigoReparacion', '0', '$id', '0', '0')";
									mysqli_query($conexion, $consulta);
								} else {
									while($fila=mysqli_fetch_array($res)){
										$rep=$fila['idRepuesto'];
										$precio=$fila['precioMomento'];
										$cantidad=$fila['cantidadusada'];
										$consulta="INSERT INTO reparacionfactura(codigoReparacion, idRepuesto, idFactura, precio, cantidad) VALUES ('$CodigoReparacion', '$rep', '$id', '$precio', '$cantidad')";
										mysqli_query($conexion, $consulta) or die ("Error:"." Error");
									}
								}
							echo "next";

						} else {
							echo "ok";
						}
					} else {
						echo "ok";
					}
				}
			}
		} else {
			echo "repe";
		}
	 }
	 else {
		header("Location: usuarioPerfil.php");
	}
?>