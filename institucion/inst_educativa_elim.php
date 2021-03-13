<?php
function eliminar_persona(){
if (!isset($_GET["id_elim"])){
	mostrar_box("err",false,"FALTAN DATOS","No se han recibido el c&oacute;digo de la persona a eliminar. ");
} else {
	$id_elim=$_GET["id_elim"];
	$sql_elim="delete from instituciones where cod_plantel='$id_elim'";
	$conexion=conectarse();
	$consulta=mysql_query($sql_elim,$conexion);
	if (!$consulta){
		$error=obtener_error(mysql_errno($conexion));
		mostrar_box("err",true,"INFORMACIÓN","No se pudo eliminar la instituci&oacute;n o plantel: ".$error);	
		echo mostrar_btn_imp_reg();
		
		} else {
			$url_redirec="inst_educativa.php?id_func=".$_GET['id_func'];
			if (mysql_affected_rows($conexion)>0){		
			mostrar_box("suc",false,"PLANTEL ELIMINADO","El plantel se elimin&oacute; correctamente, para buscar otro plantel haga <a href='$url_redirec' >haga clic aqu&iacute;</a> o espere 5 segundos para redireccionar autom&aacute;ticamente al men&uacute; de b&uacute;squeda");
			} else {
				mostrar_box("exc",false,"RESULTADO","No se encontraron planteles para eliminar, si desea buscar otro plantel haga <a href='$url_redirec' >haga clic aqu&iacute;</a> o espere 5 segundos para redireccionar autom&aacuteticamente; al men&uacute; de b&uacute;squeda");
			}
			
echo '<script language="JavaScript" type="text/javascript">

var pagina="'.$url_redirec.'"
function redireccionar() 
{
window.parent.location.href=pagina
} 
setTimeout ("redireccionar()", 5000);

</script>';
	}
}
}
?>