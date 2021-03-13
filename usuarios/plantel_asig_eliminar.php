<?php
function eliminar_plant(){
if (!isset($_GET["id_plant_elim"]) || !isset($_GET["id_per"])){
	mostrar_box("err",true,"FALTAN DATOS","No se han recibido los datos a eliminar. ");
} else {
	$id_plant=$_GET["id_plant_elim"];
	$id_usuario=$_GET["id_per"];
	$sql_elim="delete from usuario_plantel where id_personal='$id_usuario' and cod_plantel='$id_plant'";
	$conexion=conectarse();
	$consulta=mysql_query($sql_elim,$conexion);
	if (!$consulta){
		$error=obtener_error(mysql_errno($conexion));
		mostrar_box("err",true,"INFORMACIÓN","No se pudo eliminar la asignacion del plantel para el usuario seleccionado: ".$error);	
		echo mostrar_btn_imp_reg();
		} else {
			$url_redirec="usuarios.php?id_func=".$_GET['id_func']."&accion=mostrar&id_per=".$_GET["id_per"];
		mostrar_box("suc",false,"ASIGNACI&Oacute;N ELIMINADA","La asignacion del plantel para el usuario seleccionado se elimin&oacute; correctamente. Usted será redirigido automáticamente en 4 segundos. Si no se redirige automáticamente <a href='$url_redirec' target='_parent'>haga clic aqui</a>");
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
setTimeout ("redireccionar()", 4000);

</script>';
	}
}
}
?>