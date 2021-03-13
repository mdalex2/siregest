<?php
include_once("../funciones/errores_genericos.php");
function guardar_asignacion(){
if (!isset($_POST["txt_cod_pla_ocu"]) || !isset($_POST["txt_id_usu_ocu"])){
		mostrar_box("err",true,"FALTAN DATOS","No se han recibido los datos a guardar. ");
} else {
	//echo "<pre>".print_r($_POST)."</pre>";
	$cod_plant=$_POST["txt_cod_pla_ocu"];
	$id_pers=$_POST["txt_id_usu_ocu"];
	//obtengo la fecha actual del servidor con una funcion guardada en la carpeta funciones
	$fecha_actual=fecha_actual("mysql");
	$sql_guarda="insert into usuario_plantel (id_personal,cod_plantel,fecha_asig,guardado_por,fecha_g) values (
	'$id_pers',
	'$cod_plant',
	'$fecha_actual',
	'".$_SESSION["id_usuario"]."',
	'$fecha_actual')";
	$conexion=conectarse();
	$consulta=mysql_query($sql_guarda,$conexion);
	if (!$consulta){
		$error=obtener_error(mysql_errno($conexion));
		mostrar_box("err",true,"INFORMACIÓN","No se pudo guardar la asiganci&oacute;n del plantel para el usuario seleccionado: ".$error);	
		//echo mostrar_btn_imp_reg();
		
		} else {
			$url_redirec="usuarios.php?id_func=".$_GET['id_func']."&accion=mostrar&id_per=".$_GET["id_per"];
		mostrar_box("suc",false,"INFORMACI&Oacute;N","La asignaci&oacute;n del plantel para el usuario se almacen&oacute; correctamente. Usted será redirigido automáticamente en 4 segundos. Si no se redirige automáticamente <a href='$url_redirec' target='_parent'>haga clic aqui</a>");
		
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