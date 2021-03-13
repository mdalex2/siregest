<!DOCTYPE HTML>
<html>
<head>
<!-- Meta -->
<meta http-equiv="Content-Type" content="text/html; charset=<?php if (isset($_SESSION['juego_caracteres'])) echo $_SESSION['juego_caracteres']; else echo "utf-8";//esta variable se declara en modulo verificar login?>">
</head>
                 
<?php
//echo "<pre>".print_r($_POST)."</pre>";
//exit();
include_once("../funciones/funcionesPHP.php");
function guardar_datos(){
	if (empty($_POST)){ //si no se han recibido datos muestro error
			echo "<h2>No se han recibido datos de la inscripci&oacute;n</h2>";
			mostrar_btn_imp_reg();
		} else {
			//echo "<pre>".print_r($_POST)."</pre>";
			//pongo zona horaria para evitar errores al obtener fecha actual del servidor
			date_default_timezone_set("America/Caracas");
			$error_trans=false;
			$msg_err[]="";
			$id_alum=$_POST["txt_id_per_ocu"];
			$cod_anno_esc=$_POST["txt_anno_esc_ocu"];
			$cod_plantel_proc=$_POST["txt_cod_plant_ocu"];
			$cod_grado=$_POST["txt_gra_ocu"];
			$id_seccion=$_POST["txt_secc_ocu"];
			if (!empty($_POST["chk_cod_asig"])){
				$arr_chk_cod_asig_prog=$_POST["chk_cod_asig"];
				$arr_cod_asig_prog=$_POST["txt_cod_asig"];
			} else {
				$error_trans=true;
				echo mostrar_box("exc",false,"Advertencia","Debe seleccionar las asignaturas a inscribir");
				
				echo mostrar_btn_imp_reg();
				$arr_chk_cod_asig_prog="";
				$arr_cod_asig_prog="";
			}
							//obtengo los valres de check programa y cod de programa
			if (!empty($_POST["chk_cod_prog"])){
				$arr_chk_cod_prog=$_POST["chk_cod_prog"];
				$arr_cod_prog=$_POST["txt_cod_prog"];
			}else{
				$arr_chk_cod_prog="";
				$arr_cod_prog="";
			}
			$id_tip_eval_normal=1; //NORMALEMTE ES FINALES=1
			$id_escolaridad=$_POST["txt_esc_ocu"];
			$fecha_g=date("Y-m-d H:i:s");	
		  $guardado_usuario=$_SESSION["id_usuario"];

			//verifico si es con materia pendiente para traer los campos
			//verifico si se pasaron recaudos a la inscripcion
			if (!empty($_POST["chk_reca"])){
				$arr_chk_reca=$_POST["chk_reca"];
				$arr_cod_reca=$_POST["txt_cod_reca"];
				$obs=$_POST["txt_obs"];
				}
			else {
				$arr_chk_reca="";
				$arr_cod_reca="";
				$obs="";
			}
			//BUSCO LA FECHA DE EVALUACION PARA RESUMEN FINAL LA FECHA FIN DE EL AÑO ESCOLARNORMALMENTE JULIO
			$sql_fech_eval="SELECT fecha_fin FROM anno_esc_me WHERE cod_anno_esc='$cod_anno_esc'";
			$cons_fech_eval=ejecuta_sql($sql_fech_eval,false);
			if ($cons_fech_eval){
				$fila_eval=mysql_fetch_array($cons_fech_eval);
				$fecha_eval=date("Y-m-d",strtotime($fila_eval["fecha_fin"]));
				
			} else {
				$fecha_eval=date("Y-m-d");
			}
			 $conex=conectarse();
			 //INICIO LA TRANSACCCION
			 if (!mysql_query("BEGIN",$conex)){$error_trans=true;$msg_err[]=mysql_error($conex);} 
			 	

			 $sql_elim_ins="DELETE FROM alum_insc_notas 
			 WHERE 
			 id_personal='$id_alum' AND cod_anno_esc='$cod_anno_esc' AND cod_grado='$cod_grado'";
			 if (!mysql_query($sql_elim_ins,$conex)){$error_trans=true;$msg_err[]="No se pudo eliminar la inscripci&oacute;n anterior del estudiante para registrar la nueva".mysql_error($conex);}
//GUARDO LAS ASIGNATURAS INSCRITAS
for($i=0; $i < sizeof($arr_chk_cod_asig_prog); $i++){ 
 	
	if(!isset($arr_chk_cod_asig_prog[$i])){ $arr_chk_cod_asig_prog[$i]='off';}
		if($arr_chk_cod_asig_prog[$i]=='on'){
			$sql_ins_alu="INSERT INTO alum_insc_notas (id_personal,cod_anno_esc,cod_plantel_proc,cod_grado,id_seccion,cod_asig_prog,id_escolaridad,fecha_eval,fecha_inscrip,inscrito_por,guardado_por,fecha_g) VALUES
			 ('$id_alum','$cod_anno_esc','$cod_plantel_proc','$cod_grado','$id_seccion','$arr_cod_asig_prog[$i]','$id_escolaridad','$fecha_eval','$fecha_g','$guardado_usuario','$guardado_usuario','$fecha_g')";
			//echo $cod_asig[$i]." - ".$chk_cod_mat[$i]."-".$ha[$i]." - ".$hp[$i]." - ".$orden[$i]."<br />";
			if (!mysql_query($sql_ins_alu,$conex)){$error_trans=true;$msg_err[]="No se guard&oacute; la inscripci&oacute;n de la asignatura ".$arr_cod_asig_prog[$i].": ".mysql_error($conex);}
} // FIN DEL ISSET CHK CODMAT 
} // FIN DEL FOR

//GUARDO LOS PROGRAMAS A INSCIRIBIR
for($i=0; $i < sizeof($arr_chk_cod_prog); $i++){ 
 	
	if(!isset($arr_chk_cod_prog[$i])){ $arr_chk_cod_prog[$i]='off';}
		if($arr_chk_cod_prog[$i]=='on'){
			$sql_ins_prog="INSERT INTO alum_insc_notas (id_personal,cod_anno_esc,cod_plantel_proc,cod_grado,id_seccion,cod_asig_prog,id_escolaridad,fecha_eval,fecha_inscrip,inscrito_por,guardado_por,fecha_g) VALUES
			 ('$id_alum','$cod_anno_esc','$cod_plantel_proc','$cod_grado','$id_seccion','$arr_cod_prog[$i]','$id_escolaridad','$fecha_eval','$fecha_g','$guardado_usuario','$guardado_usuario','$fecha_g')";
			//echo $cod_asig[$i]." - ".$chk_cod_mat[$i]."-".$ha[$i]." - ".$hp[$i]." - ".$orden[$i]."<br />";
			if (!mysql_query($sql_ins_prog,$conex)){$error_trans=true;$msg_err[]="No se guard&oacute; la inscripci&oacute;n del Programa de Educaci&oacute;n para el Trabajo ".$arr_cod_prog[$i].": ".mysql_error($conex);}
} // FIN DEL ISSET CHK CODMAT 
} // FIN DEL FOR

// verifico si es regular con materia pendiente y inscribo la asigntura pendiente tambien 
// pero con tipo evaluacion pendiente y tipo de materia pendiente
if ($id_escolaridad=="ESCRGP"){
	if (!empty($_POST["chk_asig_pend"])){
		$arr_chk_asig_pend=$_POST["chk_asig_pend"];
		$txt_cod_asig_pend=$_POST["txt_cod_asig_pend"];
	} else {
		echo mostrar_box("exc",false,"Advertencia","Debe seleccionar la(s) asignatura(s) pendiente(s) a inscribir");
		echo mostrar_btn_imp_reg();
		$arr_chk_asig_pend="";
		$txt_cod_asig_pend="";
	}

if (!empty($arr_chk_asig_pend)){
		$cmb_gra_pen=$_POST["cmb_gra_pen"];
		$cmb_secc_pend=$_POST["cmb_secc_pend"];
			 $sql_elim_mp="DELETE FROM alum_insc_notas 
			 WHERE 
			 id_personal='$id_alum' AND cod_anno_esc='$cod_anno_esc' AND cod_grado='$cmb_gra_pen'";
			 if (!mysql_query($sql_elim_mp,$conex)){$error_trans=true;$msg_err[]="No se pudo eliminar la inscripci&oacute;n anterior de la(s) asignatura(s) pendiente(s) del estudiante para registrar la nueva inscripci&oacute;n".mysql_error($conex);}
	
	for($i=0; $i < sizeof($arr_chk_asig_pend); $i++){ 
	if(!isset($arr_chk_asig_pend[$i])){ $arr_chk_asig_pend[$i]='off';}
		if($arr_chk_asig_pend[$i]=='on'){
			$cod_asi_pen=$txt_cod_asig_pend[$i];
			$sql_gua_asig_pen="INSERT INTO alum_insc_notas (id_personal,cod_anno_esc,cod_plantel_proc,cod_grado,id_seccion,cod_asig_prog,id_tip_eval,mat_pend,id_escolaridad,fecha_eval,fecha_inscrip,inscrito_por,guardado_por,fecha_g) VALUES
			 ('$id_alum','$cod_anno_esc','$cod_plantel_proc','$cmb_gra_pen','$cmb_secc_pend','$cod_asi_pen',3,1,'$id_escolaridad','$fecha_eval','$fecha_g','$guardado_usuario','$guardado_usuario','$fecha_g')";
	if (!mysql_query($sql_gua_asig_pen,$conex)){$error_trans=true;$msg_err[]="No se guard&oacute; la inscripci&oacute;n de la asignatura pendiente: ".mysql_error($conex);}
	}
	}
}
} // fin de si es regular con materia pendiente

//-------------ELIMINO RECAUDOS ANTERIORES Y AGREGO LOS NUEVOS -------- //
			 $sql_elim_reca="DELETE FROM alum_insc_recaud WHERE 
			 id_personal='$id_alum' AND cod_anno_esc='$cod_anno_esc' AND cod_grado='$cod_grado'";
			 if (!mysql_query($sql_elim_reca,$conex)){$error_trans=true;$msg_err[]="No se pudieron eliminar la consignaci&oacute;n de recaudos de la inscripci&oacute;n anterior del estudiante para registrar la nueva".mysql_error($conex);}

for($i=0; $i < sizeof($arr_chk_reca); $i++){ 
 	
	if(!isset($arr_chk_reca[$i])){$arr_chk_reca[$i]='off';}
		if($arr_chk_reca[$i]=='on'){
			$sql_gua_reca="INSERT INTO alum_insc_recaud (id_personal,cod_anno_esc,cod_grado,id_tip_recaudo,observaciones,guardado_por,fecha_g) VALUES
			 ('$id_alum','$cod_anno_esc','$cod_grado','$arr_cod_reca[$i]','$obs[$i]','$guardado_usuario','$fecha_g')";
			//echo $cod_asig[$i]." - ".$chk_cod_mat[$i]."-".$ha[$i]." - ".$hp[$i]." - ".$orden[$i]."<br />";
			if (!mysql_query($sql_gua_reca,$conex)){$error_trans=true;$msg_err[]="No se guard&oacute; la consignaci&oacute;n del recaudo: ".mysql_error($conex);}
} // FIN DEL ISSET CHK CODMAT 
} // FIN DEL FOR

//verifico que no hubo error y guardo la transaccion
 if (!$error_trans){
	  echo mostrar_box("suc",false,"NOTIFICACIÓN","La inscripci&oacute;n se efectu&oacute; correctamente");
		echo '<button onclick =" window.open(\'planilla_inscrip.php?cod_anno_esc='.$cod_anno_esc.'&tipo=window&id_alum='.$id_alum.'&cod_dea='.$cod_plantel_proc.'\',\'_blank\')" class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" >
<span class="ui-button-text"><img src="../images/icons_menu/x32/printer2_x32.png" align="absmiddle" height="20" width="20"> Ver planilla de inscripci&oacute;n</span>
</button>';

		mysql_query("COMMIT",$conex);
 } else {
	 	echo mostrar_box("exc",false,"NOTIFICACIÓN","No se pudo realizar la inscripci&oacute;n:</br>");
		echo "<p><pre style='font-size:12px' width='100%'>";
		print_r($msg_err);
		echo "</pre></p>";
		echo mostrar_btn_imp_reg();
	 	mysql_query("ROLLBACK",$conex);
 }

} // fin de si no es empty el post
} // fin funcion
?>
</html>