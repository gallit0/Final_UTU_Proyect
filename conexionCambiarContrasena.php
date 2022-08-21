<?php
	session_start();
    if(!isset($_SESSION['idUsuario'])){
        header("Location: login.php");
    } else {
        $ci=$_SESSION['idUsuario'];
    }
    include "conexion.php";
    
    $passwordVerif = " /^(?=\w*\d)(?=\w*[A-Z])(?=\w*[a-z])\S{8,16}$/ ";

    //Verifica si el post recavo los datos
    $contrasenaUsuario=$_POST['contrasenaVieja'];
    if($contrasenaUsuario != "") {
    $contrasenaNueva=$_POST['contrasenaNueva'];
    $contrasenaConfirmar=$_POST['contrasenaConfirmar'];
    $consulta="SELECT idUsuario, contrasenaUsuario FROM usuario WHERE idUsuario='$ci' AND contrasenaUsuario='$contrasenaUsuario'";
    $res=mysqli_query($conexion, $consulta) or die ("Error:"." Error en la consulta");
    $numero = mysqli_num_rows($res);
    if (empty($numero)){
        echo "Error:"."<br>"."Contraseña incorrecta";
    } else {
        if (empty($contrasenaNueva) || empty($contrasenaConfirmar)){
            echo "Error:"." Ingrese la nueva contraseña";
        } elseif (!preg_match($passwordVerif, $contrasenaNueva) || !preg_match($passwordVerif, $contrasenaConfirmar)){
            echo  "Error:"." La nueva contraseña debe contener entre 8 a 20 caractertes y debe haber almenos 1 mayúscula, 1 minúscula y un número";
        } elseif ($contrasenaNueva!=$contrasenaConfirmar){
            echo "Error:"." Contraseñas no coinciden";
        } else {
            $consulta="UPDATE usuario SET contrasenaUsuario='$contrasenaNueva' WHERE idUsuario='$ci'";
            mysqli_query($conexion, $consulta) or die ("Error:"." Error al subir los datos");
            echo "ok";
        }
    }
    
    } else {
        echo "Error:"." No ingreso la contraseña";
    }

?>