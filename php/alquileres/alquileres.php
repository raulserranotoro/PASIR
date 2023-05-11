<?php
	//Evita que aparezcan mensajes de error en pantalla.
	error_reporting (0);
	//Crea una sesión.
	session_start ();
	//Si ambas variables están definidas (el usuario ha iniciado sesión), muestra el contenido de "alquileres.php".
	if (isset ($_SESSION["dni_empleado"]) && isset ($_SESSION["password"]) || isset ($_SESSION["dni_lector"]) && isset ($_SESSION["password"])){
?>
		<!DOCTYPE html>
		<html lang="es">
			<head>
				<link href="../../index.css" rel="stylesheet" type="text/css"/>
				<link rel="shortcut icon" href="../../imagenes/logo.png"/>
				<meta charset="UTF-8"/>
				<title>Alquileres | Biblioteca</title>
			</head>
			<body>
				<header>
					<div>
						<a href="../../index.php">
							<img src="../../imagenes/logo.png" class="logo"/>
						</a>
					</div>
			<?php
				//Si ambas variables están definidas (el usuario ha iniciado sesión), muestra el "navegador1".
				if (isset ($_SESSION["dni_empleado"]) && isset ($_SESSION["password"])){
			?>
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
			<?php
				//Si ambas variables están definidas (el usuario ha iniciado sesión), muestra el "navegador2".
				}elseif (isset ($_SESSION["dni_lector"]) && isset ($_SESSION["password"])){
			?>
					<nav>
						<ul class="navegador2">
							<li>
								<a href="../../index.php">Inicio</a>
							</li>
							<li>
								<a href="../libros/libros.php">Libros</a>
							</li>
							<li>
								<a class="fijo" href="../alquileres/alquileres.php">Alquileres</a>
							</li>
							<li>
								<a href="../lectores/datos lectores.php">Lector</a>
							</li>
						</ul>
					</nav>
			<?php
				}
			?>
				</header>
				<main>
			<?php
				//Si el empleado ha iniciado sesión, muestra un buscador distinto.
				if (isset ($_SESSION["dni_empleado"]) && isset ($_SESSION["password"])){
			?>
					<input type="text" placeholder="Buscar por DNI..." id="buscador" name="buscador" onkeyup="buscador ()"/>
					<script>
						function buscador (){
							//Declarar variables.
							var input, filtro, tabla, tr, td, i, texto;
							input=document.getElementById ("buscador");
							filtro=input.value.toUpperCase ();
							tabla=document.getElementById ("tabla");
							tr=tabla.getElementsByTagName ("tr");
							//Recorre todas las filas de la tabla y oculta aquellas que no coincidan con la consulta de búsqueda.
							for (i=0; i<tr.length; i++){
								td=tr[i].getElementsByTagName ("td")[1];
								if (td){
									texto=td.textContent || td.innerText;
									if (texto.toUpperCase () .indexOf (filtro)>-1){
										tr[i].style.display="";
									}else{
										tr[i].style.display="none";
									}
								}
							}
						}
					</script>
			<?php
				//Si el lector ha iniciado sesión, muestra un buscador distinto.
				}elseif (isset ($_SESSION["dni_lector"]) && isset ($_SESSION["password"])){
			?>
					<input type="text" placeholder="Buscar por ISBN..." id="buscador" name="buscador" onkeyup="buscador ()"/>
					<script>
						function buscador (){
							//Declarar variables.
							var input, filtro, tabla, tr, td, i, texto;
							input=document.getElementById ("buscador");
							filtro=input.value.toUpperCase ();
							tabla=document.getElementById ("tabla");
							tr=tabla.getElementsByTagName ("tr");
							//Recorre todas las filas de la tabla y oculta aquellas que no coincidan con la consulta de búsqueda.
							for (i=0; i<tr.length; i++){
								td=tr[i].getElementsByTagName ("td")[2];
								if (td){
									texto=td.textContent || td.innerText;
									if (texto.toUpperCase () .indexOf (filtro)>-1){
										tr[i].style.display="";
									}else{
										tr[i].style.display="none";
									}
								}
							}
						}
					</script>
			<?php
				}
			?>
					<?php
						//Si se han introducido todos los datos, se conecta a la base de datos.
						$connection=new mysqli ("localhost", "administrador", "Ab123456", "biblioteca");
						//Si la conexión ha dado error, muestra una alerta por pantalla y te redirecciona a "alquileres.php".
						if ($connection->connect_errno){
							echo "<script>alert ('No hay conexión: (".$connection->connect_errno.")".$connection->connect_error.".'); window.location='alquileres.php'</script>";
						}
						//Si es el empleado el que ha iniciado sesión, la variable "$query" guarda el resultado de la consulta realizada.
						if (isset ($_SESSION["dni_empleado"]) && isset ($_SESSION["password"])){
							$query=mysqli_query ($connection, "SELECT * FROM alquileres");
						//Si es el lector el que ha iniciado sesión, la variable "$query" guarda el resultado de la consulta realizada.
						}elseif (isset ($_SESSION["dni_lector"]) && isset ($_SESSION["password"])){
							$query=mysqli_query ($connection, "SELECT * FROM alquileres WHERE dni_lector='".$_SESSION["dni_lector"]."'");
						}
						echo "<table id='tabla'>";
						echo "<caption>Alquileres</caption>";
						echo "<tr>";
						echo "<th>Identificador</th>";
						echo "<th>DNI</th>";
						echo "<th>ISBN</th>";
						echo "<th>Fecha de salida</th>";
						echo "<th>Fecha de entrada</th>";
						echo "</tr>";
						//Cada vez que se ejecuta en bucle, la variable "$row" guarda un valor obtenido de la variable "$query" y se muestra en la tabla.
						while ($row=mysqli_fetch_array ($query)){
							echo "<tr>";
							echo "<td>".$row[0]."</td>";
							echo "<td>".$row[1]."</td>";
							echo "<td>".$row[2]."</td>";
							echo "<td>".$row[3]."</td>";
							echo "<td>".$row[4]."</td>";
							echo "</tr>";
						}
						echo "</table>";
						//Se cierra la conexión al servidor de MySQL.
						mysqli_close ($connection);
					?>
			<?php
				//Si ambas variables están definidas (el usuario ha iniciado sesión), muestra los siguientes enlaces.
				if (isset ($_SESSION["dni_empleado"]) && isset ($_SESSION["password"])){
			?>
					<a class="boton" href="./insertar alquileres.php">Insertar</a>
					<a class="boton" href="./modificar alquileres.php">Modificar</a>
					<a class="boton" href="./borrar alquileres.php">Borrar</a>
			<?php
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