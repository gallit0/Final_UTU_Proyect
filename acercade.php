<!DOCTYPE html>
<html lang ="es">
<head>
	<meta charset = "UTF-8">
	<title>MadMotors - About</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="estilo.css?v=<?php echo time(); ?>">
	<link rel="icon" type="image/x-icon" href="imagenes_contenido/favicon.ico">
</head>
<body>
<?php include 'cambioModoOscuro.php'?>
	<div id = "acercade">
		<!-----------------------------------------------Barra homepage----------------------------------------------->
		<?php
			include 'barraHeader.php';
		?>
		<!--Titulo acerca de-->
		
		<div class = "titulos">
			Acerca de nosotros
		</div>
		<!-----------------------------------------------Descripcion----------------------------------------------->
		<div id = "info" class="cuerpo">
			<div class="infoSecciones">
				<b>Nosotros somos:</b> Nos dedicamos a la reparación generalmente de vehículos clásicos. Nos dirigimos a los que llevan la pasión del motor con el mejor servicio hacia este tipo de vehículos. ¿A qué llamamos clásico? A todo lo que incluya a los 2000s para abajo.
			</div>
			<div class="infoSecciones">
				<b>Nuestra misión:</b> Somos Mad Motors, un taller dedicado a sus vehículos. Queremos proveer a nuestros clientes una amplia variedad de servicios para sus vehículos que se puedan adaptar a sus necesidades.
			</div>
			<div class="infoSecciones">
				<b>Nuestra visión:</b> Queremos formar parte de los grandes líderes en reparaciones y que nuestros clientes se sientan satisfechos con nuestro taller para así lograr un vínculo con el cliente. 
			</div>
		</div>

		<!-----------------------------------------------FAQ----------------------------------------------->
		<div class="titulos">
			Preguntas Frecuentes
		</div>

		<div id = "faq" class= "cuerpo">
			<div id = "preguntasFaq" class= "cuerpo">
				<p>
					<b>¿Cada cuánto hay que hacer un cambio de aceite?</b><br> Lo recomendable es entre 15.000Km a 20.000Km, todo dependiendo del tipo de vehículo o de aceite.
				</p>
				<br>
				<p>
					<b>¿Cada cuánto hay que hacer una revisión?</b><br> Lo recomendable es entre 10.000Km a 20.000Km como máximo, aunque sí notes que hay algo inusual o un ruido extraño lo mejor es llevarlo a revisión lo antes posible.
				</p>
				<br>
				<p>
					<b>¿Cuánta durabilidad tienen los neumáticos?</b><br> Dependiendo la calidad de los mismos, unos de buena calidad duran unos 40.000Km incluso 50.000Km, mientras que los de mala calidad no suelen durar más de 15.000Km.
				</p>
				<br>
				<p>
					<b>¿Cada cuánto hay que cambiar los frenos?</b><br> Los frenos son los componentes más críticos de cualquier vehículo, ya que una falla de los mismos puede ser fatal. Si se hace una revisión general cada 10.000Km o algo más no habría problema, pero solo los frenos habría que revisarlos cada 15.000Km o dos años, todo dependiendo del vehículo.
				</p>
			</div>
			<div id = "imagenesFaq" class = "cuerpo">
				<img src="imagenes_contenido/faq.jpg">
			</div>

		</div>
			
	</div>
<!-----------------------------------------------Footer----------------------------------------------->
			<?php
				include 'footerGeneral.php'
			?>
</body>
</html>
