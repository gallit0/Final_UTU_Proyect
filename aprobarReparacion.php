<?php
    include "conexion.php";
    if(isset($_GET['codigo']) && isset($_GET['op'])){
        $codigo=$_GET['codigo'];
        $opcion=$_GET['op'];
        if(empty($codigo) || !is_numeric($opcion) ) {
            echo '<script language="javascript"> alert("Datos ingresados inválidos");</script>'; 
            echo '<script language="javascript"> window.location.href="usuarioPerfil.php";</script>';
        } else {
            $consulta="SELECT * FROM reparacion WHERE codigoReparacion='$codigo'";
            $res=mysqli_query($conexion, $consulta) or die("Error");
            $num=mysqli_num_rows($res);
            if($num>0){
                if($opcion==1 || $opcion==0 ){
                    $consulta="UPDATE reparacion SET aprobadaRep='$opcion' WHERE codigoReparacion='$codigo'";
                    mysqli_query($conexion, $consulta);
                    echo '<script language="javascript"> window.location.href="usuarioPerfil.php";</script>';
                } else {
                    echo '<script language="javascript"> alert("Error en la aprobación");</script>'; 
                    echo '<script language="javascript"> window.location.href="usuarioPerfil.php";</script>';
                }
            } else {
                echo '<script language="javascript"> alert("Reparacion Inexistente");</script>'; 
                echo '<script language="javascript"> window.location.href="usuarioPerfil.php";</script>';
            }

        }
    } else {
        echo '<script language="javascript"> alert("Error al ingresar datos");</script>'; 
		echo '<script language="javascript"> window.location.href="usuarioPerfil.php";</script>';
    }
?>