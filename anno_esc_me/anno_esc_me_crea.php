<!DOCTYPE HTML>
<html>
<head>
<!-- Meta -->
<meta http-equiv="Content-Type" content="text/html; 
charset=<?php $_SESSION['juego_caracteres'];//esta variable se declara en modulo verificar login?>">
</head>
                  
<form id="form_crear" name="form_crear" action="<?php echo "anno_esc_me.php?id_func=".$_GET["id_func"]."&accion=guardar" ?>" method="post" enctype="multipart/form-data" class="uniForm">
<!-- Fieldset -->
  
<fieldset>
<legend>NUEVO A&Ntilde;O ESCOLAR:</legend>

<table  width="..." border="0">
<tr>
  <td>
    
  </td>
  <td></td>
  </tr>
<tr>
<td colspan="2">
  
  <div class="ctrlHolder">
    <label for="txt_cod">c&oacute;digo del a&ntilde;o escolar</label>
    <br>
    <input name="txt_cod" type="text" class="validate[required,minSize[9]] text-input sf"  id="txt_cod" tabindex="0" value="<?php echo date("Y");echo "-";echo date("Y")+1; ?>" maxlength="15" />
    <p class="formHint"> (*) Ejm: <?php echo date("Y");echo "-";echo date("Y")+1; ?></p>
    
    </div>									
</td>
</tr> 
<tr>
<td colspan="2">
  
  <div class="ctrlHolder">
    <label for="txt_cod">Descripci&oacute;n de a&ntilde;o escolar</label>
    <br>
    <input name="txt_ann_esc" type="text" class="validate[required,minSize[4]] text-input lf"  id="txt_ann_esc" tabindex="0" value="<?php echo "A&Ntilde;O ESCOLAR ".date("Y");echo "-";echo date("Y")+1; ?>" maxlength="30" />
    <p class="formHint"> (*) Ejm: <?php echo "A&Ntilde;O ESCOLAR ".date("Y");echo "-";echo date("Y")+1; ?></p>
    
    </div>									
</td>
</tr>
<tr>
<td>
  
  <div class="ctrlHolder">
<label for="txt_inicio">Fecha inicio<br>
<input  name="txt_inicio" type="text" class="fecha_corta validate[custom[date],required]" id="txt_inicio" value="<?php $fecha=date("d-m-Y"); echo $fecha;?>"  maxlength="10"/>
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
<input  name="txt_fin" type="text" class="fecha_corta validate[custom[date],required]" id="txt_fin" value="<?php echo $fecha=date("d-m-");echo date("Y")+1;?>"  maxlength="10"/>
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
    <select name="txt_cal_min" id="txt_cal_min" class="cssf validate[required]" size="1">
            <?php
						for ($cal=1;$cal<=20;$cal++){
						?>
            <option value="<?php echo $cal;?>" <?php if ($cal==12) echo " SELECTED ";?>><?php echo $cal;?></option>
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
            <option value="<?php echo $cal;?>"><?php echo $cal;?></option>
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
            <option value="<?php echo $cal;?>"><?php echo $cal;?></option>
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
      <textarea name="txt_obs" id="txt_obs" rows="4" class='validate[optional,maxSize[250]] textarea_small'  style="width:99%"></textarea>
      <p class="formHint"> Cualquier otra informaci&oacute;n importante</p>
      
      </div>  
    </td>
</tr>
<tr>
  <td colspan="2"><div class="ctrlHolder" id="ctrl_estatus">
    <label for="chk_act">Estatus</label>
    <label for="chk_act">
      <input type="checkbox" name="chk_act" id="chk_act" class="active" checked>
      Visible</label>
    <label for="chk_cerrado">
      <input type="checkbox" name="chk_cerrado" id="chk_cerrado" class="active">
      Cerrado</label>
      
    </div></td>
</tr>
<tr><td colspan="2">
<?php if ($array_permisos["crear"]==true) { ?>         
<button type="submit" formaction="<?php echo "anno_esc_me.php?id_func=".$_GET["id_func"]."&accion=guardar" ?>" class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" id="btn_guardar">
<span class="ui-button-text"><img src="../images/icons_menu/x32/save1_x32.png" width="20" height="20" align="absmiddle">&nbsp;Guardar</span>
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