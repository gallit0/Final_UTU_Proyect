<?php
    $timezone = "America/Montevideo";
    date_default_timezone_set($timezone);
    include "conexion.php";
    session_start();
    if(isset($_SESSION['idUsuario'])){
		if($_SESSION['permisoUsuario']==1){
			header("Location: usuarioPerfil.php");
		}
	} else {
		header("Location: index.php");
	}
?>
<!DOCTYPE HTML>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilo.css?v=<?php echo time(); ?>">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <title>MadMotors - Check Fix In</title>
    <link rel="icon" type="image/x-icon" href="imagenes_contenido/favicon.ico">
</head>
<body>
<?php include 'cambioModoOscuro.php'?>
    <div id = "ingresoReparacionMecanico">
        <!-------------Header------------->
        <?php
			include 'barraHeader.php';
		?>
        
        <div id = "cuerpoIngresoReparacionMecanico" class="cuerpo">
            <div class="titulos">Modificar reparación</div>
            <?php
            if(isset($_GET["codigo"])){
                $codigo=$_GET["codigo"];
                $consulta="SELECT * FROM reparacion WHERE codigoReparacion='$codigo'";
                $res=mysqli_query($conexion, $consulta) or die ("error");
                $fila=mysqli_fetch_array($res);
                echo "<form id='formLog' method = 'post'>";
                    echo "<p>";
                        echo "<label for='CodigoReparacion'>Código Reparacón:<br>";
                            echo "<input type='text' name = 'CodigoReparacion' value='".$fila['codigoReparacion']."' readonly>";
                        echo "</label>";
                    echo "</p>"; 
                    echo "<br>";
                    echo "<p>";
                        echo "<label for='matriculaIngresoVehiculo'>Matrícula Reparacón:<br>";
                            echo "<input type='text' name = 'matriculaIngresoVehiculo' value='".$fila['matriculaVehiculo']."' readonly>";
                        echo "</label>";
                    echo "</p>";
                    echo "<br>";
                    echo "<p>";
                        echo "<label for='kmIngresoVehiculo'>Kilometraje:<br>";
                            echo "<input type='text' name = 'kmIngresoVehiculo' value='".$fila['kilometrajeVehiculo']."'>";
                        echo "</label>";
                    echo "</p>";
                    echo "<br>";
                    echo "<p>";
                        echo "<label for='fechaIngresoReparacion'>Fecha de ingreso:<br>";
                            echo "<input type='date' name = 'fechaIngresoVehiculo' value='".$fila['fechaingreso']."'>";
                        echo "</label>";
                    echo "</p>";
                    echo "<br>";
                    echo "<p>";
                        echo "<label for='fechaEgresoReparacion'>Fecha de egreso:<br>";
                            echo "<input type='date' name = 'fechaEgresoVehiculo' value='".$fila['fechaegreso']."'>";
                        echo "</label>";
                    echo "</p>";
                    echo "<br>";
                    echo "<p>";
                        echo "<label for='combustibleIngresoVehiculo'>Combustible de ingreso:<br>";
                            echo "<input type='text' name = 'combustibleIngresoVehiculo' value='".$fila['CombustibleIngresoVehiculo']."'>";
                        echo "</label>";
                    echo "</p>";
                    echo "<br>";
                    echo "<p>";
                        echo "<label for='presupuestoIngresoVehiculo'>Presupuesto:<br>";
                            echo "<input type='text' name = 'presupuestoIngresoVehiculo' value='".$fila['presupuestoReparacion']."'>";
                        echo "</label>";
                    echo "</p>";
                    echo "<br>";
                    echo "<p>";
                        echo "<label for='descIngresoVehiculo'>Descripcion Reparación:<br>";
                            echo "<textarea name = 'descIngresoVehiculo'>".$fila['descReparacion']."</textarea>";
                        echo "</label>";
                    echo "</p>";
                    echo "<br>";
                    echo "<p>";
                        echo "<input type='reset' value='Reiniciar'>";
                        echo "<input type='submit' id= 'btnSubmit' value='Ingresar'>";
                    echo "</p>";
                echo "</form>";
                echo "<div id='output'></div>";
            } else {
                echo "ERROR";
                echo "<a href='usuarioPerfil.php'> VOLVER </a>";
            } 
            ?>
        </div>
    </div>
    <!-----------------------------------------------Footer----------------------------------------------->
	<?php
		include 'footer.php';
	?>
    <!-----------------------------------------------Conexion Ajax----------------------------------------------->
<script type="text/javascript">
            $(document).ready(function () {
            $("#btnSubmit").click(function (event) {
                //No envia el formulario directamente despues de presioanr.
                event.preventDefault();
         
                // Guarda el Formulario.
                var form = $('#formLog')[0];
         
                // Guarda los datos del formulario.
                var data = new FormData(form);
         

         
                // Desabilita el boton de enviar.
                $("#btnSubmit").prop("disabled", true);
                //Usa ajax para enviar los datos al formulario de validacion y conexión.
                $.ajax({
                    type: "POST",
                    url: "conexionReparacionMod.php",
                    data: data,
                    processData: false,
                    contentType: false,
                    cache: false,
                    dataType: "text",
                    timeout: 800000,
                    //La bitacora de la consola muestra CORRECTO y el output del conexión se carga en el div de output
                    success: function (data) {
                       if(data.includes("Vacío:")||data.includes("Error:")){
                            console.log("Errores: ", data);
                             $("#output").html(data);
                        }
                        else if(data=="ok") {
                            console.log("COORRECTO : ", data);
                            alert("Modificado");
                            window.location.href = "usuarioPerfil.php";
                        }
                        //Vuelve a habilitar el boton de Enviar
                        $("#btnSubmit").prop("disabled", false);
                    },
                     //La bitacora de la consola muestra ERROR y no envia el formulario
                    error: function (e) {
                        $("#output").text(e.responseText);
                        console.log("ERROR : ", e);
                        //Vuelve a habilitar el boton de Enviar
                        $("#btnSubmit").prop("disabled", false);
                    }
                });
            });
        });
</script>
</body>
</html>