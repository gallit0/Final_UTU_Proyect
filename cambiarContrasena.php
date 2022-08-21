<?php
	session_start();
	 if(!isset($_SESSION['idUsuario'])){
		header("Location: login.php");
    }
?>
<!DOCTYPE html>
<html lang ="es">
<head>
	<meta charset = "UTF-8">
	<title>MadMotors - Change Password</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="estilo.css?v=<?php echo time(); ?>">
	<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
	<link rel="icon" type="image/x-icon" href="imagenes_contenido/favicon.ico">
</head>
<body>
<?php include 'cambioModoOscuro.php'?>
	<div id = "cambiarContrasena">
		<!-----------------------------------------------Barra homepage----------------------------------------------->
		<?php
			include 'barraHeader.php';
		?>
		<!-----------------------------------------------Cambiar Contraseña----------------------------------------------->
		<div id = "cuerpoCambiarContrasena" class="cuerpo">
			<div id = "titulosSignLog" class="titulos">
				Cambiar Contraseña
			</div>
			<div id="formCambiarContrasena" class= "formUser">
				<form id="formLog" method = "post">
					<p>
						<input type="password" name="contrasenaVieja" placeholder="Contraseña antigua">
					</p>
					<p>
						
						<input type="password" name="contrasenaNueva" placeholder="Contraseña nueva">
					</p>
					<p>
						
						<input type="password" name="contrasenaConfirmar" placeholder="Confirmar contraseña">
					</p>
					<p>
						<input type="submit" value="Cambiar contraseña" id="btnSubmit">
					</p>
				</form>
				<div id="output"></div>
			</div>
		</div>

		
	</div>
	<!-----------------------------------------------Footer----------------------------------------------->
	<?php
		include 'footer.php';
	?>
<!-------------ajax------------->
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
                    url: "conexionCambiarContrasena.php",
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
							alert("Contraseña cambiada");
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