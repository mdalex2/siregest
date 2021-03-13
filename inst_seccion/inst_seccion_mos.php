
 <?php
if (isset($_GET["id_mos"])){
	$consulta_edit=ejecuta_sql("select inst_secciones.*,datos_per.nombres,datos_per.apellidos from (inst_secciones 
	INNER JOIN datos_per on datos_per.id_personal=inst_secciones.guardado_por
	) where id_seccion='".$_GET["id_mos"]."'",true);
if ($consulta_edit){
	date_default_timezone_set("America/Caracas");
	$registro=mysql_fetch_array($consulta_edit);
			$id_seccion=$registro["id_seccion"];
			$cod_plantel=$registro["cod_plantel"];
			$id_plan_nivel_est=$registro["id_plan_nivel_est"];
			$cod_mencion_educ=$registro["cod_mencion_educ"];
			$id_sector_educ=$registro["id_sector_educ"];
			$cod_grado=$registro["cod_grado"];
			$seccion_largo=$registro["seccion_largo"];
			$seccion_med=$registro["seccion_med"];
			$seccion_corto=$registro["seccion_corto"];
			$max_alumn=$registro["max_alumn"];
			
			$obs=$registro["observaciones"];
	
			if ($registro["visible"]==true){
				$visible="checked";
			} else {
				$visible="";
			}
			$guardado_por=strtoupper($registro["nombres"]." ".$registro["apellidos"]);
			$fecha_g=strtoupper(formato_fecha("LH",$registro["fecha_g"]));
?>                 
<form id="form_editar" name="form_editar" action="<?php echo "inst_seccion.php?id_func=".$_GET["id_func"]."&accion=modificar" ?>" method="post" enctype="multipart/form-data" class="uniForm">
<!-- Fieldset -->
  
<fieldset>
<legend>DATOS DE LA SECCI&Oacute;N:</legend>

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
<label for="cmb_pla">Plantel o instituci&oacute;n</label><br><input type="hidden" name="txt_id_ant" value="<?php echo $id_seccion;?>" />
            <SELECT NAME="cmb_pla" id="cmb_pla" SIZE=1  class="lf validate[required]" style="width:98%"> 
                
                <?php 
if ($consulta && mysql_num_rows($consulta)>0){
while ($fila=mysql_fetch_array($consulta)) {
	?>
                <OPTION VALUE='<?php echo $fila['cod_plantel']?>' <?php if ($cod_plantel==$fila['cod_plantel']){echo " selected";} ?>><?php echo $fila["den_plantel"]; ?></OPTION>";
<?php
	} // fin ciclo while
} // fin si hay mas registros >0
?>
            </SELECT>
              <p class="formHint"> (*) Seleccione el plantel</p>
</div></td>
</tr>
<tr>
<tr>
  <td colspan="2"><div class="ctrlHolder">
<label for="cmb_pla_est">Plan de estudio / Vigencia</label>
<br>
<SELECT name="cmb_pla_est" id="cmb_pla_est" SIZE=1 class="lf validate[required]" style="width:98%"> 
<option value="">SELECCIONE...</option>
<?php
	include_once("../funciones/funcionesPHP.php");
	$consulta=ejecuta_sql("select  	id_plan_nivel_est,cod_plan_nivel_me,nivel_plan_est,fecha_pub from plan_est_tip where visible=true order by nivel_plan_est ASC",false);
	//si hay registros para mostrar
  if (!$consulta==false){
	while ($fila=mysql_fetch_array($consulta)){
		if ($id_plan_nivel_est==$fila["id_plan_nivel_est"]){echo $selected=" selected ";} else {$selected="";}
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
		if ($cod_mencion_educ==$fila["cod_mencion_educ"]){echo $selected=" selected ";} else {$selected="";}
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
			if ($id_sector_educ==$fila["id_sector_educ"]){
			echo $selected=" selected ";} else {$selected="";}
		echo "<OPTION VALUE='".$fila['id_sector_educ']."' {$selected}>".$fila["sector_educ"]."</OPTION></BR>";
	}
	}
?>
</SELECT>
<p class="formHint"> (*) Requerido</p>
</div></td>
</tr>
<td>
  
  <div class="ctrlHolder">
<label for="cmb_gra">Grado - a&ntilde;o</label>
<br>
<SELECT name="cmb_gra" id="cmb_gra" SIZE=1 class="mf validate[required]"> 
<option value="">SELECCIONE...</option>
<?php
	include_once("../funciones/funcionesPHP.php");
	$consulta=ejecuta_sql("select cod_grado,grado_letras from grados_esc order by cod_grado ASC",false);
	//si hay registros para mostrar
  if (!$consulta==false){
	while ($fila=mysql_fetch_array($consulta)){
		if ($cod_grado==$fila["cod_grado"]){echo $selected=" selected ";} else {$selected="";}
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
  <input name="txt_sec_l" type="text" class="validate[required,minSize[5]] text-input sf"  id="txt_sec_l" tabindex="0" value="<?php echo $seccion_largo;?>" maxlength="10" />
  <p class="formHint"> (*) Ejemplo: Secci&oacute;n A</p>
    
  </div></td>
</tr> 
<tr>
<td>
  
  <div class="ctrlHolder">
  <label for="txt_sec_m">Secci&oacute;n (mediana)</label> 
  <br>
  <input name="txt_sec_m" type="text" class="validate[required,minSize[3]] text-input sf"  id="txt_sec_m" tabindex="0" value="<?php echo $seccion_med;?>" maxlength="8" />
  <p class="formHint"> (*) Ejm: Secc. A</p>
    
  </div>									
</td>
<td><div class="ctrlHolder">
  <label for="txt_sec_c">Secci&oacute;n (Letra)</label> 
  <br>
  <input name="txt_sec_c" type="text" class="validate[required,minSize[1]] text-input ssf"  id="txt_sec_c" tabindex="0" value="<?php echo $seccion_corto;?>" maxlength="1" />
  <p class="formHint"> (*) Ejemplo: A</p>
    
  </div></td>
</tr>
<tr>
<td>
<div class="ctrlHolder">
	<label for="txt_max_alu">M&aacute;ximo de estudiantes (capacidad)</label>
  <br>
  <input name="txt_max_alu" type="text" autofocus class="validate[required,custom[integer],min[10]] text-input ssf"  id="txt_max_alu" value="<?php echo $max_alumn;?>" maxlength="4"/>
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
      <textarea name="txt_obs" id="txt_obs" rows="4" class='validate[optional,maxSize[200]] textarea_small'  style="width:99%"><?php echo $obs;?></textarea>
      <p class="formHint"> Cualquier otra informaci&oacute;n importante</p>
      
      </div>  
    </td>
</tr>
<tr>
  <td colspan="2"><div class="ctrlHolder" id="ctrl_estatus">
    <label for="chk_act">Estatus</label>
    <label for="chk_act">
      <input type="checkbox" name="chk_act" id="chk_act" class="active" <?php echo $visible?>>
      Habilitada</label>
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
  <button type="submit" formaction="<?php echo "inst_seccion.php?id_func=".$_GET["id_func"]."&accion=modificar" ?>" class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all">
  <span class="ui-button-text"><img src="../images/icons_menu/x32/save1_x32.png" width="20" height="20" align="absmiddle">&nbsp;Guardar cambios</span>
  </button>
  <?php } // cierro si permite crear=guardar ?>
  <?php 
if ($array_permisos["eliminar"]==true) { 
	$url_elim="inst_seccion.php?id_func=".$_GET["id_func"]."&accion=eliminar&id_elim=".$id_seccion;
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