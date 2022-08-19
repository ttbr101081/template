<?php
	$usuario='root';
	$clave='';
	$servidor='localhost';
	$base='gestiondocumental';
	$l=@mysqli_connect($servidor,$usuario,$clave) or die("Error al conectarse con el servidor");
	@mysqli_select_db($l,$base) or die("Error al conectarse a la bd");
	@mysqli_set_charset($l, 'utf8');
?>