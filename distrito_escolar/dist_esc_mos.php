
 <?php
if (isset($_GET["id_mos"])){
	$consulta_edit=ejecuta_sql("select dis_esc.*,datos_per.nombres,datos_per.apellidos from (dis_esc INNER JOIN datos_per on datos_per.id_personal=dis_esc.guardado_por) where id_dis_esc='".$_GET["id_mos"]."'",true);
if ($consulta_edit){
	date_default_timezone_set("America/Caracas");
	$registro=mysql_fetch_array($consulta_edit);
			$id_dis_esc=$registro["id_dis_esc"];
			$cod_edo_ter=$registro["cod_estado_ter"];
			$num_dis=$registro["num_dist"];
			$dis_esc=$registro["dis_esc"];
			$dis_esc_abr=$registro["dis_esc_abr"];
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
<form id="form_editar" name="form_editar" action="<?php echo "dist_esc.php?id_func=".$_GET["id_func"]."&accion=modificar" ?>" method="post" enctype="multipart/form-data" class="uniForm">
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
                <OPTION VALUE='<?php echo $fila['cod_estado_ter']?>' <?php if ($fila['cod_estado_ter']==$cod_edo_ter){echo " selected";} ?>><?php echo $fila["estado_ter"]; ?></OPTION>";
<?php
	} // fin ciclo while
} // fin si hay mas registros >0
?>
              </SELECT>
              <input type="hidden" name="txt_id_ant" value="<?php echo $id_dis_esc;?>" />
              <p class="formHint"> Seleccione el estado territorial</p>
              
</div></td>
<td><div class="ctrlHolder">
  <label for="txt_num_dis">N&deg; de distrito</label>
  <br>
  <input name="txt_num_dis" type="text" autofocus class="validate[required,custom[integer]] text-input sf"  id="txt_num_dis" tabindex="0" value="<?php echo $num_dis; ?>" maxlength="7"/>
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
    <input name="txt_dis_esc" type="text" class="validate[required,minSize[3]] text-input lf"  id="txt_dis_esc" style="width:98%" tabindex="0" value="<?php echo $dis_esc; ?>" maxlength="60" />
    <p class="formHint"> (*) Descripci&oacute;n en letras ejm: Distrito escola N&deg; 4 de la ciudad de Tovar</p>
    
    </div>									
</td>
</tr> 
<tr>
<td>
  
  <div class="ctrlHolder">
  <label for="txt_dis_esc_abr">Dist. escolar abreviado</label> 
  <br>
  <input name="txt_dis_esc_abr" type="text" class="validate[required,minSize[2]] text-input sf"  id="txt_dis_esc_abr" tabindex="0" value="<?php echo $dis_esc_abr; ?>" maxlength="50" />
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
      <textarea name="txt_obs" id="txt_obs" rows="4" class='validate[optional,maxSize[200]] textarea_small'  style="width:99%"><?php echo $obs; ?></textarea>
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
  <button type="submit" formaction="<?php echo "dist_esc.php?id_func=".$_GET["id_func"]."&accion=modificar" ?>" class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all">
  <span class="ui-button-text"><img src="../images/icons_menu/x32/save1_x32.png" width="20" height="20" align="absmiddle">&nbsp;Guardar cambios</span>
  </button>
  <?php } // cierro si permite crear=guardar ?>
  <?php 
if ($array_permisos["eliminar"]==true) { 
	$url_elim="dist_esc.php?id_func=".$_GET["id_func"]."&accion=eliminar&id_elim=".$id_dis_esc;
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