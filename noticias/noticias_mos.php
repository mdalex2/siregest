
 <?php
if (isset($_GET["id_mos"])){
	$consulta_edit=ejecuta_sql("select noticias.*,datos_per.nombres,datos_per.apellidos from (noticias INNER JOIN datos_per on datos_per.id_personal=noticias.id_usuario_not) where id_noticia='".$_GET["id_mos"]."'",true);
if ($consulta_edit){
	date_default_timezone_set("America/Caracas");
	$registro=mysql_fetch_array($consulta_edit);
	$id_noticia=$registro["id_noticia"];
	$titulo=$registro["titulo"];
	$contenido=$registro["contenido"];
	if ($registro["visible"]==true){
		$visible="checked";
	} else {
		$visible="";
	}
	$guardado_por=strtoupper($registro["nombres"]." ".$registro["apellidos"]);
  $fecha_g=strtoupper(formato_fecha("LH",$registro["fecha_publicacion"]));
?>                 
<form id="form_editar" name="form_editar" action="<?php echo "noticias.php?id_func=".$_GET["id_func"]."&accion=modificar" ?>" method="post" enctype="multipart/form-data" class="uniForm">
<!-- Fieldset -->
  
<fieldset>
<legend>PUBLICAR NOTICIA:</legend>

<table  width="..." border="0">
<tr>
<td colspan="2">
  
  <div class="ctrlHolder">
    <label for="txt_tit">T&iacute;tulo de la noticia</label>
    <br>
    <input name="txt_tit" type="text" class="validate[required,minSize[9]] text-input lf"  id="txt_tit" tabindex="0" value="<?php echo $titulo; ?>" maxlength="400" />
    <input type="hidden" name="txt_id_ant" value="<?php echo $id_noticia; ?>" />
    <p class="formHint"> (*) Ejm: Entrega de notas primer lapso</p>
    
    </div>									
</td>
</tr>
<tr>
  <td colspan="3">
    <div class="ctrlHolder">
      <label for="txt_con">Contenido</label>
      <br>
      
      <textarea id="txt_con" name="txt_con" rows="15" cols="80" style="width: 80%"><?php echo $contenido; ?></textarea>
      <p class="formHint"> Cualquier otra informaci&oacute;n importante</p>
      
      </div>  
    </td>
</tr>
<tr>
  <td colspan="2"><div class="ctrlHolder" id="ctrl_estatus">
    <label for="chk_act">Estatus</label>
    <label for="chk_act">
      <input type="checkbox" name="chk_act" id="chk_act" class="active" <?php echo $visible;?>>
      Publicada</label>
    </div></td>
</tr>
<tr>
  <td colspan="2">
  <div class="ctrlHolder message warning ui-icon-close" ><img id="usuario" src="../images/icons_menu/x32/vcard.png" width="32" height="32" align="absbottom"/>
      <label for="usuario"><?php echo "<b>GUARDADO:</b> ".$guardado_por."<br><b>FECHA:</b> ".$fecha_g; ?></label>
      </div>
  </td>
</tr>
<tr><td>
  <?php if ($array_permisos["editar"]==true) { ?>         
  <button type="submit" formaction="<?php echo "noticias.php?id_func=".$_GET["id_func"]."&accion=modificar" ?>" class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all">
  <span class="ui-button-text"><img src="../images/icons_menu/x32/save1_x32.png" width="20" height="20" align="absmiddle">&nbsp;Guardar cambios</span>
  </button>
  <?php } // cierro si permite crear=guardar ?>

  <button id="btn_reset" name="btn_reset" class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" type="reset" onclick="jQuery('#form1').validationEngine('hide');$('#txt_id_func').focus();">
  <span class="ui-button-text"><img src="../images/icons_menu/x32/limpiar_x32.png" width="20" height="20" align="absmiddle"> Reestablecer</span>
  </button>
  </td>
  <td>  <?php 
if ($array_permisos["eliminar"]==true) { 
	$url_elim="noticias.php?id_func=".$_GET["id_func"]."&accion=eliminar&id_elim=".$id_noticia;
?>

  <a href="<?php echo $url_elim;?>" type="button"  class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" onclick="return confirmElim()">
  <span class="ui-button-text"><img src=../images/icons_menu/x32/elim_papelera_x32.png width="20" height="20" align="absmiddle">&nbsp;Eliminar</span>
  </a>
  <?php 
} 
//fin de si muestra boton elminar
?></td>
</tr>

</table>
</fieldset>
<!-- End of fieldset -->
</form> 
<?php
  } //cierro si se encontro la consulta y si no hubo error
	}  //cierro si se envio por url el id a mostrar
?>