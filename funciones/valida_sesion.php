<?php
if ($_SESSION['logueado_siregest']!=true){
	session_unset();
	session_destroy();
	session_start();
	$_SESSION['err']="nl";
	
	header("location:../acceso_sis/clave_acceso.php");
	exit();
	}
	
?>