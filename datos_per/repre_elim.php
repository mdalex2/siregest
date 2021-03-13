<?php
function eliminar_repre(){
if (!isset($_GET["id_repre_elim"]) && !isset($_GET["id_per"])){
	mostrar_box("err",true,"FALTAN DATOS","No se han recibido los datos a eliminar. ");
} else {
	$id_repre=$_GET["id_repre_elim"];
	$id_alumn=$_GET["id_per"];
	$sql_elim="delete from alum_repr where id_alumno='$id_alumn' AND id_representante='$id_repre'";
	$conexion=conectarse();
	$consulta=mysql_query($sql_elim,$conexion);
	if (!$consulta){
		$error=obtener_error(mysql_errno());
		mostrar_box("err",true,"INFORMACIÓN","No se quitar la asociación del representante al estudiante seleccionado: ".$error);	} else {
			$url_redirec="datos_per.php?id_func=".$_GET['id_func']."&accion=mostrar&id_per=".$_GET["id_per"];
		mostrar_box("suc",false,"ASOCIACIÓN QUITADA","La asociación de representante se eliminó correctamente. Usted será redirigido automáticamente en 4 segundos. Si no se redirige automáticamente <a href='$url_redirec' target='_parent'>haga clic aqui</a>");
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