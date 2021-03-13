<?php
function eliminar_datos(){
if (!isset($_GET["id_elim"])){
	mostrar_box("err",false,"FALTAN DATOS","No se han recibido el c&oacute;digo de la asignatura a eliminar. ");
} else {
	$id_elim=$_GET["id_elim"];
	$sql_elim="delete from asig_prog where cod_asig_prog='$id_elim'";
	$conexion=conectarse();
	$consulta=mysql_query($sql_elim,$conexion);
	if (!$consulta){
		$error=obtener_error(mysql_errno());
		mostrar_box("err",true,"INFORMACIÓN","No se pudo eliminar la asignatura o programa: ".$error);	} else {
			$url_redirec="asignaturas.php?id_func=".$_GET['id_func'];
			if (mysql_affected_rows()>0){		
			mostrar_box("suc",false,"ASIGNATURA ELIMINADA","la asignatura o programa se elimin&oacute;, para buscar otra asignatura haga <a href='$url_redirec' >haga clic aqu&iacute;</a> o espere 5 segundos para redireccionar autom&aacute;ticamente al men&uacute; de b&uacute;squeda");
			} else {
				mostrar_box("exc",false,"RESULTADO","No se encontraron asignaturas para eliminar, si desea buscar otra asignatura haga <a href='$url_redirec' >haga clic aqu&iacute;</a> o espere 10 segundos para redireccionar autom&aacuteticamente; al men&uacute; de b&uacute;squeda");
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