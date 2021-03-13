<?php
function guardar_log() {
include_once("../funciones/conexion.php");
$con=conectarse();
date_default_timezone_set("America/Caracas");
$ip=$_SERVER['REMOTE_ADDR'];
$fecha=date("Y-m-d H:i:s");	
$puerto=$_SERVER['REMOTE_PORT'];
$url=$_SERVER['REQUEST_URI'];
$detalles=$_SERVER['HTTP_USER_AGENT'];
$usuario=$_SESSION['nombre_usuario'];
$sql_log="insert into logs (ip,puerto,fecha,detalles,url_pagina,usuario) values ('$ip','$puerto','$fecha','$detalles','$url','$usuario')";
$resultado=mysql_query($sql_log,$con);
if (!$resultado){
	return false;
} else {
	return true;
}
}
?>