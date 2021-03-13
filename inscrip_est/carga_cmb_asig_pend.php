
<?php
	echo '<option value="">SELECCIONE...</option>';
  include_once("../funciones/funcionesPHP.php");
	if (!empty($_REQUEST["id"])){
	$id_secc_post=$_REQUEST["id"];
	$sql_obten_config_plan_estud="select 
 id_plan_nivel_est,cod_mencion_educ,id_sector_educ,cod_grado
 FROM inst_secciones
 WHERE id_seccion='$id_secc_post' LIMIT 1
";

if ($consulta=ejecuta_sql($sql_obten_config_plan_estud,true)){
	$reg_plan_est=mysql_fetch_array($consulta);
	$id_plan_nivel_es=$reg_plan_est["id_plan_nivel_est"];
	$cod_mencion_educ=$reg_plan_est["cod_mencion_educ"];
	$id_sector_educ=$reg_plan_est["id_sector_educ"];
	$cod_grado_pla_est=$reg_plan_est["cod_grado"];
	/*
	echo "<option>$id_secc_post</option>";
	echo $id_plan_nivel_es."<br>";
	echo $cod_mencion_educ."<br>";
	echo $id_sector_educ."<br>";
	echo $cod_grado."<br>";
	*/
	//----------------------------------
	$sql_asignaturas="SELECT plan_est_conf.cod_asig_prog,asig_prog.des_mat_prog,asig_prog.mat_prog_cor
  FROM (plan_est_conf
	INNER JOIN asig_prog ON asig_prog.cod_asig_prog=plan_est_conf.cod_asig_prog
	)
	WHERE id_plan_nivel_est='$id_plan_nivel_es' AND cod_grado='$cod_grado_pla_est' AND cod_mencion_educ='$cod_mencion_educ' AND id_sector_educ='$id_sector_educ'
	ORDER BY asig_prog.orden ASC";
 $consul_asig=ejecuta_sql($sql_asignaturas,true);
 if ($consul_asig){
	
	while ($fila=mysql_fetch_array($consul_asig)){
		$mat_prog_cor=$fila["mat_prog_cor"];
		$cod_asig_prog=$fila["cod_asig_prog"];
		$des_mat_prog=$fila["des_mat_prog"];
		echo ('<option value="'.$cod_asig_prog.'">'.$mat_prog_cor." - ".$des_mat_prog.'</option>');
	} // fin while
} // fin si hay consulta de asig
} // fin de si se encontro la configuracion del plan de estudio a traves de la seccion
	}
?>

