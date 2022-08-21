<?php
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
<!DOCTYPE html>
<html lang ="es">
<head>
	<meta charset = "UTF-8">
	<title>MadMotors - Sign In</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="estilo.css?v=<?php echo time(); ?>">
	<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
	<link rel="icon" type="image/x-icon" href="imagenes_contenido/favicon.ico">
</head>
<body>
<?php include 'cambioModoOscuro.php'?>
	<div id = "signin">
		<!-----------------------------------------------Barra homepage----------------------------------------------->
		<?php
			include 'barraHeader.php';
		?>

		<!-----------------------------------------------Cuerpo signin----------------------------------------------->

		<div id = "cuerpoSignin" class = "cuerpo">
			<div id = "ingresoSignin" class = "cuerpo">
				<div id = "titulosSignLog" class="titulos">
					Registro de usuario
				</div>
				<div id ="formularioSignin" class = "formUser">
				<?php
		            if(isset($_GET["identificador"])){
			            $identificador=$_GET["identificador"];
			            $consulta="SELECT * FROM usuario WHERE idUsuario='$identificador'";
			            $res=mysqli_query($conexion, $consulta) or die ("error");
			            $fila=mysqli_fetch_array($res);	
						echo"<form id='formLog' method = 'post'>";
							if (strlen($fila["idUsuario"])==8){
								echo"<p>";
									echo "<label for='id'>Cédula:<br>";
										echo"<input type='text' name='id' value='".$fila['idUsuario']."'  readonly>";
									echo "</label>";
								echo"</p>";
								echo"<p>";
									echo "<label for='nombreApellidoUsuario'>Nombre y Apellido:<br>";
										echo"<input type='text' name='nombreApellidoUsuario' value='".$fila['nombreApellidoUsuario']."'>";
									echo "</label>";
								echo"</p>";
								echo"<p>";
									echo "<label for='emailUsuario'>Email:<br>";
										echo"<input type='email' name='emailUsuario' value='".$fila['emailUsuario']."'>";
									echo "</label>";
								echo"</p>";
								echo"<p>";
									echo "<label for='direccionUsuario'>Direccion:<br>";
										echo"<input type='text' name='direccionUsuario' value='".$fila['direccionUsuario']."'>";
									echo "</label>";
								echo"</p>";
								echo"<p>";
									echo "<label for='contrasenaUsuario'>Contraseña:<br>";
										echo"<input type='text' name='contrasenaUsuario' value='".$fila['contrasenaUsuario']."'>";
									echo "</label>";
								echo"</p>";
								echo"<p>";
									echo "<label for='permiso'>Permiso:<br>";
										echo"<input type='text' name='permiso' value='".$fila['permisoUsuario']."'>";
									echo "</label>";
								echo"</p>";
								$consultaE="SELECT * FROM empleado WHERE ciEmpleado='$identificador'";
			            		$resE=mysqli_query($conexion, $consultaE) or die ("error");
			            		$num=mysqli_num_rows($resE);
			            		if($num>0){
				            		$filaE=mysqli_fetch_array($resE);
									echo "Si Se desea agregar mecánico cambie el permiso a 2 o 3 si prefiere un administrador";
									
									echo"<p>";
										echo "<label for='ocupacion'>Ocupacion:<br>";
											echo"<input type='text' name='ocupacion' value='".$filaE['ocupacionEmpleado']."'>";
										echo "</label>";
									echo"</p>";
									echo"<p>";
										echo "<label for='fechaNacimiento'>Fecha Nacimiento:<br>";
											echo"<input type='date' name='fechaNacimiento' value='".$filaE['fechaNacimiento']."'>";
										echo "</label>";
									echo"</p>";
									echo"<p>";
										echo"<input type='submit' name='enviarFormularioSignin' id='btnSubmit' value = 'Modificar'>";
									echo"</p>";
							} else {
									echo "Si Se desea agregar mecánico cambie el permiso a 2 o 3 si prefiere un administrador";
									
									echo"<p>";
										echo "<label for='ocupacion'>Ocupacion:<br>";
											echo"<input type='text' name='ocupacion'>";
										echo "</label>";
									echo"</p>";
									echo"<p>";
										echo "<label for='fechaNacimiento'>Fecha Nacimiento:<br>";
											echo"<input type='date' name='fechaNacimiento'>";
										echo "</label>";
									echo"</p>";
									echo"<p>";
										echo"<input type='submit' name='enviarFormularioSignin' id='btnSubmit' value = 'Modificar'>";
									echo"</p>";
							}
						  }	else {
						  		$consultaC="SELECT * FROM clientecorporativo WHERE rutCliente='$identificador'";
			            		$resC=mysqli_query($conexion, $consultaC) or die ("error");
			            		$filaC=mysqli_fetch_array($resC);	
								echo"<p>";
									echo "<label for='id'>RUT:<br>";
										echo"<input type='text' name='id' value='".$fila['idUsuario']."' readonly>";
									echo "</label>";
								echo"</p>";
								echo"<p>";
									echo "<label for='nombreApellidoUsuario'>Nombre y Apellido:<br>";
										echo"<input type='text' name='nombreApellidoUsuario' value='".$fila['nombreApellidoUsuario']."'>";
									echo "</label>";
								echo"</p>";
								echo"<p>";
									echo "<label for='direccionUsuario'>Direccion:<br>";
										echo"<input type='text' name='direccionUsuario' value='".$fila['direccionUsuario']."'>";
									echo "</label>";
								echo"</p>";
								echo"<p>";
									echo "<label for='contrasenaUsuario'>Contraseña:<br>";
										echo"<input type='text' name='contrasenaUsuario' value='".$fila['contrasenaUsuario']."'>";
									echo "</label>";
								echo"</p>";
								echo"<p>";
									echo "<label for='razonSocial'>Razon Social:<br>";
										echo"<input type='text' name='razonSocial' value='".$filaC['razonSocial']."'>";
									echo "</label>";
								echo"</p>";
								echo"<p>";
										echo"<input type='submit' name='enviarFormularioSignin' id='btnSubmit' value = 'Modificar'>";
								echo"</p>";

							}
							echo"</form>";
							echo"<div id='output'></div>";
						 
					} else {
		                echo "ERROR";
		                echo "<a href='admUsuarios.php'> VOLVER </a>";
		            }
	            	?>
					</div>
				
			</div>
			<div id = "imagenesSignin" class = "cuerpo">
				
			</div>
		</div>

		
	</div>
<!-----------------------------------------------Footer----------------------------------------------->
	<?php
		include 'footerGeneral.php'
	?>
<!-----------------------------------------------Implementar Ajax---------------------------------->
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
                    url: "conexionUsuarioMod.php",
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
							window.location.href = "admUsuarios.php";
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