<!DOCTYPE HTML>
<html>
<head>
<!-- Meta -->
<meta http-equiv="Content-Type" content="text/html; 
charset=<?php $_SESSION['juego_caracteres'];//esta variable se declara en modulo verificar login?>">
</head>
                  
<form id="form_crear" name="form_crear" action="<?php echo "anno_grado.php?id_func=".$_GET["id_func"]."&accion=guardar" ?>" method="post" enctype="multipart/form-data" class="uniForm">
<!-- Fieldset -->
  
<fieldset>
<legend>CREAR A&Ntilde;O O GRADO:</legend>

<table  width="..." border="0">
<tr>
<td colspan="2">
  <div class="ctrlHolder">
    
    <label for="txt_cod">Cod. a&ntilde;o / grado</label>
    / programa<br>
    <input name="txt_cod" type="text" autofocus class="validate[required,minSize[4]] text-input sf"  id="txt_cod" tabindex="0" value="" maxlength="7"/>
    <p class="formHint"> (*) Ejm: GRA01</p>
  </div></td>
</tr>
<tr>
  <td>
    
  </td>
  <td></td>
  </tr>
<tr>
<td>
  
  <div class="ctrlHolder">
  <label for="txt_ann_gra_l">A&ntilde;o / grado (letras)</label> 
  <br>
  <input name="txt_ann_gra_l" type="text" class="validate[required,minSize[3]] text-input mf"  id="txt_ann_gra_l" tabindex="0" maxlength="50" />
  <p class="formHint"> (*) Descripci&oacute;n en letras ejm: Primer Grado</p>
    
  </div>									
</td>
<td><div class="ctrlHolder">
  <label for="txt_ann_gra_nl">A&ntilde;o / grado (numero y letras</label> 
  )<br>
  <input name="txt_ann_gra_nl" type="text" class="validate[required,minSize[3]] text-input sf"  id="txt_ann_gra_nl" tabindex="0" maxlength="50" />
  <p class="formHint"> (*) Ejemplo: 1er Grado</p>
    
  </div></td>
</tr> 
<tr>
<td>
  
  <div class="ctrlHolder">
  <label for="txt_ann_gra_m">A&ntilde;o / grado (simbolo)</label> 
  <br>
  <input name="txt_ann_gra_m" type="text" class="validate[required,minSize[3]] text-input sf"  id="txt_ann_gra_m" tabindex="0" maxlength="50" />
  <p class="formHint"> (*) Ejm: 1&deg; Grado</p>
    
  </div>									
</td>
<td><div class="ctrlHolder">
  <label for="txt_ann_gra_c">A&ntilde;o / grado (corto)</label> 
  <br>
  <input name="txt_ann_gra_c" type="text" class="validate[required,minSize[2]] text-input sf"  id="txt_ann_gra_c" tabindex="0" maxlength="50" />
  <p class="formHint"> (*) Ejemplo: 1&deg;</p>
    
  </div></td>
</tr>
<tr>
  <td colspan="3">
    <div class="ctrlHolder">
      <label for="txt_obs">Notas</label>
      <br>
      <textarea name="txt_obs" id="txt_obs" rows="4" class='validate[optional,maxSize[200]] textarea_small'  style="width:99%"></textarea>
      <p class="formHint"> Cualquier otra informaci&oacute;n importante</p>
      
      </div>  
    </td>
</tr>
<tr>
<td>
<div class="ctrlHolder">
      
  <label for="txt_ord">Orden</label>
  <br>
  <input name="txt_ord" type="text" autofocus class="validate[required,custom[integer]] text-input sf"  id="txt_ord" value="0" maxlength="2"/>
  <p class="formHint"> (*) Escriba el numero para ordenar en los listados<br> tales como resumen final y certificaciones de notas</p>
  </div>
  </td>
<td >&nbsp;</td>
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
<button type="submit" formaction="<?php echo "anno_grado.php?id_func=".$_GET["id_func"]."&accion=guardar" ?>" class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" id="btn_guardar">
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