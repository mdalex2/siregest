<?php
if (!file_exists("../configuraciones/config.server")){
	header("location:../instalacion/archivo_conexion_form.php?error=NEAC");
	} else
		header("location:clave_acceso.php");
?>
</html>
