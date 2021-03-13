<?php
	echo "<OPTION VALUE=''>SELECCIONE...</OPTION>";
  include_once("../funciones/funcionesPHP.php");
  $cod_plantel= $_REQUEST["id"];
	  if (!empty($cod_plantel)) {
	include_once("../funciones/funcionesPHP.php");
	$consulta=ejecuta_sql("select DISTINCT  
	usuario_plantel.id_personal,
	datos_per.nombres,datos_per.apellidos,
	usuarios.id_grupo_cuenta
	 from (usuario_plantel
	 INNER JOIN datos_per ON datos_per.id_personal=usuario_plantel.id_personal
	 INNER JOIN usuarios ON usuarios.id_usuario=usuario_plantel.id_personal
	) WHERE usuario_plantel.cod_plantel='$cod_plantel' AND  	usuarios.bloqueado=false AND usuarios.id_grupo_cuenta='G0002' order by datos_per.nombres,datos_per.apellidos ASC",true);
	//si hay registros para mostrar
  if ($consulta){
	while ($fila=mysql_fetch_array($consulta)){
		echo utf8_encode("<OPTION VALUE='".$fila['id_personal']."'>".$fila["nombres"]." ".$fila["apellidos"]."</OPTION>");
	}
	}
	} // fin de si se envio el año escolar
?>
