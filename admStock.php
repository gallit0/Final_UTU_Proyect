<?php
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
	<title>MadMotors - Adm Stock</title>
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
			<form id="formLog" method="post">
				<div id= "formIngresoStockGeneral">
					<div class = "formIngresoStock">
						<div class = "titulosAdmStock">Repuesto</div>
						<p>
							<input type="text" name="nombreRepuesto" placeholder = "Nombre">
						</p>
						<br>
						<p>
							<input type="text" name="marcaRepuesto" placeholder = "Marca">
						</p>
						<br>
						<p>
							<textarea name="desRepuesto" placeholder = "Descripción"></textarea>
						</p>
						<br>
						<p>
							<input type="number" name="cantidadRepuesto" placeholder = "Cantidad">
						</p>
						<br>
						<p>
							<input type="number" name="precioRepuesto" placeholder = "Precio">
						</p>
						<br>
						<p>
							<input type="number" name="limiteRepuesto" placeholder = "Avisar en cantidad">
						</p>
						<br>
						<p>
							<label for="imagenStock">Imágen del repuesto:
								<input type="file" name = "imagenStock">
							</label>
						</p>
					</div>

					<div class = "formIngresoStock">
						<div class = "titulosAdmStock">Proveedor</div>

						<p>
							<input type="text" name="rutProveedor" placeholder = "RUT">
						</p>
						<br>
						<p>
							<input type="text" name="nombreProveedor" placeholder = "Nombre">
						</p>
						<br>
						<p>
							<input type="text" name="telefonoProveedor" placeholder = "Teléfono">
						</p>
						<br>
						<p>
							<input type="text" name="direccionSucursalCercana" placeholder="Sucursal más cercana">
						</p>
						<br>
							
						<p>
							<input type="submit" value="Guardar" id="btnSubmit">
						</p>
					</div>
				</div>
			</form>
			<div id="output"></div>
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
         		
         		
         		event.preventDefault()
                $.ajax({
                    type: "POST",
                    url: "conexionStock.php",
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
							alert("Stock Agregado");
							window.location.href = "controlStock.php";
						}
                        //Vuelve a habilitar el boton de Enviar
                        $("#btnSubmit").prop("disabled", false);
                    },
                     //La bitacora de la consola muestra ERROR y no envia el formulario
                    error: function (e) {
                        $("#output").html(e.responseText);
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