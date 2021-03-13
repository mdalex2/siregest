
 <?php
if (isset($_GET["id_mos"])){
	$consulta_edit=ejecuta_sql("select menc_edu.*,datos_per.nombres,datos_per.apellidos from (menc_edu INNER JOIN datos_per on datos_per.id_personal=menc_edu.guardado_por) where cod_mencion_educ='".$_GET["id_mos"]."'",true);
if ($consulta_edit){
	date_default_timezone_set("America/Caracas");
	$registro=mysql_fetch_array($consulta_edit);
			$cod_men=$registro["cod_mencion_educ"];
			$mencion=$registro["mencion"];
			$mencion_abr=$registro["mencion_abr"];
			$obs=$registro["observaciones"];
			$fecha_g=date("Y-m-d H:i:s",strtotime($registro["fecha_g"]));	 //fecha para guardar a mysql		
	
	if ($registro["visible"]==true){
		$visible="checked";
	} else {
		$visible="";
	}
	$guardado_por=strtoupper($registro["nombres"]." ".$registro["apellidos"]);
  $fecha_g=strtoupper(formato_fecha("LH",$registro["fecha_g"]));
?>                 
<form id="form_editar" name="form_editar" action="<?php echo "mencion_educ.php?id_func=".$_GET["id_func"]."&accion=modificar" ?>" method="post" enctype="multipart/form-data" class="uniForm">
<!-- Fieldset -->
  
<fieldset>
<legend>DATOS DE LA MENCI&Oacute;N:</legend>

<table  width="..." border="0">
<tr>
<td colspan="2">
  <div class="ctrlHolder">
    
    <label for="txt_cod">C&oacute;digo</label>
    <br>
    <input name="txt_cod" type="text" autofocus class="validate[required,minSize[5]] text-input sf"  id="txt_cod" tabindex="0" value="<?php echo $cod_men;?>" maxlength="6"/>
    <input type="hidden" name="txt_id_ant" value="<?php echo $cod_men;?>"  />
    <p class="formHint"> (*) Ejm: MENSCS</p>
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
    <label for="txt_men_edu">Menci&oacute;n</label>
    <br>
    <input name="txt_men_edu" type="text" class="validate[required,minSize[3]] text-input lf"  id="txt_men_edu" tabindex="0" value="<?php echo $mencion;?>" maxlength="50" />
    <p class="formHint"> (*) Ejm: Ciencias</p>
    
    </div>									
</td>
</tr> 
<tr>
<td>
  
  <div class="ctrlHolder">
  <label for="txt_men_edu_abr">Menci&oacute;n (abreviado)</label> 
  <br>
  <input name="txt_men_edu_abr" type="text" class="validate[required,minSize[2]] text-input ssf"  id="txt_men_edu_abr" tabindex="0" value="<?php echo $mencion_abr;?>" maxlength="3" />
  <p class="formHint"> (*) Ejm: CS</p>
    
  </div>									
</td>
<td>&nbsp;</td>
</tr>
<tr>
  <td colspan="3">
    <div class="ctrlHolder">
      <label for="txt_obs">Notas</label>
      <br>
      <textarea name="txt_obs" id="txt_obs" rows="4" class='validate[optional,maxSize[200]] textarea_small'  style="width:99%"><?php echo $obs;?></textarea>
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
<tr>
  <td colspan="2">
  <div class="ctrlHolder message warning ui-icon-close" ><img id="usuario" src="../images/icons_menu/x32/vcard.png" width="32" height="32" align="absbottom"/>
      <label for="usuario"><?php echo "<b>GUARDADO:</b> ".$guardado_por."<br><b>FECHA:</b> ".$fecha_g; ?></label>
      </div>
  </td>
</tr>
<tr><td colspan="2">
  <?php if ($array_permisos["editar"]==true) { ?>         
  <button type="submit" formaction="<?php echo "mencion_educ.php?id_func=".$_GET["id_func"]."&accion=modificar" ?>" class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all">
  <span class="ui-button-text"><img src="../images/icons_menu/x32/save1_x32.png" width="20" height="20" align="absmiddle">&nbsp;Guardar cambios</span>
  </button>
  <?php } // cierro si permite crear=guardar ?>
  <?php 
if ($array_permisos["eliminar"]==true) { 
	$url_elim="mencion_educ.php?id_func=".$_GET["id_func"]."&accion=eliminar&id_elim=".$cod_men;
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