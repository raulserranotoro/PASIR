<?php
	//Evita que aparezcan mensajes de error en pantalla.
	error_reporting (0);
	//Crea una sesión.
	session_start ();
	//Si ambas variables están definidas (el usuario ha iniciado sesión), muestra el contenido de "datos empleados.php".
	if (isset ($_SESSION["dni_empleado"]) && isset ($_SESSION["password"])){
?>
		<!DOCTYPE html>
		<html lang="es">
			<head>
				<link href="../../index.css" rel="stylesheet" type="text/css"/>
				<link rel="shortcut icon" href="../../imagenes/logo.png"/>
				<meta charset="UTF-8"/>
				<title>Datos del empleado | Biblioteca</title>
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
								<a href="../lectores/lectores.php">Lectores</a>
							</li>
							<li>
								<a class="fijo" href="../empleados/datos empleados.php">Empleado</a>
							</li>
						</ul>
					</nav>
				</header>
				<main>
                    <h2>Datos del empleado</h2>
					<?php
						//Si se han introducido todos los datos, se conecta a la base de datos.
						$connection=new mysqli ("localhost", "administrador", "Ab123456", "biblioteca");
						//Si la conexión ha dado error, muestra una alerta por pantalla y te redirecciona a "datos empleados.php".
						if ($connection->connect_errno){
							echo "<script>alert ('No hay conexión: (".$connection->connect_errno.")".$connection->connect_error.".'); window.location='datos empleados.php'</script>";
						}
						//La variable "$query" guarda el resultado de la consulta realizada.
						$query=mysqli_query ($connection, "SELECT * FROM empleados WHERE dni_empleado='".$_SESSION["dni_empleado"]."'");
						echo "<ul class='datos'>";
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
							echo "<li type='square'><b>DNI:</b> ".$dni_lector."</li>";
							echo "<br>";
							echo "<li type='square'><b>Nombre:</b> ".$nombre."</li>";
							echo "<br>";
							echo "<li type='square'><b>Apellidos:</b> ".$apellidos."</li>";
							echo "<br>";
							echo "<li type='square'><b>Teléfono:</b> ".$telefono."</li>";
							echo "<br>";
							echo "<li type='square'><b>Dirección:</b> ".$direccion."</li>";
							echo "<br>";
							echo "<li type='square'><b>Código postal:</b> ".$codigo_postal."</li>";
							echo "<br>";
							echo "<li type='square'><b>Municipio:</b> ".$municipio."</li>";
							echo "<br>";
							echo "<li type='square'><b>Provincia:</b> ".$provincia."</li>";
							echo "<br>";
							echo "<li type='square'><b>Email:</b> ".$email."</li>";
							echo "<br>";
							echo "<li type='square'><b>Fecha de nacimiento:</b> ".$fecha_nacimiento."</li>";
							echo "<br>";
							echo "<li type='square'><b>Fecha de alta:</b> ".$fecha_alta."</li>";
						}
						echo "</ul>";
						//Se cierra la conexión al servidor de MySQL.
						mysqli_close ($connection);
					?>
					<a class="boton" href="../cerrar sesion.php">Cerrar sesión</a>
					<h2>Otras opciones</h2>
					<button class="accordion">Modificar datos</button>
					<div class="panel">
						<form action="datos empleados.php" method="POST">
							<label for="dni_lector">DNI:</label>
							<br>
							<input type="text" id="dni_lector" name="dni_lector" value="<?php echo $dni_lector; ?>" readonly required/>
							<br>
							<label for="nombre">Nombre:</label>
							<br>
							<input type="text" id="nombre" name="nombre" value="<?php echo $nombre; ?>" readonly required/>
							<br>
							<label for="apellidos">Apellidos:</label>
							<br>
							<input type="text" id="apellidos" name="apellidos" value="<?php echo $apellidos; ?>" readonly required/>
							<br>
							<label for="telefono">Teléfono:</label>
							<br>
							<input type="number" min="1" placeholder="Ingrese su teléfono" id="telefono" name="telefono" pattern="^[0-9]{9}$" title="El teléfono debe tener 9 dígitos." value="<?php echo $telefono; ?>" required/>
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
							<input type="email" placeholder="Ingrese su email" id="email" name="email" pattern="^[a-z0-9._%+-]+@[a-z0-9-]+.+.[a-z]{2,4}$" title="El correo electrónico no cumple con los requisitos." value="<?php echo $email; ?>" required/>
							<br>
							<label for="fecha_nacimiento">Fecha de nacimiento:</label>
							<br>
							<input type="date" id="fecha_nacimiento" name="fecha_nacimiento" value="<?php echo $fecha_nacimiento; ?>" readonly required/>
							<br>
							<input type="submit" value="Modificar datos"/>
						</form>
						<?php
							//Comprueba si se han rellenado todos los campos del formulario mediante el método "POST".
							if (isset ($_POST["telefono"]) && isset ($_POST["direccion"]) && isset ($_POST["codigo_postal"]) && isset ($_POST["municipio"]) && isset ($_POST["provincia"]) && isset ($_POST["email"])){
								//Si se han introducido todos los datos, se conecta a la base de datos.
								$connection=new mysqli ("localhost", "administrador", "Ab123456", "biblioteca");
								//Si la conexión ha dado error, muestra una alerta por pantalla y te redirecciona a "datos empleados.php".
								if ($connection->connect_errno){
									echo "<script>alert ('No hay conexión: (".$connection->connect_errno.")".$connection->connect_error.".'); window.location='datos empleados.php'</script>";
								}
								//Guarda en cada variable lo recogido en el formulario con el método "POST".
								$telefono=$_POST["telefono"];
								$direccion=$_POST["direccion"];
								$codigo_postal=$_POST["codigo_postal"];
								$municipio=$_POST["municipio"];
								$provincia=$_POST["provincia"];
								$email=$_POST["email"];
								//La variable "$update" guarda la sentencia realizada.
								$update="UPDATE empleados SET telefono='".$telefono."', direccion='".$direccion."', codigo_postal='".$codigo_postal."', municipio='".$municipio."', provincia='".$provincia."', email='".$email."' WHERE dni_empleado='".$_SESSION["dni_empleado"]."'";
								//Si se conecta a la base de datos y se actualizan correctamente los datos, muestra una alerta por pantalla y te redirecciona a "datos empleados.php".
								if (mysqli_query ($connection, $update)){
									echo "<script>alert ('Se han modificado correctamente los datos.'); window.location='datos empleados.php'</script>";
								//Si la ejecución de sentencias ha fallado, muestra una alerta por pantalla y te redirecciona a "datos empleados.php".
								}else{
									echo "<script>alert ('Ha fallado la instrucción.'); window.location='datos empleados.php'</script>";
								}
								//Se cierra la conexión al servidor de MySQL.
								mysqli_close ($connection);
							}
						?>
					</div>
					<button class="accordion">Modificar contraseña</button>
					<div class="panel">
						<form action="datos empleados.php" method="POST">
							<label for="password_actual">Contraseña actual:</label>
							<br>
							<input type="password" placeholder="Ingrese su contraseña" id="password_actual" name="password_actual" pattern="^[A-Za-z0-9]{8,}$" title="La contraseña debe tener mínimo 8 caracteres, una letra mayúscula, una minúscula y un número." required/>
							<br>
							<label for="password_nueva">Contraseña nueva:</label>
							<br>
							<input type="password" placeholder="Ingrese su contraseña" id="password_nueva" name="password_nueva" pattern="^[A-Za-z0-9]{8,}$" title="La contraseña debe tener mínimo 8 caracteres, una letra mayúscula, una minúscula y un número." required/>
							<br>
							<input type="submit" value="Modificar contraseña"/>
						</form>
						<?php
							//Comprueba si se han rellenado todos los campos del formulario mediante el método "POST".
							if (isset ($_POST["password_actual"]) && isset ($_POST["password_nueva"])){
								//Si se han introducido todos los datos, se conecta a la base de datos.
								$connection=new mysqli ("localhost", "administrador", "Ab123456", "biblioteca");
								//Si la conexión ha dado error, muestra una alerta por pantalla y te redirecciona a "datos empleados.php".
								if ($connection->connect_errno){
									echo "No hay conexión: (".$connection->connect_errno.")".$connection->connect_error;
								}
								//Guarda en cada variable lo recogido en el formulario con el método "POST".
								$password_actual=$_POST["password_actual"];
								$password_nueva=$_POST["password_nueva"];
								//Guarda en la variable "$pass_fuerte" la contraseña nueva encriptada.
								$pass_fuerte=md5 ($password_nueva);
								//La variable "$query" guarda el resultado de la consulta.
								$query=mysqli_query ($connection, "SELECT * FROM empleados WHERE dni_empleado='".$_SESSION["dni_empleado"]."'");
								//La variable "$nr" guarda el número de filas de la tabla del contenido de la variable "$query".
								$nr=mysqli_num_rows ($query);
								//La variable "$mostrar" guarda la información de la variable "$query".
								$mostrar=mysqli_fetch_array ($query);
								//Si el contenido de la variable "$password_actual" es igual al contenido de la variable "$password_nueva" muestra una alerta por pantalla y te redirecciona a "datos empleados.php".
								if ($password_actual==$password_nueva){
									echo "<script>alert ('La nueva contraseña no puede ser igual que la anterior.'); window.location='datos empleados.php'</script>";
								}else{
									//Comprueba si el número de filas es igual a 1 y si la contraseña encriptada es igual a la contraseña que se almacena la base de datos.
									if (($nr==1) && (md5 ($password_actual)==$mostrar["password"])){
										//La variable "$update" guarda la sentencia realizada.
										$update="UPDATE empleados SET password='".$pass_fuerte."' WHERE dni_empleado='".$_SESSION["dni_empleado"]."'";
										//Si se conecta a la base de datos y se insertan correctamente los datos, muestra una alerta por pantalla.
										if (mysqli_query ($connection, $update)){
											echo "<script>alert ('Se han modificado correctamente los datos.'); window.location='datos empleados.php'</script>";
										//Si la ejecución de sentencias ha fallado, muestra una alerta por pantalla y te redirecciona a "datos empleados.php".
										}else{
											echo "<script>alert ('Ha fallado la instrucción.'); window.location='datos empleados.php'</script>";
										}
									//Si el número de filas no es igual a 1 o la contraseña enciptada no es igual, muestra una alerta por pantalla y te redirecciona a "datos empleados.php".
									}else{
										echo "<script>alert ('No se ha podido cambiar la contraseña.'); window.location='datos empleados.php'</script>";
									}
								}
								//Se cierra la conexión al servidor de MySQL.
								mysqli_close ($connection);
							}
						?>
					</div>
					<script>
						//Para desplegar las etiquetas "<button>" con el atributo "accordion".
						var acc=document.getElementsByClassName ("accordion");
						var i;
						for (i=0; i<acc.length; i++){
							acc[i].addEventListener ("click", function (){
								this.classList.toggle ("active");
								var panel=this.nextElementSibling;
								if (panel.style.maxHeight){
									panel.style.maxHeight=null;
								}else{
									panel.style.maxHeight=panel.scrollHeight+"px";
								}
							});
						}
					</script>
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
		echo "<script>alert ('Debes iniciar sesión para poder acceder.'); window.location='../index.php'</script>";
	}
?>