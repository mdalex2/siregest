<?php
include_once("../funciones/errores_genericos.php");
function guardar_telf(){
if (empty($_POST) || !isset($_GET["cod_pla"])){
	mostrar_box("err",true,"FALTAN DATOS","No se han recibido los datos a guardar. ".mysql_error())." N&deg;: ".mysql_errno();
} else {
	$num_telf=$_POST["txt_num_tel"];
	$dep_per=$_POST["txt_dep_per"];
	$cod_pla=$_GET["cod_pla"];
	//obtengo la fecha actual del servidor con una funcion guardada en la carpeta funciones
	$fecha_actual=fecha_actual("mysql");
	$sql_guarda="insert into inst_telefonos (cod_plantel,departamento,num_telf,guardado_por,fecha_g) values (
	'$cod_pla',
	'$dep_per',
	'$num_telf',
	'".$_SESSION["id_usuario"]."',
	'$fecha_actual')";
	$conexion=conectarse();
	$consulta=mysql_query($sql_guarda,$conexion);
	if (!$consulta){
		$error=obtener_error(mysql_errno());
		mostrar_box("err",true,"INFORMACIÓN","No se pudo guardar el tel&eacute;fono en la base de datos: ".$error);	} else {
									if (isset($_GET["id_edo_ter"])){
							$var_edo="&id_edo_ter=".$_GET["id_edo_ter"];
						} else {
							$var_edo="";
						}

			$url_redirec="inst_educativa.php?id_func=".$_GET['id_func']."&accion=mostrar&id_mos=".$_GET["cod_pla"].$var_edo;
		mostrar_box("suc",false,"TELEFONO GUARDADO","El tel&eacute;fono de almacen&oacute; correctamente. Usted será redirigido automáticamente en 4 segundos. Si no se redirige automáticamente <a href='$url_redirec' target='_parent'>haga clic aqui</a>");
		
		//header("Refresh: 4;url=$url_redirec;target=parent");
/*		
echo '<script type="text/javascript">
window.parent.location.href = "'.$url_redirec.'";

</script>';
*/
echo '<script language="JavaScript" type="text/javascript">

var pagina="'.$url_redirec.'"
function redireccionar() 
{
window.parent.location.href=pagina
} 
setTimeout ("redireccionar()", 4000);

</script>';

exit();
	}
}
}
?>