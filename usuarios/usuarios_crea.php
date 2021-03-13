
<!DOCTYPE HTML>
<html>
<head>
<!-- Meta -->
<meta http-equiv="Content-Type" content="text/html; 
charset=<?php $_SESSION['juego_caracteres'];//esta variable se declara en modulo verificar login?>">
</head>
                  
<form id="form_crear" name="form_crear" action="<?php echo "usuarios.php?id_func=".$_GET["id_func"]."&accion=nuevo" ?>" method="post" enctype="multipart/form-data" class="uniForm">
<!-- Fieldset -->
  
<fieldset>
<legend>DATOS DEL USUARIO:</legend>
<?php 
if ($array_permisos["crear"]==true){
?>
<table  width="..." border="0">
<tr>
<td width="50">
<div class="ctrlHolder">
<label for="cmb_tip_doc">Tipo de identificaci&oacute;n</label>
<br>
<SELECT NAME="cmb_tip_doc" id="cmb_tip_doc" SIZE=1 class="mf validate[required]"> 
<?php
	include_once("../funciones/funcionesPHP.php");
	$consulta=ejecuta_sql("select cod_tip_doc_per,tipo_doc from tip_doc_per where visible=true order by orden ASC",false);
	//si hay registros para mostrar
  if (!$consulta==false){
	while ($fila=mysql_fetch_array($consulta)){
		if (!empty($_POST["cmb_tip_doc"]) && $_POST["cmb_tip_doc"]==$fila["cod_tip_doc_per"]){echo $selected=" selected ";} else {$selected="";}
		echo "<OPTION VALUE='".$fila['cod_tip_doc_per']."' {$selected}>".$fila["tipo_doc"]."</OPTION>";
	}
	}
?>
</SELECT>
<p class="formHint"> (*) Seleccione el tipo de identificaci&oacute;n</p>
</div>            
</td>

<td>
 <div class="ctrlHolder">
      <label for="txt_num_ced">N&deg; de documento de identificacion</label><br>
      <input name="txt_num_ced" type="text" autofocus class="validate[required,minSize[7]] text-input sf"  id="txt_num_ced" tabindex="0" value="<?php if (!empty($_POST["txt_num_ced"])){echo $_POST["txt_num_ced"];}?>" maxlength="20"/>
<button formaction="<?php echo "usuarios.php?id_func=".$_GET["id_func"]."&accion=NUEVO"?>" class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" type="submit">
<span class="ui-button-text"><img src="../images/icons_menu/x32/find_x32.png" width="20" height="20" align="absmiddle">&nbsp;Buscar</span>
</button>      
      <p class="formHint"> (*) Ejm: 14771188</p>
      </div>
</td>
</tr>

<?php
$boton_activado=" disabled ";
if (!empty($_POST["cmb_tip_doc"]) && !empty($_POST["txt_num_ced"])){
	$id_per=$_POST["cmb_tip_doc"]."_".$_POST["txt_num_ced"];
	$sql_str="select nombres,apellidos,foto_perfil FROM datos_per where id_personal='$id_per'";
	if ($consulta=ejecuta_sql($sql_str,false)){
		$boton_activado="";
		while ($fila=mysql_fetch_array($consulta)) {
?>
<tr>
  <td><h2>NOMBRES:<br><?php echo "<strong>".strtoupper($fila["nombres"])."</strong>";?></h2><br><h2>APELLIDOS:<br><?php echo "<strong>".strtoupper($fila["apellidos"])."</strong>";?></h2></td>
  <td><?php   $ruta_foto=$_SESSION["carp_per_fotos"].$id_per."/".$fila["foto_perfil"];
	if (file_exists($ruta_foto) && $fila["foto_perfil"]!=''){
		echo "<img src='$ruta_foto' width='130px' height='120px'>";}
	else {
		echo "<img src='../images/sistema/no-pict.jpg' width='130' height='120'>";}
?></td>
</tr>
<?php
		} // fin del while
?>
<tr>
  <td>
	<div class="ctrlHolder">
  <label for="txt_log">Login</label><br>
  <input name="txt_log" type="text" class="validate[required,minSize[3]] text-input mf"  id="txt_log" maxlength="35" tabindex="0"/>
  <p class="formHint"> (*) Escriba el login o nombre de usuario</p>
  </div>	  
  </td>
  <td>
	<div class="ctrlHolder">
  <label for="txt_pwd">Password</label>
  <br>
  <input name="txt_pwd" type="password" class="validate[required,minSize[3]] text-input mf"  id="txt_pwd" maxlength="35" tabindex="0" autocomplete="off"/>
  <p class="formHint"> (*) Escriba la clave de acceso</p>
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
  
</tr> 
<tr>
<td colspan="4">
<div class="ctrlHolder">

<label for="cmb_gru_usu">Tipo de usuario</label>
<br>
<SELECT NAME="cmb_gru_usu" id="cmb_gru_usu" SIZE=1  class="mf validate[required]"  style="width:100%"> 
<option value="">SELECCIONE...</option>
<?php
	include_once("../funciones/funcionesPHP.php");
	$consulta=ejecuta_sql("select id_grupo,nombre_grupo_usuario from sis_grupos where visible=true order by nombre_grupo_usuario ASC",false);
	//si hay registros para mostrar
  if (!$consulta==false){
	while ($fila=mysql_fetch_array($consulta)){
		echo "<OPTION VALUE='".$fila['id_grupo']."'>".$fila["nombre_grupo_usuario"]."</OPTION>";
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
<tr>
  <td colspan="4">
  <div class="ctrlHolder" id="ctrl_estatus">
                <label for="chk_usu_bloq" title="Chequeado=usuario bloqueado">Usuario bloqueado</label>
                  <input type="checkbox" name="chk_usu_bloq" id="chk_usu_bloq" title="Chequeado=usuario bloqueado">
            </div>
  </td>
</tr>
<tr><td colspan="4">
<?php if ($array_permisos["crear"]==true) { ?>         
<button type="submit" formaction="<?php echo "usuarios.php?id_func=".$_GET["id_func"]."&accion=guardar" ?>" class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" id="btn_guardar" <?php echo $boton_activado;?>>
<span class="ui-button-text"><img src="../images/icons_menu/x32/save1_x32.png" width="20" height="20" align="absmiddle">&nbsp;Guardar</span>
</button>
<?php } // cierro si permite crear=guardar ?>

<button id="btn_reset" name="btn_reset" class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" type="reset" onclick="jQuery('#form1').validationEngine('hide');$('#txt_id_func').focus();">
<span class="ui-button-text"><img src="../images/icons_menu/x32/limpiar_x32.png" width="20" height="20" align="absmiddle"> Reestablecer</span>
</button>
</td>
</tr>
<?php
	} //fin de si hay consulta
	 else { 
	 		mostrar_box("inf",false,"DATOS PERSONALES NO ENCONTRADOS","El sistema no pudo encontrar los datos personales del usuario que intenta agregar, posibles causas:<br>1- Verifique que el tipo de identificacion y el n&uacute;mero de c&eacute;dula e intente de nuevo.<br>2- Si no ha agregado los datos personales del usuario puede agregarlos <a href='../datos_per/datos_per.php?id_func=00022&accion=nuevo'><b>haciendo clic aqui</b></a> siempre y cuando usted tenga los privilegios necesarios para crear expedientes personales");
	 }
	}  //fin si los datos personales se encontraron
?>
</table>
<?php
	} else{mostrar_box("err",false,"ACCESO DENEGADO","No se tienen los privilegios suficientes para crear usuarios");
	echo mostrar_btn_imp_reg();
	} // fin de si array permisos =true
?>
</fieldset>
<!-- End of fieldset -->
</form> 
<!-- FIN DEL FORM DATOS PERSONALES -->

</html>