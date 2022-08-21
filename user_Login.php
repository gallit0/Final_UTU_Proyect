<?php
    session_start();
    if(isset($_SESSION['idUsuario'])){
        header("Location: usuarioPerfil.php");
    }
    else{
        header("Location: login.php");
    }
?>