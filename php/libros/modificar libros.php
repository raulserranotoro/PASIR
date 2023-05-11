<?php
	//Evita que aparezcan mensajes de error en pantalla.
	error_reporting (0);
	//Crea una sesión.
	session_start ();
	//Si ambas variables están definidas (el usuario ha iniciado sesión), muestra el contenido de "modificar libros.php".
	if (isset ($_SESSION["dni_empleado"]) && isset ($_SESSION["password"])){
?>
		<!DOCTYPE html>
		<html lang="es">
			<head>
				<link href="../../index.css" rel="stylesheet" type="text/css"/>
				<link rel="shortcut icon" href="../../imagenes/logo.png"/>
				<meta charset="UTF-8"/>
				<title>Modificar libros | Biblioteca</title>
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
								<a class="fijo" href="../libros/libros.php">Libros</a>
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
					<h2>Modificar libros</h2>
					<form action="modificar libros.php" method="POST">
						<fieldset>
							<legend>¿Qué libro deseas modificar?</legend>
							<input type="text" placeholder="Buscar ISBN..." id="buscar_isbn" name="buscar_isbn" pattern="^[0-9]{13}$" title="El ISBN debe estar formado por 13 dígitos." required/>
							<button>Autorellenar datos</button>
						</fieldset>
					</form>
					<?php
						if (isset ($_POST["buscar_isbn"])){
							//Si se han introducido todos los datos, se conecta a la base de datos.
							$connection=new mysqli ("localhost", "administrador", "Ab123456", "biblioteca");
							//Si la conexión ha dado error, muestra una alerta por pantalla y te redirecciona a "modificar libros.php".
							if ($connection->connect_errno){
								echo "<script>alert ('No hay conexión: (".$connection->connect_errno.")".$connection->connect_error.".'); window.location='modificar libros.php'</script>";
							}
							//La variable "$query" guarda el resultado de la consulta.
							$query=mysqli_query ($connection, "SELECT * FROM libros WHERE isbn='".$_POST["buscar_isbn"]."'");
							//La variable "$nr" guarda el número de filas de la tabla del contenido de la variable "$query".
							$nr=mysqli_num_rows ($query);
							//Comprueba si el número de filas es igual a 1.
							if ($nr==1){
								//Cada vez que se ejecuta en bucle, la variable "$row" guarda un valor obtenido de la variable "$query" y se muestra en la lista.
								while ($row=mysqli_fetch_array ($query)){
									$isbn=$row[0];
									$titulo=$row[1];
									$fecha_lanzamiento=$row[2];
									$autor=$row[3];
									$categoria=$row[4];
									$editorial=$row[5];
									$idioma=$row[6];
									$paginas=$row[7];
									$descripcion=$row[8];
								}
							//Si la ejecución de sentencias ha fallado, muestra una alerta por pantalla y te redirecciona a "borrar libros.php".
							}else{
								echo "<script>alert ('El libro con ISBN ".$_POST["buscar_isbn"]." no existe.'); window.location='modificar libros.php'</script>";
							}
							//Se cierra la conexión al servidor de MySQL.
							mysqli_close ($connection);
						}
					?>
					<form action="modificar libros.php" method="POST">
						<label for="isbn">ISBN:</label>
						<br>
						<input type="text" placeholder="Ingrese el ISBN" id="isbn" name="isbn" value="<?php echo $isbn; ?>" readonly required/>
						<br>
						<label for="titulo">Título:</label>
						<br>
						<input type="text" placeholder="Ingrese el título" id="titulo" name="titulo" pattern="^[ÁÉÍÓÚA-Z][a-záéíóú]+(\s+[ÁÉÍÓÚA-Z]?[a-záéíóú]+)*$" title="El título debe empezar por letra mayúscula." value="<?php echo $titulo; ?>" required/>
						<br>
						<label for="fecha_lanzamiento">Fecha de lanzamiento:</label>
						<br>
						<input type="date" id="fecha_lanzamiento" name="fecha_lanzamiento" value="<?php echo $fecha_lanzamiento; ?>" required/>
						<br>
						<label for="autor">Autor:</label>
						<br>
						<select id="autor" name="autor" required>
							<option value="<?php echo $autor; ?>"><?php echo $autor; ?></option>
					<?php
						//La variable "$mysqli" guarda la conexión al servidor MySQL.
						$mysqli=mysqli_connect ("localhost", "administrador", "Ab123456", "biblioteca");
						//La variable "$query_autores" guarda el resultado de la consulta realizada.
						$query_autores=mysqli_query ($mysqli, "SELECT id_autor, autor FROM autores");
						//Cada vez que se ejecuta en bucle, la variable "$datos_autores" guarda un valor obtenido de la variable "$query_autores" y se muestra en la etiqueta "<option>" y en el atributo "value".
						while ($datos_autores=mysqli_fetch_array ($query_autores)){
					?>
							<option value="<?php echo $datos_autores["autor"]; ?>"><?php echo $datos_autores["autor"]; ?></option>
					<?php
						}
					?>
						</select>
						<br>
						<label for="categoria">Categoría:</label>
						<br>
						<select id="categoria" name="categoria" required>
							<option value="<?php echo $categoria; ?>""><?php echo $categoria; ?></option>
					<?php
						//La variable "$mysqli" guarda la conexión al servidor MySQL.
						$mysqli=mysqli_connect ("localhost", "administrador", "Ab123456", "biblioteca");
						//La variable "$query_categorias" guarda el resultado de la consulta realizada.
						$query_categorias=mysqli_query ($mysqli, "SELECT id_categoria, categoria FROM categorias");
						//Cada vez que se ejecuta en bucle, la variable "$datos_categorias" guarda un valor obtenido de la variable "$query_categorias" y se muestra en la etiqueta "<option>" y en el atributo "value".
						while ($datos_categorias=mysqli_fetch_array ($query_categorias)){
					?>
							<option value="<?php echo $datos_categorias["categoria"]; ?>"><?php echo $datos_categorias["categoria"]; ?></option>
					<?php
						}
					?>
						</select>
						<br>
						<label for="editorial">Editorial:</label>
						<br>
						<select id="editorial" name="editorial" required>
							<option value="<?php echo $editorial; ?>"><?php echo $editorial; ?></option>
					<?php
						//La variable "$mysqli" guarda la conexión al servidor MySQL.
						$mysqli=mysqli_connect ("localhost", "administrador", "Ab123456", "biblioteca");
						//La variable "$query_editoriales" guarda el resultado de la consulta realizada.
						$query_editoriales=mysqli_query ($mysqli, "SELECT id_editorial, editorial FROM editoriales");
						//Cada vez que se ejecuta en bucle, la variable "$datos_editoriales" guarda un valor obtenido de la variable "$query_editoriales" y se muestra en la etiqueta "<option>" y en el atributo "value".
						while ($datos_editoriales=mysqli_fetch_array ($query_editoriales)){
					?>
							<option value="<?php echo $datos_editoriales["editorial"]; ?>"><?php echo $datos_editoriales["editorial"]; ?></option>
					<?php
						}
					?>
						</select>
						<br>
						<label for="idioma">Idioma:</label>
						<br>
						<input type="radio" id="idioma" name="idioma" value="Español" <?php if ($idioma=="Español") print "checked=true" ?>>Español</input>
						<input type="radio" id="idioma" name="idioma" value="Inglés" <?php if ($idioma=="Inglés") print "checked=true" ?>>Inglés</input>
						<input type="radio" id="idioma" name="idioma" value="Francés" <?php if ($idioma=="Francés") print "checked=true" ?>>Francés</input>
						<input type="radio" id="idioma" name="idioma" value="Alemán" <?php if ($idioma=="Alemán") print "checked=true" ?>>Alemán</input>
						<br>
						<label for="paginas">Páginas:</label>
						<br>
						<input type="number" min="1" placeholder="Ingrese el número de páginas" id="paginas" name="paginas" value="<?php echo $paginas; ?>" required/>
						<br>
						<label for="descripcion">Descripción:</label>
						<br>
						<textarea placeholder="Ingrese la descripción" id="descripcion" name="descripcion" required><?php echo $descripcion; ?></textarea>
						<br>
						<input type="submit" value="Modificar libro"/>
					</form>
					<?php
						//Comprueba si se han rellenado todos los campos del formulario mediante el método "POST".
						if (isset ($_POST["titulo"]) && isset ($_POST["fecha_lanzamiento"]) && isset ($_POST["autor"]) && isset ($_POST["categoria"]) && isset ($_POST["editorial"]) && isset ($_POST["idioma"]) && isset ($_POST["paginas"]) && isset ($_POST["descripcion"])){
							//Si se han introducido todos los datos, se conecta a la base de datos.
							$connection=new mysqli ("localhost", "administrador", "Ab123456", "biblioteca");
							//Si la conexión ha dado error, muestra una alerta por pantalla y te redirecciona a "modificar libros.php".
							if ($connection->connect_errno){
								echo "<script>alert ('No hay conexión: (".$connection->connect_errno.")".$connection->connect_error.".'); window.location='modificar libros.php'</script>";
							}
							//Guarda en cada variable lo recogido en el formulario con el método "POST".
							$isbn=$_POST["isbn"];
							$titulo=$_POST["titulo"];
							$fecha_lanzamiento=$_POST["fecha_lanzamiento"];
							$autor=$_POST["autor"];
							$categoria=$_POST["categoria"];
							$editorial=$_POST["editorial"];
							$idioma=$_POST["idioma"];
							$paginas=$_POST["paginas"];
							$descripcion=$_POST["descripcion"];
							//La variable "$update" guarda la sentencia realizada.
							$update="UPDATE libros SET titulo='".$titulo."', fecha_lanzamiento='".$fecha_lanzamiento."', autor='".$autor."', categoria='".$categoria."', editorial='".$editorial."', idioma='".$idioma."', paginas='".$paginas."', descripcion='".$descripcion."' WHERE isbn='".$isbn."'";
							//Si se conecta a la base de datos y se actualizan correctamente los datos, muestra una alerta por pantalla y te redirecciona a "libros.php".
							if (mysqli_query ($connection, $update)){
								echo "<script>alert ('Se ha modificado correctamente el libro con ISBN ".$_POST["isbn"].".'); window.location='libros.php'</script>";
							//Si la ejecución de sentencias ha fallado, muestra una alerta por pantalla y te redirecciona a "modificar libros.php".
							}else{
								echo "<script>alert ('Ha fallado la instrucción.'); window.location='modificar libros.php'</script>";
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