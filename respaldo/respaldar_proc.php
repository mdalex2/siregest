<?php
include_once("../funciones/aplica_config_global.php");
include_once("../funciones/conexion.php");
$conn=conectarse();
if (!$conn){mostrar_box("err",true,"ERROR AL CONECTAR CON LA BASE DE DATOS","Se produjo un error al establecer la conexión con el servidor de base de datos; por lo tanto <b>no se pudo efectuar el respaldo</b>: ".mysql_error());
exit();
}
$servidor=$_SESSION["host"];
$usuario=$_SESSION["usuario_bd"];
$bd=$_SESSION["bd"];
$pwd=$_SESSION["password"];

$mes_letra=strftime( "%B", time());
//creo la carpeta del año en el que se esta efectuando el respaldo
//chmod("../respaldo",0777);
if (!file_exists(date("Y"))){
	mkdir(date("Y"),0777);
}
//creo la carapeta del mes en el que se esta haciendo el respaldo
if (!file_exists(date("Y")."/".$mes_letra)){
	mkdir(date("Y")."/".$mes_letra,0777);
}
$nombre_archivo=date("Y")."/".$mes_letra."/".date("d_m_Y_h_i_s").".sql.gz";
//echo "nombre de archivo. ".$nombre_archivo;
$ruta="../respaldo/$nombre_archivo";
$ejecuta = shell_exec("mysqldump --host=$servidor --user=$usuario --password=$pwd $bd | gzip > $nombre_archivo");
/*
if (!$ejecuta){
	echo $servidor.$usuario.$pwd.$bd;
	echo "error".mysql_error();
	exit();
}
*/
//echo "tamaño_archivo: ".filesize($nombre_archivo);
if (filesize($nombre_archivo)<50){
		if (file_exists($nombre_archivo)){
			unlink($nombre_archivo);}

		mostrar_box("err",true,"ERROR AL EFECTUAR EL RESPALDO","Se produjo un error al efectuar el respaldo de la base de datos, es probable que no se tenga privilegios de escritura en disco, el disco esté lleno o no se halla establecido la conexión con el servidor");
} else {
mostrar_box("suc",true,"EL RESPALDO SE EFECTU&Oacute; CORRECTAMENTE","El sistema redireccionará automáticamente a la descarga; si la misma no se ejecuta automáticamente siga las siguientes instrucciones:");
	?>
<style type="text/css">
a:link {
	color: #333;
}
a:visited {
	color: #069;
}
a:active {
	color: #333;
}
</style>

<h2>Si desea obtener una copia del respaldo haga clic aqui: &nbsp;&nbsp;  
<a href="<?php echo $nombre_archivo;?>"><img src="../images/sistema/folder_download.png" width="64" height="64"  align='absmiddle' start="fileopen"/>Descargar</a></h2>
<?php
echo '<script language="JavaScript" type="text/javascript">

var pagina="'.$nombre_archivo.'"
function redireccionar() 
{
window.parent.location.href=pagina
} 
setTimeout ("redireccionar()", 3000);

</script>';

}
?>
