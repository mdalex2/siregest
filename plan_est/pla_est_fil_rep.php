            
<form id="form_plan_est_adm" name="form_plan_est_adm" action="plan_est_rep.php" method="get" enctype="multipart/form-data" class="uniForm" target="new">
<!-- Fieldset -->
  
<fieldset>
<legend>IMPRIMIR ASIGNACI&Oacute;N DE MATERIAS - PLAN DE ESTUDIO:</legend>

<table  width="100%" border="0">
<tr>
<td width="100px">
<div class="ctrlHolder">
<label for="id_pla">Plan de estudio / Vigencia</label>
<br>
<SELECT name="id_pla" id="id_pla" SIZE=1 class="lf validate[required]"> 
<option value="">SELECCIONE...</option>
<?php
	include_once("../funciones/funcionesPHP.php");
	$consulta=ejecuta_sql("select  	id_plan_nivel_est,cod_plan_nivel_me,nivel_plan_est,fecha_pub from plan_est_tip where visible=true order by nivel_plan_est ASC",false);
	//si hay registros para mostrar
  if (!$consulta==false){
	while ($fila=mysql_fetch_array($consulta)){
		if (!empty($_POST["cmb_pla_est"]) && $_POST["cmb_pla_est"]==$fila["id_plan_nivel_est"]){echo $selected=" selected ";} else {$selected="";}
		//pongo fecha mes en letra año
		$fecha_pub=strtoupper(formato_fecha("MA",$fila["fecha_pub"]));
echo "<OPTION VALUE='".$fila['id_plan_nivel_est']."' {$selected}>".$fila["cod_plan_nivel_me"]." - ".$fila["nivel_plan_est"]."&nbsp;&nbsp;&nbsp;| &rarr; $fecha_pub</OPTION>";
	}
	}
?>
</SELECT>
<p class="formHint"> (*) Requerido</p>
</div>
</td>
<td width="100px">
<div class="ctrlHolder">
<label for="cod_sec">Sector</label>
<br>
<SELECT name="cod_sec" id="cod_sec" SIZE=1 class="mf validate[required]"> 
<option value="">SELECCIONE...</option>
<?php
	include_once("../funciones/funcionesPHP.php");
	$consulta=ejecuta_sql("select id_sector_educ,sector_educ from sectores_educ order by sector_educ ASC",false);
	//si hay registros para mostrar
  if (!$consulta==false){
	while ($fila=mysql_fetch_array($consulta)){
		$selected="";
		if (isset($_POST["cmb_sec_pla_est"])){
			if ($_POST["cmb_sec_pla_est"]==0 or $_POST["cmb_sec_pla_est"]==$fila["id_sector_educ"]){
			echo $selected=" selected ";} else {$selected="";}}
		echo "<OPTION VALUE='".$fila['id_sector_educ']."' {$selected}>".$fila["sector_educ"]."</OPTION></BR>";
	}
	}
?>
</SELECT>
<p class="formHint"> (*) Requerido</p>
</div>    

</td>
<td>
  <button id="btn_reset" name="btn_reset" class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" type="reset" onclick="jQuery('#form1').validationEngine('hide');$('#txt_id_func').focus();">
    <span class="ui-button-text"><img src="../images/icons_menu/x32/limpiar_x32.png" width="20" height="20" align="absmiddle"> Reestablecer</span>
    </button>
  
</td>
</tr>
<tr>
<td>
<div class="ctrlHolder">
<label for="cod_men">Menci&oacute;n</label>
<br>
<SELECT name="cod_men" id="cod_men" SIZE=1 class="mf validate[required]"> 
<option value="">SELECCIONE...</option>
<?php
	include_once("../funciones/funcionesPHP.php");
	$consulta=ejecuta_sql("select  	cod_mencion_educ,mencion from menc_edu where visible=true order by mencion ASC",false);
	//si hay registros para mostrar
  if (!$consulta==false){
	while ($fila=mysql_fetch_array($consulta)){
		if (!empty($_POST["cmb_men"]) && $_POST["cmb_men"]==$fila["cod_mencion_educ"]){echo $selected=" selected ";} else {$selected="";}
		echo "<OPTION VALUE='".$fila['cod_mencion_educ']."' {$selected}>".$fila["mencion"]."</OPTION>";
	}
	}
?>
</SELECT>
<p class="formHint"> (*) Requerido</p>
</div>
</td>
<td>
<div class="ctrlHolder">
<label for="cod_gra">Grado - a&ntilde;o</label>
<br>
<SELECT name="cod_gra" id="cod_gra" SIZE=1 class="mf validate[required]"> 
<option value="">SELECCIONE...</option>
<?php
	include_once("../funciones/funcionesPHP.php");
	$consulta=ejecuta_sql("select cod_grado,grado_letras from grados_esc order by cod_grado ASC",false);
	//si hay registros para mostrar
  if (!$consulta==false){
	while ($fila=mysql_fetch_array($consulta)){
		if (!empty($_POST["cmb_gra"]) && $_POST["cmb_gra"]==$fila["cod_grado"]){echo $selected=" selected ";} else {$selected="";}
		echo "<OPTION VALUE='".$fila['cod_grado']."' {$selected}>".$fila["grado_letras"]."</OPTION>";
	}
	}
?>
</SELECT>
<p class="formHint"> (*) Requerido</p>
</div>    

</td>
<td>
  <?php if ($array_permisos["editar"]==true) { ?>         
		<button onclick ="submit()" class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" formtarget="_new" >
<span class="ui-button-text"><img src="../images/icons_menu/x32/printer2_x32.png" align="absmiddle" height="20" width="20"> Imprimir</span>
</button>
  <?php } // cierro si permite crear=guardar ?>
</td>
</tr>
</table>
</fieldset>
<!-- End of fieldset -->
</form> 

