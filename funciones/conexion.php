<?php
include_once("funcionesPHP.php");
error_reporting(E_ALL & ~E_DEPRECATED);
ini_set("display_errors", 1); 
function conectarse(){
   require_once "encriptado.php";
  	$llave_encriptar='!%&$SisTemas2012#!?';
if (!file_exists("../configuraciones/config.server")){
	header("location:../instalacion/archivo_conexion_form.php?error=NEAC");
	exit();
	}
$archivo = file("../configuraciones/config.server"); //creamos el array con las lineas del archivo
$lineas = count($archivo); //contamos los elementos del array, es decir el total de lineas
for($i=0; $i < $lineas; $i++){
	$datos=desencriptar($archivo[$i],$llave_encriptar);
	switch ($i){
		case 0:
			$_SESSION["host"]=$datos;
		  $host=$datos;
		  break;
		case 1:
			$_SESSION["bd"]=$datos;
		  $bd=$datos;
		  break;
		case 2:
			$_SESSION["usuario_bd"]=$datos;
		  $usuario=$datos;
		  break;
		case 3:
			$_SESSION["password"]=$datos;
		  $password=$datos;
		  break;
		}
}

$link = mysql_connect($host, $usuario,$password, $bd);
mysql_query("SET NAMES 'utf8'");
   if (!$link){
   	$pag="../instalacion/archivo_conexion_form.php?error=ESBD&servidor=".$host."&id_usu=".$usuario."&bd=".$bd;
   	echo redireccionar_js($pag,0);
	   exit();     	
   }
   else
   if (!mysql_select_db($bd,$link)){
   	/*echo '<script>alert("Error en la conexión al seleccionar la base de datos");</script>';*/
   	$pag="../instalacion/archivo_conexion_form.php?error=ESBD&servidor=".$host."&id_usu=".$usuario."&bd=".$bd;
   	echo redireccionar_js($pag,0);

	   exit();
		}
	else{
		return $link;
		mysql_close();
		}
		
}
//-------------------------------------------------------------------
	
?>
