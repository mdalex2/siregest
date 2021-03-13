
 <?php
if (isset($_GET["id_mos"])){
	$consulta_edit=ejecuta_sql("select grados_esc.*,datos_per.nombres,datos_per.apellidos from (grados_esc INNER JOIN datos_per on datos_per.id_personal=grados_esc.guardado_por) where cod_grado='".$_GET["id_mos"]."'",true);
if ($consulta_edit){
	date_default_timezone_set("America/Caracas");
	$registro=mysql_fetch_array($consulta_edit);
			$cod_gra=$registro["cod_grado"];
			$ann_gra_l=$registro["grado_letras"];
			$ann_gra_nl=$registro["grado_num_letra"];
			$ann_gra_m=$registro["grado_med"];
			$ann_gra_c=$registro["grado_corto"];
			$obs=$registro["observaciones"];
			$ord=$registro["orden"];

			$fecha_g=date("Y-m-d H:i:s",strtotime($registro["fecha_g"]));	 //fecha para guardar a mysql		
	
	if ($registro["visible"]==true){
		$visible="checked";
	} else {
		$visible="";
	}
	$guardado_por=strtoupper($registro["nombres"]." ".$registro["apellidos"]);
  $fecha_g=strtoupper(formato_fecha("LH",$registro["fecha_g"]));
?>                 
<form id="form_editar" name="form_editar" action="<?php echo "anno_grado.php?id_func=".$_GET["id_func"]."&accion=modificar" ?>" method="post" enctype="multipart/form-data" class="uniForm">
<!-- Fieldset -->
  
<fieldset>
<legend>A&Ntilde;O O GRADO:</legend>

<table  width="..." border="0">
<tr>
<td colspan="2">
  <div class="ctrlHolder">
    
    <label for="txt_cod">Cod. a&ntilde;o / grado</label>
    <br>
    <input name="txt_cod" type="text" autofocus class="validate[required,minSize[4]] text-input sf"  id="txt_cod" tabindex="0" value="<?php echo $cod_gra?>" maxlength="7"/>
    <input type="hidden" name="txt_id_mos_ant" value="<?php echo $cod_gra?>" />
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
  <input name="txt_ann_gra_l" type="text" class="validate[required,minSize[3]] text-input mf"  id="txt_ann_gra_l" tabindex="0" maxlength="50" value="<?php echo $ann_gra_l?>" />
  <p class="formHint"> (*) Descripci&oacute;n en letras ejm: Primer Grado</p>
    
  </div>									
</td>
<td><div class="ctrlHolder">
  <label for="txt_ann_gra_nl">A&ntilde;o / grado (numero y letras</label> 
  )<br>
  <input name="txt_ann_gra_nl" type="text" class="validate[required,minSize[3]] text-input sf"  id="txt_ann_gra_nl" tabindex="0" maxlength="50" value="<?php echo $ann_gra_nl?>" />
  <p class="formHint"> (*) Ejemplo: 1er Grado</p>
    
  </div></td>
</tr> 
<tr>
<td>
  
  <div class="ctrlHolder">
  <label for="txt_ann_gra_m">A&ntilde;o / grado (simbolo)</label> 
  <br>
  <input name="txt_ann_gra_m" type="text" class="validate[required,minSize[3]] text-input sf"  id="txt_ann_gra_m" tabindex="0" maxlength="50" value="<?php echo $ann_gra_m?>"/>
  <p class="formHint"> (*) Ejm: 1&deg; Grado</p>
    
  </div>									
</td>
<td><div class="ctrlHolder">
  <label for="txt_ann_gra_c">A&ntilde;o / grado (corto)</label> 
  <br>
  <input name="txt_ann_gra_c" type="text" class="validate[required,minSize[2]] text-input sf"  id="txt_ann_gra_c" tabindex="0" maxlength="50" value="<?php echo $ann_gra_c?>"/>
  <p class="formHint"> (*) Ejemplo: 1&deg;</p>
    
  </div></td>
</tr>
<tr>
  <td colspan="3">
    <div class="ctrlHolder">
      <label for="txt_obs">Notas</label>
      <br>
      <textarea name="txt_obs" id="txt_obs" rows="4" class='validate[optional,maxSize[200]] textarea_small'  style="width:99%"><?php echo $obs?></textarea>
      <p class="formHint"> Cualquier otra informaci&oacute;n importante</p>
      
      </div>  
    </td>
</tr>
<tr>
<td>
<div class="ctrlHolder">
      
  <label for="txt_ord">Orden</label>
  <br>
  <input name="txt_ord" type="text" autofocus class="validate[required,custom[integer]] text-input sf"  id="txt_ord" value="<?php echo $ord?>" maxlength="2"/>
  <p class="formHint"> (*) Escriba el numero para ordenar en los listados <br> tales como resumen final y certificaciones de notas</p>
  </div>
  </td>
<td >&nbsp;</td>
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
  <button type="submit" formaction="<?php echo "anno_grado.php?id_func=".$_GET["id_func"]."&accion=modificar" ?>" class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all">
  <span class="ui-button-text"><img src="../images/icons_menu/x32/save1_x32.png" width="20" height="20" align="absmiddle">&nbsp;Guardar cambios</span>
  </button>
  <?php } // cierro si permite crear=guardar ?>
  <?php 
if ($array_permisos["eliminar"]==true) { 
	$url_elim="anno_grado.php?id_func=".$_GET["id_func"]."&accion=eliminar&id_elim=".$cod_gra;
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