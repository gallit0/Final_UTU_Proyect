<?php
	session_start();
	if(isset($_SESSION['idUsuario'])){
        header("Location: usuarioPerfil.php");
    }
?>
<!DOCTYPE html>
<html lang ="es">
<head>
	<meta charset = "UTF-8">
	<title>MadMotors - Log In</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="estilo.css?v=<?php echo time(); ?>">
	<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
	<link rel="icon" type="image/x-icon" href="imagenes_contenido/favicon.ico">
</head>
<body>
<?php include 'cambioModoOscuro.php'?>
	<div id = "login">
		<!-----------------------------------------------Barra homepage----------------------------------------------->
		<?php
			include 'barraHeader.php';
		?>
		<!-----------------------------------------------Cuerpo login----------------------------------------------->
		<div id = "cuerpoLogin">
			<div id = "ingresoLogin" class="cuerpo">
				<div id = "titulosSignLog" class="titulos">
					Ingreso de usuario
				</div>
				<div class = "formUser">
					<form  id="formLog" method = "post">
						<p>
							<input type="email" name="emailUsuario" placeholder="Email">
						</p>
						<p>
							<input type="password" name="contrasenaUsuario" placeholder = "Contraseña">
						</p>
						<p>
							<input type="submit" name="enviarFormularioLogin" id="btnSubmit" value = "Ingresar">
						</p>
					</form>
					<div id="output"></div>
					<div class = "alternarSignLogIn">o <a href = "signin.php">regístrate aquí</a>.</div>
					<div class = "alternarSignLogIn">Click <a href="loginCorp.php">aquí para login corporativo</a>.</div>
				</div>
			</div>
			<div id = "imagenesLogin" class="cuerpo">
				<img src="imagenes_contenido/login.jpg">
			</div>
		</div>
		
	</div>
	<!-----------------------------------------------Footer----------------------------------------------->
	<?php
		include 'footerGeneral.php'
	?>
	<!-----------------------------------------------Conexion Ajax----------------------------------------------->
	<script type="text/javascript">
	    	$(document).ready(function () {
            $("#btnSubmit").click(function (event) {
                //No envia el formulario directamente despues de presionar.
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
                    url: "conexionLogin.php",
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