<?php
function quitar_asociacion(){
if (!isset($_GET["id_func"]) || !isset($_GET["cod_anno_esc"]) || !isset($_GET["cod_prog"]) || !isset($_GET["id_seccion"])){
	mostrar_box("err",false,"FALTAN DATOS","No se han recibido el c&oacute;digo del programa o a&ntilde;o al que desea quitar la asociaci&oacute;n");
	echo mostrar_btn_imp_reg();
} else {
	$cod_anno_esc=$_GET["cod_anno_esc"];
	$cod_prog=$_GET["cod_prog"];
	$id_func=$_GET["id_func"];
	$id_seccion=$_GET["id_seccion"];
	$sql_elim="delete from asi_doc_sec where cod_anno_esc='$cod_anno_esc' AND cod_asig_prog='$cod_prog' AND id_seccion='$id_seccion'";
	$conexion=conectarse();
	$consulta=mysql_query($sql_elim,$conexion);
	$cant_reg=mysql_affected_rows();
	if (!$consulta){
		$error=obtener_error(mysql_errno($conexion));
		mostrar_box("exc",true,"INFORMACI&Oacute;N","No se pudo quitar la asignaci&oacute;n del programa: ".$error);
		mostrar_btn_imp_reg();
			} else {
			$url_redirec="asi_doc_sec.php?id_func=".$_GET['id_func']."&accion=administrar&id_mos=$id_seccion";
			if ($cant_reg>0){		
			mostrar_box("suc",false,"ASIGNACIÓN QUITADA","La asignaci&oacute;n al programa se elimin&oacute;, para buscar otro programa haga <b><a href='$url_redirec' >haga clic aqu&iacute;</a></b> o espere 5 segundos para redireccionar autom&aacute;ticamente al men&uacute; de b&uacute;squeda");
			} else {
				mostrar_box("exc",false,"RESULTADO".$cant_reg,"No se encontraron asignaciones de programas para quitar, si desea buscar otro programa haga <b><a href='$url_redirec' >haga clic aqu&iacute;</a></b> o espere 10 segundos para redireccionar autom&aacuteticamente; al men&uacute; de b&uacute;squeda");
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