<?php
function eliminar_telf(){
if (!isset($_GET["id_telf_elim"])){
	mostrar_box("err",true,"FALTAN DATOS","No se han recibido los datos a eliminar. ");
} else {
	unset($_SESSION["msg"]);

	$id_telf=$_GET["id_telf_elim"];
	$sql_elim="delete from inst_telefonos where id_telf='$id_telf'";
	$conexion=conectarse();
	$consulta=mysql_query($sql_elim,$conexion);
	if (!$consulta){
		$error=obtener_error(mysql_errno());
		mostrar_box("err",true,"INFORMACIÓN","No se pudo eliminar el tel&eacute;fono: ".$error);	} else {
						if (isset($_GET["id_edo_ter"])){
							$var_edo="&id_edo_ter=".$_GET["id_edo_ter"];
						} else {
							$var_edo="";
						}			
			$url_redirec="inst_educativa.php?id_func=".$_GET['id_func']."&accion=mostrar&id_mos=".$_GET["cod_pla"].$var_edo;
		mostrar_box("suc",false,"TELEFONO ELIMINADO","El tel&eacute;fono se elimin&oacute; correctamente. Usted será redirigido automáticamente en 4 segundos. Si no se redirige automáticamente <a href='$url_redirec' target='_parent'>haga clic aqui</a>");
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