<?php
	//Evita que aparezcan mensajes de error en pantalla.
	error_reporting (0);
	//Crea una sesión.
	session_start ();
	//Si ambas variables están definidas (el usuario ha iniciado sesión), te redirecciona a "index.php".
	if (isset ($_SESSION["dni_empleado"]) && isset ($_SESSION["password"]) || isset ($_SESSION["dni_lector"]) && isset ($_SESSION["password"])){
		header ("location: ../index.php");
	//Si ambas variables no están definidas (el usuario no ha iniciado sesión), muestra el contenido de "acceso.php".
	}else{
?>
		<!DOCTYPE html>
		<html lang="es">
			<head>
				<link href="../index.css" rel="stylesheet" type="text/css"/>
				<link rel="shortcut icon" href="../imagenes/logo.png"/>
				<meta charset="UTF-8"/>
				<title>Acceso | Biblioteca</title>
			</head>
			<body>
				<header>
					<div>
						<a href="../index.php">
							<img src="../imagenes/logo.png" class="logo"/>
						</a>
					</div>
					<nav>
						<ul class="navegador2">
							<li>
								<a href="../index.php">Inicio</a>
							</li>
							<li>
								<a href="./libros/libros.php">Libros</a>
							</li>
							<li>
								<a href="./lectores/registrar lectores.php">Registro</a>
							</li>
							<li>
								<a class="fijo" href="./acceso.php">Acceso</a>
							</li>
						</ul>
					</nav>
				</header>
				<main>
					<h2>Acceso empleados</h2>
					<form action="acceso.php" method="POST">
						<label for="dni_empleado">DNI:</label>
						<br>
						<input type="text" placeholder="Ingrese su DNI" id="dni_empleado" name="dni_empleado" pattern="^[0-9]{7,8}[A-Z]$" title="El DNI debe estar formado por 7 u 8 dígitos y una letra al final." required/>
						<br>
						<label for="password">Contraseña:</label>
						<br>
						<input type="password" placeholder="Ingrese su contraseña" id="password" name="password" pattern="^(?=\w*\d)(?=\w*[A-Z])(?=\w*[a-z])\S{8,16}$" title="La contraseña debe tener mínimo 8 caracteres, una letra mayúscula, una minúscula y un número." required/>
						<br>
						<input type="submit" value="Acceder"/>
					</form>
					<?php
						//Comprueba si se han rellenado todos los campos del formulario mediante el método "POST".
						if (isset ($_POST["dni_empleado"]) && isset ($_POST["password"])){
							//Si se han introducido todos los datos, se conecta a la base de datos.
							$connection=new mysqli ("localhost", "administrador", "Ab123456", "biblioteca");
							//Si la conexión ha dado error, muestra una alerta por pantalla y te redirecciona a "acceso.php".
							if ($connection->connect_errno){
								echo "<script>alert ('No hay conexión: (".$connection->connect_errno.")".$connection->connect_error.".'); window.location='acceso.php'</script>";
							}
							//Guarda en cada variable lo recogido en el formulario con el método "POST".
							$dni_empleado=$_POST["dni_empleado"];
							$password=$_POST["password"];
							//La variable "$query" guarda el resultado de la consulta.
							$query=mysqli_query ($connection, "SELECT * FROM empleados WHERE dni_empleado='".$dni_empleado."'");
							//La variable "$nr" guarda el número de filas de la tabla del contenido de la variable "$query".
							$nr=mysqli_num_rows ($query);
							//La variable "$mostrar" guarda la información de la variable "$query".
							$mostrar=mysqli_fetch_array ($query);
							//Comprueba si el número de filas es igual a 1 y si la contraseña encriptada es igual a la contraseña que se almacena la base de datos.
							if (($nr==1) && ((md5 ($password)==$mostrar["password"]))){
								//Guarda en cada variable "$_SESSION" lo que contiene las variables que guardan los datos obtenidos del formulario mediante el método "POST".
								$_SESSION["dni_empleado"]=$dni_empleado;
								$_SESSION["password"]=$password;
								//Si ambas variables están definidas (el usuario ha iniciado sesión), te redirecciona a "index.php".
								if (isset ($_SESSION["dni_empleado"]) && isset ($_SESSION["password"])){
									echo "<script>alert ('Has iniciado sesión como empleado.'); window.location='../index.php'</script>";
								}
							//Si el número de filas no es igual a 1 o la contraseña enciptada no es igual, muestra una alerta por pantalla y te redirecciona a "acceso.php".
							}else{
								echo "<script>alert ('DNI o contraseña incorrecto.'); window.location='acceso.php'</script>";
							}
							//Se cierra la conexión al servidor de MySQL.
							mysqli_close ($connection);
						}
					?>
					<h2>Acceso lectores</h2>
					<form action="acceso.php" method="POST">
						<label for="dni_lector">DNI:</label>
						<br>
						<input type="text" placeholder="Ingrese su DNI" id="dni_lector" name="dni_lector" pattern="^[0-9]{7,8}[A-Z]$" title="El DNI debe estar formado por 7 u 8 dígitos y una letra mayúscula al final." required/>
						<br>
						<label for="password">Contraseña:</label>
						<br>
						<input type="password" placeholder="Ingrese su contraseña" id="password" name="password" pattern="^(?=\w*\d)(?=\w*[A-Z])(?=\w*[a-z])\S{8,16}$" title="La contraseña debe tener entre 8 y 16 caracteres, una letra mayúscula, una minúscula y un número." required/>
						<br>
						<input type="submit" value="Acceder"/>
					</form>
					<?php
						//Comprueba si se han rellenado todos los campos del formulario mediante el método "POST".
						if (isset ($_POST["dni_lector"]) && isset ($_POST["password"])){
							//Si se han introducido todos los datos, se conecta a la base de datos.
							$connection=new mysqli ("localhost", "administrador", "Ab123456", "biblioteca");
							//Si la conexión ha dado error, muestra una alerta por pantalla y te redirecciona a "acceso.php".
							if ($connection->connect_errno){
								echo "<script>alert ('No hay conexión: (".$connection->connect_errno.")".$connection->connect_error.".'); window.location='acceso.php'</script>";
							}
							//Guarda en cada variable lo recogido en el formulario con el método "POST".
							$dni_lector=$_POST["dni_lector"];
							$password=$_POST["password"];
							//La variable "$query" guarda el resultado de la consulta.
							$query=mysqli_query ($connection, "SELECT * FROM lectores WHERE dni_lector='".$dni_lector."'");
							//La variable "$nr" guarda el número de filas de la tabla del contenido de la variable "$query".
							$nr=mysqli_num_rows ($query);
							//La variable "$mostrar" guarda la información de la variable "$query".
							$mostrar=mysqli_fetch_array ($query);
							//Comprueba si el número de filas es igual a 1 y si la contraseña encriptada es igual a la contraseña que se almacena la base de datos.
							if (($nr==1) && ((md5 ($password)==$mostrar["password"]))){
								//Guarda en cada variable "$_SESSION" lo que contiene las variables que guardan los datos obtenidos del formulario mediante el método "POST".
								$_SESSION["dni_lector"]=$dni_lector;
								$_SESSION["password"]=$password;
								//Si ambas variables están definidas (el usuario ha iniciado sesión), te redirecciona a "index.php".
								if (isset ($_SESSION["dni_lector"]) && isset ($_SESSION["password"])){
									echo "<script>alert ('Has iniciado sesión como lector.'); window.location='../index.php'</script>";
								}
							//Si el número de filas no es igual a 1 o la contraseña enciptada no es igual, muestra una alerta por pantalla y te redirecciona a "acceso.php".
							}else{
								echo "<script>alert ('DNI o contraseña incorrecto.'); window.location='acceso.php'</script>";
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
	}
?>