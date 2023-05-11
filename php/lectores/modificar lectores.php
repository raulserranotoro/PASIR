<?php
	//Evita que aparezcan mensajes de error en pantalla.
	error_reporting (0);
	//Crea una sesión.
	session_start ();
	//Si ambas variables están definidas (el usuario ha iniciado sesión), muestra el contenido de "modificar lectores.php".
	if (isset ($_SESSION["dni_empleado"]) && isset ($_SESSION["password"])){
?>
		<!DOCTYPE html>
		<html lang="es">
			<head>
				<link href="../../index.css" rel="stylesheet" type="text/css"/>
				<link rel="shortcut icon" href="../../imagenes/logo.png"/>
				<meta charset="UTF-8"/>
				<title>Modificar lectores | Biblioteca</title>
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
								<a href="../alquileres/alquileres.php">Alquileres</a>
							</li>
							<li>
								<a class="fijo" href="../lectores/lectores.php">Lectores</a>
							</li>
							<li>
								<a href="../empleados/datos empleados.php">Empleado</a>
							</li>
						</ul>
					</nav>
				</header>
				<main>
					<h2>Modificar lectores</h2>
					<form action="modificar lectores.php" method="POST">
						<fieldset>
							<legend>¿Qué lector deseas modificar?</legend>
							<input type="text" placeholder="Buscar DNI..." id="buscar_dni" name="buscar_dni" pattern="^[0-9]{7,8}[A-Z]$" title="El DNI debe estar formado por 7 u 8 dígitos y una letra al final." required/>
							<button>Autorellenar datos</button>
						</fieldset>
					</form>
					<?php
						if (isset ($_POST["buscar_dni"])){
							//Si se han introducido todos los datos, se conecta a la base de datos.
							$connection=new mysqli ("localhost", "administrador", "Ab123456", "biblioteca");
							//Si la conexión ha dado error, muestra una alerta por pantalla y te redirecciona a "modificar lectores.php".
							if ($connection->connect_errno){
								echo "<script>alert ('No hay conexión: (".$connection->connect_errno.")".$connection->connect_error.".'); window.location='modificar lectores.php'</script>";
							}
							//La variable "$query" guarda el resultado de la consulta.
							$query=mysqli_query ($connection, "SELECT * FROM lectores WHERE dni_lector='".$_POST["buscar_dni"]."'");
							//La variable "$nr" guarda el número de filas de la tabla del contenido de la variable "$query".
							$nr=mysqli_num_rows ($query);
							//Comprueba si el número de filas es igual a 1.
							if ($nr==1){
								//Cada vez que se ejecuta en bucle, la variable "$row" guarda un valor obtenido de la variable "$query" y se muestra en la lista.
								while ($row=mysqli_fetch_array ($query)){
									$dni_lector=$row[0];
									$nombre=$row[1];
									$apellidos=$row[2];
									$telefono=$row[3];
									$direccion=$row[4];
									$codigo_postal=$row[5];
									$municipio=$row[6];
									$provincia=$row[7];
									$email=$row[8];
									$fecha_nacimiento=$row[9];
									$fecha_alta=$row[10];
									$observaciones=$row[11];
								}
							//Si la ejecución de sentencias ha fallado, muestra una alerta por pantalla y te redirecciona a "modificar lectores.php".
							}else{
								echo "<script>alert ('El lector con DNI ".$_POST["buscar_dni"]." no existe.'); window.location='modificar lectores.php'</script>";
							}
							//Se cierra la conexión al servidor de MySQL.
							mysqli_close ($connection);
						}
					?>
					<form action="modificar lectores.php" method="POST">
						<label for="dni_lector">DNI:</label>
						<br>
						<input type="text" placeholder="Ingrese su DNI" id="dni_lector" name="dni_lector" value="<?php echo $dni_lector; ?>" readonly required/>
						<br>
						<label for="nombre">Nombre:</label>
						<br>
						<input type="text" placeholder="Ingrese su nombre" id="nombre" name="nombre" value="<?php echo $nombre; ?>" readonly required/>
						<br>
						<label for="apellidos">Apellidos:</label>
						<br>
						<input type="text" placeholder="Ingrese sus apellidos" id="apellidos" name="apellidos" value="<?php echo $apellidos; ?>" readonly required/>
						<br>
						<label for="telefono">Teléfono:</label>
						<br>
						<input type="text" placeholder="Ingrese su teléfono" id="telefono" name="telefono" pattern="^[0-9]{9}$" title="El teléfono debe tener 9 dígitos." value="<?php echo $telefono; ?>" required/>
						<br>
						<label for="direccion">Dirección:</label>
						<br>
						<input type="text" placeholder="Ingrese su dirección" id="direccion" name="direccion" value="<?php echo $direccion; ?>" required/>
						<br>
						<label for="codigo_postal">Código postal:</label>
						<br>
						<input type="number" min="1" placeholder="Ingrese su código postal" id="codigo_postal" name="codigo_postal" pattern="^[0-9]{5}$" title="El código postal debe tener 5 dígitos." value="<?php echo $codigo_postal; ?>" required/>
						<br>
						<label for="municipio">Municipio:</label>
						<br>
						<input type="text" placeholder="Ingrese su municipio" id="municipio" name="municipio" pattern="^[ÁÉÍÓÚA-Z][a-záéíóú]+(\s+[ÁÉÍÓÚA-Z]?[a-záéíóú]+)*$" title="El nombre del municipio debe empezar por letra mayúscula." value="<?php echo $municipio; ?>" required/>
						<br>
						<label for="provincia">Provincia:</label>
						<br>
						<input type="text" placeholder="Ingrese su provincia" id="provincia" name="provincia" pattern="^[ÁÉÍÓÚA-Z][a-záéíóú]+(\s+[ÁÉÍÓÚA-Z]?[a-záéíóú]+)*$" title="El nombre de la provincia debe empezar por letra mayúscula." value="<?php echo $provincia; ?>" required/>
						<br>
						<label for="email">Email:</label>
						<br>
						<input type="text" placeholder="Ingrese su email" id="email" name="email" pattern="^[a-z0-9._%+-]+@[a-z0-9-]+.+.[a-z]{2,4}$" title="El correo electrónico no cumple con los requisitos." value="<?php echo $email; ?>" required/>
						<br>
						<label for="fecha_nacimiento">Fecha de nacimiento:</label>
						<br>
						<input type="date" id="fecha_nacimiento" name="fecha_nacimiento" value="<?php echo $fecha_nacimiento; ?>" readonly required/>
						<br>
						<label for="observaciones">Observaciones:</label>
						<br>
						<textarea placeholder="Ingrese las observaciones" id="observaciones" name="observaciones"><?php echo $observaciones; ?></textarea>
						<br>
						<input type="submit" value="Modificar lector"/>
					</form>
					<?php
						//Comprueba si se han rellenado todos los campos del formulario mediante el método "POST".
						if (isset ($_POST["telefono"]) && isset ($_POST["direccion"]) && isset ($_POST["codigo_postal"]) && isset ($_POST["municipio"]) && isset ($_POST["provincia"]) && isset ($_POST["email"]) && isset ($_POST["observaciones"])){
							//Si se han introducido todos los datos, se conecta a la base de datos.
							$connection=new mysqli ("localhost", "administrador", "Ab123456", "biblioteca");
							//Si la conexión ha dado error, muestra una alerta por pantalla y te redirecciona a "modificar lectores.php".
							if ($connection->connect_errno){
								echo "<script>alert ('No hay conexión: (".$connection->connect_errno.")".$connection->connect_error.".'); window.location='modificar alquileres.php'</script>";
							}
							//Guarda en cada variable lo recogido en el formulario con el método "POST".
							$dni_lector=$_POST["dni_lector"];
							$nombre=$_POST["nombre"];
							$apellidos=$_POST["apellidos"];
							$telefono=$_POST["telefono"];
							$direccion=$_POST["direccion"];
							$codigo_postal=$_POST["codigo_postal"];
							$municipio=$_POST["municipio"];
							$provincia=$_POST["provincia"];
							$email=$_POST["email"];
							$fecha_nacimiento=$_POST["fecha_nacimiento"];
							$observaciones=$_POST["observaciones"];
							//La variable "$update" guarda la sentencia realizada.
							$update="UPDATE lectores SET telefono='".$telefono."', direccion='".$direccion."', codigo_postal='".$codigo_postal."', municipio='".$municipio."', provincia='".$provincia."', email='".$email."', observaciones='".$observaciones."' WHERE dni_lector='".$dni_lector."'";
							//Si se conecta a la base de datos y se actualizan correctamente los datos, muestra una alerta por pantalla y te redirecciona a "lectores.php".
							if (mysqli_query ($connection, $update)){
								echo "<script>alert ('Se ha modificado correctamente al lector ".$nombre." ".$apellidos.".'); window.location='lectores.php'</script>";
							//Si la ejecución de sentencias ha fallado, muestra una alerta por pantalla y te redirecciona a "modificar lectores.php".
							}else{
								echo "<script>alert ('Ha fallado la instrucción.'); window.location='modificar lectores.php'</script>";
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