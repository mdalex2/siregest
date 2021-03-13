
 <?php
if (isset($_GET["id_mos"])){
	$consulta_edit=ejecuta_sql("select asig_prog.*,datos_per.nombres,datos_per.apellidos from (asig_prog INNER JOIN datos_per on datos_per.id_personal=asig_prog.guardado_por) where cod_asig_prog='".$_GET["id_mos"]."'",true);
if ($consulta_edit){
	date_default_timezone_set("America/Caracas");
	$registro=mysql_fetch_array($consulta_edit);
	$cod_asig=$registro["cod_asig_prog"];
	$tip_asig=$registro["tip_asig"];
	$asignatura=$registro["des_mat_prog"];
	$asi_med=$registro["mat_prog_med"];
	$asi_abr=$registro["mat_prog_cor"];
  $uc=$registro["uc"];
	$orden=$registro["orden"];
	$horas_max_sem=strtoupper($registro["horas_max_sem"]);
	if ($registro["visible"]==true){
		$visible="checked";
	} else {
		$visible="";
	}
	$guardado_por=strtoupper($registro["nombres"]." ".$registro["apellidos"]);
  $fecha_g=strtoupper(formato_fecha("LH",$registro["fecha_g"]));
	$observaciones=$registro["observaciones"];
?>                 
<form id="form_editar" name="form_editar" action="<?php echo "asignaturas.php?id_func=".$_GET["id_func"]."&accion=modificar" ?>" method="post" enctype="multipart/form-data" class="uniForm">
<!-- Fieldset -->
  
<fieldset>
<legend>ASIGNATURA O PROGRAMA:</legend>

<table  width="..." border="0">
<tr>
<td colspan="2">

<div class="ctrlHolder">
<label for="cmb_tip">Tipo </label>
<br>
<SELECT NAME="cmb_tip" SIZE=1 class="sf validate[required]" id="cmb_tip">
<OPTION VALUE="AS" <?php if (isset($tip_asig) && $tip_asig=="AS") echo " selected " ?>>ASIGNATURA</OPTION>
<OPTION VALUE="PR" <?php if (isset($tip_asig) && $tip_asig=="PR") echo " selected " ?>>PROGRAMA</OPTION>
<OPTION VALUE="OT" <?php if (isset($tip_asig) && $tip_asig=="OT") echo " selected " ?>>OTRO</OPTION>
 
</SELECT>
<input id="txt_id_mos_ant" name="txt_id_mos_ant" type="hidden" value="<?php echo $cod_asig;?>">
<p class="formHint"> (*) Seleccione el tipo registro</p>
</div>            </td>
<td >
  <div class="ctrlHolder">
    
    <label for="txt_cod">Cod. asignatura</label>
    / programa<br>
    <input name="txt_cod" type="text" autofocus class="validate[required,minSize[4]] text-input sf"  id="txt_cod" tabindex="0" value="<?php echo $cod_asig;?>" maxlength="7"/>
    <p class="formHint"> (*) Ejm: ASCL</p>
    </div>
</td>
</tr>
<tr>
  <td colspan="2">
    
  </td>
  <td></td>
  </tr>
<tr>
<td colspan="3" width="50">
  
  <div class="ctrlHolder">
  <label for="txt_asi_pro">Asignatura o programa</label><br>
  <input name="txt_asi_pro" type="text" class="validate[required,minSize[3]] text-input lf"  id="txt_asi_pro" tabindex="0" value="<?php echo $asignatura; ?>" maxlength="50" style="width:100%"/>
  <p class="formHint"> (*) Escriba los nombres de la persona </p>
    
  </div>									
</td>
</tr> 
<tr>
<td colspan="2">
<div class="ctrlHolder">
      
  <label for="txt_med">Abreviatura o iniciales</label>
  <br>
  <input name="txt_med" type="text" autofocus class="validate[required,minSize[2]] text-input sf"  id="txt_med" value="<?php echo $asi_med;?>" maxlength="2"/>
  <p class="formHint"> (*) Ejm: CL</p>
  </div>
  </td>
<td>
<div class="ctrlHolder">
      
  <label for="txt_med">Abreviatura o iniciales</label>
  <br>
  <input name="txt_abr" type="text" autofocus class="validate[required,minSize[2]] text-input sf"  id="txt_abr" value="<?php echo $asi_abr;?>" maxlength="2"/>
  <p class="formHint"> (*) Ejm: CL</p>
  </div></td>
</tr> 
<tr>
<td>
<div class="ctrlHolder">
      
  <label for="txt_hor_max">Horas m&aacute;ximas semanales</label>
  <br>
  <input name="txt_hor_max" type="text" autofocus class="validate[required,custom[integer]] text-input sf"  id="txt_hor_max" value="<?php echo $horas_max_sem;?>" maxlength="3"/>
  <p class="formHint"> (*) Ejm: 4</p>
  </div>
  </td>
<td><div class="ctrlHolder">
    
    <label for="txt_uc">Unidades de cr&eacute;dito</label>
    <br>
    <input name="txt_uc" type="text" autofocus class="validate[required,custom[integer]] text-input sf"  id="txt_uc" value="<?php echo $uc;?>" maxlength="4"/>
    <p class="formHint"> (*) Ejm: 4</p>
    </div></td>
<td >
<div class="ctrlHolder">
      
  <label for="txt_ord">Orden de aparicion en los informes</label>
  <br>
  <input name="txt_ord" type="text" autofocus class="validate[required,custom[integer]] text-input sf"  id="txt_ord" value="<?php echo $orden;?>" maxlength="4"/>
  <p class="formHint"> (*) Ejm: 0, escriba un numero para ordenar</p>
  </div>
</td>
</tr>
<tr>
  <td colspan="4">
    <div class="ctrlHolder">
      <label for="txt_obs">Observaciones</label>
      <br>
      <textarea name="txt_obs" id="txt_obs" rows="4" class='validate[optional,maxSize[500]] textarea_small'  style="width:99%"><?php echo $observaciones; ?></textarea>
      <p class="formHint"> Cualquier otra informaci&oacute;n importante</p>
      
      </div>  
    </td>
</tr>
<tr>
<td colspan="2"><div class="ctrlHolder" id="ctrl_estatus">
                <label for="chk_act">Estatus</label>
                <label for="chk_act">
                  <input type="checkbox" name="chk_act" id="chk_act" class="active" <?php echo $visible; ?>>
                  Habilitada</label>
            </div></td>
<td>
  
</td>
</tr>

<tr><td colspan="3">
  <?php if ($array_permisos["editar"]==true) { ?>         
  <button type="submit" formaction="<?php echo "asignaturas.php?id_func=".$_GET["id_func"]."&accion=modificar" ?>" class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all">
  <span class="ui-button-text"><img src="../images/icons_menu/x32/save1_x32.png" width="20" height="20" align="absmiddle">&nbsp;Guardar cambios</span>
  </button>
  <?php } // cierro si permite crear=guardar ?>
  <?php 
if ($array_permisos["eliminar"]==true) { 
	$url_elim="asignaturas.php?id_func=".$_GET["id_func"]."&accion=eliminar&id_elim=".$cod_asig;
?>

  <button onclick="if (confirm_elim()){window.location='<?php echo $url_elim;?>';}" type="button"  class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all">
  <span class="ui-button-text"><img src=../images/icons_menu/x32/elim_papelera_x32.png width="20" height="20" align="absmiddle">&nbsp;Eliminar</span>
  </button>
  <?php 
} 
//fin de si muestra boton elminar
?>
  <button id="btn_reset" name="btn_reset" class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" type="reset" onclick="jQuery('#form1').validationEngine('hide');$('#txt_id_func').focus();">
  <span class="ui-button-text"><img src="../images/icons_menu/x32/limpiar_x32.png" width="20" height="20" align="absmiddle"> Reestablecer</span>
  </button>
  </td>
</tr>
<tr>
  <td colspan="3">&nbsp;</td>
</tr>
<tr>
  <td colspan="3">
  <div class="ctrlHolder message warning ui-icon-close" ><img id="usuario" src="../images/icons_menu/x32/vcard.png" width="32" height="32" align="absbottom"/>
      <label for="usuario"><?php echo "<b>GUARDADO:</b> ".$guardado_por."<br><b>FECHA:</b> ".$fecha_g; ?></label>
      </div>
  </td>
</tr>
</table>
</fieldset>
<!-- End of fieldset -->
</form> 
<?php
  } //cierro si se encontro la consulta y si no hubo error
	}  //cierro si se envio por url el id a mostrar
?>