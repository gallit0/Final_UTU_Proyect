<html>
	<head>
		<link rel="stylesheet" href="estilo.css?v=<?php echo time(); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="fontawesome\css\all.min.css?v=<?php echo time(); ?>">
		<link rel="icon" type="image/x-icon" href="imagenes_contenido/favicon.ico">
	</head>
	<body>
		
		<div id = "header">
			<div id = "logoHeader">
				<a href = "index.php"><img src = "layout/logoMadHomepage.png" style="height:94%; width: auto;"></a>
			</div>
			<div id = "barraHomepage">
				<ul>
					<li id = "barraHomepage_Usuario">
						<a href="user_Login.php"><i class="fa fa-user-circle"></i></a>
					</li>
					<li class = "barraHomepage_Texto">
						<a href="acercade.php">Acerca de</a>
					</li>
					<li class = "barraHomepage_Texto">
						<a href="contacto.php">Contacto</a>
					</li>
					<li class = "barraHomepage_Texto">
						<a href="servicios.php">Servicios</a>
					</li>
					<li class = "barraHomepage_Texto">
						<a href="index.php">Inicio</a>
					</li>

					<!--Menu desplegable responsive-->
					<li id = "barraHomepage_MenuDesplegable">
						<i class="fas fa-bars"></i>
						<div id = "menuDesplegable">
							<ul>
								<li>
									<a href="index.php"><i class="fas fa-home"></i>&nbsp;Inicio </a>
								</li>
								<li>
									<a href="servicios.php"><i class="fas fa-wrench"></i>&nbsp;Servicios </a>	
								</li>
								<li>
									<a href="contacto.php"><i class="fas fa-address-book"></i>&nbsp;Contacto</a>
								</li>
								<li>
									<a href="acercade.php"><i class="fas fa-info-circle"></i>&nbsp;Acerca de</a>
								</li>
								<li>
									<a href="user_Login.php"><i class="fa fa-user-circle"></i>&nbsp;Usuario </a>
								</li>
							</ul>
						</div>
					</li>
				</ul>
			</div>
		</div>
		<!--Separacion del header y el resto de la pagina-->
		<div id = "separacionHeader"></div>
		
	</body>
</html>