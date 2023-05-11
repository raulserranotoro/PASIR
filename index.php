<!DOCTYPE html>
<html lang="es">
	<head>
		<link href="./index.css" rel="stylesheet" type="text/css"/>
		<link rel="shortcut icon" href="./imagenes/logo.png"/>
		<meta charset="UTF-8"/>
		<title>Inicio | Biblioteca</title>
	</head>
	<body>
		<header>
			<div>
				<a href="./index.php">
					<img src="./imagenes/logo.png" class="logo"/>
				</a>
			</div>
	<?php
		//Evita que aparezcan mensajes de error en pantalla.
		error_reporting (0);
		//Crea una sesión.
		session_start ();
		//Si ambas variables están definidas (el usuario ha iniciado sesión), muestra el "navegador1".
		if (isset ($_SESSION["dni_empleado"]) && isset ($_SESSION["password"])){
	?>
			<nav>
				<ul class="navegador1">
					<li>
						<a class="fijo" href="./index.php">Inicio</a>
					</li>
					<li>
						<a href="./php/libros/libros.php">Libros</a>
					</li>
					<li>
						<a href="./php/autores/autores.php">Autores</a>
					</li>
					<li>
						<a href="./php/categorias/categorias.php">Categorías</a>
					</li>
					<li>
						<a href="./php/editoriales/editoriales.php">Editoriales</a
					</li>
					<li>
						<a href="./php/alquileres/alquileres.php">Alquileres</a>
					</li>
					<li>
						<a href="./php/lectores/lectores.php">Lectores</a>
					</li>
					<li>
						<a href="./php/empleados/datos empleados.php">Empleado</a>
					</li>
				</ul>
			</nav>
	<?php
		//Si ambas variables están definidas (el usuario ha iniciado sesión), muestra el "navegador2".
		}elseif (isset ($_SESSION["dni_lector"]) && isset ($_SESSION["password"])){
	?>
			<nav>
				<ul class="navegador2">
					<li>
						<a class="fijo" href="./index.php">Inicio</a>
					</li>
					<li>
						<a href="./php/libros/libros.php">Libros</a>
					</li>
					<li>
						<a href="./php/alquileres/alquileres.php">Alquileres</a>
					</li>
					<li>
						<a href="./php/lectores/datos lectores.php">Lector</a>
					</li>
				</ul>
			</nav>
	<?php
		//Si ambas variables no están definidas (el usuario no ha iniciado sesión), muestra el "navegador2".
		}else{
	?>
			<nav>
				<ul class="navegador2">
					<li>
						<a class="fijo" href="./index.php">Inicio</a>
					</li>
					<li>
						<a href="./php/libros/libros.php">Libros</a>
					</li>
					<li>
						<a href="./php/lectores/registrar lectores.php">Registro</a>
					</li>
					<li>
						<a href="./php/acceso.php">Acceso</a>
					</li>
				</ul>
			</nav>
	<?php
		}
	?>
		</header>
		<main style="background-color: #5b77fa;">
			<img src="./imagenes/portada.png" class="portada"/>
		</main>
		<footer>
			<p>
				<script type="text/javascript">
					//Muestra la fecha actual.
					var d=new Date ();
					var mes=d.getMonth ()+1;
					document.write (d.getDate ()+'/'+mes+'/'+d.getFullYear ());
				</script>
				© Biblioteca
			</p>
		</footer>
	</body>
</html>