<form action="<?php echo "registro_calif.php?id_func=".$_GET["id_func"]."&accion=guardar" ?>" method="post" enctype="multipart/form-data" name="frm_calif" id="frm_calif" target="_self">
<fieldset>
<legend>DATOS DE LA SECCI&Oacute;N - ASIGNATURA</legend> 
<?php
include_once("../funciones/funcionesPHP.php");
		if (!empty($_POST["cmb_secc"])){
			$id_seccion=$_POST["cmb_secc"];
			$cod_asig=$_POST["cmb_asig"];
			$cod_grado=$_POST["cmb_gra"];
			$cod_anno_esc=$_POST["cmb_anno_esc"];
			$cod_plantel=$_POST["cmb_plan"];
			
		}
		$consulta_secc=ejecuta_sql("select  inst_secciones.cod_plantel,inst_secciones.id_plan_nivel_est,inst_secciones.cod_mencion_educ,inst_secciones.cod_grado,inst_secciones.id_sector_educ,id_seccion,seccion_largo,seccion_corto,inst_secciones.fecha_g,grados_esc.grado_letras,inst_secciones.visible,menc_edu.mencion,plan_est_tip.nivel_plan_est,sectores_educ.sector_educ,instituciones.den_plantel from (inst_secciones 
		INNER JOIN grados_esc on grados_esc.cod_grado=inst_secciones.cod_grado
		INNER JOIN menc_edu ON menc_edu.cod_mencion_educ=inst_secciones.cod_mencion_educ
				INNER JOIN plan_est_tip ON plan_est_tip.id_plan_nivel_est=inst_secciones.id_plan_nivel_est
		INNER JOIN sectores_educ ON sectores_educ.id_sector_educ=inst_secciones.id_sector_educ
		INNER JOIN instituciones ON instituciones.cod_plantel=inst_secciones.cod_plantel

		) where inst_secciones.id_seccion='$id_seccion' LIMIT 1",true);
		if ($consulta_secc){
			$filas_secc=mysql_fetch_array($consulta_secc)
			
?>

<table width="100%" border="0">
  <tr>
    <td colspan="3"><div class="ctrlHolder" style="margin:0px;">
     <p class="formHint" style="margin:0px;">Plantel:<input type="hidden" name="txt_cod_pla" value="<?php echo $_POST["cmb_plan"]; ?>" /></p>
    <label><b><?php echo $filas_secc["den_plantel"]." (".$filas_secc["sector_educ"].")";?></b></label>
    <br>
   
  </div>
  </td>
    <td><div class="ctrlHolder" style="margin:0px;">
     <p class="formHint" style="margin:0px;">Menci&oacute;n:</p>
    <label><b><?php echo $filas_secc["mencion"];?></b></label>
    <br></div></td>
  </tr>
  <tr>
    <td><div class="ctrlHolder">
      <p class="formHint" style="margin:0px;">Periodo escolar:
        <input type="hidden" name="txt_per_esc" value="<?php echo $cod_anno_esc; ?>" />
      </p>
      <label><b><?php echo $_POST["cmb_anno_esc"];?></b></label>
      <br />
    </div></td>
    <td><div class="ctrlHolder">
      <p class="formHint" style="margin:0px;">A&ntilde;o o grado:</p>
      <label><b><?php echo $filas_secc["grado_letras"];?></b></label>
      <br />
    </div></td>
    <td><div class="ctrlHolder">
     <p class="formHint" style="margin:0px;">Secci&oacute;n:</p>
     <input type="hidden" name="txt_cod_secc" id="txt_cod_secc" value="<?php echo $id_seccion;?>" />
    <label><b><?php echo $filas_secc["seccion_largo"];?></b></label>
    <br></div></td>
    <td>
<div class="ctrlHolder" style="margin:0px;">
     <p class="formHint" style="margin:0px;">Plan de estudio:</p>
    <label><b><?php echo $filas_secc["nivel_plan_est"];?></b></label>
    <br>
   
  </div>    
    </td>
  </tr>
  <tr>
    <td colspan="2"><div class="ctrlHolder" style="margin:0px;">
     <p class="formHint" style="margin:0px;">ASIGNATURA:<input type="hidden" name="txt_cod_asig"  id="txt_cod_asig"  value="<?php echo $cod_asig; ?>" /></p>
    <label><b><?php if (!empty($_POST["txt_nom_asig"])) echo $_POST["txt_nom_asig"]; else echo "NO DEFINIDA";;?></b></label>
    <br></div></td>
    <td colspan="2"><div class="ctrlHolder" style="margin:0px;">
    <?php
		$sql_bus_docent="SELECT datos_per.nombres,datos_per.apellidos FROM ( asi_doc_sec 
		INNER JOIN datos_per ON datos_per.id_personal=asi_doc_sec.id_profesor
		) WHERE	cod_anno_esc='$cod_anno_esc' AND  	id_seccion='$id_seccion' AND cod_asig_prog='$cod_asig'";
		$consult_docent=ejecuta_sql($sql_bus_docent,false);
		$docente="";
		if ($consult_docent){
			$fila_docente=mysql_fetch_array($consult_docent);
			$docente=$fila_docente["nombres"]." ".$fila_docente["apellidos"];
		}
		?>
      <p class="formHint" style="margin:0px;">DOCENTE:
        <input type="hidden" name="txt_ano_gra" value="<?php echo $filas_secc["cod_grado"]; ?>" /></p>
      <label><b><?php echo $docente;?></b></label>
      <br></div></td>
    </tr>
</table>
</fieldset>
<!-- FIN FIELD DE RESUMEN DE ECNCABEZADO DE ASIGNATURA - SECCION -->
<fieldset>
<legend>ESTUDIANTES DE LA SECCI&Oacute;N</legend>
<table id="tabla_alumnos" class="mouse_hover" style="font-size:11px;">
	<thead>
  <tr>
    <th width="80px">N&deg; C&Eacute;DULA</th>
    <th width="...">APELLIDOS Y NOMBRES</th>
    <th title="Calificaci&oacute;n del primer lapso" width="50px">LAP.1</th>
    <th title="Calificaci&oacute;n del segundo lapso">LAP.2</th>
    <th title="Calificaci&oacute;n del tercer lapso">LAP.3</th>
    <th width="50px" title="N&deg; de inasistencias en el primero lapso">INA.1</th>
    <th title="N&deg; de inasistencias en el segundo lapso">INA.2</th>
    <th title="N&deg; de inasistencias en el tercer lapso">INA.3</th>
    <th width="50px" title="Calificaci&oacute;n de revisi&oacute;n">REV.</th>
    <th title="Tipo de evaluaci&oacute;n">TIP. EVA.</th>
    <th title="Fecha de evaluaci&oacute;n">FECHA EVAL.</th>
  </tr>    
  </thead>
<tbody>
<?php
$sql_alumnos="SELECT 
alum_insc_notas.id_personal,
n1,n2,n3,i1,i2,i3,rev,
id_tip_eval,
tip_doc_per.tipo_doc,
tip_doc_per.tipo_doc_abr,
tip_doc_per.poner_num,
tip_doc_per.separador,
tip_doc_per.num_con_punto,
datos_per.num_identificacion,datos_per.nombres,datos_per.apellidos,
fecha_eval  
FROM (alum_insc_notas 
INNER JOIN datos_per ON datos_per.id_personal=alum_insc_notas.id_personal
INNER JOIN tip_doc_per ON tip_doc_per.cod_tip_doc_per=datos_per.cod_tip_doc_per
)
WHERE alum_insc_notas.cod_anno_esc='$cod_anno_esc' AND alum_insc_notas.id_seccion='$id_seccion' AND alum_insc_notas.cod_asig_prog='$cod_asig'
ORDER BY datos_per.apellidos,datos_per.nombres ASC";
$cons_alumnos=ejecuta_sql($sql_alumnos,true);
$ig=-1;
if ($cons_alumnos){
	while ($fila_alum=mysql_fetch_array($cons_alumnos)){
		$ig++;
		$id_alumno=$fila_alum["id_personal"];
		$num_id_per=$fila_alum["num_identificacion"];
		$tipo_doc_abr=$fila_alum["tipo_doc_abr"];
		$poner_num=$fila_alum["poner_num"];
		$separador=$fila_alum["separador"];
		$num_con_punto=$fila_alum["num_con_punto"];
		$apellidos_nombres=$fila_alum["apellidos"]." ".$fila_alum["nombres"];
		//calificaciones de lapsos BD
		$l1_bd=$fila_alum["n1"];
		$l2_bd=$fila_alum["n2"];
		$l3_bd=$fila_alum["n3"];
		$cr_bd=$fila_alum["rev"]; //calificacion revision
		
		//inasistencias BD
		$i1_bd=$fila_alum["i1"];
		$i2_bd=$fila_alum["i2"];
		$i3_bd=$fila_alum["i3"];	
		
		$tip_eva_bd=$fila_alum["id_tip_eval"];
		$fecha_eval=date("d-m-Y",strtotime($fila_alum["fecha_eval"]));
?>
<tr>
  <td><input type="hidden" name="txt_id_alum[<?PHP echo $ig?>]" id="txt_id_alum[<?PHP echo $ig?>]" value="<?php echo $id_alumno;?>" /><?php echo formatear_id_personal($num_id_per,$tipo_doc_abr,$poner_num,$separador,$num_con_punto); ?></td>
  <td><?php echo $apellidos_nombres;?></td>
  <td align="center"><select name="txt_l1[<?PHP echo $ig?>]" id="txt_l1[<?PHP echo $ig?>]" class="cssf validate[required,custom[integer],min[0],max[20]]" size="1" title="Calificaci&oacute;n del primer lapso">
    <option value="0">0</option>
    <option value="1" <?php if (1==$l1_bd) echo " selected=selected ";?>>I</option> 
    <?php
						for ($l1=2;$l1<=20;$l1++){
						?>
    <option value="<?php echo $l1;?>" <?php if ($l1==$l1_bd) echo " selected=selected ";?>><?php echo $l1;?></option>
    <?php
							}
						?>        
  </select></td>
  <td align="center"><select name="txt_l2[<?PHP echo $ig?>]" id="txt_l2[<?PHP echo $ig?>]" class="cssf validate[required,custom[integer],min[0],max[20]]" size="1" title="Calificaci&oacute;n del segundo lapso">
  <option value="0">0</option>
  <option value="1" <?php if (1==$l2_bd) echo " selected=selected ";?>>I</option> 
  <?php
						for ($l2=2;$l2<=20;$l2++){
						?>
    <option value="<?php echo $l2;?>" <?php if ($l2==$l2_bd) echo " selected=selected ";?>><?php echo $l2;?></option>
    <?php
							}
						?>
  </select></td>
  <td align="center"><select name="txt_l3[<?PHP echo $ig?>]" id="txt_l3[<?PHP echo $ig?>]" class="cssf validate[required,custom[integer],min[0],max[20]]" size="1" title="Calificaci&oacute;n del tercer lapso">
<option value="0">0</option>
<option value="1" <?php if (1==$l3_bd) echo " selected=selected ";?>>I</option> 
    <?php
						for ($l3=2;$l3<=20;$l3++){
						?>
    <option value="<?php echo $l3;?>" <?php if ($l3==$l3_bd) echo " selected=selected ";?>><?php echo $l3;?></option>
    <?php
							}
						?>
             
  </select></td>
  <td align="center"><input name="txt_i1[<?PHP echo $ig?>]" id="txt_i1[<?PHP echo $ig?>]" type="text" class="validate[required,custom[integer],min[0],max[365]] text-input ssf" value="<?php echo $i1_bd;?>" maxlength="3" title="N&deg; de inasistencias en el primero lapso"/></td>
  <td width="50px" align="center" style="margin:0px;"><input name="txt_i2[<?PHP echo $ig?>]" id="txt_i2[<?PHP echo $ig?>]" type="text" class="validate[required,custom[integer],min[0],max[365]] text-input ssf" value="<?php echo $i2_bd;?>" maxlength="3"  title="N&deg; de inasistencias en el segundo lapso"/></td>
  <td width="50px" align="center"><input name="txt_i3[<?PHP echo $ig?>]" id="txt_i3[<?PHP echo $ig?>]" type="text" class="validate[required,custom[integer],min[0],max[365]] text-input ssf" value="<?php echo $i3_bd;?>" maxlength="3" title="N&deg; de inasistencias en el tercer lapso"/></td>
  <td align="center"><select name="txt_rev[<?PHP echo $ig?>]" id="txt_rev[<?PHP echo $ig?>]" class="cssf validate[required,custom[integer],min[0],max[20]]" size="1" title="Calificaci&oacute;n de revisi&oacute;n">
    <?php
						for ($cr=0;$cr<=20;$cr++){
						?>
    <option value="<?php echo $cr;?>" <?php if ($cr==$cr_bd) echo " selected=selected ";?>><?php echo $cr;?></option>
    <?php
							}
						?>
  </select></td>
  <td width="50px" align="center"><div class="ctrlHolder">
  <SELECT NAME="cmb_tip_eva[<?PHP echo $ig?>]" id="cmb_tip_eva[<?PHP echo $ig?>]" SIZE=1 class="sf validate[required] tooltip" style="width:98%"> 
  <option value="">SELECCIONE...</option>
  <?php
	$consulta=ejecuta_sql("select id_tip_eval ,tipo_evaluacion,tipo_evaluacion_abrev from tip_eval_calif where visible=true order by tipo_evaluacion ASC",true);
	//si hay registros para mostrar
  if (!$consulta==false){
	while ($fila=mysql_fetch_array($consulta)){
if ($tip_eva_bd==$fila['id_tip_eval']){$seleccionado= " SELECTED=SELECTED ";} else {$seleccionado= "";};				
		echo "<OPTION VALUE='".$fila['id_tip_eval']."' $seleccionado>".$fila["tipo_evaluacion"]."</OPTION>";
	}
	}
?>
  </SELECT>
  </div></td>
  <td width="50px" align="center"><input  name="txt_fec_eval[<?PHP echo $ig;?>]" type="text" class="fecha_corta validate[custom[date],required]" id="txt_fec_eval[<?PHP echo $ig;?>]" value="<?php echo $fecha_eval;?>"  maxlength="10"/>    
  </td>
</tr>
<?php
	} //fin while
} //fin if consulta alumnos
?>
</tbody>
</table>
</fieldset>
<?php
		} // fin de si hubo consulta de seccion
?>
<?php if ($array_permisos["crear"]==true) { ?>         
<button type="submit" formaction="<?php echo "registro_calif.php?id_func=".$_GET["id_func"]."&accion=guardar" ?>" class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all tooltip" id="btn_guardar" title="Guardar calificaciones">
<span class="ui-button-text"><img src="../images/icons_menu/x32/save1_x32.png" width="20" height="20" align="absmiddle">&nbsp;Guardar</span>
</button>
<?php } // cierro si permite crear=guardar ?>
<button id="btn_reg" name="btn_reg" class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" type="reset" onclick="jQuery('#frm_calif').validationEngine('hide');javascript:history.go(-1);">
<span class="ui-button-text"><img src="../images/icons_menu/x32/atras_azul.png" width="20" height="20" align="absmiddle"> Regresar</span>
</button>&nbsp;
<button id="btn_reset" name="btn_reset" class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" type="reset" onclick="jQuery('#frm_calif').validationEngine('hide');">
<span class="ui-button-text"><img src="../images/icons_menu/x32/limpiar_x32.png" width="20" height="20" align="absmiddle"> Deshacer cambios</span>
</button>
</form>
