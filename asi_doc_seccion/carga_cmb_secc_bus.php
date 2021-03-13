<?php
	include_once("../funciones/funcionesPHP.php");
	if (isset($_REQUEST["id"]) ){
		$cod_plantel=$_REQUEST["id"];
		
	$consulta=ejecuta_sql("select DISTINCT  inst_secciones.cod_grado,grados_esc.grado_letras from (inst_secciones 
	INNER JOIN grados_esc ON grados_esc.cod_grado=inst_secciones.cod_grado
	) WHERE inst_secciones.cod_plantel='$cod_plantel' AND grados_esc.visible=true order by grados_esc.orden ASC",false);
	//si hay registros para mostrar
  if ($consulta){
	while ($fila=mysql_fetch_array($consulta)){
		echo "<OPTION VALUE='".$fila['cod_grado']."' {$selected}>".$fila["grado_letras"]."</OPTION>";
	}
	} else //si no hubo consulta se grados o años
		{
			echo "<OPTION VALUE='' SELECTED>SIN ASIGNACI&Oacute;N</OPTION>";
		}
	}
?>