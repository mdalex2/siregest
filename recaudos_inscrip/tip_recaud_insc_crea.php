<!DOCTYPE HTML>
<html>
<head>
<!-- Meta -->
<meta http-equiv="Content-Type" content="text/html; 
charset=<?php $_SESSION['juego_caracteres'];//esta variable se declara en modulo verificar login?>">
</head>
                  
<form id="form_crear" name="form_crear" action="<?php echo "tip_recaud_insc.php?id_func=".$_GET["id_func"]."&accion=guardar" ?>" method="post" enctype="multipart/form-data" class="uniForm">
<!-- Fieldset -->
  
<fieldset>
<legend>CREAR REAUDO PARA INSCRIPCI&Oacute;N:</legend>

<table  width="..." border="0">
<tr>
<td colspan="2">
  <div class="ctrlHolder">
<label for="cmb_gra">Grado - a&ntilde;o</label>
<br>
<SELECT name="cmb_gra" id="cmb_gra" SIZE=1 class="mf"> 
<?php
	include_once("../funciones/funcionesPHP.php");
	$consulta=ejecuta_sql("select cod_grado,grado_letras from grados_esc order by orden ASC",false);
	//si hay registros para mostrar
  if (!$consulta==false){
	while ($fila=mysql_fetch_array($consulta)){
		echo "<OPTION VALUE='".$fila['cod_grado']."'>".$fila["grado_letras"]."</OPTION>";
	}
	}
?>
</SELECT>
<p class="formHint"> (*) Requerido</p>
</div><div class="ctrlHolder" id="ctrl_estatus">
    <label for="chk_tod">
      <input type="checkbox" name="chk_tod" id="chk_tod" class="active" title="Si el recaudo sera solicitado en la inscripci&oacute;n para todos los a&ntilde;os o grados">
      Para todos los grados o a&ntilde;os</label>
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
    <label for="txt_reca">Descripci&oacute;n recaudo</label> 
    <br>
    <input name="txt_reca" type="text" class="validate[required,minSize[3]] text-input lf"  id="txt_reca" tabindex="0" maxlength="50" value="" />
    <p class="formHint"> (*) Ejm: copia de c&eacute;dula</p>
    
    </div>									
</td>
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
      <input type="checkbox" name="chk_act" id="chk_act" class="active">
      Habilitada</label>
    </div></td>
</tr>
<tr><td colspan="2">
  <?php if ($array_permisos["editar"]==true) { ?>         
  <button type="submit" formaction="<?php echo "tip_recaud_insc.php?id_func=".$_GET["id_func"]."&accion=guardar" ?>" class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all">
    <span class="ui-button-text"><img src="../images/icons_menu/x32/save1_x32.png" width="20" height="20" align="absmiddle">&nbsp;Guardar </span>
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