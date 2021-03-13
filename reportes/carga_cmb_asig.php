
<?php
session_start();
	echo '<option value="">SELECCIONE...</option>';
  include_once("../funciones/funcionesPHP.php");
	if (!empty($_REQUEST["id"])){
	$id_secc_post=$_REQUEST["id"];
	$cod_anno_esc=$_REQUEST["cod_anno_esc"];
	if ($_SESSION["id_grupo_usuario"]=="G0001" || $_SESSION["id_grupo_usuario"]=="G0002" || $_SESSION["id_grupo_usuario"]=="G0003"){
	$sql_asignaturas="SELECT asi_doc_sec.cod_asig_prog,asig_prog.des_mat_prog,asig_prog.mat_prog_cor
  FROM (asi_doc_sec
	INNER JOIN asig_prog ON asig_prog.cod_asig_prog=asi_doc_sec.cod_asig_prog
	)
	WHERE asi_doc_sec.id_seccion='$id_secc_post' AND asi_doc_sec.cod_anno_esc='$cod_anno_esc'
	ORDER BY asig_prog.orden ASC";
	} else {
		$id_usuario=$_SESSION['id_usuario'];
	$sql_asignaturas="SELECT asi_doc_sec.cod_asig_prog,asig_prog.des_mat_prog,asig_prog.mat_prog_cor
  FROM (asi_doc_sec
	INNER JOIN asig_prog ON asig_prog.cod_asig_prog=asi_doc_sec.cod_asig_prog
	)
	WHERE asi_doc_sec.id_seccion='$id_secc_post' AND asi_doc_sec.cod_anno_esc='$cod_anno_esc' AND id_profesor='$id_usuario'
	ORDER BY asig_prog.orden ASC";		
	}
 $consul_asig=ejecuta_sql($sql_asignaturas,true);
 if ($consul_asig){
	
	while ($fila=mysql_fetch_array($consul_asig)){
		$mat_prog_cor=$fila["mat_prog_cor"];
		$cod_asig_prog=$fila["cod_asig_prog"];
		$des_mat_prog=$fila["des_mat_prog"];
		echo ('<option value="'.$cod_asig_prog.'">'.$mat_prog_cor." - ".$des_mat_prog.'</option>');
	} // fin while
} // fin si hay consulta de asig
} //fin de si se recibio las variables por la url si no es empty
?>

