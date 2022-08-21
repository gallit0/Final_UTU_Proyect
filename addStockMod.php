<?php
	$timezone = "America/Montevideo";
    date_default_timezone_set($timezone);
	include"conexion.php";
	$codigo=$_GET["rep"];
	if(isset($_POST["repSeleccion"]) && isset($_POST["cantidadU"]) && isset($_GET["rep"])){
		$id=$_POST["repSeleccion"];
		$cantidad=$_POST["cantidadU"];
		
		if(empty($cantidad) || $cantidad<=0 || !is_numeric($cantidad)){
			echo '<script language="javascript"> alert("Cantidad inválida");</script>'; 
			echo '<script language="javascript"> window.location.href="addStock.php?codigoRep='.$codigo.'";</script>';
			
		} else {
			$consulta="SELECT * FROM reparacion WHERE codigoReparacion='$codigo'";
			$res=mysqli_query($conexion, $consulta) or die ("error");
			$consultaR="SELECT * FROM repuesto WHERE idRepuesto='$id'";
			$resR=mysqli_query($conexion, $consultaR) or die ("error");
			if(mysqli_num_rows($res)==0 || mysqli_num_rows($resR)==0){
				echo '<script language="javascript"> alert("Reparacion y/o repuesto inválido");</script>'; 
				echo '<script language="javascript"> window.location.href="addStock.php?codigoRep='.$codigo.'";</script>';
			} else {

				$consulta="SELECT * FROM repuestousado WHERE idRepuesto='$id' AND codigoReparacion='$codigo'";
				$res=mysqli_query($conexion, $consulta) or die ("error");
				if(mysqli_num_rows($res)>0){
					echo '<script language="javascript"> alert("Repuesto ya utilizado en la reparacion");</script>'; 
					echo '<script language="javascript"> window.location.href="addStock.php?codigoRep='.$codigo.'";</script>';
				} else {
					$fila=mysqli_fetch_array($resR);
					$precio=$fila['precioRepuesto'];
					$cantidadAlm=$fila['cantidadRepuesto'];
					$fecha=date('Y-m-d');
					if ($cantidad>$cantidadAlm){
						echo '<script language="javascript"> alert("Cantidad requerida mayor al almacenado");</script>'; 
						echo '<script language="javascript"> window.location.href="addStock.php?codigoRep='.$codigo.'";</script>';
					} else {
						$consulta="INSERT INTO repuestousado(idRepuesto, codigoReparacion, fechaUso, precioMomento, cantidadusada) VALUES ('$id','$codigo','$fecha','$precio','$cantidad')";
						mysqli_query($conexion, $consulta) or die ("error");
						$newTotal=$cantidadAlm-$cantidad;
						$consulta="UPDATE repuesto SET cantidadRepuesto='$newTotal' WHERE idRepuesto='$id'";
						mysqli_query($conexion, $consulta) or die ("error");
						echo '<script language="javascript"> alert("Ingreso Correcto!");</script>'; 
						echo '<script language="javascript"> window.location.href="addStock.php?codigoRep='.$codigo.'";</script>';	
					}
					
				}
			}
		}
	} else{
		echo '<script language="javascript"> alert("Error al subir los datos");</script>'; 
		echo '<script language="javascript"> window.location.href="addStock.php?codigoRep='.$codigo.'";</script>';
	}


?>