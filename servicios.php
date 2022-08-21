<!DOCTYPE html>
<html lang ="es">
<head>
	<meta charset = "UTF-8">
	<title>MadMotors - Services</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="estilo.css?v=<?php echo time(); ?>">
	<link rel="icon" type="image/x-icon" href="imagenes_contenido/favicon.ico">
</head>
<body>
<?php include 'cambioModoOscuro.php'?>
	<div id = "servicios">
		<!-----------------------------------------------Barra homepage----------------------------------------------->
		<?php
			include 'barraHeader.php';
		?>
		<div class="titulos">
			Servicios
		</div>
		<!-----------------------------------------------Servicios cuerpo-------------------------------------------->
		<div id= "cuerpoServicios" class="cuerpo">
			<div class="serviciosDiv">
				<div class="imagenDerechaServicio">
					<img src="imagenes_contenido/ac1.jpg">
				</div>
				<div class="descripcionIzquierdaServicio">
				<p><b>Cambio de aceite:</b> Cada cierto tiempo se debe realizar un cambio para un buen mantenimiento del vehículo. Nuestros mecánicos se encargarán de reemplazar el aceite viejo por nuevo.</p>
				</div>
			</div>

			<div class="serviciosDiv">
				<div class="imagenIzquierdaServicio">
					<img src="imagenes_contenido/ali.jpg">
				</div>
				<div class="descripcionDerechaServicio">
					<p><b>Alineación y balanceo:</b> Se ajustará y distribuirá uniformemente el peso entre las llantas y los rines, además se alinearán los neumáticos para la correcta dirección del vehículo.</p>
				</div>
				
			</div>

			<div class="serviciosDiv">
				<div class="imagenDerechaServicio">
					<img src="imagenes_contenido/luz.jpg">
				</div>
				<div class="descripcionIzquierdaServicio">
					<p><b>Iluminación:</b> Se realiza un chequeo en los faros e iluminación interna, además se cambiarán si es necesario.</p>
				</div>
			</div>

			<div class="serviciosDiv">
				<div class="imagenIzquierdaServicio">
					<img src="imagenes_contenido/fr.jpg">
				</div>
				<div class="descripcionDerechaServicio">
					<p><b>Frenos:</b> Principalmente se le hará revisión a las pastillas, en el caso que notemos un alto desgaste o estén directamente dañados se le hará un cambio.</p>
				</div>
			</div>

			<div class="serviciosDiv">
				<div class="imagenDerechaServicio">
					<img src="imagenes_contenido/neu.jpg">
				</div>
				<div class="descripcionIzquierdaServicio">
					<p><b>Neumáticos:</b> Dependiendo del desgaste de los mismos es cuando efectuaremos el cambio, además depende de la decisión del cliente si cambiar dos o directamente los cuatro.</p>
				</div>
			</div>

			<div class="serviciosDiv">
				<div class="imagenIzquierdaServicio">
					<img src="imagenes_contenido/mot.jpg">
				</div>
				<div class="descripcionDerechaServicio">
					<p><b>Revisión general del vehículo:</b> Dirigido a las personas que escuchan algún tipo de ruido en el vehículo o simplemente una revisión general rutinaria, se examina por completo el vehículo en caso de que pueda fallar o tenga un desgaste excesivo en diversos componentes.</p>
				</div>
			</div>
		</div>
	<!-----------------------------------------------Agendar-------------------------------------------->
		<div id ="agendate">
			<div id="botonAgenda">
				<a href="contacto.php">
					<div class= "descripcionBotones">
						<i class="far fa-calendar-alt"></i>&nbsp;Agenda una cita
					</div>
				</a>		
			</div>
		</div>
			
	</div>
	<!-----------------------------------------------Footer----------------------------------------------->
	<?php
		include 'footerGeneral.php'
	?>
</body>
</html>
