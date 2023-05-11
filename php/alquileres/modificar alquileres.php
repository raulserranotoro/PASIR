<?php
	//Evita que aparezcan mensajes de error en pantalla.
	error_reporting (0);
	//Crea una sesión.
	session_start ();
	//Si ambas variables están definidas (el usuario ha iniciado sesión), muestra el contenido de "modificar alquileres.php".
	if (isset ($_SESSION["dni_empleado"]) && isset ($_SESSION["password"])){
?>
		<!DOCTYPE html>
		<html lang="es">
			<head>
				<link href="../../index.css" rel="stylesheet" type="text/css"/>
				<link rel="shortcut icon" href="../../imagenes/logo.png"/>
				<meta charset="UTF-8"/>
				<title>Modificar alquileres | Biblioteca</title>
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
					<h2>Modificar alquileres</h2>
					<form action="modificar alquileres.php" method="POST">
						<fieldset>
							<legend>¿Qué alquiler deseas modificar?</legend>
							<input type="text" placeholder="Buscar ID..." id="buscar_id" name="buscar_id" pattern="^[0-9]+$" title="El ID está formado solo por números." required/>
							<button>Autorellenar datos</button>
						</fieldset>
					</form>
					<?php
						if (isset ($_POST["buscar_id"])){
							//Si se han introducido todos los datos, se conecta a la base de datos.
							$connection=new mysqli ("localhost", "administrador", "Ab123456", "biblioteca");
							//Si la conexión ha dado error, muestra una alerta por pantalla y te redirecciona a "modificar alquileres.php".
							if ($connection->connect_errno){
								echo "<script>alert ('No hay conexión: (".$connection->connect_errno.")".$connection->connect_error.".'); window.location='modificar alquileres.php'</script>";
							}
							//La variable "$query" guarda el resultado de la consulta.
							$query=mysqli_query ($connection, "SELECT * FROM alquileres WHERE id_alquiler='".$_POST["buscar_id"]."'");
							//La variable "$nr" guarda el número de filas de la tabla del contenido de la variable "$query".
							$nr=mysqli_num_rows ($query);
							//Comprueba si el número de filas es igual a 1.
							if ($nr==1){
								//Cada vez que se ejecuta en bucle, la variable "$row" guarda un valor obtenido de la variable "$query" y se muestra en la lista.
								while ($row=mysqli_fetch_array ($query)){
									$id_alquiler=$row[0];
									$dni_lector=$row[1];
									$isbn=$row[2];
									$fecha_salida=$row[3];
									$fecha_entrada=$row[4];
								}
							//Si la ejecución de sentencias ha fallado, muestra una alerta por pantalla y te redirecciona a "modificar alquileres.php".
							}else{
								echo "<script>alert ('El alquiler con ID ".$_POST["buscar_id"]." no existe.'); window.location='modificar alquileres.php'</script>";
							}
							//Se cierra la conexión al servidor de MySQL.
							mysqli_close ($connection);
						}
					?>
					<form action="modificar alquileres.php" method="POST">
						<label for="id_alquiler">Identificador:</label>
						<br>
						<input type="text" placeholder="Ingrese el ID" id="id_alquiler" name="id_alquiler" value="<?php echo $id_alquiler; ?>" readonly required/>
						<br>
						<label for="dni_lector">DNI:</label>
						<br>
						<input type="text" placeholder="Ingrese el DNI" id="dni_lector" name="dni_lector" value="<?php echo $dni_lector; ?>" readonly required/>
						<br>
						<label for="isbn">ISBN:</label>
						<br>
						<input type="text" placeholder="Ingrese el ISBN" id="isbn" name="isbn" value="<?php echo $isbn; ?>" readonly required/>
						<br>
						<label for="fecha_salida">Fecha de salida:</label>
						<br>
						<input type="date" id="fecha_salida" name="fecha_salida" value="<?php echo $fecha_salida; ?>" required/>
						<br>
						<label for="fecha_entrada">Fecha de entrada:</label>
						<br>
						<input type="date" id="fecha_entrada" name="fecha_entrada" value="<?php echo $fecha_entrada; ?>" required/>
						<br>
						<input type="submit" value="Modificar alquiler"/>
					</form>
					<?php
						//Comprueba si se han rellenado todos los campos del formulario mediante el método "POST".
						if (isset ($_POST["fecha_salida"]) && isset ($_POST["fecha_entrada"])){
							//Si se han introducido todos los datos, se conecta a la base de datos.
							$connection=new mysqli ("localhost", "administrador", "Ab123456", "biblioteca");
							//Si la conexión ha dado error, muestra una alerta por pantalla y te redirecciona a "modificar alquileres.php".
							if ($connection->connect_errno){
								echo "<script>alert ('No hay conexión: (".$connection->connect_errno.")".$connection->connect_error.".'); window.location='modificar alquileres.php'</script>";
							}
							//Guarda en cada variable lo recogido en el formulario con el método "POST".
							$id_alquiler=$_POST["id_alquiler"];
							$fecha_salida=$_POST["fecha_salida"];
							$fecha_entrada=$_POST["fecha_entrada"];
							//La variable "$update" guarda la sentencia realizada.
							$update="UPDATE alquileres SET fecha_salida='".$fecha_salida."', fecha_entrada='".$fecha_entrada."' WHERE id_alquiler='".$id_alquiler."'";
							//Si se conecta a la base de datos y se actualizan correctamente los datos, muestra una alerta por pantalla y te redirecciona a "alquileres.php".
							if (mysqli_query ($connection, $update)){
								echo "<script>alert ('Se ha modificado correctamente el alquiler.'); window.location='alquileres.php'</script>";
							//Si la ejecución de sentencias ha fallado, muestra una alerta por pantalla y te redirecciona a "modificar alquileres.php".
							}else{
								echo "<script>alert ('Ha fallado la instrucción.'); window.location='modificar alquileres.php'</script>";
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