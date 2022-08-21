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
	<title>MadMotors - Adm stock</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="estilo.css?v=<?php echo time(); ?>">
	<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
	<link rel="icon" type="image/x-icon" href="imagenes_contenido/favicon.ico">
</head>
<body>
<?php include 'cambioModoOscuro.php'?>
	<div id = "admStock">
		<!-------------Header------------->
		<?php
			include 'barraHeader.php';
		?>
		<div class = "titulos">Ingresar stock</div>
		<div id = "cuerpoAdmStock"class= "cuerpo">
		<?php
			$codigo=$_GET["codigo"];
            $consulta="SELECT * FROM repuesto WHERE idRepuesto='$codigo'";
            $res=mysqli_query($conexion, $consulta) or die ("error");
            $fila=mysqli_fetch_array($res);
			echo"<form id='formLog' method='post'>";
				echo"<div id= 'formIngresoStockGeneral'>";
					echo"<div class = 'formIngresoStock'>";
						echo"<div class = 'titulosAdmStock'>Repuesto</div>";
						echo"<input type='hidden' name='id' value='".$codigo."'>";
						echo"<p>";
							echo"<label for='nombreRepuesto'>Nombre:";
							echo "<br>";
								echo"<input type='text' name='nombreRepuesto' value='".$fila['nombreRepuesto']."'>";
							echo"</label>";
						echo"</p>";
						echo"<br>";
						echo"<p>";
							echo"<label for='marcaRepuesto'>Marca:";
							echo "<br>";
								echo"<input type='text' name='marcaRepuesto' value='".$fila['marcaRepuesto']."'>";
							echo"</label>";
						echo"</p>";
						echo"<br>";
						echo"<p>";
							echo"<label for='desRepuesto'>Descripción:";
							echo "<br>";
								echo"<textarea name='desRepuesto'>".$fila['desRepuesto']."</textarea>";
							echo"</label>";
						echo"</p>";
						echo"<br>";
						echo"<p>";
							echo"<label for='cantidadRepuesto'>Cantidad:";
							echo "<br>";
								echo"<input type='number' name='cantidadRepuesto' value='".$fila['cantidadRepuesto']."'>";
							echo"</label>";
						echo"</p>";
						echo"<br>";
						echo"<p>";
							echo"<label for='precioRepuesto'>Precio:";
							echo "<br>";
								echo"<input type='number' name='precioRepuesto' value='".$fila['precioRepuesto']."'>";
							echo"</label>";
						echo"</p>";
						echo"<p>";
							echo"<label for='limiteRepuesto'>Avisar en cantidad:";
							echo "<br>";
								echo"<input type='number' name='limiteRepuesto' value='".$fila['recordatorio']."'>";
							echo"</label>";
						echo"</p>";
						echo"<br>";
						echo"<p>";
							echo"<label for='cambImg'>¿Mantener imagen?"."&nbsp"."&nbsp";
								echo"<input type='checkbox' name = 'cambImg'  value='".$fila['urlimagen']."' checked>";
							echo"</label>";
						echo"</p>";
						echo"<br>";
						echo"<p>";
							echo"<label for='imagenStock'>Imágen del repuesto:";
							echo "<br>";
								echo"<input type='file' name = 'imagenStock' value='imagenStock/".$fila['urlimagen']."' >";
							echo"</label>";
						echo"</p>";
					echo"</div>";
            		$proveedor=$fila['rutProveedor'];
            		$consultaPr="SELECT * FROM proveedor WHERE rutProveedor='$proveedor'";
            		$resPr=mysqli_query($conexion, $consultaPr) or die ("error");
            		$filaPr=mysqli_fetch_array($resPr);
					echo"<div class = 'formIngresoStock'>";
						echo"<div class = 'titulosAdmStock'>Proveedor</div>";

						echo"<p>";
							echo"<label for='rutProveedor'>RUT:";
							echo "<br>";
								echo"<input type='text' name='rutProveedor' value='".$filaPr['rutProveedor']."'>";
							echo"</label>";
						echo"</p>";
						echo"<br>";
						echo"<p>";
							echo"<label for='nombreProveedor'>Nombre Proveedor:";
							echo "<br>";
								echo"<input type='text' name='nombreProveedor'  value='".$filaPr['nombreProveedor']."'>";
							echo"</label>";
						echo"</p>";
						echo"<br>";
						echo"<p>";
						$consultaT="SELECT * FROM telefonospoveedor WHERE rutProveedor='$proveedor'";
            			$resT=mysqli_query($conexion, $consultaT) or die ("error");
							echo"<label for='telefonoProveedor'>Teléfono Proveedor:";
							$filaT=mysqli_fetch_array($resT);
								echo "<br>";
									echo"<input type='text' name='telefonoProveedor'  value='".$filaT['telefonosProveedor']."'>";
							
							
							echo"</label>";
						echo"</p>";
						echo"<br>";
						echo"<p>";
							echo"<label for='direccionSucursalCercana'>Sucursal Cercana Proveedor:";
							echo "<br>";
								echo"<input type='text' name='direccionSucursalCercana' value='".$filaPr['direccionSucursalCercana']."'>";
							echo"</label>";
						echo"</p>";
						echo"<br>";
							
						echo"<p>";
							echo"<input type='submit' value='Guardar' id='btnSubmit'>";
						echo"</p>";
					echo"</div>";
				echo"</div>";
			echo"</form>";
			echo"<div id='output'></div>";
			?>
		</div>

		
	</div>
	<!-------------Footer------------->
		<?php
			include 'footer.php';
		?>
	<!-------------Validar imagen------------->
	<script>
    Filevalidation = () => {
        const fi = document.getElementById('imagenStock');
        // Check if any file is selected.
        if (fi.files.length > 0) {
            for (const i = 0; i <= fi.files.length - 1; i++) {
  
                const fsize = fi.files.item(i).size;
                const file = Math.round((fsize / 1024));
                // The size of the file.
                if (file >= 4096) {
                    alert(
                      "El archivo es muy grande, supera los 4mb")
                    	document.getElementById("imagenStock").value = "";
                } 
            }
        }
    }
</script>
<!-------------Implementar Ajax------------->
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
                    url: "conexionStockMod.php",
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
							alert("Repuesto Modificado");
							window.location.href = "controlStock.php";
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