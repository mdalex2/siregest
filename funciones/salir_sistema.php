<?php
	session_start();
if (isset($_SESSION['var_menu'])){
	//echo "sesion destruida";
	session_unset();
	session_destroy();
	unset($_SESSION['logueado_siregest']);
	header("Location: ../acceso_sis/index.php");
	}
	else 
	{
		header("Location: ../acceso_sis/index.php");
		echo "no se ha definido la sesion";
	}
?>