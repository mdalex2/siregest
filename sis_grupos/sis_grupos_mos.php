
 <?php
if (isset($_GET["id_mos"])){
	$consulta_edit=ejecuta_sql("select * from sis_grupos where id_grupo='".$_GET["id_mos"]."'",true);
if ($consulta_edit){
	date_default_timezone_set("America/Caracas");
	$registro=mysql_fetch_array($consulta_edit);
			$id_grupo=$registro["id_grupo"];
			$nom_gru_usu=$registro["nombre_grupo_usuario"];
	
		  if ($registro["visible"]==true){
				$visible="checked";
			} else {
				$visible="";
			}
			$notas=$registro["notas"];
?>                 
<form id="form_editar" name="form_editar" action="<?php echo "sis_grupos.php?id_func=".$_GET["id_func"]."&accion=modificar" ?>" method="post" enctype="multipart/form-data" class="uniForm">
<!-- Fieldset -->
  
<fieldset>
<legend>GRUPO DE USUARIO:</legend>

<table  width="..." border="0">
<tr>
<td colspan="2"><div class="ctrlHolder">
  <label for="txt_cod">C&oacute;digo del grupo de usuario</label>
  <br>
  <input name="txt_cod" type="text" autofocus class="validate[required,minSize[1]] text-input sf"  id="txt_cod" tabindex="0" value="<?php echo $id_grupo;?>" maxlength="6"/>
  <input type="hidden" name="txt_id_ant" value="<?php echo $id_grupo;?>" />
  <p class="formHint"> (*) Ejm: G1</p>
</div></td>
</tr>
<tr>
  <td>
    
  </td>
  <td></td>
  </tr>
<td colspan="2">
  
  <div class="ctrlHolder">
    <label for="txt_sis_grupos">Grupo de usuario</label> 
    <br>
    <input name="txt_sis_grupos" type="text" class="validate[required,minSize[3]] text-input mf"  id="txt_sis_grupos" tabindex="0" value="<?php echo $nom_gru_usu;?>" maxlength="30"  />
    <p class="formHint"> (*) Ejm: Administradores</p>
    
    </div>									
</td>
</tr>


<tr>
<td colspan="2">
  <div class="ctrlHolder message warning ui-icon-close" ><img id="usuario" src="../images/icons_menu/x32/vcard.png" width="32" height="32" align="absbottom"/>
      <label for="usuario"><?php echo "<b>GUARDADO:</b> ". $notas; ?></label>
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
  <button type="submit" formaction="<?php echo "sis_grupos.php?id_func=".$_GET["id_func"]."&accion=modificar" ?>" class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all">
  <span class="ui-button-text"><img src="../images/icons_menu/x32/save1_x32.png" width="20" height="20" align="absmiddle">&nbsp;Guardar cambios</span>
  </button>
  <?php } // cierro si permite crear=guardar ?>
  <?php 
if ($array_permisos["eliminar"]==true) { 
	$url_elim="sis_grupos.php?id_func=".$_GET["id_func"]."&accion=eliminar&id_elim=".$id_grupo;
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