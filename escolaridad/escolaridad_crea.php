<!DOCTYPE HTML>
<html>
<head>
<!-- Meta -->
<meta http-equiv="Content-Type" content="text/html; 
charset=<?php $_SESSION['juego_caracteres'];//esta variable se declara en modulo verificar login?>">
</head>
                  
<form id="form_crear" name="form_crear" action="<?php echo "escolaridad.php?id_func=".$_GET["id_func"]."&accion=guardar" ?>" method="post" enctype="multipart/form-data" class="uniForm">
<!-- Fieldset -->
  
<fieldset>
<legend>ESCOLARIDAD:</legend>

<table  width="..." border="0">
<tr>
<td colspan="2"><div class="ctrlHolder">
  <label for="txt_cod">C&oacute;digo</label>
  <br>
  <input name="txt_cod" type="text" autofocus class="validate[required,minSize[4]] text-input sf"  id="txt_cod" tabindex="0" value="" maxlength="6"/>
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
    <input name="txt_esc" type="text" class="validate[required,minSize[3]] text-input lf"  id="txt_esc" tabindex="0" maxlength="100"  />
    <p class="formHint"> (*) Ejm: REGULAR</p>
    
    </div>									
</td>
</tr>
<tr>
<td colspan="2">
  
  <div class="ctrlHolder">
  <label for="txt_esc_abr">Escolaridad (abreviada)</label><br>
    <input name="txt_esc_abr" type="text" class="validate[required,minSize[2]] text-input ssf"  id="txt_esc_abr" tabindex="0" maxlength="3"  />
    <p class="formHint"> (*) Ejm: REG</p>
    
    </div>									
</td>
</tr>
<tr>
  <td colspan="2">
    <div class="ctrlHolder">
      <label for="txt_obs">Notas</label>
      <br>
      <textarea name="txt_obs" id="txt_obs" rows="4" class='validate[optional,maxSize[200]] textarea_small'  style="width:99%"></textarea>
      <p class="formHint"> Cualquier otra informaci&oacute;n importante</p>
      
      </div>  
    </td>
</tr>
<tr>
  <td colspan="2"><div class="ctrlHolder" id="ctrl_estatus">
    <label for="chk_act">Estatus</label>
    <label for="chk_act">
      <input type="checkbox" name="chk_act" id="chk_act" class="active" checked>
      Habilitada</label>
    </div></td>
</tr>
<tr><td colspan="2">
<?php if ($array_permisos["crear"]==true) { ?>         
<button type="submit" formaction="<?php echo "escolaridad.php?id_func=".$_GET["id_func"]."&accion=guardar" ?>" class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" id="btn_guardar">
<span class="ui-button-text"><img src="../images/icons_menu/x32/save1_x32.png" width="20" height="20" align="absmiddle">&nbsp;Guardar</span>
</button>
<?php } // cierro si permite crear=guardar ?>

<button id="btn_reset" name="btn_reset" class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" type="reset" onclick="jQuery('#form1').validationEngine('hide');$('#txt_id_func').focus();">
<span class="ui-button-text"><img src="../images/icons_menu/x32/limpiar_x32.png" width="20" height="20" align="absmiddle"> Reestablecer</span>
</button>
</td>
</tr>
</table>
</fieldset>
<!-- End of fieldset -->
</form> 
<!-- FIN DEL FORM DATOS PERSONALES -->

</html>