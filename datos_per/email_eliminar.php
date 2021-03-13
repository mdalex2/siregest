<?php
function eliminar_email(){
if (!isset($_GET["id_email_elim"])){
	mostrar_box("err",true,"FALTAN DATOS","No se han recibido los datos a eliminar. ");
} else {
	$id_email=$_GET["id_email_elim"];
	$sql_elim="delete from emails_pers where id_email='$id_email'";
	$conexion=conectarse();
	$consulta=mysql_query($sql_elim,$conexion);
	if (!$consulta){
		$error=obtener_error(mysql_errno());
		mostrar_box("err",true,"INFORMACIÓN","No se pudo eliminar la direcci&oacute;n de correo electr&oacute;nico: ".$error);	} else {
			$url_redirec="datos_per.php?id_func=".$_GET['id_func']."&accion=mostrar&id_per=".$_GET["id_per"];
		mostrar_box("suc",false,"EMAIL ELIMINADO","la direcci&oacute;n de correo electr&oacute;nico se elimin&oacute; correctamente. Usted será redirigido automáticamente en 4 segundos. Si no se redirige automáticamente <a href='$url_redirec' target='_parent'>haga clic aqui</a>");
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