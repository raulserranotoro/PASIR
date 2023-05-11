<?php
	//Evita que aparezcan mensajes de error en pantalla.
	error_reporting (0);
	//Crea una sesión.
	session_start ();
	//Si ambas variables están definidas (el usuario ha iniciado sesión), muestra el contenido de "modificar autores.php".
	if (isset ($_SESSION["dni_empleado"]) && isset ($_SESSION["password"])){
?>
		<!DOCTYPE html>
		<html lang="es">
			<head>
				<link href="../../index.css" rel="stylesheet" type="text/css"/>
				<link rel="shortcut icon" href="../../imagenes/logo.png"/>
				<meta charset="UTF-8"/>
				<title>Modificar autores | Biblioteca</title>
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
								<a class="fijo" href="../autores/autores.php">Autores</a>
							</li>
							<li>
								<a href="../categorias/categorias.php">Categorías</a>
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
					<h2>Modificar autores</h2>
					<form action="modificar autores.php" method="POST">
						<fieldset>
							<legend>¿Qué autor deseas modificar?</legend>
							<select id="buscar_autor" name="buscar_autor" required>
								<option value=""></option>
						<?php
							//La variable "$mysqli" guarda la conexión al servidor MySQL.
							$mysqli=mysqli_connect ("localhost", "administrador", "Ab123456", "biblioteca");
							//La variable "$query_autores" guarda el resultado de la consulta realizada.
							$query_autores=mysqli_query ($mysqli, "SELECT id_autor, autor FROM autores");
							//Cada vez que se ejecuta en bucle, la variable "$datos_autores" guarda un valor obtenido de la variable "$query_autores" y se muestra en la etiqueta "<option>" y en el atributo "value".
							while ($datos_autores=mysqli_fetch_array ($query_autores)){
						?>
								<option value="<?php echo $datos_autores["id_autor"]; ?>"><?php echo $datos_autores["autor"]; ?></option>
						<?php
							}
						?>
							</select>
							<button>Autorellenar datos</button>
						</fieldset>
					</form>
					<?php
						if (isset ($_POST["buscar_autor"])){
							//Si se han introducido todos los datos, se conecta a la base de datos.
							$connection=new mysqli ("localhost", "administrador", "Ab123456", "biblioteca");
							//Si la conexión ha dado error, muestra una alerta por pantalla y te redirecciona a "modificar autores.php".
							if ($connection->connect_errno){
								echo "<script>alert ('No hay conexión: (".$connection->connect_errno.")".$connection->connect_error.".'); window.location='modificar autores.php'</script>";
							}
							//La variable "$query" guarda el resultado de la consulta.
							$query=mysqli_query ($connection, "SELECT * FROM autores WHERE id_autor='".$_POST["buscar_autor"]."'");
							//La variable "$nr" guarda el número de filas de la tabla del contenido de la variable "$query".
							$nr=mysqli_num_rows ($query);
							//Comprueba si el número de filas es igual a 1.
							if ($nr==1){
								//Cada vez que se ejecuta en bucle, la variable "$row" guarda un valor obtenido de la variable "$query" y se muestra en la lista.
								while ($row=mysqli_fetch_array ($query)){
									$id_autor=$row[0];
									$autor=$row[1];
								}
							}
						}
					?>
					<form action="modificar autores.php" method="POST">
						<label for="id_autor">Identificador:</label>
						<br>
						<input type="text" placeholder="Ingrese el ID" id="id_autor" name="id_autor" value="<?php echo $id_autor; ?>" readonly required/>
						<br>
						<label for="autor">Nombre y apellido del autor:</label>
						<br>
						<input type="text" placeholder="Ingrese el autor" id="autor" name="autor" pattern="^[ÁÉÍÓÚA-Z][a-záéíóú]+(\s+[ÁÉÍÓÚA-Z]?[a-záéíóú]+)*$" title="El nombre y el apellido del autor debe empezar por letra mayúscula." value="<?php echo $autor; ?>" required/>
						<br>
						<input type="submit" value="Modificar autor"/>
					</form>
					<?php
						//Comprueba si se han rellenado todos los campos del formulario mediante el método "POST".
						if (isset ($_POST["autor"])){
							//Si se han introducido todos los datos, se conecta a la base de datos.
							$connection=new mysqli ("localhost", "administrador", "Ab123456", "biblioteca");
							//Si la conexión ha dado error, muestra una alerta por pantalla y te redirecciona a "modificar autores.php".
							if ($connection->connect_errno){
								echo "<script>alert ('No hay conexión: (".$connection->connect_errno.")".$connection->connect_error.".'); window.location='modificar autores.php'</script>";
							}
							//La variable "$query" guarda el resultado de la consulta.
							$query=mysqli_query ($connection, "SELECT * FROM libros WHERE autor IN (SELECT autor FROM autores WHERE id_autor='".$_POST["id_autor"]."')");
							//La variable "$nr" guarda el número de filas de la tabla del contenido de la variable "$query".
							$nr=mysqli_num_rows ($query);
							//Comprueba si el número de filas es igual a 0.
							if ($nr==0){
								//La variable "$query" guarda el resultado de la consulta.
								$query=mysqli_query ($connection, "SELECT * FROM autores WHERE id_autor='".$_POST["id_autor"]."'");
								//Cada vez que se ejecuta en bucle, la variable "$row" guarda un valor obtenido de la variable "$query" y se muestra en la lista.
								while ($row=mysqli_fetch_array ($query)){
									$id_autor=$row[0];
									$autor=$row[1];
								}
								//La variable "$update" guarda la sentencia realizada.
								$update="UPDATE autores SET autor='".$_POST["autor"]."' WHERE id_autor='".$id_autor."'";
								//Si se conecta a la base de datos y se actualizan correctamente los datos, muestra una alerta por pantalla y te redirecciona a "autores.php".
								if (mysqli_query ($connection, $update)){
									echo "<script>alert ('Se ha modificado correctamente el autor ".$autor.".'); window.location='autores.php'</script>";
								//Si la ejecución de sentencias ha fallado, muestra una alerta por pantalla y te redirecciona a "modificar autores.php".
								}else{
									echo "<script>alert ('Ha fallado la instrucción.'); window.location='modificar autores.php'</script>";
								}
							}else{
								//La variable "$query" guarda el resultado de la consulta.
								$query=mysqli_query ($connection, "SELECT * FROM autores WHERE id_autor='".$_POST["id_autor"]."'");
								//Cada vez que se ejecuta en bucle, la variable "$row" guarda un valor obtenido de la variable "$query" y se muestra en la lista.
								while ($row=mysqli_fetch_array ($query)){
									$id_autor=$row[0];
									$autor=$row[1];
								}
								//La variable "$update" guarda la sentencia realizada.
								$update="UPDATE libros, autores SET libros.autor='".$_POST["autor"]."', autores.autor='".$_POST["autor"]."' WHERE libros.autor='".$autor."' AND autores.id_autor='".$id_autor."'";
								$foreign_key_checks="SET FOREIGN_KEY_CHECKS=0";
								mysqli_query ($connection, $foreign_key_checks);
								//Si se conecta a la base de datos y se actualizan correctamente los datos, muestra una alerta por pantalla y te redirecciona a "autores.php".
								if (mysqli_query ($connection, $update)){
									echo "<script>alert ('Se ha modificado correctamente el autor ".$autor.".'); window.location='autores.php'</script>";
								//Si la ejecución de sentencias ha fallado, muestra una alerta por pantalla y te redirecciona a "modificar categorias.php".
								}else{
									echo "<script>alert ('Ha fallado la instrucción.'); window.location='modificar categorias.php'</script>";
								}
								$foreign_key_checks="SET FOREIGN_KEY_CHECKS=1";
								mysqli_query ($connection, $foreign_key_checks);
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