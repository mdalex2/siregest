<?php
function eliminar_persona(){
if (!isset($_GET["id_elim"])){
	mostrar_box("err",false,"FALTAN DATOS","No se han recibido el c&oacute;digo de la persona a eliminar. ");
} else {
	$id_elim=$_GET["id_elim"];
	$sql_elim="delete from datos_per where id_personal='$id_elim' AND id_personal<>'CIS_ADMIN'";
	$conexion=conectarse();
	if ($consulta=mysql_query($sql_elim,$conexion)){
		$num_reg=mysql_affected_rows($conexion);
	}
	if (!$consulta){
		$error=obtener_error(mysql_errno($conexion));
		mostrar_box("err",true,"INFORMACIÓN","No se pudo eliminar el expediente personal: ".$error);	} else {
			$url_redirec="datos_per.php?id_func=".$_GET['id_func'];
			if ($num_reg>0){		
			mostrar_box("suc",false,"EXPEDIENTE ELIMINADO","El expediente personal se elimin&oacute;, para buscar otro expediente haga <a href='$url_redirec' >haga clic aqu&iacute;</a> o espere 5 segundos para redireccionar autom&aacute;ticamente al men&uacute; de b&uacute;squeda");
			} else {
				mostrar_box("exc",false,"RESULTADO","No se encontraron expedientes personales para eliminar, si desea buscar otro expediente haga <a href='$url_redirec' >haga clic aqu&iacute;</a> o espere 10 segundos para redireccionar autom&aacuteticamente; al men&uacute; de b&uacute;squeda");
			}
			
echo '<script language="JavaScript" type="text/javascript">

var pagina="'.$url_redirec.'"
function redireccionar() 
{
window.parent.location.href=pagina
} 
setTimeout ("redireccionar()", 10000);

</script>';
	}
}
}
?>