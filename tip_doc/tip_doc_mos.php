
 <?php
if (isset($_GET["id_mos"])){
	$consulta_edit=ejecuta_sql("select * from tip_doc_per where cod_tip_doc_per='".$_GET["id_mos"]."'",true);
if ($consulta_edit){
	date_default_timezone_set("America/Caracas");
	$registro=mysql_fetch_array($consulta_edit);
			$cod_tip_doc_per=$registro["cod_tip_doc_per"];
			$tipo_doc=$registro["tipo_doc"];
			$tipo_doc_abr=$registro["tipo_doc_abr"];
			$separador=$registro["separador"];
			$observaciones=$registro["observaciones"];
			$orden=$registro["orden"];
	
		  if ($registro["poner_num"]==true){
				$poner_num="checked";
			} else {
				$poner_num="";
			}
		  if ($registro["num_con_punto"]==true){
				$num_con_punto="checked";
			} else {
				$num_con_punto="";
			}			if ($registro["visible"]==true){
				$visible="checked";
			} else {
				$visible="";
			}
?>                 
<form id="form_editar" name="form_editar" action="<?php echo "tip_doc.php?id_func=".$_GET["id_func"]."&accion=modificar" ?>" method="post" enctype="multipart/form-data" class="uniForm">
<!-- Fieldset -->
  
<fieldset>
<legend>TIPO DE DOCUMENTO:</legend>

<table  width="..." border="0">
<tr>
<td colspan="2"><div class="ctrlHolder">
  <label for="txt_cod">C&oacute;digo del tipo de documento</label>
  <br>
  <input name="txt_cod" type="text" autofocus class="validate[required,minSize[4]] text-input sf"  id="txt_cod" tabindex="0" value="<?php echo $cod_tip_doc_per;?>" maxlength="6"/>
  <input type="hidden" name="txt_id_ant" value="<?php echo $cod_tip_doc_per;?>" />
  <p class="formHint"> (*) Ejm: CIS</p>
</div></td>
</tr>
<tr>
  <td>
    
  </td>
  <td></td>
  </tr>
<td>
  
  <div class="ctrlHolder">
    <label for="txt_tip_doc">Tipo de documento</label> 
    <br>
    <input name="txt_tip_doc" type="text" class="validate[required,minSize[3]] text-input mf"  id="txt_tip_doc" tabindex="0" value="<?php echo $tipo_doc?>" maxlength="30"  />
    <p class="formHint"> (*) Ejm: N&deg; de c&eacute;dula venezolana</p>
    
    </div>									
</td>
<td><div class="ctrlHolder"> <br>
  <input name="chk_pon_num" id="chk_pon_num" type="checkbox" <?php echo $poner_num;?>>
  <label for="chk_pon_num" title="Ejm: V-14771188">Poner numero</label>
  <p class="formHint"> Si se debe colocar el numero de identificaci&oacute;n en los reportes</p>
</div></td>
</tr>
<tr>
<td>
  
  <div class="ctrlHolder">
    <label for="txt_tip_doc">Tipo de documento (abreviado)</label> 
    <br>
    <input name="txt_tip_doc_abr" type="text" class="validate[optional] text-input ssf"  id="txt_tip_doc_abr" tabindex="0" value="<?php echo $tipo_doc_abr?>" maxlength="6"  />
    <p class="formHint"> (*) Ejm: V</p>
    
    </div>									
</td>
<td><div class="ctrlHolder">
      
  <label for="txt_sep">Separador</label>
  <br>
  <input name="txt_sep" type="text" autofocus class="validate[optional] text-input sf"  id="txt_sep" value="<?php echo $separador?>" maxlength="2" title="Ejm: V-14771188"/>
  <input name="chk_for_mill" id="chk_for_mill" type="checkbox" <?php echo $num_con_punto;?>>
  <label for="chk_for_mill" title="Ejm: 14.771.188">Formato millares</label>
  <p class="formHint"> (*)Ejm: - / \</p>
  </div></td>
</tr>
<tr>
<td>
<div class="ctrlHolder">
      
  <label for="txt_ord">Orden</label>
  <br>
  <input name="txt_ord" type="text" autofocus class="validate[required,custom[integer]] text-input sf"  id="txt_ord" value="<?php echo $orden;?>" maxlength="2"/>
  <p class="formHint"> (*) Escriba el numero para ordenar en los listados<br> tales como resumen final y certificaciones de notas</p>
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
  <button type="submit" formaction="<?php echo "tip_doc.php?id_func=".$_GET["id_func"]."&accion=modificar" ?>" class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all">
  <span class="ui-button-text"><img src="../images/icons_menu/x32/save1_x32.png" width="20" height="20" align="absmiddle">&nbsp;Guardar cambios</span>
  </button>
  <?php } // cierro si permite crear=guardar ?>
  <?php 
if ($array_permisos["eliminar"]==true) { 
	$url_elim="tip_doc.php?id_func=".$_GET["id_func"]."&accion=eliminar&id_elim=".$cod_tip_doc_per;
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