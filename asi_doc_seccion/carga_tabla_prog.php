
<?php
session_start();

include_once("../funciones/errores_genericos.php");

if (!empty($_REQUEST["cod_anno_esc"]) && !empty($_REQUEST["id_profesor"]) && !empty($_REQUEST["cod_prog"])) {
	include_once("../funciones/funcionesPHP.php");
	$id_func=$_REQUEST["id_func"];
	$cod_anno_esc= $_REQUEST["cod_anno_esc"];
	$cod_secc= $_REQUEST["cod_secc"];
	$cod_prog= $_REQUEST["cod_prog"];
	$id_profesor= $_REQUEST["id_profesor"];
	$observaciones= $_REQUEST["observaciones"];
	$id_docente_guia= $_REQUEST["id_docente_guia"];
	$fecha_g=date("Y-m-d H:i:s");	
	$guardado_por=$_SESSION["id_usuario"];
	$conex=conectarse();
	$consulta_gua=mysql_query("INSERT INTO asi_doc_sec (cod_anno_esc,id_seccion,cod_asig_prog, 	id_profesor,observaciones,id_docente_guia,guardado_por,fecha_g) VALUES ('$cod_anno_esc','$cod_secc','$cod_prog','$id_profesor','$observaciones','$id_docente_guia','$guardado_por','$fecha_g')");
	if (!$consulta_gua){
		$msg=obtener_error(mysql_errno($conex));
		echo "<script>alert('$msg');</script>";
	} else {
		echo "<script>alert('Registro almacenado');</script>";
	}
	include_once("mostrar_tabla_prog.php");
	mostrar_tabla_prog($id_func,$cod_anno_esc,$cod_secc,true);
	} // fin se si se recibieron variables request
?>
