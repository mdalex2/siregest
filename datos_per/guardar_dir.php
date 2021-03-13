<?php
include_once("../funciones/errores_genericos.php");

function guardar_direccion(){
if (!empty($_POST["cmb_estado"]) && !empty($_POST["cmb_mcpio"]) && !empty($_POST["cmb_par"]) &&  !empty($_POST["cmb_pob"]) && !empty($_POST["cmb_tip_dir"]) && !empty($_POST["txt_des_dir"]) ){
if (empty($_POST) || !isset($_GET["id_per"])){
	mostrar_box("err",true,"FALTAN DATOS","No se han recibido los datos a guardar. ".mysql_error())." N&deg;: ";
} else {
	
	$direccion=$_POST["txt_des_dir"];
	$id_pers=$_GET["id_per"];
	$tip_dir=$_POST["cmb_tip_dir"];
	$estado=$_POST["cmb_estado"];
	$mcpio=$_POST["cmb_mcpio"];
	$parroquia=$_POST["cmb_par"];
	$poblado=$_POST["cmb_pob"];
	//obtengo la fecha actual del servidor con una funcion guardada en la carpeta funciones
	$fecha_actual=fecha_actual("mysql");
	$sql_guarda="insert into direcc_personas (id_personal,cod_tip_dir,cod_estado_ter,cod_municipio,cod_parroquia,cod_poblado,direccion,guardado_por,fecha_g) values (
	'$id_pers',
	'$tip_dir',
	'$estado',
	'$mcpio',
	'$parroquia',
	'$poblado',
	'$direccion',
	'".$_SESSION["id_usuario"]."',
	'$fecha_actual')";
	$conexion=conectarse();
	$consulta=mysql_query($sql_guarda,$conexion);
	if (!$consulta){
		$error=obtener_error(mysql_errno());
		mostrar_box("err",true,"INFORMACIÓN","No se pudo guardar la direcci&oacute;n en la base de datos: ".$error.mysql_error());	} else {
			$url_redirec="datos_per.php?id_func=".$_GET['id_func']."&accion=mostrar&id_per=".$_GET["id_per"];
		mostrar_box("suc",false,"DIRECCI&Oacute;N ALMACENADA","La direcci&oacute;n se almacen&oacute; correctamente. Usted será redirigido automáticamente en 4 segundos. Si no se redirige automáticamente <a href='$url_redirec' target='_parent'>haga clic aqui</a>");
		
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
setTimeout ("redireccionar()", 3000);

</script>';

exit();
	}
}
}
}
?>