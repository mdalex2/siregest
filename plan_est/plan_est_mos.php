
 <?php

if (!empty($_GET["id_mos"])){
	$id_mos=$_GET["id_mos"];
	$consulta_edit=ejecuta_sql("select plan_est_tip.*,
		datos_per.nombres,
		datos_per.apellidos 
		from (plan_est_tip  
		INNER JOIN datos_per on plan_est_tip.guardado_por=datos_per.id_personal 
		) where id_plan_nivel_est='$id_mos' ORDER BY nivel_plan_est ASC",true);
if ($consulta_edit){
	$registro=mysql_fetch_array($consulta_edit);
	$id_pla_est=$registro["id_plan_nivel_est"];
	$cod_pla_est_me=$registro["cod_plan_nivel_me"];
	$pla_est=$registro["nivel_plan_est"];
	if ($registro["visible"]==true){
		$vis="checked";
	} else {
		$vis="";
	}
	$guardado_por=strtoupper($registro["nombres"]." ".$registro["apellidos"]);
	$fecha_pub=date("d-m-Y",strtotime($registro["fecha_pub"]));
  $fecha_g=strtoupper(formato_fecha("LH",$registro["fecha_g"]));
	$not=$registro["notas"];
?>                 
<form id="form_editar" name="form_editar" action="<?php echo "plan_est.php?id_func=".$_GET["id_func"]."&accion=modificar" ?>" method="post" enctype="multipart/form-data" class="uniForm">
<!-- Fieldset -->
  
<fieldset>
<legend>PLAN DE ESTUDIO:</legend>

<table  width="100%" border="0">
<tr>
<td>
<div class="ctrlHolder">
      
  <label for="txt_cod">C&oacute;digo plan de estudio</label>
  <br>
  <input name="txt_cod" type="text" autofocus class="validate[required,minSize[4]] text-input sf"  id="txt_cod" tabindex="0" value="<?php echo $cod_pla_est_me;?>" maxlength="7"/>
  <input type="hidden" id="txt_id_mos_ant" name="txt_id_mos_ant" value="<?php echo $id_pla_est;?>" />
  <p class="formHint"> (*) C&oacute;digo del plan de estudio suministrado por el ME. Ejm: 32011</p>
  </div>
</td>
</tr>
<tr>
  <td colspan="2">
				<label for="txt_fecha">Fecha publicaci&oacute;n<br>
					<input name="txt_fecha" type="text" class="fecha_corta validate[required,custom[date]]" id="txt_fecha" value="<?php if (!empty($fecha_pub)) {echo $fecha_pub;}?>"  maxlength="10"/>
						<a name='txt_fecha1' style="cursor:pointer;">
						</a>
				</label>
				<!-- SCRIPT PARA EL CALENDARIO-->
          <script type="text/javascript">
					$("#txt_fecha").datepicker({
   					showOn: "both",
						regional:"es",
						dateFormat: "dd-mm-yy",
						minDate: new Date(1900, 1 - 1, 1), 
   					buttonImage: "../images/icons_menu/x32/calendario1_x32.png",
						showButtonPanel: true,
   					buttonImageOnly: true,
   					changeYear: true,
   					numberOfMonths: 1,
						onClose: function(dateText, inst) {
						var endDateTextBox = $("#txt_fecha");
								if (endDateTextBox.val() != "") {
										var testStartDate = new Date(dateText);
										var testEndDate = new Date(endDateTextBox.val());
										if (testStartDate > testEndDate)
												endDateTextBox.val(dateText);
								}
								else {
										endDateTextBox.val(dateText);
								}
						},
						onSelect: function (selectedDateTime){
								var start = $(this).datetimepicker("getDate");
								
						}
									}); 
        </script>  
				<!--FIN DEL CALENDARIO DESDE-->	
         <p class="formHint"> (*) Fecha de publicaci&oacute;n de la gaceta o resoluci&oacute;n</p>  
  </td>
</tr>
<tr>
  <td>
    
  </td>
  <td></td>
  </tr>
<tr>
<td colspan="2" width="50">
  
  <div class="ctrlHolder">
  <label for="txt_pla_est">Plan de estudio</label><br>
  <input name="txt_pla_est" type="text" class="validate[required,minSize[3]] text-input lf"  id="txt_pla_est" tabindex="0" value="<?php echo $pla_est; ?>" maxlength="50" style="width:100%"/>
  <p class="formHint"> (*) Escriba los nombres de la persona </p>
    
  </div>									
</td>
</tr> 

<tr>
  <td colspan="3">
    <div class="ctrlHolder">
      <label for="txt_not">Notas / observaciones</label>
      <br>
      <textarea name="txt_not" id="txt_not" rows="4" class='validate[optional,maxSize[500]] textarea_small'  style="width:99%"><?php echo $not; ?></textarea>
      <p class="formHint"> Cualquier otra informaci&oacute;n importante</p>
      
      </div>  
    </td>
</tr>
<tr>
<td><div class="ctrlHolder" id="ctrl_estatus">
                <label for="chk_act">Estatus</label>
                <label for="chk_act">
                  <input type="checkbox" name="chk_act" id="chk_act" class="active" <?php echo $vis; ?>>
                  Habilitado</label>
</div></td>
</tr>

<tr><td colspan="2">
  <?php if ($array_permisos["editar"]==true) { ?>         
  <button type="submit" formaction="<?php echo "plan_est.php?id_func=".$_GET["id_func"]."&accion=modificar" ?>" class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all">
  <span class="ui-button-text"><img src="../images/icons_menu/x32/save1_x32.png" width="20" height="20" align="absmiddle">&nbsp;Guardar cambios</span>
  </button>
  <?php } // cierro si permite crear=guardar ?>
  <?php 
if ($array_permisos["eliminar"]==true) { 
	$url_elim="plan_est.php?id_func=".$_GET["id_func"]."&accion=eliminar&id_elim=".$id_mos;
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
<tr>
  <td colspan="2">&nbsp;</td>
</tr>
<tr>
  <td colspan="2">
  <div class="ctrlHolder message warning ui-icon-close" ><img id="usuario" src="../images/icons_menu/x32/vcard.png" width="32" height="32" align="absbottom"/>
      <label for="usuario"><?php echo "<b>GUARDADO:</b> ".$guardado_por."<br><b>FECHA:</b> ".$fecha_g; ?></label>
      </div>
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