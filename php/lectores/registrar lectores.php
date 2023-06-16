<?php
	//Evita que aparezcan mensajes de error en pantalla.
	error_reporting (0);
	//Crea una sesión.
	session_start ();
	//Si ambas variables están definidas (el usuario ha iniciado sesión), te redirecciona a "index.php".
	if (isset ($_SESSION["dni_lector"]) && isset ($_SESSION["password"]) || isset ($_SESSION["dni_empleado"]) && isset ($_SESSION["password"])){
		header ("location: ../../index.php");
	}else{
?>
		<!DOCTYPE html>
		<html lang="es">
			<head>
				<link href="../../index.css" rel="stylesheet" type="text/css"/>
				<link rel="shortcut icon" href="../../imagenes/logo.png"/>
				<meta charset="UTF-8"/>
				<title>Registro lector | Biblioteca</title>
			</head>
			<body>
				<header>
					<div>
						<a href="../../index.php">
							<img src="../../imagenes/logo.png" class="logo"/>
						</a>
					</div>
					<nav>
						<ul class="navegador2">
							<li>
								<a href="../../index.php">Inicio</a>
							</li>
							<li>
								<a href="../libros/libros.php">Libros</a>
							</li>
							<li>
								<a class="fijo" href="../lectores/registrar lectores.php">Registro</a>
							</li>
							<li>
								<a href="../acceso.php">Acceso</a>
							</li>
						</ul>
					</nav>
				</header>
				<main>
					<h2>Registro lector</h2>
					<form action="registrar lectores.php" method="POST">
						<label for="dni_lector">DNI:</label>
						<br>
						<input type="text" placeholder="Ingrese su DNI" id="dni_lector" name="dni_lector" pattern="^[0-9]{7,8}[A-Z]$" title="El DNI debe estar formado por 7 u 8 dígitos y una letra al final." required/>
						<br>
						<label for="nombre">Nombre:</label>
						<br>
						<input type="text" placeholder="Ingrese su nombre" id="nombre" name="nombre" pattern="^[ÁÉÍÓÚA-Z][a-záéíóú]+(\s+[ÁÉÍÓÚA-Z]?[a-záéíóú]+)*$" title="El nombre debe empezar por letra mayúscula." required/>
						<br>
						<label for="apellidos">Apellidos:</label>
						<br>
						<input type="text" placeholder="Ingrese sus apellidos" id="apellidos" name="apellidos" pattern="^[ÁÉÍÓÚA-Z][a-záéíóú]+(\s+[ÁÉÍÓÚA-Z]?[a-záéíóú]+)*$" title="Los apellidos deben empezar por letra mayúscula." required/>
						<br>
						<label for="telefono">Teléfono:</label>
						<br>
						<input type="text" placeholder="Ingrese su teléfono" id="telefono" name="telefono" pattern="^[0-9]{9}$" title="El teléfono debe tener 9 dígitos." required/>
						<br>
						<label for="direccion">Dirección:</label>
						<br>
						<input type="text" placeholder="Ingrese su dirección" id="direccion" name="direccion" required/>
						<br>
						<label for="codigo_postal">Código postal:</label>
						<br>
						<input type="text" placeholder="Ingrese su código postal" id="codigo_postal" name="codigo_postal" pattern="^[0-9]{5}$" title="El código postal debe tener 5 dígitos." required/>
						<br>
						<label for="municipio">Municipio:</label>
						<br>
						<input type="text" placeholder="Ingrese su municipio" id="municipio" name="municipio" pattern="^[ÁÉÍÓÚA-Z][a-záéíóú]+(\s+[ÁÉÍÓÚA-Z]?[a-záéíóú]+)*$" title="El nombre del municipio debe empezar por letra mayúscula." required/>
						<br>
						<label for="provincia">Provincia:</label>
						<br>
						<input type="text" placeholder="Ingrese su provincia" id="provincia" name="provincia" pattern="^[ÁÉÍÓÚA-Z][a-záéíóú]+(\s+[ÁÉÍÓÚA-Z]?[a-záéíóú]+)*$" title="El nombre de la provincia debe empezar por letra mayúscula." required/>
						<br>
						<label for="email">Email:</label>
						<br>
						<input type="email" placeholder="Ingrese su email" id="email" name="email" pattern="^[a-z0-9._%+-]+@[a-z0-9-]+.+.[a-z]{2,4}$" title="El correo electrónico no cumple con los requisitos."/>
						<br>
						<label for="fecha_nacimiento">Fecha de nacimiento:</label>
						<br>
						<input type="date" id="fecha_nacimiento" name="fecha_nacimiento" required/>
						<br>
						<label for="observaciones">Observaciones:</label>
						<br>
						<textarea cols="50" rows="10" placeholder="Ingrese las observaciones" id="observaciones" name="observaciones"></textarea>
						<br>
						<label for="password">Contraseña:</label>
						<br>
						<input type="password" placeholder="Ingrese su contraseña" id="password" name="password" pattern="^(?=\w*\d)(?=\w*[A-Z])(?=\w*[a-z])\S{8,16}$" title="La contraseña debe tener entre 8 y 16 caracteres, una letra mayúscula, una minúscula y un número." required/>
						<br>
						<input type="submit" value="Registrarse"/>
					</form>
					<?php
						//Comprueba si se han rellenado todos los campos del formulario mediante el método "POST".
						if (isset ($_POST["dni_lector"]) && isset ($_POST["nombre"]) && isset ($_POST["apellidos"]) && isset ($_POST["telefono"]) && isset ($_POST["direccion"]) && isset ($_POST["codigo_postal"]) && isset ($_POST["municipio"]) && isset ($_POST["provincia"]) && isset ($_POST["email"]) && isset ($_POST["fecha_nacimiento"]) && isset ($_POST["observaciones"]) && isset ($_POST["password"])){
							//Si se han introducido todos los datos, se conecta a la base de datos.
							$connection=new mysqli ("localhost", "administrador", "Ab123456", "biblioteca");
							//Si la conexión ha dado error, muestra una alerta por pantalla y te redirecciona a "registrar lectores.php".
							if ($connection->connect_errno){
								echo "<script>alert ('No hay conexión: (".$connection->connect_errno.")".$connection->connect_error.".'); window.location='registrar lectores.php'</script>";
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
							$fecha_alta=date ("Y-m-d");
							$observaciones=$_POST["observaciones"];
							$password=$_POST["password"];
							//La variable "$query" guarda el resultado de la consulta.
							$query=mysqli_query ($connection, "SELECT * FROM lectores WHERE dni_lector='".$dni_lector."'");
							//Se guarda en la variable "$query_password" el valor de la contraseña.
							while ($row=mysqli_fetch_array ($query)){
								$query_password=$row[12];
							}
							//La variable "$nr" guarda el número de filas de la tabla del contenido de la variable "$query".
							$nr=mysqli_num_rows ($query);
							//Comprueba si el número de filas es igual a 0.
							if ($nr==0){
								//La variable "$pass_fuerte" guarda el hash encriptado de la contraseña introducida.
								$pass_fuerte=md5 ($password);
								//La variable "$query_registrar" guarda la sentencia "INSERT" que añade datos a la tabla.
								$query_registrar="INSERT INTO lectores (dni_lector, nombre, apellidos, telefono, direccion, codigo_postal, municipio, provincia, email, fecha_nacimiento, fecha_alta, observaciones, password) VALUES ('".$dni_lector."', '".$nombre."', '".$apellidos."', '".$telefono."', '".$direccion."', '".$codigo_postal."', '".$municipio."', '".$provincia."', '".$email."', '".$fecha_nacimiento."', '".$fecha_alta."', '".$observaciones."', '".$pass_fuerte."')";
								//Si se conecta a la base de datos y se insertan correctamente los datos, se inicia la sesión, muestra una alerta por pantalla y te redirecciona a "index.php".
								if (mysqli_query ($connection, $query_registrar)){
									//Guarda en cada variable "$_SESSION" lo que contiene las variables que guardan los datos obtenidos del formulario mediante el método "POST".
									$_SESSION["dni_lector"]=$dni_lector;
									$_SESSION["password"]=$password;
									//Si ambas variables están definidas (el usuario ha iniciado sesión), te redirecciona a "index.php".
									if (isset ($_SESSION["dni_lector"]) && isset ($_SESSION["password"])){
										echo "<script>alert ('El lector con DNI ".$dni_lector." ha sido registrado y se ha iniciado la sesión.'); window.location='../index.php'</script>";
									}
								//Si la ejecución de sentencias ha fallado, muestra una alerta por pantalla y te redirecciona a "registrar lectores.php".
								}else{
									echo "<script>alert ('Error: ".$query_registrar."<br>".mysqli_error ($connection).".'); window.location='registrar lectores.php'</script>";
								}
							//Si el usuario ya está insertado en la tabla y no tiene contraseña, se modifica su contenido.
							}elseif ($nr==1 && $query_password==NULL){
								//La variable "$pass_fuerte" guarda el hash encriptado de la contraseña introducida.
								$pass_fuerte=md5 ($password);
								//La variable "$query_registrar" guarda la sentencia "INSERT" que añade datos a la tabla.
								$query_registrar="UPDATE lectores SET dni_lector='".$dni_lector."', nombre='".$nombre."', apellidos='".$apellidos."', telefono='".$telefono."', direccion='".$direccion."', codigo_postal='".$codigo_postal."', municipio='".$municipio."', provincia='".$provincia."', email='".$email."', fecha_nacimiento='".$fecha_nacimiento."', fecha_alta='".$fecha_alta."', observaciones='".$observaciones."', password='".$pass_fuerte."' WHERE dni_lector='".$dni_lector."'";
								//Si se conecta a la base de datos y se insertan correctamente los datos, se inicia la sesión, muestra una alerta por pantalla y te redirecciona a "index.php".
								if (mysqli_query ($connection, $query_registrar)){
									//Guarda en cada variable "$_SESSION" lo que contiene las variables que guardan los datos obtenidos del formulario mediante el método "POST".
									$_SESSION["dni_lector"]=$dni_lector;
									$_SESSION["password"]=$password;
									//Si ambas variables están definidas (el usuario ha iniciado sesión), te redirecciona a "index.php".
									if (isset ($_SESSION["dni_lector"]) && isset ($_SESSION["password"])){
										echo "<script>alert ('El lector con DNI ".$dni_lector." ha sido registrado y se ha iniciado la sesión.'); window.location='../index.php'</script>";
									}
								//Si la ejecución de sentencias ha fallado, muestra una alerta por pantalla y te redirecciona a "registrar lectores.php".
								}else{
									echo "<script>alert ('Error: ".$query_registrar."<br>".mysqli_error ($connection).".'); window.location='registrar lectores.php'</script>";
								}
							//Si el número de filas no es igual a 0 muestra una alerta por pantalla y te redirecciona a "registrar lectores.php".
							}else{
								echo "<script>alert ('No puedes registrar al usuario.'); window.location='registrar lectores.php'</script>";
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