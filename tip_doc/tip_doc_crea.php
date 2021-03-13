<!DOCTYPE HTML>
<html>
<head>
<!-- Meta -->
<meta http-equiv="Content-Type" content="text/html; 
charset=<?php $_SESSION['juego_caracteres'];//esta variable se declara en modulo verificar login?>">
</head>
                  
<form id="form_crear" name="form_crear" action="<?php echo "tip_doc.php?id_func=".$_GET["id_func"]."&accion=guardar" ?>" method="post" enctype="multipart/form-data" class="uniForm">
<!-- Fieldset -->
  
<fieldset>
<legend>INGRESE LOS SIGUIENTES DATOS:</legend>

<table  width="..." border="0">
<tr>
<td colspan="2"><div class="ctrlHolder">
  <label for="txt_cod">C&oacute;digo del tipo de documento</label>
  <br>
  <input name="txt_cod" type="text" autofocus class="validate[required,minSize[4]] text-input sf"  id="txt_cod" tabindex="0" value="" maxlength="6"/>
  <p class="formHint"> (*) Ejm: CIS</p>
</div></td>
</tr>

<td>
  
  <div class="ctrlHolder">
    <label for="txt_tip_doc">Tipo de documento</label> 
    <br>
    <input name="txt_tip_doc" type="text" class="validate[required,minSize[3]] text-input mf"  id="txt_tip_doc" tabindex="0" maxlength="30"  />
    <p class="formHint"> (*) Ejm: N&deg; de c&eacute;dula venezolana</p>
    
    </div>									
</td>
<td><div class="ctrlHolder"> <br>
  <input name="chk_pon_num" id="chk_pon_num" type="checkbox" checked>
  <label for="chk_for_mill" title="Ejm: V-14771188">Poner numero</label>
  <p class="formHint"> Si se debe colocar el numero de identificaci&oacute;n en los reportes</p>
</div></td>
</tr>
<tr>
<td>
  
  <div class="ctrlHolder">
    <label for="txt_tip_doc">Tipo de documento (abreviado)</label> 
    <br>
    <input name="txt_tip_doc_abr" type="text" class="validate[optional] text-input ssf"  id="txt_tip_doc_abr" tabindex="0" maxlength="6"  />
    <p class="formHint"> (*) Ejm: V</p>
    
    </div>									
</td>
<td><div class="ctrlHolder">
      
  <label for="txt_sep">Separador</label>
  <br>
  <input name="txt_sep" type="text" autofocus class="validate[optional] text-input sf"  id="txt_sep" value="-" maxlength="2" title="Ejm: V-14771188"/>
  <input name="chk_for_mill" id="chk_for_mill" type="checkbox" checked>
  <label for="chk_for_mill" title="Ejm: 14.771.188">Formato millares</label>
  <p class="formHint"> (*)Ejm: - / \</p>
  </div></td>
</tr>
<tr>
<td>
<div class="ctrlHolder">
      
  <label for="txt_sep">Orden</label>
  <br>
  <input name="txt_ord" type="text" autofocus class="validate[required,custom[integer]] text-input sf"  id="txt_ord" value="0" maxlength="2"/>
  <p class="formHint"> (*) Escriba el n&uacute;mero para ordenar en los listados<br> tales como resumen final y certificaciones de notas</p>
  </div>
  </td>
<td></td>
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
<button type="submit" formaction="<?php echo "tip_doc.php?id_func=".$_GET["id_func"]."&accion=guardar" ?>" class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" id="btn_guardar">
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