<?php
	include_once("../funciones/funcionesPHP.php");
	include_once("../funciones/conexion.php");
	if (!empty($_POST)  ){
  if(!isset($_REQUEST['chk_cod_mat'])){
		mostrar_box("inf",false,"Información","No se han seleccionado las materias o asignaturas que desea agregar al plan de estudio, debe seleccionar al menos una asignatura");
		echo mostrar_btn_imp_reg();
  }else{
		date_default_timezone_set("America/Caracas");
 		$cod_pla_est=$_POST["cod_pla_est"];
		$cod_sec=$_POST["cod_sec"];
		$cod_men=$_POST["cod_men"];
		$cod_gra=$_POST["cod_gra"];
		$fecha_g=date("Y-m-d H:i:s");	
		$guardado_por=$_SESSION["id_usuario"];
		$error=false;
		$conex=conectarse();
		/*
		echo "cod_plan: $cod_pla_est</br>";
		echo "sector: $cod_sec</br>";
		echo "mencion: $cod_men</br>";
		echo "grado: $cod_gra</br>";
		*/
    $chk_cod_mat = $_REQUEST['chk_cod_mat'];
    $ha = $_REQUEST['txt_ha'];
    $hp = $_REQUEST['txt_hp'];
  	$cod_asig=$_REQUEST['txt_cod_mat'];
		$orden=$_REQUEST['txt_ord'];
		//inicio la transaccion y elimino las configuraciones viejas
 if (!mysql_query("BEGIN",$conex)){$error=true;$msg_err[]=mysql_error();} 
 			$sql_elim="delete from plan_est_conf where".
			" id_plan_nivel_est='$cod_pla_est' and ".
			" cod_grado='$cod_gra' and ".
			" cod_mencion_educ='$cod_men' and ".
			" id_sector_educ='$cod_sec'";
			//verifico si se produjo error para deshacer los cambios
			if (!mysql_query($sql_elim,$conex)){$error=true;$msg_err[]=mysql_error();}

 for($i=0; $i < sizeof($chk_cod_mat); $i++)
 { 
 	if(!isset($chk_cod_mat[$i])){ $chk_cod_mat[$i]='off';}
		if($chk_cod_mat[$i]=='on'){
			$sql_ins_asi="INSERT INTO plan_est_conf (id_plan_nivel_est,cod_grado,cod_mencion_educ,id_sector_educ,cod_asig_prog,orden,hp,ha,guardado_por,fecha_g) VALUES
			 ('$cod_pla_est','$cod_gra','$cod_men','$cod_sec','$cod_asig[$i]',$orden[$i],$hp[$i],$ha[$i],'$guardado_por','$fecha_g')";
			//echo $cod_asig[$i]." - ".$chk_cod_mat[$i]."-".$ha[$i]." - ".$hp[$i]." - ".$orden[$i]."<br />";
			if (!mysql_query($sql_ins_asi,$conex)){$error=true;$msg_err[]=mysql_error();}
		} 

 }
 if (!$error){
	  echo mostrar_box("suc",false,"NOTIFICACIÓN","La configuración del plan de estudio se aplicó correctamente");
		$pagina="pagina.php";
		echo '<button onclick =" window.open(\'plan_est_rep.php?id_pla='.$cod_pla_est.'&cod_sec='.$cod_sec.'&cod_men='.$cod_men.'&cod_gra='.$cod_gra.'\',\'_blank\')" class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" >
<span class="ui-button-text"><img src="../images/icons_menu/x32/printer2_x32.png" align="absmiddle" height="20" width="20"> Ver reporte</span>
</button>

<button class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" onclick="javascript:history.back(1)">
<span class="ui-button-text"><img src="../images/icons_menu/x32/atras_azul.png" align="absmiddle" height="20" width="20"> Ir atr&aacute;s</span>
</button>';
		mysql_query("COMMIT",$conex);
 } else {
	 	echo mostrar_box("err",false,"NOTIFICACIÓN","Error al aplicar la configuración al plan de estudio:</br>");
		echo "<h2><pre>";
		print_r($msg_err);
		echo "</pre></h2>";
		echo mostrar_btn_imp_reg();
	 	mysql_query("ROLLBACK",$conex);
 }
}
}

	?>
