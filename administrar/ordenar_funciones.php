<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>
<?php
function reordenar_funciones(){
require_once("../funciones/conexion.php");
require_once("../funciones/funcionesPHP.php");
session_start();
$link=conectarse();
//consulta agrupada
$_SESSION["orden"]=1;
$sql_padre="select * from sis_funciones where id_padre='00001' AND UPPER(texto_icono)!='INICIO' ORDER BY texto_icono asc";
$consulta_padre=mysql_query($sql_padre,$link);

if (!$consulta_padre){	
	$_SESSION["titulo_msg"]="Error al reordenar las funciones";
	$_SESSION["error"]="No se pudo efectuar la conexión al servidor. <br>Información técnica: ".mysql_error() ;
	header("location:../controlador/msgs_menu.php");
}
while ($fila_padre=mysql_fetch_array($consulta_padre)){
	echo "id: {$fila_padre['id_func']} / padre: {$fila_padre['id_padre']} / Funcion: {$fila_padre['texto_icono']} ";
		$sql_orden_padre="update sis_funciones set orden={$_SESSION['orden']} where id_func='".$fila_padre['id_func']."'";
		mysql_query($sql_orden_padre,$link);
		$_SESSION["orden"]++;
		obtener_cant_hijos($fila_padre['id_func']);
		obtener_hijos($fila_padre['id_func']);
		
	}
}
//--------------------------------------------------------------------------------
function obtener_hijos($id_func_padre){
require_once("../funciones/conexion.php");
require_once("../funciones/funcionesPHP.php");
$link=conectarse();
//consulta agrupada
$sql_hijo="select * from sis_funciones where id_padre='$id_func_padre' ORDER BY texto_icono asc";
$consulta_hijo=mysql_query($sql_hijo,$link);
if (!$consulta_hijo){	
	$_SESSION["titulo_msg"]="Error al reordenar las funciones";
	$_SESSION["error"]="No se pudo efectuar la conexión al servidor. <br>Información técnica: ".mysql_error() ;
	header("location:../controlador/msgs_menu.php");
}
while ($fila_hijo=mysql_fetch_array($consulta_hijo)){
	echo "id: {$fila_hijo['id_func']} / padre: {$fila_hijo['id_padre']}Funcion: {$fila_hijo['texto_icono']}<br>";
	obtener_cant_hijos($fila_hijo['id_func']);
	obtener_hijos($fila_hijo['id_func']);
		$sql_orden_hijo="update sis_funciones set orden={$_SESSION['orden']} where id_func='".$fila_hijo['id_func']."'";
		mysql_query($sql_orden_hijo,$link);
		$_SESSION["orden"]++;

	}
}
//--------------------------------------------------------------------------
function obtener_cant_hijos($id_func_padre){
require_once("../funciones/conexion.php");
require_once("../funciones/funcionesPHP.php");
$link=conectarse();
//consulta agrupada
$sql_cant_hijos="select * from sis_funciones where id_padre='$id_func_padre' ORDER BY texto_icono asc";
$consulta_cant_hijos=mysql_query($sql_cant_hijos,$link);
$cant_hijos = mysql_num_rows($consulta_cant_hijos);
if (!$consulta_cant_hijos){	
	$_SESSION["titulo_msg"]="Error al reordenar las funciones";
	$_SESSION["error"]="No se pudo efectuar la conexión al servidor. <br>Información técnica: ".mysql_error() ;
	header("location:../controlador/msgs_menu.php");
}
if ($cant_hijos>0){
	echo "cantidad de hijos: ".$cant_hijos."<br>";}
}
reordenar_funciones();
?>
<body>
</body>
</html>