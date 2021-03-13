<?php
	echo "<OPTION VALUE=''>SELECCIONE...</OPTION>";
  include_once("../funciones/funcionesPHP.php");
  $anno_esc= $_REQUEST["id"];
	$cod_plantel=$_REQUEST["cod_plantel"];
	  if (!empty($anno_esc) && !empty($cod_plantel)) {
	include_once("../funciones/funcionesPHP.php");
	$consulta=ejecuta_sql("select DISTINCT  inst_secciones.cod_grado,grados_esc.grado_letras from (asi_doc_sec
	INNER JOIN inst_secciones ON inst_secciones.id_seccion=asi_doc_sec.id_seccion
	INNER JOIN grados_esc ON grados_esc.cod_grado=inst_secciones.cod_grado
	) WHERE asi_doc_sec.cod_anno_esc='$anno_esc' AND  	cod_plantel='$cod_plantel' order by grados_esc.orden ASC",true);
	//si hay registros para mostrar
  if ($consulta){
	while ($fila=mysql_fetch_array($consulta)){
		echo ("<OPTION VALUE='".$fila['cod_grado']."'>".$fila["grado_letras"]."</OPTION>");
	}
	}
	} // fin de si se envio el año escolar
?>
