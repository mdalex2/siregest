
 <?php
if (isset($_GET["id_mos"])){
	$consulta_edit=ejecuta_sql("select anno_esc_me.*,datos_per.nombres,datos_per.apellidos from (anno_esc_me INNER JOIN datos_per on datos_per.id_personal=anno_esc_me.guardado_por) where cod_anno_esc='".$_GET["id_mos"]."'",true);
if ($consulta_edit){
	date_default_timezone_set("America/Caracas");
	$registro=mysql_fetch_array($consulta_edit);
			$cod_anno_esc=$registro["cod_anno_esc"];
			$descrip_anno_esc=$registro["descrip_anno_esc"];
			$fecha_ini=date("d-m-Y",strtotime($registro["fecha_inicio"]));
			$fecha_fin=date("d-m-Y",strtotime($registro["fecha_fin"]));
			$obs=$registro["observaciones"];
			$calif_min=$registro["calif_min"];
			$dias_habiles=$registro["dias_habiles"];
			$porcen_inas_aplazado=$registro["porcen_inas_aplazado"];
	if ($registro["visible"]==true){
		$visible="checked";
	} else {
		$visible="";
	}
	if ($registro["cerrado"]==true){
		$cerrado="checked";
	} else {
		$cerrado="";
	}	
	$guardado_por=strtoupper($registro["nombres"]." ".$registro["apellidos"]);
  $fecha_g=strtoupper(formato_fecha("LH",$registro["fecha_g"]));
?>                 
<form id="form_editar" name="form_editar" action="<?php echo "anno_esc_me.php?id_func=".$_GET["id_func"]."&accion=modificar" ?>" method="post" enctype="multipart/form-data" class="uniForm">
<!-- Fieldset -->
  
<fieldset>
<legend>A&Ntilde;O ESCOLAR:</legend>

<table  width="..." border="0">
<tr>
<td colspan="2">
  
  <div class="ctrlHolder">
    <label for="txt_cod">c&oacute;digo del a&ntilde;o escolar</label>
    <br>
    <input name="txt_cod" type="text" class="validate[required,minSize[9]] text-input sf"  id="txt_cod" tabindex="0" value="<?php echo $cod_anno_esc; ?>" maxlength="15" />
    <input type="hidden" name="txt_id_ant" value="<?php echo $cod_anno_esc; ?>" />
    <p class="formHint"> (*) Ejm: <?php echo date("Y");echo "-";echo date("Y")+1; ?></p>
    
    </div>									
</td>
</tr> 
<tr>
<td colspan="2">
  
  <div class="ctrlHolder">
    <label for="txt_cod">Descripci&oacute;n de a&ntilde;o escolar</label>
    <br>
    <input name="txt_ann_esc" type="text" class="validate[required,minSize[4]] text-input lf"  id="txt_ann_esc" tabindex="0" value="<?php echo $descrip_anno_esc; ?>" maxlength="30" />
    <p class="formHint"> (*) Ejm: <?php echo "A&Ntilde;O ESCOLAR ".date("Y");echo "-";echo date("Y")+1; ?></p>
    
    </div>									
</td>
</tr>
<tr>
<td>
  
  <div class="ctrlHolder">
<label for="txt_fin">Fecha inicio<br>
<input  name="txt_inicio" type="text" class="fecha_corta validate[custom[date],required]" id="txt_inicio" value="<?php echo $fecha_ini; ?>"  maxlength="10"/>
<!--<a name='txt_inicio' style="cursor:pointer;">
</a>-->
</label>
<p class="formHint"> (*) Formato dd-mm-yyyy</p>
<!-- SCRIPT PARA EL CALENDARIO-->
<script type="text/javascript">
$("#txt_inicio").datepicker({
showOn: "both",
regional:"es",
dateFormat: "dd-mm-yy",
minDate: new Date(1920, 1 - 1, 1), 
buttonImage: "../images/icons_menu/x32/calendario1_x32.png",
showButtonPanel: true,
buttonImageOnly: true,
changeYear: true,
numberOfMonths: 1,
}); 
</script>  

<!--FIN DEL CALENDARIO DESDE-->																		
</div>									
</td>
<td><div class="ctrlHolder">
<label for="txt_fin">Fecha culminaci&oacute;n<br>
<input  name="txt_fin" type="text" class="fecha_corta validate[custom[date],required]" id="txt_fin" value="<?php echo $fecha_fin; ?>"  maxlength="10" onChange="calcular_edad(this.value)"/>
<!--<a name='txt_inicio' style="cursor:pointer;">
</a>-->
</label>
<p class="formHint"> (*) Formato dd-mm-yyyy </p>
<!-- SCRIPT PARA EL CALENDARIO-->
<script type="text/javascript">
$("#txt_fin").datepicker({
showOn: "both",
regional:"es",
dateFormat: "dd-mm-yy",
minDate: new Date(1920, 1 - 1, 1), 
buttonImage: "../images/icons_menu/x32/calendario1_x32.png",
showButtonPanel: true,
buttonImageOnly: true,
changeYear: true,
numberOfMonths: 1,
}); 
</script>  

<!--FIN DEL CALENDARIO DESDE-->																		
</div>
</td>
</tr>
<tr>
  <td><div class="ctrlHolder">
    <label for="txt_cod">Calificaci&oacute;n minima</label>
    <br>
    <select name="txt_cal_min" id="txt_cal_min" class="cssf validate[required,custom[integer],min[1]]" size="1">
            <?php
						for ($cal=1;$cal<=20;$cal++){
						?>
            <option value="<?php echo $cal;?>" <?php if ($calif_min==$cal) echo " SELECTED ";?>><?php echo $cal;?></option>
            <?php
							}
						?>
            </select>
    <p class="formHint"> (*) Calificaci&oacute;n minima para aprobar cada asignatura</p>
    
    </div></td>
  <td><div class="ctrlHolder">
    <label for="cmb_porc_inas">D&iacute;as h&aacute;biles</label>
    <br>
    <select name="cmb_dias_hab" id="cmb_dias_hab" class="ssf validate[required]" size="1">
    <option value="">...</option>
            <?php
						for ($cal=1;$cal<=365;$cal++){
						?>
            <option value="<?php echo $cal;?>" <?php if ($dias_habiles==$cal) echo " SELECTED ";?>><?php echo $cal;?></option>
            <?php
							}
						?>
            </select>
    <p class="formHint"> (*) N&deg; de d&iacute;as escolares h&aacute;biles</p>
    
    </div></td>
</tr>
<tr>
  <td><div class="ctrlHolder">
    <label for="cmb_porc_inas">&#37 de inasistencias maximo</label>
    <br>
    <select name="cmb_porc_inas" id="cmb_porc_inas" class="ssf validate[required]" size="1">
    <option value="">...</option>
            <?php
						for ($cal=1;$cal<=100;$cal++){
						?>
            <option value="<?php echo $cal;?>" <?php if ($porcen_inas_aplazado==$cal) echo " SELECTED ";?>><?php echo $cal;?></option>
            <?php
							}
						?>
            </select>
    <p class="formHint"> (*) &#37 inasist. maximo por estudiante</p>
    
    </div></td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td colspan="3">
    <div class="ctrlHolder">
      <label for="txt_obs">Notas</label>
      <br>
      <textarea name="txt_obs" id="txt_obs" rows="4" class='validate[optional,maxSize[250]] textarea_small'  style="width:99%"><?php echo $obs; ?></textarea>
      <p class="formHint"> Cualquier otra informaci&oacute;n importante</p>
      
      </div>  
    </td>
</tr>
<tr>
  <td colspan="2"><div class="ctrlHolder" id="ctrl_estatus">
    <label for="chk_act">Estatus</label>
    <label for="chk_act">
      <input type="checkbox" name="chk_act" id="chk_act" class="active" <?php echo $visible;?>>
      Habilitada</label>
      <label for="chk_cerrado">
      <input type="checkbox" name="chk_cerrado" id="chk_cerrado" class="active" <?php echo $cerrado;?>>
      Cerrado</label>
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
  <button type="submit" formaction="<?php echo "anno_esc_me.php?id_func=".$_GET["id_func"]."&accion=modificar" ?>" class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all">
  <span class="ui-button-text"><img src="../images/icons_menu/x32/save1_x32.png" width="20" height="20" align="absmiddle">&nbsp;Guardar cambios</span>
  </button>
  <?php } // cierro si permite crear=guardar ?>
  <?php 
if ($array_permisos["eliminar"]==true) { 
	$url_elim="anno_esc_me.php?id_func=".$_GET["id_func"]."&accion=eliminar&id_elim=".$cod_anno_esc;
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