<?php
	//Evita que aparezcan mensajes de error en pantalla.
	error_reporting (0);
	//Crea una sesión.
	session_start ();
	//Si ambas variables están definidas (el usuario ha iniciado sesión), muestra el contenido de "borrar lectores.php".
	if (isset ($_SESSION["dni_empleado"]) && isset ($_SESSION["password"])){
?>
		<!DOCTYPE html>
		<html lang="es">
			<head>
				<link href="../../index.css" rel="stylesheet" type="text/css"/>
				<link rel="shortcut icon" href="../../imagenes/logo.png"/>
				<meta charset="UTF-8"/>
				<title>Borrar lectores | Biblioteca</title>
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
					<h2>Borrar lectores</h2>
					<form action="borrar lectores.php" method="POST">
						<label for="dni_lector">DNI:</label>
						<br>
						<input type="text" placeholder="Ingrese su DNI" id="dni_lector" name="dni_lector" pattern="^[0-9]{7,8}[A-Z]$" title="El DNI debe estar formado por 7 u 8 dígitos y una letra al final." required/>
						<br>
						<input type="submit" value="Borrar lector" onclick="return confirmacion ()"/>
					</form>
					<script type="text/javascript">
						function confirmacion (){
							var respuesta=confirm ("Se borrarán todos sus alquileres que están asociados a su DNI. ¿Estás seguro de que deseas eliminar al lector?");
							if (respuesta==true){
								return true;
							}else{
								return false;
							}
						}
					</script>
					<?php
						//Comprueba si se han rellenado todos los campos del formulario mediante el método "POST".
						if (isset ($_POST["dni_lector"])){
							//Si se han introducido todos los datos, se conecta a la base de datos.
							$connection=new mysqli ("localhost", "administrador", "Ab123456", "biblioteca");
							//Si la conexión ha dado error, muestra una alerta por pantalla y te redirecciona a "borrar lectores.php".
							if ($connection->connect_errno){
								echo "<script>alert ('No hay conexión: (".$connection->connect_errno.")".$connection->connect_error.".'); window.location='borrar lectores.php'</script>";
							}
							//Guarda en cada variable lo recogido en el formulario con el método "POST".
							$dni_lector=$_POST["dni_lector"];
							//La variable "$query" guarda el resultado de la consulta.
							$query=mysqli_query ($connection, "SELECT * FROM lectores WHERE dni_lector='".$dni_lector."'");
							//La variable "$nr" guarda el número de filas de la tabla del contenido de la variable "$query".
							$nr=mysqli_num_rows ($query);
							//Comprueba si el número de filas es igual a 1.
							if ($nr==1){
								//La variable "$query" guarda el resultado de la consulta.
								$query=mysqli_query ($connection, "SELECT * FROM alquileres WHERE dni_lector='".$dni_lector."'");
								//La variable "$nr" guarda el número de filas de la tabla del contenido de la variable "$query".
								$nr=mysqli_num_rows ($query);
								//Comprueba si el número de filas es igual a 0.
								if ($nr==0){
									//La variable "$delete" guarda la sentencia realizada.
									$delete="DELETE FROM lectores WHERE dni_lector='".$dni_lector."'";
									//Si se conecta a la base de datos y se borran correctamente los datos, muestra una alerta por pantalla y te redirecciona a "lectores.php".
									if (mysqli_query ($connection, $delete)){
										echo "<script>alert ('Se ha borrado correctamente al lector con DNI ".$dni_lector.".'); window.location='lectores.php'</script>";
									//Si la ejecución de sentencias ha fallado, muestra una alerta por pantalla y te redirecciona a "borrar lectores.php".
									}else{
										echo "<script>alert ('Ha fallado la instrucción.'); window.location='borrar lectores.php'</script>";
									}
								//Si el número de filas no es igual a 0, muestra una alerta por pantalla y te redirecciona a "borrar lectores lectores.php".
								}else{
									echo "<script>alert ('No se puede borrar al lector debido a que tiene alquileres de libros.'); window.location='borrar lectores.php'</script>";
								}
							//Si la ejecución de sentencias ha fallado, muestra una alerta por pantalla y te redirecciona a "borrar lectores.php".
							}else{
								echo "<script>alert ('El lector con DNI ".$dni_lector." no existe.'); window.location='borrar lectores.php'</script>";
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