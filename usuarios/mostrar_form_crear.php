<?php
function mostrar_form_usuario(){
if (!empty($_GET["id_usuario"])){
?>
<tr>
<td colspan="4">
<div class="ctrlHolder">

<label for="cmb_pro">Tipo de usuario</label>
<br>
<SELECT NAME="cmb_pro" id="cmb_pro" SIZE=1  class="lf validate[required]"  style="width:100%"> 
<option value="">SELECCIONE...</option>
<?php
	include_once("../funciones/funcionesPHP.php");
	$consulta=ejecuta_sql("select cod_tip_ocup,ocup_profesion from tip_ocup where visible=true order by ocup_profesion ASC",true);
	//si hay registros para mostrar
  if (!$consulta==false){
	while ($fila=mysql_fetch_array($consulta)){
		echo "<OPTION VALUE='".$fila['cod_tip_ocup']."'>".$fila["ocup_profesion"]."</OPTION>";
	}
	}
?></SELECT>
<p class="formHint"> (*) Seleccione el tipo de usuario</p>
</div>    
</td>
</tr>  
<tr>
<td colspan="4">
<div class="ctrlHolder">
<label for="txt_obs">Observaciones</label>
<br>
<textarea name="txt_obs" id="txt_obs" rows="4" class='validate[optional,maxSize[500]] textarea_small'  style="width:99%"></textarea>
<p class="formHint"> Cualquier otra informaci&oacute;n importante</p>

</div>  
</td>
</tr>
<tr><td colspan="4">
<?php if ($array_permisos["crear"]==true) { ?>         
<button type="submit" formaction="<?php echo "datos_per.php?id_func=".$_GET["id_func"]."&accion=guardar" ?>" class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" id="btn_guardar">
<span class="ui-button-text"><img src="../images/icons_menu/x32/save1_x32.png" width="20" height="20" align="absmiddle">&nbsp;Guardar</span>
</button>
<?php } // cierro si permite crear=guardar ?>

<button id="btn_reset" name="btn_reset" class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" type="reset" onclick="jQuery('#form1').validationEngine('hide');$('#txt_id_func').focus();">
<span class="ui-button-text"><img src="../images/icons_menu/x32/limpiar_x32.png" width="20" height="20" align="absmiddle"> Reestablecer</span>
</button>
</td>
</tr>
<?php 
}
}
?>