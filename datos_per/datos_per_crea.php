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
<legend>DATOS PERSONALES:</legend>

<table  width="..." border="0">
<tr>
<td>
<div class="ctrlHolder">
<label for="cmb_tip_reg">Tipo de identificaci&oacute;n</label>
<br>
<SELECT NAME="cmb_tip_doc" id="cmb_tip_doc" SIZE=1 class="mf validate[required]"> 
<option value="">SELECCIONE...</option>
<?php
	include_once("../funciones/funcionesPHP.php");
	$consulta=ejecuta_sql("select cod_tip_doc_per,tipo_doc from tip_doc_per where visible=true order by orden ASC",true);
	//si hay registros para mostrar
  if (!$consulta==false){
	while ($fila=mysql_fetch_array($consulta)){
		echo "<OPTION VALUE='".$fila['cod_tip_doc_per']."'>".$fila["tipo_doc"]."</OPTION>";
	}
	}
?>
</SELECT>
<p class="formHint"> (*) Seleccione el tipo de identificaci&oacute;n</p>
</div>            
</td>

<td>
 <div class="ctrlHolder">
      <label for="txt_num_ced">N&deg; de identificaci&oacute;n</label><br>
      <input name="txt_num_ced" type="text" class="validate[required,minSize[5],custom[integer]] text-input sf"  id="txt_num_ced" maxlength="22" tabindex="0" autofocus/>
      <p class="formHint"> (*) Ejm: 14771188</p>
      </div>
</td>
</tr>
<tr>
  <td><div class="ctrlHolder">
<label for="cmb_tip_reg">Tipo </label>
<br>
<SELECT NAME="cmb_tip_reg" id="cmb_tip_reg" SIZE=1 class="mf validate[required]"> 
<option value="">SELECCIONE...</option>
<?php
	include_once("../funciones/funcionesPHP.php");
	$consulta=ejecuta_sql("select id_grupo,nombre_grupo_usuario from sis_grupos where visible=true order by nombre_grupo_usuario ASC",true);
	//si hay registros para mostrar
  if (!$consulta==false){
	while ($fila=mysql_fetch_array($consulta)){
		echo "<OPTION VALUE='".$fila['id_grupo']."'>".$fila["nombre_grupo_usuario"]."</OPTION>";
	}
	}
?>
</SELECT>
<p class="formHint"> (*) Seleccione el tipo de registro</p>
</div></td>
  <td>
  <div class="ctrlHolder">
  <label for="txt_foto">Fotograf&iacute;a</label>
  <br>
  <input type="file" id="txt_foto" name="txt_foto"  accept="image/*"  class="fileUpload text-input mf" onChange='LimitAttach(this,1);cargar(this.value);'  />
  
  <p class="formHint">(Opcional) Fotograf&iacute;a</p>
  </div>
  </td>
  </tr>
<tr>
<td width="50">
  
  <div class="ctrlHolder">
  <label for="txt_nombres">Nombres</label><br>
  <input name="txt_nombres" type="text" class="validate[required,minSize[3]] text-input mf"  id="txt_nombres" maxlength="35" tabindex="0"/>
  <p class="formHint"> (*) Escriba los nombres de la persona</p>
    
  </div>									
</td>
<td >
<div class="ctrlHolder">
<label for="txt_apellidos">Apellidos</label>
<br>
<input name="txt_apellidos" type="text" class="validate[required,minSize[5]] text-input mf"  id="txt_apellidos" maxlength="35" tabindex="0"s/>
<p class="formHint"> (*) Escriba los apellidos de la persona</p>

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
    
  <label for="cmb_nac">Nacionalidad</label>
  <br>
  <SELECT NAME="cmb_nac" SIZE=1  class="mf validate[required]" id="cmb_nac"> 
  <option value="">SELECCIONE...</option>
  <?php
	include_once("../funciones/funcionesPHP.php");
	$consulta=ejecuta_sql("select cod_nac,nacionalidad,pais from terr_nacionalidad where visible=true order by nacionalidad ASC",true);
	//si hay registros para mostrar
  if ($consulta!=false){
	while ($fila=mysql_fetch_array($consulta)){
echo "<OPTION VALUE='".strtoupper($fila['cod_nac']."'>".$fila["nacionalidad"]." (".$fila["pais"]).")"."</OPTION>";	}
	}
?>
  </SELECT>
  <p class="formHint"> (*) Seleccione la nacionalidad</p>
  </div>    
  </td>
  <td colspan="3">
  <div class="ctrlHolder">
    
  <label for="cmb_sex">Sexo</label>
  <br>
  <SELECT NAME="cmb_sex" SIZE=1 class="sf validate[required]" id="cmb_sex"> 
  <option value="">SELECCIONE...</option>
  <OPTION VALUE="M">MASCULINO</OPTION>
  <OPTION VALUE="F">FEMENINO</OPTION>
  </SELECT>
  <p class="formHint"> (*) Seleccione el sexo</p>
  </div>     </td>
</tr> 
<tr>
<td>
<div class="ctrlHolder">
<label for="txt_fec_nac">Fecha de nacimiento<br>
<input  name="txt_fec_nac" type="text" class="fecha_corta validate[custom[date],required]" id="txt_fec_nac" value="<?php $fecha=strftime( "%d-%m-%Y", time() ); echo $fecha;?>"  maxlength="10" onChange="calcular_edad(this.value)"/>
<!--<a name='txt_fec_nac' style="cursor:pointer;">
</a>-->
</label>
<p class="formHint"> (*) Seleccione la fecha de nacimiento</p>
<!-- SCRIPT PARA EL CALENDARIO-->
<script type="text/javascript">
$("#txt_fec_nac").datepicker({
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
<td colspan="3">
    <img src="../images/sistema/icon_cumple.png" width="32" height="32" align="absmiddle" />&nbsp;<h2 id="lbl_edad">Edad:</h2>
<script type="text/javascript">
function calcular_edad(fecha) {
//var fecha = null;
//var fecha = prompt("Fecha de nacimiento","");
if (fecha == null || fecha == "") {
alert ("Escribe tu fecha de nacimiento");
} else {
var hoy = new Date()
divFecha = fecha.split("-");
var editFecha = new Date(divFecha[2],divFecha[1],divFecha[0])
diferencia =  hoy.getTime() - editFecha.getTime();
segundostotales = parseInt(diferencia /1000);
anyos = parseInt(segundostotales/60/60/24/365);
document.getElementById('lbl_edad').innerHTML="Edad: "+anyos+" a&ntilde;os";
//alert(anyos);
}
}
</script>

</td>
</tr>
<tr>
  <td>
  <div class="ctrlHolder">
<?php

$sql_estado="select * from terr_estados order by estado_ter asc";
$consulta=ejecuta_sql($sql_estado,0);
?>
               
              <label for="cmb_edo_civil">Estado de nacimiento</label>
              )<br>
            <SELECT NAME="cmb_estado" id="cmb_estado" SIZE=1  class="mf validate[required]"> 
                <option value="">SELECCIONE...</option>
                <?php 
if ($consulta && mysql_num_rows($consulta)>0){
while ($fila=mysql_fetch_array($consulta)) {
	?>
                <OPTION VALUE='<?php echo $fila['cod_estado_ter']?>' <?php if (isset($_POST["cmb_estado"]) && $_POST["cmb_estado"]==$fila['cod_estado_ter']){echo " selected";} ?>><?php echo $fila["estado_ter"]; ?></OPTION>";
<?php
	} // fin ciclo while
} // fin si hay mas registros >0
?>
              </SELECT>
              <p class="formHint"> Seleccione el estado de nacimiento</p>
</div>
</td>
  <td colspan="3">
  <div class="ctrlHolder">
    <label for="txt_lug_nac">Lugar de nacimiento</label>
<br>
<input name="txt_lug_nac" type="text" class="validate[required,minSize[3]] text-input mf"  id="txt_lug_nac" maxlength="35" tabindex="0"/>
<p class="formHint"> (*) Ejm: Tovar</p>

</div>
  </td>
</tr> 
<tr>
  <td ><div class="ctrlHolder">
<?php

$sql_edo_civ="SELECT id_edo_civ,edo_civil FROM edo_civil order by edo_civil asc";
$cons_edo_civ=ejecuta_sql($sql_edo_civ,true);
?>
               
              <label for="cmb_edo_civil">Estado civil</label>
              <br>
            <SELECT NAME="cmb_edo_civil" id="cmb_edo_civil" SIZE=1  class="mf validate[required]"> 
                <option value="">SELECCIONE...</option>
                <?php 
if ($cons_edo_civ && mysql_num_rows($cons_edo_civ)>0){
while ($fil_edo_civ=mysql_fetch_array($cons_edo_civ)) {
	?>
                <OPTION VALUE='<?php echo $fil_edo_civ['id_edo_civ']?>' <?php if (isset($_POST["cmb_edo_civil"]) && $_POST["cmb_edo_civil"]==$fil_edo_civ['id_edo_civ']){echo " selected";} ?>><?php echo $fil_edo_civ["edo_civil"]; ?></OPTION>";
<?php
	} // fin ciclo while
} // fin si hay mas registros >0
?>
            </SELECT>
              <p class="formHint"> Seleccione el estado civil de la persona</p>
</div></td>
  <td>&nbsp;</td>
</tr>
<tr>
<td colspan="4">
<div class="ctrlHolder">

<label for="cmb_pro">Profesi&oacute;n / Ocupaci&oacute;n</label>
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
<p class="formHint"> (*) Seleccione la profesi&oacute;n o ocupaci&oacute;n</p>
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
</table>
</fieldset>
<!-- End of fieldset -->
</form> 
<!-- FIN DEL FORM DATOS PERSONALES -->

</html>