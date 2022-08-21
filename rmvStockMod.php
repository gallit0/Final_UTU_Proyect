<?php
	include"conexion.php";
	if(isset($_GET["codigo"])){
		$id=$_GET["codigo"];
		$codigo=$_GET["rep"];
		$consultaR="SELECT * FROM repuesto WHERE idRepuesto='$id'";
		$resR=mysqli_query($conexion, $consultaR) or die ("error");
		$consulta="SELECT * FROM repuestousado WHERE idRepuesto='$id' AND codigoReparacion='$codigo'";
		$res=mysqli_query($conexion, $consulta) or die ("error");
		if(mysqli_num_rows($resR)>0 && mysqli_num_rows($res)>0) {
			$filaR=mysqli_fetch_array($resR);
			$fila=mysqli_fetch_array($res);
			$cantidadAlm=$filaR['cantidadRepuesto'];
			$cantidad=$fila['cantidadusada'];
			$consulta="DELETE FROM repuestousado WHERE idRepuesto='$id'";
			mysqli_query($conexion, $consulta) or die ("Error al Eliminar");
			$newTotal=$cantidadAlm+$cantidad;
			$consulta="UPDATE repuesto SET cantidadRepuesto='$newTotal' WHERE idRepuesto='$id'";
			mysqli_query($conexion, $consulta) or die ("Error");
			echo '<script language="javascript"> window.location.href="addStock.php?codigoRep='.$_GET["rep"].'";</script>';
		} else {
			echo '<script language="javascript"> alert("Error al seleccionar los datos");</script>'; 
			echo '<script language="javascript"> window.location.href="addStock.php?codigoRep='.$_GET["rep"].'";</script>';
		}
	} else {
		echo '<script language="javascript"> alert("Error al subir los datos");</script>'; 
		echo '<script language="javascript"> window.location.href="addStock.php?codigoRep='.$_GET["rep"].'";</script>';
	} 



?>