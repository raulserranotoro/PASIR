<?php
	//Evita que aparezcan mensajes de error en pantalla.
	error_reporting (0);
	//Crea una sesión.
	session_start ();
	//Si ambas variables están definidas (el usuario ha iniciado sesión), muestra el contenido de "insertar alquileres.php".
	if (isset ($_SESSION["dni_empleado"]) && isset ($_SESSION["password"])){
?>
		<!DOCTYPE html>
		<html lang="es">
			<head>
				<link href="../../index.css" rel="stylesheet" type="text/css"/>
				<link rel="shortcut icon" href="../../imagenes/logo.png"/>
				<meta charset="UTF-8"/>
				<title>Insertar alquileres | Biblioteca</title>
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
								<a href="../categorias/categorias.php">Categorías</a>
							</li>
							<li>
								<a href="../editoriales/editoriales.php">Editoriales</a>
							</li>
							<li>
								<a class="fijo" href="../alquileres/alquileres.php">Alquileres</a>
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
					<h2>Insertar alquileres</h2>
					<form action="insertar alquileres.php" method="POST">
						<label for="dni_lector">DNI:</label>
						<br>
						<input type="text" placeholder="Ingrese el DNI" id="dni_lector" name="dni_lector" pattern="^[0-9]{7,8}[A-Z]$" title="El DNI debe estar formado por 7 u 8 dígitos y una letra al final." required/>
						<br>
						<label for="isbn">ISBN:</label>
						<br>
						<input type="text" placeholder="Ingrese el ISBN" id="isbn" name="isbn" pattern="^[0-9]{13}$" title="El ISBN debe estar formado por 13 dígitos." required/>
						<br>
						<label for="fecha_salida">Fecha de salida:</label>
						<br>
						<input type="date" id="fecha_salida" name="fecha_salida" required/>
						<br>
						<label for="fecha_entrada">Fecha de entrada:</label>
						<br>
						<input type="date" id="fecha_entrada" name="fecha_entrada" required/>
						<br>
						<input type="submit" value="Insertar alquiler"/>
					</form>
					<?php
						//Comprueba si se han rellenado todos los campos del formulario mediante el método "POST".
						if (isset ($_POST["dni_lector"]) && isset ($_POST["isbn"]) && isset ($_POST["fecha_salida"]) && isset ($_POST["fecha_entrada"])){
							//Si se han introducido todos los datos, se conecta a la base de datos.
							$connection=new mysqli ("localhost", "administrador", "Ab123456", "biblioteca");
							//Si la conexión ha dado error, muestra una alerta por pantalla y te redirecciona a "insertar alquileres.php".
							if ($connection->connect_errno){
								echo "<script>alert ('No hay conexión: (".$connection->connect_errno.")".$connection->connect_error.".'); window.location='insertar alquileres.php'</script>";
							}
							//Guarda en cada variable lo recogido en el formulario con el método "POST".
							$dni_lector=$_POST["dni_lector"];
							$isbn=$_POST["isbn"];
							$fecha_entrada=$_POST["fecha_entrada"];
							$fecha_salida=$_POST["fecha_salida"];
							//La variable "$query" guarda el resultado de la consulta.
							$query=mysqli_query ($connection, "SELECT * FROM lectores, libros WHERE dni_lector='".$dni_lector."' AND isbn='".$isbn."'");
							//La variable "$nr" guarda el número de filas de la tabla del contenido de la variable "$query".
							$nr=mysqli_num_rows ($query);
							//Comprueba si el número de filas es igual a 1.
							if ($nr==1){
								//La variable "$insert" guarda la sentencia realizada.
								$insert="INSERT INTO alquileres (dni_lector, isbn, fecha_salida, fecha_entrada) VALUES ('".$dni_lector."', '".$isbn."', '".$fecha_entrada."', '".$fecha_salida."')";
								//Si se conecta a la base de datos y se insertan correctamente los datos, muestra una alerta por pantalla y te redirecciona a "alquileres.php".
								if (mysqli_query ($connection, $insert)){
									echo "<script>alert ('Se ha insertado correctamente el alquiler.'); window.location='alquileres.php'</script>";
								//Si la ejecución de sentencias ha fallado, muestra una alerta por pantalla y te redirecciona a "insertar alquileres.php".
								}else{
									echo "<script>alert ('Ha fallado la instrucción.'); window.location='insertar alquileres.php'</script>";
								}
							//Si la ejecución de sentencias ha fallado, muestra una alerta por pantalla y te redirecciona a "modificar alquileres.php".
							}else{
								echo "<script>alert ('No se puede insertar el alquiler debido a que el DNI o ISBN insertado no existe.'); window.location='insertar alquileres.php'</script>";
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