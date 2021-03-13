
 <?php
if (isset($_GET["id_mos"])){
	$consulta_edit=ejecuta_sql("select * from escolaridad where id_escolaridad='".$_GET["id_mos"]."'",true);
if ($consulta_edit){
	date_default_timezone_set("America/Caracas");
	$registro=mysql_fetch_array($consulta_edit);
			$cod_esc=$registro["id_escolaridad"];
			$escolaridad=$registro["escolaridad"];
			$escolaridad_abrev=$registro["escolaridad_abrev"];
			$observaciones=$registro["observaciones"];
	
			if ($registro["visible"]==true){
				$visible="checked";
			} else {
				$visible="";
			}
?>                 
<form id="form_editar" name="form_editar" action="<?php echo "escolaridad.php?id_func=".$_GET["id_func"]."&accion=modificar" ?>" method="post" enctype="multipart/form-data" class="uniForm">
<!-- Fieldset -->
  
<fieldset>
<legend>ESCOLARIDAD:</legend>

<table  width="..." border="0">
<tr>
<td colspan="2"><div class="ctrlHolder">
  <label for="txt_cod">C&oacute;digo</label>
  <br>
  <input name="txt_cod" type="text" autofocus class="validate[required,minSize[4]] text-input sf"  id="txt_cod" tabindex="0" value="<?php echo $cod_esc;?>" maxlength="6"/>
  <input type="hidden" name="txt_id_ant" value="<?php echo $cod_esc;?>" />
  <p class="formHint"> (*) Ejm: ESCREG</p>
</div></td>
</tr>
<tr>
  <td>
    
  </td>
  <td></td>
  </tr>
<tr>
<td colspan="2">
  
  <div class="ctrlHolder">
  <label for="txt_esc">Escolaridad</label><br>
    <input name="txt_esc" type="text" class="validate[required,minSize[3]] text-input lf"  id="txt_esc" tabindex="0" value="<?php echo $escolaridad;?>" maxlength="100"  />
    <p class="formHint"> (*) Ejm: REGULAR</p>
    
    </div>									
</td>
</tr>
<tr>
<td colspan="2">
  
  <div class="ctrlHolder">
    <label for="txt_esc_abr">Escolaridad (abreviada)</label><br>

    <input name="txt_esc_abr" type="text" class="validate[required,minSize[2]] text-input ssf"  id="txt_esc_abr" tabindex="0" value="<?php echo $escolaridad_abrev;?>" maxlength="3"  />
    <p class="formHint"> (*) Ejm: REG</p>
    
    </div>									
</td>
</tr>
<tr>
  <td colspan="2">
    <div class="ctrlHolder">
      <label for="txt_obs">Notas</label>
      <br>
      <textarea name="txt_obs" id="txt_obs" rows="4" class='validate[optional,maxSize[200]] textarea_small'  style="width:99%"><?php echo $observaciones;?></textarea>
      <p class="formHint"> Cualquier otra informaci&oacute;n importante</p>
      
      </div>  
    </td>
</tr>
<tr>
  <td colspan="2"><div class="ctrlHolder" id="ctrl_estatus">
    <label for="chk_act">Estatus</label>
    <label for="chk_act">
      <input type="checkbox" name="chk_act" id="chk_act" class="active" <?php echo $visible?>>
      Habilitada</label>
    </div></td>
</tr>
<tr><td colspan="2">
  <?php if ($array_permisos["editar"]==true) { ?>         
  <button type="submit" formaction="<?php echo "escolaridad.php?id_func=".$_GET["id_func"]."&accion=modificar"; ?>" class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all">
  <span class="ui-button-text"><img src="../images/icons_menu/x32/save1_x32.png" width="20" height="20" align="absmiddle">&nbsp;Guardar cambios</span>
  </button>
  <?php } // cierro si permite crear=guardar ?>
  <?php 
if ($array_permisos["eliminar"]==true) { 
	$url_elim="escolaridad.php?id_func=".$_GET["id_func"]."&accion=eliminar&id_elim=".$cod_esc;
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
</table>
</fieldset>
<!-- End of fieldset -->
</form> 
<?php
  } //cierro si se encontro la consulta y si no hubo error
	}  //cierro si se envio por url el id a mostrar
?>