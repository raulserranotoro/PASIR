<?php
	//Evita que aparezcan mensajes de error en pantalla.
	error_reporting (0);
	//Crea una sesión.
	session_start ();
	//Si ambas variables están definidas (el usuario ha iniciado sesión), muestra el contenido de "modificar editoriales.php".
	if (isset ($_SESSION["dni_empleado"]) && isset ($_SESSION["password"])){
?>
		<!DOCTYPE html>
		<html lang="es">
			<head>
				<link href="../../index.css" rel="stylesheet" type="text/css"/>
				<link rel="shortcut icon" href="../../imagenes/logo.png"/>
				<meta charset="UTF-8"/>
				<title>Modificar editoriales | Biblioteca</title>
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
								<a class="fijo" href="../editoriales/editoriales.php">Editoriales</a>
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
					<h2>Modificar editoriales</h2>
					<form action="modificar editoriales.php" method="POST">
						<fieldset>
							<legend>¿Qué editorial deseas modificar?</legend>
							<select id="buscar_editorial" name="buscar_editorial" required>
								<option value=""></option>
						<?php
							//La variable "$mysqli" guarda la conexión al servidor MySQL.
							$mysqli=mysqli_connect ("localhost", "administrador", "Ab123456", "biblioteca");
							//La variable "$query_editoriales" guarda el resultado de la consulta realizada.
							$query_editoriales=mysqli_query ($mysqli, "SELECT editorial FROM editoriales");
							//Cada vez que se ejecuta en bucle, la variable "$datos_editoriales" guarda un valor obtenido de la variable "$query_editoriales" y se muestra en la etiqueta "<option>" y en el atributo "value".
							while ($datos_editoriales=mysqli_fetch_array ($query_editoriales)){
						?>
								<option value="<?php echo $datos_editoriales["editorial"]; ?>"><?php echo $datos_editoriales["editorial"]; ?></option>
						<?php
							}
						?>
							</select>
							<button>Autorellenar datos</button>
						</fieldset>
					</form>
					<?php
						if (isset ($_POST["buscar_editorial"])){
							//Si se han introducido todos los datos, se conecta a la base de datos.
							$connection=new mysqli ("localhost", "administrador", "Ab123456", "biblioteca");
							//Si la conexión ha dado error, muestra una alerta por pantalla y te redirecciona a "modificar editoriales.php".
							if ($connection->connect_errno){
								echo "<script>alert ('No hay conexión: (".$connection->connect_errno.")".$connection->connect_error.".'); window.location='modificar editoriales.php'</script>";
							}
							//La variable "$query" guarda el resultado de la consulta.
							$query=mysqli_query ($connection, "SELECT * FROM editoriales WHERE editorial='".$_POST["buscar_editorial"]."'");
							//La variable "$nr" guarda el número de filas de la tabla del contenido de la variable "$query".
							$nr=mysqli_num_rows ($query);
							//Comprueba si el número de filas es igual a 1.
							if ($nr==1){
								//Cada vez que se ejecuta en bucle, la variable "$row" guarda un valor obtenido de la variable "$query" y se muestra en la lista.
								while ($row=mysqli_fetch_array ($query)){
									$id_editorial=$row[0];
									$editorial=$row[1];
								}
							}
						}
					?>
					<form action="modificar editoriales.php" method="POST">
						<label for="id_editorial">Identificador:</label>
						<br>
						<input type="text" placeholder="Ingrese el ID" id="id_editorial" name="id_editorial" value="<?php echo $id_editorial; ?>" readonly required/>
						<br>
						<label for="editorial_modificada">Nombre de la editorial:</label>
						<br>
						<input type="text" placeholder="Ingrese la editorial" id="editorial" name="editorial" pattern="^[ÁÉÍÓÚA-Z][a-záéíóú]+(\s+[ÁÉÍÓÚA-Z]?[a-záéíóú]+)*$" title="El nombre de la editorial debe empezar por letra mayúscula." value="<?php echo $editorial; ?>" required/>
						<br>
						<input type="submit" value="Modificar editorial"/>
					</form>
					<?php
						//Comprueba si se han rellenado todos los campos del formulario mediante el método "POST".
						if (isset ($_POST["editorial"])){
							//Si se han introducido todos los datos, se conecta a la base de datos.
							$connection=new mysqli ("localhost", "administrador", "Ab123456", "biblioteca");
							//Si la conexión ha dado error, muestra una alerta por pantalla y te redirecciona a "modificar editoriales.php".
							if ($connection->connect_errno){
								echo "<script>alert ('No hay conexión: (".$connection->connect_errno.")".$connection->connect_error.".'); window.location='modificar editoriales.php'</script>";
							}
							//La variable "$query" guarda el resultado de la consulta.
							$query=mysqli_query ($connection, "SELECT * FROM editoriales WHERE editorial='".$_POST["editorial"]."'");
							//La variable "$nr" guarda el número de filas de la tabla del contenido de la variable "$query".
							$nr=mysqli_num_rows ($query);
							//Comprueba si el número de filas es igual a 0.
							if ($nr==0){
								//La variable "$query" guarda el resultado de la consulta.
								$query=mysqli_query ($connection, "SELECT * FROM libros WHERE editorial IN (SELECT editorial FROM editoriales WHERE id_editorial='".$_POST["id_editorial"]."')");
								//La variable "$nr" guarda el número de filas de la tabla del contenido de la variable "$query".
								$nr=mysqli_num_rows ($query);
								//Comprueba si el número de filas es igual a 0.
								if ($nr==0){
									//La variable "$query" guarda el resultado de la consulta.
									$query=mysqli_query ($connection, "SELECT * FROM editoriales WHERE id_editorial='".$_POST["id_editorial"]."'");
									//Cada vez que se ejecuta en bucle, la variable "$row" guarda un valor obtenido de la variable "$query" y se muestra en la lista.
									while ($row=mysqli_fetch_array ($query)){
										$id_editorial=$row[0];
										$editorial=$row[1];
									}
									//La variable "$update" guarda la sentencia realizada.
									$update="UPDATE editoriales SET editorial='".$_POST["editorial"]."' WHERE editorial='".$editorial."'";
									//Si se conecta a la base de datos y se actualizan correctamente los datos, muestra una alerta por pantalla y te redirecciona a "editoriales.php".
									if (mysqli_query ($connection, $update)){
										echo "<script>alert ('Se ha modificado correctamente la editorial ".$editorial.".'); window.location='editoriales.php'</script>";
									//Si la ejecución de sentencias ha fallado, muestra una alerta por pantalla y te redirecciona a "modificar editoriales.php".
									}else{
										echo "<script>alert ('Ha fallado la instrucción.'); window.location='modificar editoriales.php'</script>";
									}
								}else{
									//La variable "$query" guarda el resultado de la consulta.
									$query=mysqli_query ($connection, "SELECT * FROM editoriales WHERE id_editorial='".$_POST["id_editorial"]."'");
									//Cada vez que se ejecuta en bucle, la variable "$row" guarda un valor obtenido de la variable "$query" y se muestra en la lista.
									while ($row=mysqli_fetch_array ($query)){
										$id_editorial=$row[0];
										$editorial=$row[1];
									}
									//La variable "$update" guarda la sentencia realizada.
									$update="UPDATE libros, editoriales SET libros.editorial='".$_POST["editorial"]."', editoriales.editorial='".$_POST["editorial"]."' WHERE libros.editorial='".$editorial."' AND editoriales.editorial='".$editorial."'";
									$foreign_key_checks="SET FOREIGN_KEY_CHECKS=0";
									mysqli_query ($connection, $foreign_key_checks);
									//Si se conecta a la base de datos y se actualizan correctamente los datos, muestra una alerta por pantalla y te redirecciona a "editoriales.php".
									if (mysqli_query ($connection, $update)){
										echo "<script>alert ('Se ha modificado correctamente la editorial ".$editorial.".'); window.location='editoriales.php'</script>";
									//Si la ejecución de sentencias ha fallado, muestra una alerta por pantalla y te redirecciona a "modificar editoriales.php".
									}else{
										echo "<script>alert ('Ha fallado la instrucción.'); window.location='modificar editoriales.php'</script>";
									}
									$foreign_key_checks="SET FOREIGN_KEY_CHECKS=1";
									mysqli_query ($connection, $foreign_key_checks);
								}
							//Si el número de filas no es igual a 0 entonces muestra una alerta por pantalla y te redirecciona a "modificar editoriales.php".
							}else{
								echo "<script>alert ('No se ha podido modificar la editorial.'); window.location='modificar editoriales.php'</script>";
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