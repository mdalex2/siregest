<!DOCTYPE HTML>
<html>
<head>
<!-- Meta -->
<meta http-equiv="Content-Type" content="text/html; 
charset=<?php $_SESSION['juego_caracteres'];//esta variable se declara en modulo verificar login?>">
</head>
                  
<form id="form_crear" name="form_crear" action="<?php echo "dist_esc.php?id_func=".$_GET["id_func"]."&accion=guardar" ?>" method="post" enctype="multipart/form-data" class="uniForm">
<!-- Fieldset -->
  
<fieldset>
<legend>DISTRITO ESCOLAR:</legend>

<table  width="..." border="0">
<tr>
<td><div class="ctrlHolder">
<?php

$sql_estado="select * from terr_estados";
$consulta=ejecuta_sql($sql_estado,0);
?>
              <label for="cmb_tip_dir">Estado</label>
              <br>
              <SELECT NAME="cmb_estado" id="cmb_estado" SIZE=1  class="mf validate[required]"> 
                <option value="">SELECCIONE...</option>
                <?php 
if ($consulta && mysql_num_rows($consulta)>0){
while ($fila=mysql_fetch_array($consulta)) {
	?>
                <OPTION VALUE='<?php echo $fila['cod_estado_ter']?>' <?php if (isset($_POST["cmb_estado"]) && $_POST["cmb_estado"]==$fila['cod_estado_ter']){echo " selected";} ?>><?php echo $fila["estado_ter"]; ?></OPTION>";
<?php
	} // fin ciclo while
} // fin si hay mas registros >0
?>
              </SELECT>
              <p class="formHint"> Seleccione el estado territorial</p>
              
</div></td>
<td><div class="ctrlHolder">
  <label for="txt_num_dis">N&deg; de distrito</label>
  <br>
  <input name="txt_num_dis" type="text" autofocus class="validate[required,custom[integer]] text-input sf"  id="txt_num_dis" tabindex="0" value="" maxlength="7"/>
  <p class="formHint"> (*) Ejm: 5</p>
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
    <label for="txt_dis_esc">Distrito escolar</label> 
    <br>
    <input name="txt_dis_esc" type="text" class="validate[required,minSize[3]] text-input lf"  id="txt_dis_esc" tabindex="0" maxlength="60" style="width:98%" />
    <p class="formHint"> (*) Descripci&oacute;n en letras ejm: Distrito escola N&deg; 4 de la ciudad de Tovar</p>
    
    </div>									
</td>
</tr> 
<tr>
<td>
  
  <div class="ctrlHolder">
  <label for="txt_dis_esc_abr">Dist. escolar abreviado</label> 
  <br>
  <input name="txt_dis_esc_abr" type="text" class="validate[required,minSize[2]] text-input sf"  id="txt_dis_esc_abr" tabindex="0" maxlength="50" />
  <p class="formHint"> (*) Ejm: ME</p>
    
  </div>									
</td>
<td>&nbsp;</td>
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
  <td colspan="2"><div class="ctrlHolder" id="ctrl_estatus">
    <label for="chk_act">Estatus</label>
    <label for="chk_act">
      <input type="checkbox" name="chk_act" id="chk_act" class="active" checked>
      Habilitada</label>
    </div></td>
</tr>
<tr><td colspan="2">
<?php if ($array_permisos["crear"]==true) { ?>         
<button type="submit" formaction="<?php echo "dist_esc.php?id_func=".$_GET["id_func"]."&accion=guardar" ?>" class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" id="btn_guardar">
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