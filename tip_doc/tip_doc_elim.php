<?php
function eliminar_datos(){
if (!isset($_GET["id_elim"])){
	mostrar_box("err",false,"FALTAN DATOS","No se han recibido el c&oacute;digo de la profesi&oacute;n u ocupaci&oacute;n a eliminar. ");
} else {
	$id_elim=$_GET["id_elim"];
	$sql_elim="delete from tip_doc_per where cod_tip_doc_per='$id_elim'";
	$conexion=conectarse();
	$consulta=mysql_query($sql_elim,$conexion);
	if (!$consulta){
		$error=obtener_error(mysql_errno($conexion));
		mostrar_box("err",true,"INFORMACIÓN","No se pudo eliminar el tipo de documento de identificaci&oacute;n: ".$error);	} else {
			$url_redirec="tip_doc.php?id_func=".$_GET['id_func'];
			if (mysql_affected_rows($conexion)>0){		
			mostrar_box("suc",false,"RESULTADO DE LA ELIMINACI&Oacute;N","El tipo de documento de identificaci&oacute;n se elimin&oacute; correctamente, para buscar otro haga <a href='$url_redirec' >haga clic aqu&iacute;</a> o espere 5 segundos para redireccionar autom&aacute;ticamente al men&uacute; de b&uacute;squeda");
			echo mostrar_btn_imp_reg();
			} else {
				mostrar_box("exc",false,"RESULTADO","No se encontr&oacute; del tipo de documento de identificaci&oacute;n para eliminar, si desea buscar otro haga <a href='$url_redirec' >haga clic aqu&iacute;</a> o espere 10 segundos para redireccionar autom&aacuteticamente; al men&uacute; de b&uacute;squeda");
			}
			
echo '<script language="JavaScript" type="text/javascript">

var pagina="'.$url_redirec.'"
function redireccionar() 
{
window.parent.location.href=pagina
} 
setTimeout ("redireccionar()", 5000);

</script>';
//exit();
	}
}
}
?>