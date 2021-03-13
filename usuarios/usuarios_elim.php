<?php
function eliminar_datos(){
if (!isset($_GET["id_elim"])){
	mostrar_box("err",false,"FALTAN DATOS","No se han recibido el c&oacute;digo del usuaio a eliminar. ");
} else {
	$id_elim=$_GET["id_elim"];
	$sql_elim="delete from usuarios where id_usuario='$id_elim' AND id_usuario<>'CIS_ADMIN'";
	$conexion=conectarse();
	$consulta=mysql_query($sql_elim,$conexion);
	if (!$consulta){
		$error=obtener_error(mysql_errno());
		mostrar_box("err",true,"INFORMACIÓN","No se pudo eliminar el usuario: ".$error);	} else {
			$url_redirec="usuarios.php?id_func=".$_GET['id_func'];
			if (mysql_affected_rows()>0){		
			mostrar_box("suc",false,"USUARIO ELIMINADO","El usuario se elimin&oacute; correctamente, para buscar otro usuario haga <a href='$url_redirec' >haga clic aqu&iacute;</a> o espere 5 segundos para redireccionar autom&aacute;ticamente al men&uacute; de b&uacute;squeda");
			} else {
				mostrar_box("exc",false,"RESULTADO","No se encontraron usuarios para eliminar, si desea buscar otro usuario haga <a href='$url_redirec' >haga clic aqu&iacute;</a> o espere 10 segundos para redireccionar autom&aacuteticamente; al men&uacute; de b&uacute;squeda");
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