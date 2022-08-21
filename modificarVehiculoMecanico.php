<?php
	include 'conexion.php';
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
<html>
<head>
	<meta charset = "UTF-8">
	<title>MadMotors - Check in</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="estilo.css?v=<?php echo time(); ?>">
	<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
	<link rel="icon" type="image/x-icon" href="imagenes_contenido/favicon.ico">
</head>
<body>
<?php include 'cambioModoOscuro.php'?>
	<div id = "ingresoVehiculoMecanico">
		<!-------------Header------------->
		<?php
			include 'barraHeader.php';

		?>

		<div id ="cuerpoIngresoVehiculoMecanico" class = "cuerpo">
			<div id = "titulosSignLog"class = "titulos">
				Modificar Vehículo
			</div>
			<?php
            if(isset($_GET["matricula"])){
            	$matricula=urldecode($_GET["matricula"]);
            	$consulta="SELECT * FROM vehiculo WHERE matriculaVehiculo='$matricula'";
            	$res=mysqli_query($conexion, $consulta) or die ("errorR");
            	$fila=mysqli_fetch_array($res);
				
				echo "<form id='formLog' method='post'>";
					echo "<p>";
						echo "<br>";
						echo "<input type='text' name='matriculaIngresoVehiculo' value='".$fila['matriculaVehiculo']."' readonly>";
					echo "</p>";
					echo "<p>";
						echo "<br>";
						echo "<input type='text' name='tipoIngresoVehiculoForm' value='".$fila['tipoVehiculo']."'>";
					echo "</p>";
					echo "<p>";
						echo "<br>";
						echo "<input type='text' name='marcaIngresoVehiculoForm' value='".$fila['marcaVehiculo']."'>";
					echo "</p>";
					echo "<p>";
						echo "<br>";
						echo "<input type='text' name='colorIngresoVehiculoForm' value='".$fila['colorVehiculo']."'>";
					echo "</p>";
					echo "<br>";
					$consultaC="SELECT * FROM llevataller 
							WHERE matriculaVehiculo='".$fila['matriculaVehiculo']."'";
							$resC=mysqli_query($conexion, $consultaC) or die ("error");
							while($filaC=mysqli_fetch_array($resC)){
								echo "<input type='text' name='cedula' value='".$filaC['ciCliente']."' readonly>";
							}
					echo "<br>";
					echo "<br>";
					echo "<p>";
						echo "<input type='submit' value = 'Actualizar vehículo' id='btnSubmit'>";
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
                    url: "conexionVehiculoMod.php",
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
							alert("Vehiculo Modificado");
							window.location.href = "vehiculosTaller.php";
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