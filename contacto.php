<?php
	$timezone = "America/Montevideo";
    date_default_timezone_set($timezone);
?>
<!DOCTYPE html>
<html lang ="es">
<head>
	<meta charset = "UTF-8">
	<title>MadMotors - Contact</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="estilo.css?v=<?php echo time(); ?>">
	<link rel="icon" type="image/x-icon" href="imagenes_contenido/favicon.ico">
</head>
<body>
<?php include 'cambioModoOscuro.php'?>
	<div id = "contacto">
		<!-----------------------------------------------Barra homepage----------------------------------------------->
		<?php
			include 'barraHeader.php';
		?>
		<!-----------------------------------------------Descripcion Contacto----------------------------------------------->
		<div id = "infoContacto">
			<div id= "contactoDescripcion" class="cuerpo">
				<p><b>¿Dónde encontrarnos?</b></p>
				<p>Puedes contactarte por nuestras redes sociales, Facebook, Instagram, Twitter o directamente desde nuestra página puedes agendar una cita para el mecánico. Nos encuentras entre Pdte. Tomás Berreta, 91400 Santa Rosa, Departamento de Canelones.</p>
				<p>Puedes contactarnos mediante el correo madmotors22@gmail.com.</p>
				<div id ="redesSociales_Contacto">
					<a href="https://www.instagram.com/madmotors22/">
						<i class="fab fa-instagram"></i>
					</a>
					<a href="https://twitter.com/MadMotors22">
						<i class="fab fa-twitter"></i>
					</a>
					<a href="https://www.facebook.com/Mad-Motors-109062908226607">
						<i class="fab fa-facebook-f"></i>
					</a>
					<a href="https://wa.me/59899610417">
						<i class="fab fa-whatsapp"></i>
					</a>
				</div>
			</div>
			<div id = "maparedesContacto">
				<div id= "mapaContacto" class="cuerpo">
					<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3910.2560338329704!2d-56.04336265099144!3d-34.49983479652274!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x95a048192840a655%3A0x4e3dc93c2e811f23!2sFercun!5e0!3m2!1ses!2suy!4v1632400258346!5m2!1ses!2suy" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
				</div>
			</div>
		</div>

		<!-----------------------------------------------Formulario----------------------------------------------->
		<div class="titulos">
			Agenda una cita
		</div>

		<div id = "formularioContacto" class = "cuerpo">
			<div class="formUser">
				<form action = "mailto:damagecodebusiness@gmail.com" method = "post" enctype = "text/plain">
					<p>
						<input type="text" name="Nombre" placeholder="Nombre">
					</p>
					<p>
						<input type="text" name="Apellido" placeholder="Apellido">
					</p>
					<p>
						<input type="text" name="Telefono" placeholder="Teléfono">
					</p>
					<p>
						<input type="email" name="Email" placeholder="Email">
					</p>
					<p>
						<textarea name="Descripcion" placeholder="Breve descripción de la consulta"></textarea>
					</p>
					<p>
						<input type="submit" value = "Agéndate">
					</p>
				</form>
			</div>
		</div>
			
	</div>
	<!-----------------------------------------------Footer----------------------------------------------->
	<?php
		include 'footer.php'
	?>
</body>
</html>
