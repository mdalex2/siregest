<?php
function eliminar_datos(){
if (empty($_GET["id_elim"])){
	mostrar_box("err",false,"FALTAN DATOS","No se han recibido el c&oacute;digo identificador del plan de estudio a eliminar. ");
} else {
	
	$id_elim=$_GET["id_elim"];
	$sql_elim="delete from plan_est_tip where id_plan_nivel_est='$id_elim'";
	$conexion=conectarse();
	$consulta=mysql_query($sql_elim,$conexion);
	if (!$consulta){
		$error=obtener_error(mysql_errno());
		mostrar_box("err",true,"INFORMACIÓN","No se pudo eliminar el plan de estudio: ".$error);	} else {
			$url_redirec="plan_est.php?id_func=".$_GET['id_func'];
			if (mysql_affected_rows()>0){		
			mostrar_box("suc",false,"PLAN DE ESTUDIO ELIMINADO","El plan de estudio se elimin&oacute;, para buscar otro plan de estudio haga <a href='$url_redirec' >haga clic aqu&iacute;</a> o espere 5 segundos para redireccionar autom&aacute;ticamente al men&uacute; de b&uacute;squeda");
			} else {
				mostrar_box("exc",false,"RESULTADO","No se encontr&oacute; el plan de estudio para eliminar, si desea buscar otro haga <a href='$url_redirec' >haga clic aqu&iacute;</a> o espere 10 segundos para redireccionar autom&aacuteticamente; al men&uacute; de b&uacute;squeda");
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