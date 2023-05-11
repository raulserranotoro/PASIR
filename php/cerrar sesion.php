<?php
	//Crea una sesión.
	session_start ();
	//Elimina la variable "$_SESSION".
	unset ($_SESSION);
	//La variable "$_SESSION" almacena un array.
	$_SESSION=array ();
	//Destruye toda la información asociada con la sesión actual.
	session_destroy ();
	//Redirecciona a "index.php".
	header ("location: ../index.php");
?>