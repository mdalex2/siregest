<?php
//echo "<pre>".print_r($_POST)."</pre>";
//exit();
	include_once("../funciones/funcionesPHP.php");
	include_once("../funciones/conexion.php");
	if (!empty($_POST)  ){
		date_default_timezone_set("America/Caracas");
		$error_trans=false;
		$conex=conectarse();
		/*
		echo "cod_plan: $cod_pla_est</br>";
		echo "sector: $cod_sec</br>";
		echo "mencion: $cod_men</br>";
		echo "grado: $cod_gra</br>";
		*/
		$anno_esc_me=$_POST["txt_per_esc"];
		$cod_plantel=$_POST["txt_cod_pla"];
		$id_seccion=$_POST["txt_cod_secc"];
		$cod_asig_prog=$_POST["txt_cod_asig"];
		$arr_id_alum=$_POST["txt_id_alum"];
		$arr_L1=$_POST["txt_l1"];
		$arr_L2=$_POST["txt_l2"];
		$arr_L3=$_POST["txt_l3"];
		
		$arr_i1=$_POST["txt_i1"];
		$arr_i2=$_POST["txt_i2"];
		$arr_i3=$_POST["txt_i3"];
		
		$arr_rev=$_POST["txt_rev"];
		$arr_tip_eva=$_POST["cmb_tip_eva"];
		$arr_fec_eval=$_POST["txt_fec_eval"];
		//echo "<pre>".print_r($_POST)."</pre>";
		$fecha_g=date("Y-m-d H:i:s");	
		$guardado_por=$_SESSION["id_usuario"];
		//inicio la transaccion 
 if (!mysql_query("BEGIN",$conex)){$error_trans=true;$msg_err[]=mysql_error();} 
 
//inicio el repita para actualizar las notas
 for($i=0; $i < sizeof($arr_id_alum); $i++)
 { 
 	$fech_eval_formato=date("Y-m-d",strtotime($arr_fec_eval[$i]));
	$id_alumno=$arr_id_alum[$i];
	$sql_gua_calif="UPDATE alum_insc_notas SET 
	 n1=$arr_L1[$i],
	 n2=$arr_L2[$i],
	 n3=$arr_L3[$i],
	 i1=$arr_i1[$i],
	 i2=$arr_i2[$i],
	 i3=$arr_i3[$i],
	 rev='$arr_rev[$i]',
	 id_tip_eval=$arr_tip_eva[$i],
	 fecha_eval='$fech_eval_formato',
	 guardado_por='$guardado_por',
	 fecha_g='$fecha_g'
			WHERE
			id_personal='$id_alumno' 
			AND cod_anno_esc='$anno_esc_me' 
			AND cod_plantel_proc='$cod_plantel' 
			AND id_seccion='$id_seccion' 
			AND cod_asig_prog='$cod_asig_prog'";
			//echo $cod_docent_ocult[$i]." - ".$cod_docent_ocult[$i]."-".$ha[$i]." - ".$hp[$i]." - ".$orden[$i]."<br />";
			
			if (!mysql_query($sql_gua_calif,$conex)){$error_trans=true;$msg_err[]=mysql_error($conex);}
 } //fin del for
?>
 
<?php
 if (!$error_trans){
	  echo mostrar_box("suc",false,"NOTIFICACIÓN","Las calificaciones se guardaron correctamente");
		mysql_query("COMMIT",$conex);
 } else {
	 	echo mostrar_box("exc",false,"NOTIFICACIÓN","No se pudieron almacenar las calificaciones:</br>");
		echo "<h2><pre>";
		print_r($msg_err);
		echo "</pre></h2>";
		echo mostrar_btn_imp_reg();
	 	mysql_query("ROLLBACK",$conex);
 }
} else {
	echo mostrar_box("err",false,"DATOS NO RECIBIDOS","No se han recibido los datos de las calificaciones para guardar");
}

	?>

<table>
 <tr><td>
<?php if ($array_permisos["imprimir"]==true) { 
?>    
      <a href="<?php echo "registro_calif.php?id_func=".$_GET["id_func"]."&accion=buscar" ?>"  type="button" class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" style="font-size:10px;color:#0080C0;">
  <span class="ui-button-text"><img src="../images/sistema/lupa_hoja.png" align="absmiddle" height="24" width="24"> Buscar otra secci&oacute;n</span>
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