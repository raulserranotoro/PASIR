<?php
	//Evita que aparezcan mensajes de error en pantalla.
	error_reporting (0);
	//Crea una sesión.
	session_start ();
	//Si ambas variables están definidas (el usuario ha iniciado sesión), muestra el contenido de "insertar categorias.php".
	if (isset ($_SESSION["dni_empleado"]) && isset ($_SESSION["password"])){
?>
		<!DOCTYPE html>
		<html lang="es">
			<head>
				<link href="../../index.css" rel="stylesheet" type="text/css"/>
				<link rel="shortcut icon" href="../../imagenes/logo.png"/>
				<meta charset="UTF-8"/>
				<title>Insertar categorías | Biblioteca</title>
			</head>
			<body>
				<header>
					<div>
						<a href="../../index.php">
							<img src="../../imagenes/logo.png" class="logo"/>
						</a>
					</div>
					<nav>
						<ul class="navegador1">
							<li>
								<a href="../../index.php">Inicio</a>
							</li>
							<li>
								<a href="../libros/libros.php">Libros</a>
							</li>
							<li>
								<a href="../autores/autores.php">Autores</a>
							</li>
							<li>
								<a class="fijo" href="../categorias/categorias.php">Categorías</a>
							</li>
							<li>
								<a href="../editoriales/editoriales.php">Editoriales</a>
							</li>
							<li>
								<a href="../alquileres/alquileres.php">Alquileres</a>
							</li>
							<li>
								<a href="../lectores/lectores.php">Lectores</a>
							</li>
							<li>
								<a href="../empleados/datos empleados.php">Empleado</a>
							</li>
						</ul>
					</nav>
				</header>
				<main>
					<h2>Insertar categorías</h2>
					<form action="insertar categorias.php" method="POST">
						<label for="categoria">Nombre de la categoría:</label>
						<br>
						<input type="text" placeholder="Ingrese la categoría" id="categoria" name="categoria" pattern="^[ÁÉÍÓÚA-Z][a-záéíóú]+(\s+[ÁÉÍÓÚA-Z]?[a-záéíóú]+)*$" title="El nombre de la categoría debe empezar por letra mayúscula." required/>
						<br>
						<input type="submit" value="Insertar categoría"/>
					</form>
					<?php
						//Comprueba si se han rellenado todos los campos del formulario mediante el método "POST".
						if (isset ($_POST["categoria"])){
							//Si se han introducido todos los datos, se conecta a la base de datos.
							$connection=new mysqli ("localhost", "administrador", "Ab123456", "biblioteca");
							//Si la conexión ha dado error, muestra una alerta por pantalla y te redirecciona a "insertar categorias.php".
							if ($connection->connect_errno){
								echo "<script>alert ('No hay conexión: (".$connection->connect_errno.")".$connection->connect_error.".'); window.location='insertar categorias.php'</script>";
							}
							//Guarda en cada variable lo recogido en el formulario con el método "POST".
							$categoria=$_POST["categoria"];
							//La variable "$query" guarda el resultado de la consulta.
							$query=mysqli_query ($connection, "SELECT * FROM categorias WHERE categoria='".$categoria."'");
							//La variable "$nr" guarda el número de filas de la tabla del contenido de la variable "$query".
							$nr=mysqli_num_rows ($query);
							//Comprueba si el número de filas es igual a 0.
							if ($nr==0){
								//La variable "$insert" guarda la sentencia realizada.
								$insert="INSERT INTO categorias (categoria) VALUES ('".$categoria."')";
								//Si se conecta a la base de datos y se insertan correctamente los datos, muestra una alerta por pantalla y te redirecciona a "categorias.php".
								if (mysqli_query ($connection, $insert)){
									echo "<script>alert ('Se ha insertado correctamente la categoría ".$categoria.".'); window.location='categorias.php'</script>";
								//Si la ejecución de sentencias ha fallado, muestra una alerta por pantalla y te redirecciona a "insertar categorias.php".
								}else{
									echo "<script>alert ('Ha fallado la instrucción.'); window.location='insertar categorias.php'</script>";
								}
							//Si el número de filas no es igual a 0 entonces muestra una alerta por pantalla y te redirecciona a "insertar categorias.php".
							}else{
								echo "<script>alert ('La categoría ".$categoria." ya existe.'); window.location='insertar categorias.php'</script>";
							}
							//Se cierra la conexión al servidor de MySQL.
							mysqli_close ($connection);
						}
					?>
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
<?php
	//Si ambas variables no están definidas (el usuario no ha iniciado sesión), muestra una alerta por pantalla y te redirecciona a "index.php".
	}else{
		echo "<script>alert ('Debes iniciar sesión para poder acceder.'); window.location='../../index.php'</script>";
	}
?>