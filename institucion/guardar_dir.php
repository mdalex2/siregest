<?php
include_once("../funciones/funcionesPHP.php");
include_once("../funciones/errores_genericos.php");
function pasar_dir(){
if (!empty($_POST["cmb_estado"]) && !empty($_POST["cmb_mcpio"]) && !empty($_POST["cmb_par"]) &&  !empty($_POST["cmb_pob"])){
if (empty($_POST) || !isset($_GET["id_func"])){
	mostrar_box("err",true,"FALTAN DATOS","No se ha recibido los datos del poblado. ".mysql_error())." N&deg;: ";
} else {
	
	if (isset($_GET["id_mos"])){$id_mos= $_GET['id_mos'];} else  {$id_mos="";}
			$url_redirec="inst_educativa.php?id_func=".$_GET['id_func']."&accion=".$_GET["accion"]."&id_pob=".$_POST["cmb_pob"]."&id_edo_ter=".$_POST["cmb_estado"]."&id_mos=$id_mos";
		//mostrar_box("suc",false,"DIRECCI&Oacute;N ALMACENADA","La direcci&oacute;n se almacen&oacute; correctamente. Usted será redirigido automáticamente en 4 segundos. Si no se redirige automáticamente <a href='$url_redirec' target='_parent'>haga clic aqui</a>");
		
		//header("Refresh: 4;url=$url_redirec;target=parent");
/*		
echo '<script type="text/javascript">
window.parent.location.href = "'.$url_redirec.'";

</script>';
*/
echo '<script language="JavaScript" type="text/javascript">

var pagina="'.$url_redirec.'"
function redireccionar() 
{
window.parent.location.href=pagina
} 
setTimeout ("redireccionar()", 0);

</script>';

exit();
	}
}
}
?>