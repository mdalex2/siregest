<?php
include_once("../funciones/errores_genericos.php");
function guardar_repre(){
if (empty($_POST) || !isset($_GET["id_per"])){
	mostrar_box("err",true,"FALTAN DATOS","No se han recibido los datos a guardar. ");
} else {
	$id_alum=$_GET["id_per"];
	$id_repre=$_REQUEST["txt_id_rep"];
	$cod_parentes=$_REQUEST["cmb_par"];
	$obs=$_POST["txt_obs"];
	if (!empty($_POST["chk_rep"]) && $_POST["chk_rep"]=="on"){
		$es_repre_primario=true;
	} else {
	$es_repre_primario=false;}
	//obtengo la fecha actual del servidor con una funcion guardada en la carpeta funciones
	$fecha_actual=fecha_actual("mysql");
	$sql_guarda="insert into alum_repr (id_alumno,id_representante,id_parentesco, 	representante,observaciones,guardado_por,fecha_g) values (
	'$id_alum',
	'$id_repre',
	'$cod_parentes',
	'$es_repre_primario',
	'$obs',
	'".$_SESSION["id_usuario"]."',
	'$fecha_actual')";
	$conexion=conectarse();
	$consulta=mysql_query($sql_guarda,$conexion);
	if (!$consulta){
		$error=obtener_error(mysql_errno());
		mostrar_box("err",true,"INFORMACIÓN","No se pudo asignar el representante al alumno: ".$error);
		echo mostrar_btn_imp_reg();
			} else {
			$url_redirec="datos_per.php?id_func=".$_GET['id_func']."&accion=mostrar&id_per=".$_GET["id_per"];
		mostrar_box("suc",false,"INFORMACIÓN","El representante se asignó correctamente. Usted será redirigido automáticamente en 4 segundos. Si no se redirige automáticamente <a href='$url_redirec' target='_parent'>haga clic aqui</a>");
		
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