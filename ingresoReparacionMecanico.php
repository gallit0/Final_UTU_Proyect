<?php
    session_start();
    $timezone = "America/Montevideo";
    date_default_timezone_set($timezone);
    
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
    <link rel="icon" type="image/x-icon" href="imagenes_contenido/favicon.ico">
    <title>MadMotors - Check Fix In</title>
</head>
<body>
<?php include 'cambioModoOscuro.php'?>
    <div id = "ingresoReparacionMecanico">
        <!-------------Header------------->
        <?php
			include 'barraHeader.php';
		?>
        
        <div id = "cuerpoIngresoReparacionMecanico" class="cuerpo">
            <div class="titulos">Ingresar reparación</div>

            <form id="formLog" method = "post">
                <p>
                    <input type="text" name = "ci" placeholder = "ID">
                </p> 
                <br>
                <p>
                    <input type="text" name = "matriculaIngresoVehiculo" placeholder = "Matrícula">
                </p>
                <br>
                <p>
                    <input type="text" name = "kmIngresoVehiculo" placeholder = "Kilometraje">
                </p>
                <br>
                <p>
                    <label for="fechaIngresoReparacion">Fecha de ingreso:<br>
                        <input type="date" name = "fechaIngresoVehiculo" value="<?= date('Y-m-d')?>">
                    </label>
                </p>
                <br>
                <p>
                    <input type="text" name = "combustibleIngresoVehiculo" placeholder = "Combustible de ingreso">
                </p>
                <br>
                <p>
                    <input type="text" name = "presupuestoIngresoVehiculo" placeholder = "Presupuesto">
                </p>
                <br>
                <p>
                    <textarea name = "descIngresoVehiculo" placeholder = "Descripción"></textarea>
                </p>
                <br>
                <p>
                    <input type="reset" value="Reiniciar">
                    <input type="submit" id= "btnSubmit" value="Ingresar">
                </p>
            </form>
            <div id="output"></div>
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
                    url: "conexionReparacion.php",
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
                            alert("Reparacíon Agregada");
                             $("#output").html(data);
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