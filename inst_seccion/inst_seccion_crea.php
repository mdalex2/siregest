<!DOCTYPE HTML>
<html>
<head>
<!-- Meta -->
<meta http-equiv="Content-Type" content="text/html; 
charset=<?php $_SESSION['juego_caracteres'];//esta variable se declara en modulo verificar login?>">
</head>
                  
<form id="form_crear" name="form_crear" action="<?php echo "inst_seccion.php?id_func=".$_GET["id_func"]."&accion=guardar" ?>" method="post" enctype="multipart/form-data" class="uniForm">
<!-- Fieldset -->
  
<fieldset>
<legend>CREAR SECCI&Oacute;N:</legend>

<table  width="..." border="0">
<tr>
  <td colspan="2"><div class="ctrlHolder">
<?php
if (isset($_SESSION['id_grupo_usuario']) && $_SESSION['id_grupo_usuario']=="G0001"){
$sql="select cod_plantel,den_plantel from instituciones where activa=true order by den_plantel,id_dis_esc asc";
} else {
$sql="select cod_plantel,den_plantel from instituciones where activa=true and cod_plantel='".$_SESSION["cod_plantel_ses"]."' order by den_plantel,id_dis_esc asc";
}
$consulta=ejecuta_sql($sql,0);
?>
<label for="cmb_pla">Plantel o instituci&oacute;n</label><br>
            <SELECT NAME="cmb_pla" id="cmb_pla" SIZE=1  class="lf validate[required]" style="width:98%"> 
                
                <?php 
if ($consulta && mysql_num_rows($consulta)>0){
while ($fila=mysql_fetch_array($consulta)) {
	?>
                <OPTION VALUE='<?php echo $fila['cod_plantel']?>' <?php if (isset($_POST["cmb_pla"]) && $_POST["cmb_pla"]==$fila['cod_plantel']){echo " selected";} ?>><?php echo $fila["den_plantel"]; ?></OPTION>";
<?php
	} // fin ciclo while
} // fin si hay mas registros >0
?>
              </SELECT>
              <p class="formHint"> (*) Seleccione el plantel</p>
</div></td>
</tr>
<tr>
  <td colspan="2"><div class="ctrlHolder">
<label for="cmb_pla_est">Plan de estudio / Vigencia</label>
<br>
<SELECT name="cmb_pla_est" id="cmb_pla_est" SIZE=1 class="lf validate[required]" style="width:98%"> 
<option value="">SELECCIONE...</option>
<?php
	include_once("../funciones/funcionesPHP.php");
	$consulta=ejecuta_sql("select  	id_plan_nivel_est,nivel_plan_est, 	cod_plan_nivel_me,fecha_pub from plan_est_tip where visible=true order by nivel_plan_est ASC",false);
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
</tr>
<tr>
  <td>
  <div class="ctrlHolder">
<label for="cmb_men">Menci&oacute;n</label>
<br>
<SELECT name="cmb_men" id="cmb_men" SIZE=1 class="mf validate[required]"> 
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
</div></td>
  <td><div class="ctrlHolder">
<label for="cmb_sec_pla_est">Sector</label>
<br>
<SELECT name="cmb_sec_pla_est" id="cmb_sec_pla_est" SIZE=1 class="mf validate[required]"> 
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
</div></td>
</tr>
<tr>
<td>
  
  <div class="ctrlHolder">
<label for="cmb_gra">Grado - a&ntilde;o</label>
<br>
<SELECT name="cmb_gra" id="cmb_gra" SIZE=1 class="mf validate[required]"> 
<option value="">SELECCIONE...</option>
<?php
	include_once("../funciones/funcionesPHP.php");
	$consulta=ejecuta_sql("select cod_grado,grado_letras from grados_esc order by orden ASC",false);
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
<td><div class="ctrlHolder">
  <label for="txt_sec_l">Secci&oacute;n</label> 
  <br>
  <input name="txt_sec_l" type="text" class="validate[required,minSize[5]] text-input sf"  id="txt_sec_l" tabindex="0" maxlength="10" />
  <p class="formHint"> (*) Ejemplo: Secci&oacute;n A</p>
    
  </div></td>
</tr> 
<tr>
<td>
  
  <div class="ctrlHolder">
  <label for="txt_sec_m">Secci&oacute;n (mediana)</label> 
  <br>
  <input name="txt_sec_m" type="text" class="validate[required,minSize[3]] text-input sf"  id="txt_sec_m" tabindex="0" maxlength="8" />
  <p class="formHint"> (*) Ejm: Secc. A</p>
    
  </div>									
</td>
<td><div class="ctrlHolder">
  <label for="txt_sec_c">Secci&oacute;n (Letra)</label> 
  <br>
  <input name="txt_sec_c" type="text" class="validate[required,minSize[1]] text-input ssf"  id="txt_sec_c" tabindex="0" maxlength="1" />
  <p class="formHint"> (*) Ejemplo: A</p>
    
  </div></td>
</tr>
<tr>
<td>
<div class="ctrlHolder">
	<label for="txt_max_alu">M&aacute;ximo de estudiantes (capacidad)</label>
  <br>
  <input name="txt_max_alu" type="text" autofocus class="validate[required,custom[integer],min[10]] text-input ssf"  id="txt_max_alu" value="0" maxlength="4"/>
  <p class="formHint"> (*) Ejm: 30</p>
  </div>
  </td>
<td >&nbsp;</td>
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
      <input type="checkbox" name="chk_act" id="chk_act" class="active" checked>
      Habilitada</label>
    </div></td>
</tr>
<tr><td colspan="2">
<?php if ($array_permisos["crear"]==true) { ?>         
<button type="submit" formaction="<?php echo "inst_seccion.php?id_func=".$_GET["id_func"]."&accion=guardar" ?>" class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" id="btn_guardar">
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