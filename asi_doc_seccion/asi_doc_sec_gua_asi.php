<?php
	include_once("../funciones/funcionesPHP.php");
	include_once("../funciones/conexion.php");
	if (!empty($_POST)  ){
  if(!isset($_REQUEST['cmb_doc_ocu'])){
		mostrar_box("inf",false,"Información","No se han seleccionado las materias o asignaturas que desea agregar al plan de estudio, debe seleccionar al menos una asignatura");
		echo mostrar_btn_imp_reg();
  }else{
		date_default_timezone_set("America/Caracas");
		$error=false;
		$conex=conectarse();
		/*
		echo "cod_plan: $cod_pla_est</br>";
		echo "sector: $cod_sec</br>";
		echo "mencion: $cod_men</br>";
		echo "grado: $cod_gra</br>";
		*/
    $cod_asig = $_REQUEST['txt_cod_asig_ocu'];
    $cod_docent_ocult = $_REQUEST['cmb_doc_ocu'];
		$id_docent_guia=$_REQUEST['cmb_prof_guia'];
		$cod_año_escolar=$_REQUEST['txt_cod_anno_esc_ocu'];
		$id_seccion=$_REQUEST["txt_id_sec_ocu"];
		$obs=$_REQUEST["txt_obs_ocu"];
		$fecha_g=date("Y-m-d H:i:s");	
		$guardado_por=$_SESSION["id_usuario"];
		//inicio la transaccion y elimino las configuraciones viejas
 if (!mysql_query("BEGIN",$conex)){$error=true;$msg_err[]=mysql_error();} 
 			//$sql_elim="delete from asi_doc_sec where".
			//" cod_anno_esc='$cod_año_escolar' and ".
			//" id_seccion='$id_seccion'";
			$sql_elim="DELETE asi_doc_sec.* FROM asi_doc_sec INNER JOIN asig_prog ON asig_prog.cod_asig_prog=asi_doc_sec.cod_asig_prog WHERE asig_prog.tip_asig='AS' AND cod_anno_esc='$cod_año_escolar' and ".
" id_seccion='$id_seccion'";
			 

			//verifico si se produjo error para deshacer los cambios
			if (!mysql_query($sql_elim,$conex)){$error=true;$msg_err[]=mysql_error();}
 for($i=0; $i < sizeof($cod_docent_ocult); $i++)
 { 
 	if(!isset($cod_docent_ocult[$i])){ $cod_docent_ocult[$i]='';}
		if($cod_docent_ocult[$i]!=''){
			$sql_ins_asi="INSERT INTO asi_doc_sec (cod_anno_esc,id_seccion,cod_asig_prog, 	id_profesor,observaciones,id_docente_guia,guardado_por,fecha_g) VALUES
			 ('$cod_año_escolar','$id_seccion','$cod_asig[$i]','$cod_docent_ocult[$i]','$obs[$i]','$id_docent_guia','$guardado_por','$fecha_g')";
			//echo $cod_docent_ocult[$i]." - ".$cod_docent_ocult[$i]."-".$ha[$i]." - ".$hp[$i]." - ".$orden[$i]."<br />";
			if (!mysql_query($sql_ins_asi,$conex)){$error=true;$msg_err[]=mysql_error();}
		} 

 }
 if (!$error){
	  echo mostrar_box("suc",false,"NOTIFICACIÓN","La asignaci&oacute;n de docentes a la secci&oacute;n se efectu&oacute; correctamente");
 ?>
 <table>
 <tr><td>
<?php if ($array_permisos["imprimir"]==true) { 
?>    
      <a href="asi_doc_sec_rep.php?id_secc=<?php echo $id_seccion;?>&cod_anno_esc=<?php echo $cod_año_escolar;?>" type="button" class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" target="_blank" onclick="submit()" style="font-size:10px;color:#0080C0;">
  <span class="ui-button-text"><img src="../images/icons_menu/x32/printer2_x32.png" align="absmiddle" height="24" width="24"> Generar reporte</span>
  </a>
 
      <?php } // cierro si permite crear=guardar ?>
  </td>
  <td>
<button class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" onclick="javascript:history.back(1)">
<span class="ui-button-text"><img src="../images/icons_menu/x32/atras_azul.png" align="absmiddle" height="24" width="24"> Ir atr&aacute;s</span>
</button>
</td>
</tr>
</table>
<?php
		mysql_query("COMMIT",$conex);
 } else {
	 	echo mostrar_box("err",false,"NOTIFICACIÓN","Error al aplicar la asignaci&oacute;n de docentes a la secci&oacute;n:</br>");
		echo "<h2><pre>";
		print_r($msg_err);
		echo "</pre></h2>";
		echo mostrar_btn_imp_reg();
	 	mysql_query("ROLLBACK",$conex);
 }
}
}

	?>
