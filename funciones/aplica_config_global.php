<?php
// asigna las configuraciones gloables a las paginas
session_cache_limiter('nocache,private'); //evita mensaje de sesion expirada al presionar atras en el navegador
//ASIGNO LO CONFIGURACION DE MANIPULACION DE FECHAS A ESPAÑOL
date_default_timezone_set("America/Caracas");
include_once("detectar_os.php");
if ($os=="Windows" || $os=="Macintosh" || $os=="OS/2" || $os=="BeOS"){
	setlocale(LC_ALL,'es_VE', 'es_VE.utf-8',"es_Es",''); //pongo la traduccion de fecha a español
	//setlocale(LC_ALL,"spanish");
	}
else{
	//es linux pongo el locale de linux
   setlocale(LC_ALL,'es_VE', 'es_VE.utf-8',"es_Es");}
	//setlocale(LC_ALL,"es_VE.utf-8");	//-------------------------------------------------

	
?>
