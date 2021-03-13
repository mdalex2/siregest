<?php
function eliminar_direcc(){
if (!isset($_GET["id_tipo_dir"]) ||!isset($_GET["id_per"]) ){
	mostrar_box("err",true,"FALTAN DATOS","No se han recibido los datos a eliminar. ");
	echo mostrar_btn_imp_reg(); //muestro los botones de regresa e imprimir
} else {
	$cod_tip_dir=$_GET["id_tipo_dir"];
	$id_personal=$_GET["id_per"];
	$sql_elim="delete from direcc_personas where cod_tip_dir='$cod_tip_dir' and id_personal='$id_personal'";
	$conexion=conectarse();
	$consulta=mysql_query($sql_elim,$conexion);
	if (!$consulta){
		$error=obtener_error(mysql_errno());
		mostrar_box("err",true,"INFORMACIÓN","No se pudo eliminar la direcci&oacute;n: ".$error);	} else {
			$url_redirec="datos_per.php?id_func=".$_GET['id_func']."&accion=mostrar&id_per=".$_GET["id_per"];
		mostrar_box("suc",false,"DIRECI&Oacute;N ELIMINADA","La direcci&oacute;n se elimin&oacute; correctamente. Usted será redirigido automáticamente en 4 segundos. Si no se redirige automáticamente <a href='$url_redirec' target='_parent'>haga clic aqui</a>");
		//header("Refresh: 4;datos_per.php?id_func=".$_GET['id_func']."&accion=mostrar&id_per=".$_GET["id_pers"]);
		
/*echo '<script type="text/javascript">
window.parent.location.href = "$url_redirec";
</script>';
*/
echo '<script language="JavaScript" type="text/javascript">

var pagina="'.$url_redirec.'"
function redireccionar() 
{
window.parent.location.href=pagina
} 
setTimeout ("redireccionar()", 3000);

</script>';
	}
}
}
?>