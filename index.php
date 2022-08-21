<!DOCTYPE html>
<html lang ="es">
<head>
	<meta charset = "UTF-8">
	<title>MadMotors - Index</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="estilo.css?v=<?php echo time(); ?>">
	<link rel="stylesheet" href="fontawesome\css\all.min.css?v=<?php echo time(); ?>">
	<link rel="icon" type="image/x-icon" href="imagenes_contenido/favicon.ico">
</head>
<body>
	<div id = "galeriaBotones">
		<button id = "botonIzquierda"><i class="fas fa-chevron-left"></i></button>
		<button id = "botonDerecha"><i class="fas fa-chevron-right"></i></button>
	</div>
	<?php include 'cambioModoOscuro.php'?>
	<div id = "indice">
		<!-----------------------------------------------Barra homepage----------------------------------------------->
		<?php
			include 'barraHeader.php';
		?>
		<!-----------------------------------------------Galeria de imagenes----------------------------------------------->
		<div id = "galeria">

			<script>//Script en javascript
				/*Variables y arrays*/
				var i = 0;
				var imagenes = [];
				var imagenesC = [];
				
				var botonIzquierda = document.getElementById("botonIzquierda");
				var botonDerecha = document.getElementById("botonDerecha");

				//imagenes dentro de array 
				imagenes [0] = "slider_index/0.jpg";
				imagenes [1] = "slider_index/1.jpg";
				imagenes [2] = "slider_index/2.jpg";
				imagenes [3] = "slider_index/3.jpg";

				imagenesC [0] = "slider_index/10.jpg";
				imagenesC [1] = "slider_index/11.jpg";
				imagenesC [2] = "slider_index/12.jpg";
				imagenesC [3] = "slider_index/13.jpg";

				//botones
				botonIzquierda.onclick = function(){//Izquierda
					console.log ('boton izquierdo');
					if(i ==3 || i ==2 || i ==1){
						i--;
					}else{
						i = 3;
					}
					console.log (i);
				}
				botonDerecha.onclick = function(){//Derecha
					console.log ('boton derecho');
					if(i < imagenes.length - 1){
						i++;
					} else{
						i = 0;
					}
					console.log (i);
				}
				//funcion cambiar imagenes
				function cambiarImagen(){
					document.slide.src = imagenes[i];
					document.slideChico.src = imagenesC[i];
					setTimeout("cambiarImagen()", 1);
				}
				window.onload = cambiarImagen;

			</script>

			<img name="slide" id = "slide" width="auto" height="100%">

			<img name="slideChico" id = "slideChico" width="100%" height="auto">

		</div>
		<!-----------------------------------------------Descripcion----------------------------------------------->
		<div id = "descripcion" class= "texto">
			<div id = "descripcionCentrado">
				<a href="acercade.php">
					<div class= "descripcionBotones">
						<i class="fas fa-info-circle"></i>&nbsp;Acerca de nosotros
					</div>
				</a>		
				<a href="contacto.php">
					<div class= "descripcionBotones">
						<i class="far fa-calendar-alt"></i>&nbsp;Agenda una cita
					</div>
				</a>		
				<a href="user_Login.php">
					<div class= "descripcionBotones">
						<i class="fas fa-car-alt"></i>&nbsp;Seguir reparación
					</div>
				</a>	
			</div>
		</div>
		<!-----------------------------------------------Servicios - index----------------------------------------------->
		<div class ="titulos">
			Servicios
		</div>

		<div id = "serviciosGeneral" class="cuerpo">
			<div id = "serviciosSuperior1">
				<div class= "serviciosSuperiorDescripciones">
					<img src="imagenes_contenido/ali.jpg">
				</div>
				<div class= "serviciosSuperiorDescripciones">
					<img src="imagenes_contenido/luz.jpg">
				</div>
				<div class= "serviciosSuperiorDescripciones">
					<img src="imagenes_contenido/fr.jpg">
				</div>
			</div>
			<div id = "serviciosSuperior2">
				<div class= "serviciosSuperiorDescripciones">
					Alineación y balanceo
				</div>
				<div class= "serviciosSuperiorDescripciones">
					Iluminación
				</div>
				<div class= "serviciosSuperiorDescripciones">
					Frenos
				</div>
			</div>
			
		</div>

		
	</div>
	<!-----------------------------------------------Footer----------------------------------------------->
	<?php
		include 'footerGeneral.php'
	?>

</body>
</html>