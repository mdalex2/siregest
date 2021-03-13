<!DOCTYPE HTML>
<html>
<head>
<!-- Meta -->
<meta http-equiv="Content-Type" content="text/html; 
charset=<?php $_SESSION['juego_caracteres'];//esta variable se declara en modulo verificar login?>">
</head>
<?php
		if (isset($_GET["id_edo_ter"])){
			$var_edo="&id_edo_ter=".$_GET["id_edo_ter"];
		} else {
			$var_edo="";
		}

?>                  
<form id="form_crear" name="form_crear" action="<?php echo "inst_educativa.php?id_func=".$_GET["id_func"]."&accion=guardar".$var_edo ?>" method="post" enctype="multipart/form-data" class="uniForm">
<!-- Fieldset -->
  
<fieldset>
<legend>INSTITUCI&Oacute;N O PLANTEL:</legend>

<table  width="..." border="0">
<tr>
<td>
<div class="ctrlHolder">
              <?php
if (isset($_GET["id_edo_ter"])) {$sql_filtro=" where terr_estados.cod_estado_ter=".$_GET["id_edo_ter"];} else {$sql_filtro="";}
$sql_par="select id_poblado,poblado,terr_estados.estado_ter from terr_poblados INNER JOIN terr_estados on terr_estados.cod_estado_ter=terr_poblados.cod_estado_ter $sql_filtro order by poblado,estado_ter asc";
$consulta=ejecuta_sql($sql_par,0);
?>
              <label for="cmb_pob">Poblado o sector / estado de ubicaci&oacute;n</label>
              <br>
              <SELECT NAME="cmb_pob" id="cmb_pob" SIZE=1  class="lf validate[required]"> 
                <option value="">SELECCIONE...</option>
                <?php 
if ($consulta && mysql_num_rows($consulta)>0){
while ($fila=mysql_fetch_array($consulta)) {
	?>
                <OPTION VALUE='<?php echo $fila['id_poblado']?>' <?php if ((isset($_POST["cmb_pob"]) && $_POST["cmb_pob"]==$fila['id_poblado']) || isset($_GET["id_pob"]) && $_GET["id_pob"]==$fila['id_poblado']){echo " selected";} ?>><?php echo $fila["poblado"]." / (".$fila["estado_ter"].")"; ?></OPTION>";
<?php
	} // fin ciclo while
} // fin si hay mas registros >0
?>

              </SELECT>
               
              <p class="formHint"> Seleccione el sector</p>
           
</div>
</td>
<td>
 <?php if ($array_permisos["crear"]==true) {?>
<button href="inst_educativa_agr_dir.php?id_func=<?php echo $_GET["id_func"];?>&accion=nuevo" class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all fancybox.iframe resize_small" title="Busqueda avanzada del poblado">
<span class="ui-button-text"><img src="../images/icons_menu/x32/world_add.png" width="20" height="20" align="absmiddle">&nbsp;Busqueda avanzada</span>
</button>

<?php } // fin de si permite agrgar?> 
</td>
</tr>
<tr>
  <td>
    <div class="ctrlHolder">
      
  <label for="txt_cod_pla">C&oacute;digo del plantel</label><br>
  <input name="txt_cod_pla" type="text" autofocus class="validate[required,minSize[7]] text-input sf"  id="txt_cod_pla" tabindex="0" value="" maxlength="20"/>
  <p class="formHint"> (*) Ejm: SD-324353-1</p>
  </div>
  </td>
  <td>
<div class="ctrlHolder">
				<label for="txt_fecha">Fecha creada<br>
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
         <p class="formHint"> (*) Fecha de creaci&oacute;n</p>  
  </div>  
  </td>
  </tr>
<tr>
  <td colspan="2"><div class="ctrlHolder">
<label for="txt_den_pla_abr">Denominaci&oacute;n del plantel</label>
<br>
<textarea name="txt_den_pla" id="txt_den_pla" rows="4" class='validate[required] textarea_small'  style="width:99%"></textarea>
<p class="formHint"> (*) Ejm: Unidad Educativa Dr. Jos&eacute; Ram&oacute;n Vega</p>

</div>
</td>
</tr>
<tr>
  <td colspan="2"><div class="ctrlHolder">
<label for="txt_den_pla_abr">Denominaci&oacute;n del plantel (abreviada-corta)</label>
<br>
<input name="txt_den_pla_abr" type="text" class='validate[required] lf' id="txt_den_pla_abr"  style="width:99%" maxlength="50" rows="4"></textarea>
<p class="formHint"> (*) Ejm: U. E. Dr. Jos&eacute; Ram&oacute;n Vega</p>

</div>
</td>
</tr>
<tr>
  <td><div class="ctrlHolder">
<label for="txt_email">Email</label>
<br>
<input name="txt_email" type="text" class='validate[optional,custom[email]] lf' id="txt_email" value="" rows="4"></textarea>
<p class="formHint">Ejm: jose_ramon_vega@me.edu.ve</p>

</div>
</td>
<td>
<div class="ctrlHolder">
<?php

$sql_sec_edu="select id_sector_educ,sector_educ from sectores_educ where visible=true order by sector_educ asc";
$consulta=ejecuta_sql($sql_sec_edu,0);
?>
               
              <label for="cmb_sec_edu">Sector educativo</label>
              <br>
            <SELECT NAME="cmb_sec_edu" id="cmb_sec_edu" SIZE=1  class="mf validate[required]"> 
                <option value="">SELECCIONE...</option>
                <?php 
if ($consulta && mysql_num_rows($consulta)>0){
while ($fila=mysql_fetch_array($consulta)) {
	?>
                <OPTION VALUE='<?php echo $fila['id_sector_educ']?>' <?php if (isset($_POST["cmb_sec_edu"]) && $_POST["cmb_sec_edu"]==$fila['id_sector_educ']){echo " selected";} ?>><?php echo $fila["sector_educ"]; ?></OPTION>";
<?php
	} // fin ciclo while
} // fin si hay mas registros >0
?>
            </SELECT>
              <p class="formHint"> (*) Seleccione el sector educativo al cual pertenece el plantel</p>
</div>
</td>
</tr>
<tr>
  <td>
 
  </td>
  <td colspan="2">
    
  </td>
</tr>
 

<tr>
  <td>
  <div class="ctrlHolder">
<?php

$sql_estado="select id_dis_esc,dis_esc,num_dist from dis_esc where visible=true order by num_dist,dis_esc asc";
$consulta=ejecuta_sql($sql_estado,0);
?>
               
              <label for="cmb_sec_edu">Distrito escolar</label>
              <br>
            <SELECT NAME="cmb_dis_esc" id="cmb_dis_esc" SIZE=1  class="mf validate[required]"> 
                <option value="">SELECCIONE...</option>
                <?php 
if ($consulta && mysql_num_rows($consulta)>0){
while ($fila=mysql_fetch_array($consulta)) {
	?>
                <OPTION VALUE='<?php echo $fila['id_dis_esc']?>' <?php if (isset($_POST["cmb_dis_esc"]) && $_POST["cmb_dis_esc"]==$fila['cmb_dis_esc']){echo " selected";} ?>><?php echo $fila["num_dist"]." - ".$fila["dis_esc"]; ?></OPTION>";
<?php
	} // fin ciclo while
} // fin si hay mas registros >0
?>
              </SELECT>
              <p class="formHint"> (*) Seleccione el distrito escolar</p>
</div>
</td>
  <td colspan="3">
  <div class="ctrlHolder">
<?php

$sql_estado="select id_tip_ins,tip_ins from tip_ins where visible=true order by tip_ins asc";
$consulta=ejecuta_sql($sql_estado,0);
?>
               
              <label for="cmb_tip_pla">Tipo</label>
              <br>
            <SELECT NAME="cmb_tip_pla" id="cmb_tip_pla" SIZE=1  class="mf validate[required]"> 
                <option value="">SELECCIONE...</option>
                <?php 
if ($consulta && mysql_num_rows($consulta)>0){
while ($fila=mysql_fetch_array($consulta)) {
	?>
                <OPTION VALUE='<?php echo $fila['id_tip_ins']?>' <?php if (isset($_POST["cmb_tip_pla"]) && $_POST["cmb_tip_pla"]==$fila['id_tip_ins']){echo " selected";} ?>><?php echo $fila["tip_ins"]; ?></OPTION>";
<?php
	} // fin ciclo while
} // fin si hay mas registros >0
?>
            </SELECT>
              <p class="formHint"> (*) Seleccione el tipo de instituci&oacute;n o plantel</p>
</div>
  </td>
</tr> 
<tr>
<td colspan="4">
<div class="ctrlHolder">
<label for="txt_den_pla_abr">Direcci&oacute;n</label>
<br>
<textarea name="txt_dir" id="txt_dir" rows="4" class='validate[required,maxSize[500]] textarea_small'  style="width:99%"></textarea>
<p class="formHint"> (*) Av. / calle / edificio - casa / piso / N&deg; vivienda</p>

</div>  
</td>
</tr>  
<tr>
<td colspan="4">
<div class="ctrlHolder">
<label for="txt_den_pla_abr">Observaciones</label>
<br>
<textarea name="txt_obs" id="txt_obs" rows="4" class='validate[optional,maxSize[500]] textarea_small'  style="width:99%"></textarea>
<p class="formHint"> Cualquier otra informaci&oacute;n importante</p>

</div>  
</td>
</tr>
<tr>
  <td colspan="4"><div class="ctrlHolder" id="ctrl_estatus">
                <label for="chk_act">Estatus</label>
                <label for="chk_act">
                  <input type="checkbox" name="chk_act" id="chk_act" class="active" checked>
                  Activa</label>
            </div></td>
</tr>
<tr><td colspan="4">
<?php if ($array_permisos["crear"]==true) { ?>         
<button type="submit" formaction="<?php echo "inst_educativa.php?id_func=".$_GET["id_func"]."&accion=guardar".$var_edo ?>" class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" id="btn_guardar">
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