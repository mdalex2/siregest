<?php
	echo "<OPTION VALUE=''>SELECCIONE...</OPTION>";
  include_once("../funciones/funcionesPHP.php");
  $cod_grado= $_REQUEST["id"];
	$cod_plantel=$_REQUEST["cod_plantel"];
	  if (!empty($cod_grado) && !empty($cod_plantel)) {
	include_once("../funciones/funcionesPHP.php");
	$consulta=ejecuta_sql("select inst_secciones.id_seccion,inst_secciones.seccion_corto,menc_edu.mencion from (inst_secciones
	INNER JOIN menc_edu ON menc_edu.cod_mencion_educ=inst_secciones.cod_mencion_educ
	) where inst_secciones.cod_plantel='$cod_plantel' AND inst_secciones.cod_grado='$cod_grado' AND inst_secciones.seccion_corto='U' AND inst_secciones.visible=true order by inst_secciones.seccion_corto ASC",false);
	//si hay registros para mostrar
  if (!$consulta==false){
	while ($fila=mysql_fetch_array($consulta)){
		echo "<OPTION VALUE='".$fila['id_seccion']."'>".$fila["seccion_corto"]." | ".$fila["mencion"]."</OPTION>";
	}
	}
 } // fin si se envio el post muestro
?>
