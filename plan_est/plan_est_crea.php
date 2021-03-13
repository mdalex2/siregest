<!DOCTYPE HTML>
<html>
<head>
<!-- Meta -->
<meta http-equiv="Content-Type" content="text/html; 
charset=<?php $_SESSION['juego_caracteres'];//esta variable se declara en modulo verificar login?>">
</head>
                  
<form id="form_crear" name="form_crear" action="<?php echo "datos_per.php?id_func=".$_GET["id_func"]."&accion=guardar" ?>" method="post" enctype="multipart/form-data" class="uniForm">
<!-- Fieldset -->
  
<fieldset>
<legend>PLAN DE ESTUDIO:</legend>

<table  width="80%" border="0">
<td colspan="2">
<div class="ctrlHolder">
      
  <label for="txt_cod">C&oacute;digo plan de estudio</label>
  <br>
  <input name="txt_cod" type="text" autofocus class="validate[required,minSize[4]] text-input sf"  id="txt_cod" tabindex="0" maxlength="7"/>
  <p class="formHint"> (*) C&oacute;digo del plan de estudio suministrado por el ME. Ejm: 32011</p>
  </div>
</td>
</tr>
<tr>
  <td>
    
  </td>
  <td></td>
  </tr>
<tr>
  <td colspan="2">
				<label for="txt_fecha">Fecha publicaci&oacute;n<br>
					<input type="text" name="txt_fecha" id="txt_fecha" class="fecha_corta validate[required,custom[date]]"  maxlength="10"/>
						<a name='txt_fecha' style="cursor:pointer;">
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
<td colspan="2" width="50">
  
  <div class="ctrlHolder">
  <label for="txt_pla_est">Plan de estudio</label><br>
  <input name="txt_pla_est" type="text" class="validate[required,minSize[3]] text-input lf"  id="txt_pla_est" tabindex="0" maxlength="50" style="width:100%"/>
  <p class="formHint"> (*) Escriba los nombres de la persona </p>
    
  </div>									
</td>
</tr> 

<tr>
  <td colspan="3">
    <div class="ctrlHolder">
      <label for="txt_not">Notas / observaciones</label>
      <br>
      <textarea name="txt_not" id="txt_not" rows="4" class='validate[optional,maxSize[500]] textarea_small'  style="width:99%"></textarea>
      <p class="formHint"> Cualquier otra informaci&oacute;n importante</p>
      
      </div>  
    </td>
</tr>
<tr>
<td><div class="ctrlHolder" id="ctrl_estatus">
                <label for="chk_act">Estatus</label>
                <label for="chk_act">
                  <input type="checkbox" name="chk_act" id="chk_act" class="active" checked>
            Habilitado</label>
</div></td>
</tr>

<tr><td colspan="2">
  <?php if ($array_permisos["editar"]==true) { ?>         
  <button type="submit" formaction="<?php echo "plan_est.php?id_func=".$_GET["id_func"]."&accion=guardar" ?>" class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all">
  <span class="ui-button-text"><img src="../images/icons_menu/x32/save1_x32.png" width="20" height="20" align="absmiddle">&nbsp;Guardar cambios</span>
  </button>
  <?php } // cierro si permite crear=guardar ?>
  <button id="btn_reset" name="btn_reset" class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" type="reset" onclick="jQuery('#form1').validationEngine('hide');$('#txt_id_func').focus();">
  <span class="ui-button-text"><img src="../images/icons_menu/x32/limpiar_x32.png" width="20" height="20" align="absmiddle">Limpiar</span>
  </button>
  </td>
</table>
</fieldset>
<!-- End of fieldset -->
</form> 
<!-- FIN DEL FORM DATOS PERSONALES -->

</html>