<!DOCTYPE html>
<html lang="es">
	<head>
		<link href="../../index.css" rel="stylesheet" type="text/css"/>
		<link rel="shortcut icon" href="../../imagenes/logo.png"/>
		<meta charset="UTF-8"/>
		<title>Libros | Biblioteca</title>
	</head>
	<body>
		<header>
			<div>
				<a href="../../index.php" class="logo">
					<img src="../../imagenes/logo.png" class="logo"/>
				</a>
			</div>
	<?php
		//Evita que aparezcan mensajes de error en pantalla.
		error_reporting (0);
		//Crea una sesión.
		session_start ();
		//Si ambas variables están definidas (el usuario ha iniciado sesión), muestra el "navegador1".
		if (isset ($_SESSION["dni_empleado"]) && isset ($_SESSION["password"])){
	?>
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
	<?php
		//Si ambas variables no están definidas (el usuario no ha iniciado sesión), muestra el "navegador2".
		}elseif (isset ($_SESSION["dni_lector"]) && isset ($_SESSION["password"])){
	?>
			<nav>
				<ul class="navegador2">
					<li>
						<a href="../../index.php">Inicio</a>
					</li>
					<li>
						<a class="fijo" href="../libros/libros.php">Libros</a>
					</li>
					<li>
						<a href="../alquileres/alquileres.php">Alquileres</a>
					</li>
					<li>
						<a href="../lectores/datos lectores.php">Lector</a>
					</li>
				</ul>
			</nav>
	<?php
		//Si ambas variables no están definidas (el usuario no ha iniciado sesión), muestra el "navegador2".
		}else{
	?>
			<nav>
				<ul class="navegador2">
					<li>
						<a href="../../index.php">Inicio</a>
					</li>
					<li>
						<a class="fijo" href="../libros/libros.php">Libros</a>
					</li>
					<li>
						<a href="../lectores/registrar lectores.php">Registro</a>
					</li>
					<li>
						<a href="../acceso.php">Acceso</a>
					</li>
				</ul>
			</nav>
	<?php
		}
	?>
		</header>
		<main>
			<button class="accordion">Filtros</button>
			<div class="panel">
				<form action="libros.php" method="POST">
					<label for="titulo">Título:</label>
					<br>
					<input type="text" placeholder="Ingrese el título" id="titulo" name="titulo" pattern="^[ÁÉÍÓÚA-Z][a-záéíóú]+(\s+[ÁÉÍÓÚA-Z]?[a-záéíóú]+)*$" title="El título debe empezar por letra mayúscula."/>
					<br>
					<label for="fecha_desde">Fecha desde:</label>
					<br>
					<input type="date" id="fecha_desde" name="fecha_desde"/>
					<br>
					<label for="fecha_hasta">Fecha hasta:</label>
					<br>
					<input type="date" id="fecha_hasta" name="fecha_hasta"/>
					<br>
					<label for="autor">Autor:</label>
					<br>
					<select id="autor" name="autor">
						<option value=""></option>
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
					<select id="categoria" name="categoria">
						<option value=""></option>
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
					<select id="editorial" name="editorial">
						<option value=""></option>
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
					<select id="idioma" name="idioma">
						<option value=""></option>
						<option value="Español">Español</option>
						<option value="Inglés">Inglés</option>
						<option value="Francés">Francés</option>
						<option value="Alemán">Alemán</option>
					</select>
					<br>
					<label for="orden">Ordenar por:</label>
					<br>
					<select id="orden" name="orden">
						<option value=""></option>
						<option value="1">Título</option>
						<option value="2">Fecha de lanzamiento</option>
						<option value="3">Autor</option>
						<option value="4">Categoría</option>
						<option value="5">Editorial</option>
						<option value="6">Idioma</option>
					</select>
					<br>
					<input type="submit" value="Aplicar filtros"/>
				</form>
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
		<?php
			//La variable "$query" guarda la consulta realizada.
			$query="SELECT * FROM libros WHERE titulo LIKE '%".$_POST["titulo"]."%'";
			//Si la fecha no está vacía, añade a la variable "$query" la siguiente sentencia.
			if ($_POST["fecha_desde"]!=""){
				$query.=" AND fecha_lanzamiento BETWEEN '".$_POST["fecha_desde"]."' AND '".$_POST["fecha_hasta"]."'";
			}
			//Si el autor no está vacío, añade a la variable "$query" la siguiente sentencia.
			if ($_POST["autor"]!=""){
				$query.=" AND autor='".$_POST["autor"]."'";
			}
			//Si la categoría no está vacía, añade a la variable "$query" la siguiente sentencia.
			if ($_POST["categoria"]!=""){
				$query.=" AND categoria LIKE '".$_POST["categoria"]."'";
			}
			//Si la editorial no está vacía, añade a la variable "$query" la siguiente sentencia.
			if ($_POST["editorial"]!=""){
				$query.=" AND editorial LIKE '".$_POST["editorial"]."'";
			}
			//Si el idioma no está vacío, añade a la variable "$query" la siguiente sentencia.
			if ($_POST["idioma"]!=""){
				$query.=" AND idioma LIKE '".$_POST["idioma"]."'";
			}
			//Si el valor de la opción seleccionada de la etiqueta "<select>" es igual al valor "1", añade a la variable "$query" la siguiente sentencia.
			if ($_POST["orden"]=="1"){
				$query.=" ORDER BY titulo ASC";
			}
			//Si el valor de la opción seleccionada de la etiqueta "<select>" es igual al valor "2", añade a la variable "$query" la siguiente sentencia.
			if ($_POST["orden"]=="2"){
				$query.=" ORDER BY fecha_lanzamiento ASC";
			}
			//Si el valor de la opción seleccionada de la etiqueta "<select>" es igual al valor "3", añade a la variable "$query" la siguiente sentencia.
			if ($_POST["orden"]=="3"){
				$query.=" ORDER BY autor ASC";
			}
			//Si el valor de la opción seleccionada de la etiqueta "<select>" es igual al valor "4", añade a la variable "$query" la siguiente sentencia.
			if ($_POST["orden"]=="4"){
				$query.=" ORDER BY categoria ASC";
			}
			//Si el valor de la opción seleccionada de la etiqueta "<select>" es igual al valor "5", añade a la variable "$query" la siguiente sentencia.
			if ($_POST["orden"]=="5"){
				$query.=" ORDER BY editorial ASC";
			}
			//Si el valor de la opción seleccionada de la etiqueta "<select>" es igual al valor "6", añade a la variable "$query" la siguiente sentencia.
			if ($_POST["orden"]=="6"){
				$query.=" ORDER BY idioma ASC";
			}
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
						td=tr[i].getElementsByTagName ("td")[0];
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
				//Si se han introducido todos los datos, se conecta a la base de datos.
				$connection=new mysqli ("localhost", "administrador", "Ab123456", "biblioteca");
				//Si la conexión ha dado error, muestra una alerta por pantalla y te redirecciona a "libros.php".
				if ($connection->connect_errno){
					echo "<script>alert ('No hay conexión: (".$connection->connect_errno.")".$connection->connect_error.".'); window.location='libros.php'</script>";
				}
				//La variable "$query" guarda el resultado de la consulta realizada.
				$query=mysqli_query ($connection, $query);
				echo "<table id='tabla'>";
				echo "<caption>Libros</caption>";
				echo "<tr>";
				echo "<th>ISBN</th>";
				echo "<th>Título</th>";
				echo "<th>Fecha de lanzamiento</th>";
				echo "<th>Autor</th>";
				echo "<th>Categoría</th>";
				echo "<th>Editorial</th>";
				echo "<th>Idioma</th>";
				echo "<th>Páginas</th>";
				echo "<th>Descripción</th>";
				echo "</tr>";
				//Cada vez que se ejecuta en bucle, la variable "$row" guarda un valor obtenido de la variable "$query" y se muestra en la tabla.
				while ($row=mysqli_fetch_array ($query)){
					echo "<tr>";
					echo "<td>".$row[0]."</td>";
					echo "<td>".$row[1]."</td>";
					echo "<td>".$row[2]."</td>";
					echo "<td>".$row[3]."</td>";
					echo "<td>".$row[4]."</td>";
					echo "<td>".$row[5]."</td>";
					echo "<td>".$row[6]."</td>";
					echo "<td>".$row[7]."</td>";
					echo "<td>".$row[8]."</td>";
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
			<a class="boton" href="./insertar libros.php">Insertar</a>
			<a class="boton" href="./modificar libros.php">Modificar</a>
			<a class="boton" href="./borrar libros.php">Borrar</a>
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