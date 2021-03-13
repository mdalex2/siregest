<!DOCTYPE HTML>
<html>
<head>
<!-- Meta -->
<meta http-equiv="Content-Type" content="text/html; 
charset=<?php $_SESSION['juego_caracteres'];//esta variable se declara en modulo verificar login?>">
</head>
                  
<form id="form_crear" name="form_crear" action="<?php echo "asignaturas.php?id_func=".$_GET["id_func"]."&accion=guardar" ?>" method="post" enctype="multipart/form-data" class="uniForm">
<!-- Fieldset -->
  
<fieldset>
<legend>CREAR ASIGNATURAS / PROGRAMAS:</legend>

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
<input id="txt_id_mos_ant" name="txt_id_mos_ant" type="hidden" value="">
<p class="formHint"> (*) Seleccione el tipo registro</p>
</div>            </td>
<td >
  <div class="ctrlHolder">
    
    <label for="txt_cod">Cod. asignatura</label>
    / programa<br>
    <input name="txt_cod" type="text" autofocus class="validate[required,minSize[4]] text-input sf"  id="txt_cod" tabindex="0" value="" maxlength="7"/>
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
  <input name="txt_asi_pro" type="text" class="validate[required,minSize[3]] text-input lf"  id="txt_asi_pro" tabindex="0" maxlength="50" style="width:100%"/>
  <p class="formHint"> (*) Escriba los nombres de la persona </p>
    
  </div>									
</td>
</tr> 
<tr>
<td colspan="2">
<div class="ctrlHolder"><label for="txt_med">Asignatura mediana</label><br>
  <input name="txt_med" type="text" autofocus class="validate[required,minSize[5]] text-input sf"  id="txt_med" maxlength="12"/>
  <p class="formHint"> (*) Ejm: CAST. LIT.</p>
  </div>
  </td>
<td >
 <div class="ctrlHolder">
      
  <label for="txt_abr">Abreviatura o iniciales</label>
  <br>
  <input name="txt_abr" type="text" autofocus class="validate[required,minSize[2]] text-input sf"  id="txt_abr" maxlength="2"/>
  <p class="formHint"> (*) Ejm: CL</p>
  </div> 
</td>
</tr> 
<tr>
<td>
<div class="ctrlHolder">
      
  <label for="txt_hor_max">Horas m&aacute;ximas semanales</label>
  <br>
  <input name="txt_hor_max" type="text" autofocus class="validate[required,custom[integer]] text-input sf"  id="txt_hor_max" value="0" maxlength="3"/>
  <p class="formHint"> (*) Ejm: 4</p>
  </div>
  </td>
<td><div class="ctrlHolder">
    
    <label for="txt_uc">Unidades de cr&eacute;dito</label>
    <br>
    <input name="txt_uc" type="text" autofocus class="validate[required,custom[integer]] text-input sf"  id="txt_uc" value="0" maxlength="4"/>
    <p class="formHint"> (*) Ejm: 4</p>
    </div></td>
<td >
<div class="ctrlHolder">
      
  <label for="txt_ord">Orden de aparicion en los informes</label>
  <br>
  <input name="txt_ord" type="text" autofocus class="validate[required,custom[integer]] text-input sf"  id="txt_ord" value="0" maxlength="4"/>
  <p class="formHint"> (*) Ejm: 0, escriba un numero para ordenar</p>
  </div>
</td>
</tr>
<tr>
  <td colspan="3">
    <div class="ctrlHolder">
      <label for="txt_obs">Observaciones</label>
      <br>
      <textarea name="txt_obs" id="txt_obs" rows="4" class='validate[optional,maxSize[500]] textarea_small'  style="width:99%"></textarea>
      <p class="formHint"> Cualquier otra informaci&oacute;n importante</p>
      
      </div>  
    </td>
</tr>
<tr>
<td colspan="3"><div class="ctrlHolder" id="ctrl_estatus">
                <label for="chk_act">Estatus</label>
                <label for="chk_act">
                  <input type="checkbox" name="chk_act" id="chk_act" class="active" checked>
                  Habilitada</label>
            </div></td>
          </tr>
<tr><td colspan="3">
<?php if ($array_permisos["crear"]==true) { ?>         
<button type="submit" formaction="<?php echo "asignaturas.php?id_func=".$_GET["id_func"]."&accion=guardar" ?>" class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" id="btn_guardar">
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