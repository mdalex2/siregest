
 <?php
	include_once("../funciones/funcionesPHP.php");
if (isset($_GET["id_per"])&& !empty($_GET["id_per"])){
	$id_personal_bus=$_GET["id_per"];
	$consulta_edit=ejecuta_sql("select * from datos_per where id_personal='$id_personal_bus'",true);
if ($consulta_edit){
	$registro=mysql_fetch_array($consulta_edit);
	$id_personal=$registro["id_personal"];
	$id_estado_nac=$registro["cod_estado_ter"];
	$cedula=$registro["num_identificacion"];
	$nombres=$registro["nombres"];
	$apellidos=$registro["apellidos"];
  $cod_nacionalidad=$registro["cod_nac"];
	$id_edo_civ=$registro["id_edo_civ"];
	$cod_profesion=$registro["cod_tip_ocup"];
	$sexo=strtoupper($registro["sexo"]);
	$nombre_foto=$registro["foto_perfil"];
	$fecha_nac=date("d-m-Y",strtotime($registro["fecha_nac"]));
	$lugar_nac=$registro["lugar_nac"];
	$observaciones=$registro["observaciones"];
	$id_guard_por=$registro["guardado_por"];
	$fecha_g=$registro["fecha_g"];
?>                 
<form id="form_editar" name="form_editar" action="<?php echo "datos_per.php?id_func=".$_GET["id_func"]."&accion=modificar" ?>" method="post" enctype="multipart/form-data" class="uniForm">
<!-- Fieldset -->
  
<fieldset>
<legend>DATOS PERSONALES:</legend>

<table  width="..." border="0">
<tr>
 <td><div class="ctrlHolder">
<label for="cmb_tip_reg">Grupo</label>
<br>
<SELECT NAME="cmb_tip_reg" id="cmb_tip_reg" SIZE=1 class="mf validate[required]"> 
<option value="">SELECCIONE...</option>
<?php
	include_once("../funciones/funcionesPHP.php");
	$consulta=ejecuta_sql("select id_grupo,nombre_grupo_usuario from sis_grupos where visible=true order by nombre_grupo_usuario ASC",true);
	//si hay registros para mostrar
  if (!$consulta==false){
	while ($fila=mysql_fetch_array($consulta)){
		$cmb_seleccionado="";
		if ($fila['id_grupo']==$registro["id_grupo"]){$cmb_seleccionado=" selected ";}
		
		echo "<OPTION VALUE='".$fila['id_grupo']."' $cmb_seleccionado>".$fila["nombre_grupo_usuario"]."</OPTION>";
	}
	}
?>
</SELECT>
<p class="formHint"> (*) Seleccione el tipo de registro</p>
</div></td>
<td rowspan="4"  bordercolorlight="#666666" border="1" >   <div id="foto" name="foto" style="height:260px; width:220px; border:#666666; border-radius:5px; border-style:solid">
<input name="foto_ant" id="foto_ant" type="hidden" value="<?php echo $nombre_foto;?>" />
<?php 
  $ruta_foto=$_SESSION["carp_per_fotos"].$id_personal."/".$nombre_foto;
	if (file_exists($ruta_foto) && $nombre_foto!=''){
		echo "<img src='$ruta_foto' width='220px' height='260px'>";}
	else {
		echo "<img src='../images/sistema/no-pict.jpg' width='220' height='260'>";}
?></div>                                           								
</td>
 </tr>
<tr>
<td>

<div class="ctrlHolder">
<label for="cmb_tip_doc">Tipo de identificaci&oacute;n</label>
<br>
<SELECT NAME="cmb_tip_doc" SIZE=1 class="mf validate[required]" id="cmb_tip_doc"> 
<?php
	$consulta=ejecuta_sql("select cod_tip_doc_per,tipo_doc from tip_doc_per where visible=true order by orden ASC",true);
	//si hay registros para mostrar
  if (!$consulta==false){
	while ($fila=mysql_fetch_array($consulta)){
		$cmb_seleccionado="";
		if ($fila['cod_tip_doc_per']==$registro["cod_tip_doc_per"]){$cmb_seleccionado=" selected ";}
		echo "<OPTION VALUE='".$fila['cod_tip_doc_per']."' $cmb_seleccionado>".$fila["tipo_doc"]."</OPTION>";
	}
	}
?>
</SELECT>
<input id="txt_id_per_ant" name="txt_id_per_ant" type="hidden" value="<?php echo $id_personal;?>">
<p class="formHint"> (*) Seleccione el tipo de identificaci&oacute;n</p>
</div>            </td>
</tr>
<tr>
  <td>
    <div class="ctrlHolder">
      
  <label for="txt_num_ced">N&deg; de identificaci&oacute;n</label><br>
  <input name="txt_num_ced" type="text" autofocus class="validate[required,minSize[5],custom[integer]] text-input sf"  id="txt_num_ced" tabindex="0" value="<?php echo $cedula;?>" maxlength="22"/>
  <p class="formHint"> (*) Ejm: 14771188</p>
  </div>
  </td>
  </tr>
<tr>
<td width="50">
  
  <div class="ctrlHolder">
  <label for="txt_nombres">Nombres</label><br>
  <input name="txt_nombres" type="text" class="validate[required,minSize[3]] text-input mf"  id="txt_nombres" tabindex="0" value="<?php echo $nombres; ?>" maxlength="35" style="font-size:18px"/>
  <p class="formHint"> (*) Escriba los nombres de la persona </p>
    
  </div>									
</td>
</tr>
<tr>
  <td>
  <div class="ctrlHolder">
<label for="txt_apellidos">Apellidos</label>
<br>
<input name="txt_apellidos" type="text" class="validate[required,minSize[5]] text-input mf"  id="txt_apellidos" tabindex="0" value="<?php echo $apellidos; ?>" maxlength="35" style="font-size:18px"/>
<p class="formHint"> (*) Escriba los apellidos de la persona</p>

</div>	 
  </td>
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
<td>
<div class="ctrlHolder">

<label for="cmb_nac">Nacionalidad</label>
<br>
<SELECT NAME="cmb_nac" SIZE=1  class="mf validate[required]" id="cmb_nac"> 
<option value="" selected>SELECCIONE...</option>
<?php
	$consulta=ejecuta_sql("select cod_nac,nacionalidad,pais from terr_nacionalidad where visible=true order by nacionalidad ASC",true);
	//si hay registros para mostrar
  if ($consulta!=false){
	while ($fila=mysql_fetch_array($consulta)){
		$nac_seleccionado="";
		if ($cod_nacionalidad==$fila["cod_nac"]){$nac_seleccionado=" selected ";}
		echo "<OPTION VALUE='".$fila['cod_nac']."' $nac_seleccionado>".strtoupper($fila["nacionalidad"]." (".$fila["pais"]).")"."</OPTION>";
	}
	}
?>
</SELECT>
<p class="formHint"> (*) Seleccione la nacionalidad</p>
</div>    
</td>
<td >
<div class="ctrlHolder">

<label for="cmb_sex">Sexo</label>
<br>
<SELECT NAME="cmb_sex" SIZE=1 class="sf validate[required]" id="cmb_sex"> 
<option value="">SELECCIONE...</option>
<OPTION VALUE="M" <?php if ($sexo=="M"){echo " selected ";} ?>>MASCULINO</OPTION>
<OPTION VALUE="F" <?php if ($sexo=="F"){echo " selected ";} ?>>FEMENINO</OPTION>
</SELECT>
<p class="formHint"> (*) Seleccione el sexo</p>
</div>     </td>
</tr> 
<tr>
<td>
<div class="ctrlHolder">
<label for="txt_fec_nac">Fecha de nacimiento<br>
<input  name="txt_fec_nac" type="text" class="fecha_corta validate[custom[date],required]" id="txt_fec_nac" value="<?php echo $fecha_nac;?>"  maxlength="10" onChange="calcular_edad(this.value)"/>
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
		
    <h2 id="lbl_edad"><img src="../images/sistema/icon_cumple.png" width="32" height="32" align="absmiddle" />&nbsp;Edad: <?php echo calcular_edad($fecha_nac); ?></h2>
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
               
              <label for="cmb_estado">Estado de nacimiento</label>
              )<br>
            <SELECT NAME="cmb_estado" id="cmb_estado" SIZE=1  class="mf validate[required]"> 
                <option value="">SELECCIONE...</option>
                <?php 
if ($consulta && mysql_num_rows($consulta)>0){
while ($fila=mysql_fetch_array($consulta)) {
	?>
                <OPTION VALUE='<?php echo $fila['cod_estado_ter']?>' <?php if ($id_estado_nac==$fila['cod_estado_ter']){echo " selected";} ?>><?php echo $fila["estado_ter"]; ?></OPTION>";
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
<input name="txt_lug_nac" type="text" class="validate[required,minSize[3]] text-input mf"  id="txt_lug_nac" maxlength="35" tabindex="0" value="<?php echo $lugar_nac; ?>"/>
<p class="formHint"> (*) Ejm: Tovar</p>

</div>
  </td>
</tr>
 
<tr>
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
if ($cons_edo_civ){
while ($fil_edo_civ=mysql_fetch_array($cons_edo_civ)) {
	$edo_civ_seleccion="";
	if ($id_edo_civ==$fil_edo_civ["id_edo_civ"]){$edo_civ_seleccion=" selected=selected ";} 
	?>
                <OPTION VALUE='<?php echo $fil_edo_civ['id_edo_civ']?>' <?php echo $edo_civ_seleccion; ?>><?php echo $fil_edo_civ["edo_civil"]; ?></OPTION>";
<?php
	} // fin ciclo while
} // fin si hay mas registros >0
?>
            </SELECT>
              <p class="formHint"> Seleccione el estado civil de la persona</p>
</div></td>
  <td>&nbsp;</td>
</tr>
<td colspan="2">
<div class="ctrlHolder">

<label for="cmb_pro">Profesi&oacute;n / Ocupaci&oacute;n</label>
<br>
<SELECT NAME="cmb_pro" id="cmb_pro" SIZE=1  class="lf validate[required]"  style="width:100%"> 
<option value="">SELECCIONE...</option>
<?php
	$consulta=ejecuta_sql("select cod_tip_ocup,ocup_profesion from tip_ocup where visible=true order by ocup_profesion ASC",true);
	//si hay registros para mostrar
  if (!$consulta==false){
	while ($fila=mysql_fetch_array($consulta)){
		$cmb_seleccionado="";
		if ($cod_profesion==$fila["cod_tip_ocup"]){$cmb_seleccionado=" selected ";}
		echo "<OPTION VALUE='".$fila['cod_tip_ocup']."' $cmb_seleccionado>".$fila["ocup_profesion"]."</OPTION>";
	}
	}
?></SELECT>
<p class="formHint"> (*) Seleccione la profesi&oacute;n o ocupaci&oacute;n</p>
</div>    
</td>
</tr>  
<tr>
<td colspan="3">
<div class="ctrlHolder">
<label for="txt_obs">Observaciones</label>
<br>
<textarea name="txt_obs" id="txt_obs" rows="4" class='validate[optional,maxSize[500]] textarea_small'  style="width:99%"><?php echo $observaciones; ?></textarea>
<p class="formHint"> Cualquier otra informaci&oacute;n importante</p>

</div>  
</td>
</tr>
<?php
	$sql_usu_dat_per="select nombres,apellidos,fecha_g from datos_per where id_personal='".$id_guard_por."'";
	$con_usu_guar=ejecuta_sql($sql_usu_dat_per,true);
	if ($con_usu_guar && mysql_num_rows($con_usu_guar)==1){
		$fila=mysql_fetch_array($con_usu_guar);
	?>  
<tr><td colspan="3">
  <div class="ctrlHolder message warning ui-icon-close" ><img id="usuario" src="../images/icons_menu/x32/vcard.png" width="32" height="32" align="absbottom"/>
      <label for="usuario"><?php echo "<b>GUARDADO:</b> ". $fila["nombres"]." ". $fila["apellidos"]."<br><b>FECHA:</b> ".formato_fecha("LH",$fecha_g); ?></label>
      </div>
  </td>
 </tr> 
 <?php } ?> 
<tr><td colspan="3">
  <?php if ($array_permisos["editar"]==true) { ?>         
  <button type="submit" formaction="<?php echo "datos_per.php?id_func=".$_GET["id_func"]."&accion=modificar" ?>" class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all">
  <span class="ui-button-text"><img src="../images/icons_menu/x32/save1_x32.png" width="20" height="20" align="absmiddle">&nbsp;Guardar cambios</span>
  </button>
  <?php } // cierro si permite crear=guardar ?>
  <?php 
if ($array_permisos["eliminar"]==true) { 
	$url_elim="datos_per.php?id_func=".$_GET["id_func"]."&accion=eliminar&id_elim=".$id_personal;
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
<!-- FIN DEL FORM DATOS PERSONALES -->

<!-- INICIO FORM REPRESENTANTE -->
<form id="frm_repre" name="frm_repre action="" method="post" enctype="multipart/form-data" class="uniForm">
<!-- Fieldset -->
  
<fieldset>
<legend>REPRESENTANTE, MADRE Y PADRE DEL ESTUDIANTE:</legend>
<?php
	  //$represent_asig=false;
		$sql_repres="SELECT alum_repr.id_representante,alum_repr.id_alumno,datos_per.nombres,datos_per.apellidos,dat_per_gp.nombres AS dat_per_gp_nombres,dat_per_gp.apellidos  AS dat_per_gp_apellidos,datos_per.num_identificacion,tip_doc_per.tipo_doc_abr,parentescos.parentesco,alum_repr.fecha_g,representante FROM (alum_repr 
		INNER JOIN datos_per AS dat_per_gp ON dat_per_gp.id_personal=alum_repr.guardado_por
		INNER JOIN datos_per ON datos_per.id_personal=alum_repr.id_representante
		
		INNER JOIN tip_doc_per ON tip_doc_per.cod_tip_doc_per=datos_per.cod_tip_doc_per
		INNER JOIN parentescos ON parentescos.id_parentesco=alum_repr.id_parentesco
		)
		WHERE alum_repr.id_alumno='$id_personal'
		ORDER BY datos_per.nombres,datos_per.apellidos asc
		";
		$consulta_repres=ejecuta_sql($sql_repres,false);
		if ($consulta_repres){
	?>
 <table id="tabla_repre" border="0" class="letra_16 mouse_hover" style="font-size:12px">
 <thead>
 	<tr>
  	<th>N&deg; C&Eacute;DULA</th>
    <th width="250px">NOMBRES Y APELLIDOS</th>
    <th>PARENTESCO</th>
    <th>TIPO</th>
    <th title="USUARIO QUE EFECTU&Oacute; LA ASIGNACI&Oacute;N DEL REPRESENTANTE">USU.</th>
    <th title="OPCIONES" width="80px" align="center">OPC.</th>
  </tr>
 </thead>
 <?php 
 while ($fila_repre=mysql_fetch_array($consulta_repres)){
	 $fecha_g_rep=formato_fecha("LH",$fila_repre["fecha_g"]);
		if ($fila_repre["representante"]==true){
			$represent_asig="REPRESENTANTE";
		} else {
			$represent_asig="OTRO";
		}	 
 ?>
  <tr>

    <td><?php echo $fila_repre["tipo_doc_abr"]."-".number_format($fila_repre["num_identificacion"], 0, ",", ".");?></td>
    <td><?php echo $fila_repre["nombres"]." ".$fila_repre["apellidos"];?></td>
    <td><?php echo $fila_repre["parentesco"];?></td>
    <td><?php echo $represent_asig;?></td>
    <td><?php $fecha=formato_fecha("LH",$fila["fecha_g"]);echo "<img src='../images/sistema/user_comment.png' width='20' height='20' class='tooltip' title='".$fila_repre["dat_per_gp_nombres"]." ".$fila_repre["dat_per_gp_apellidos"]."<br/>".$fecha_g_rep."'/>";?></td>
    <td align="center">
<a id="resize" onclick="return confirm_elim_repre()" href="datos_per.php?<?php echo "id_func={$array_permisos['id_func']}&accion=eliminar_repre&id_repre_elim={$fila_repre['id_representante']}&id_per=$id_personal"?>" class=" ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" style="font-size:10px;padding:2px; color:#000000;" width="45%" height="90%" title="Eliminar registro" >&nbsp;
                  <img src='../images/icons_menu/x32/telephone_delete.png' width='18' height="18" heigth='16px' align='absmiddle'></img>&nbsp;Elim.&nbsp;
              </a>     </td>
  </tr>
  <?php
 } // fin while
	?>
</table>
<?php
		
		}// fin de si se ejecuto y hay registros consulta representnate
		else {
			//de lo contrario si no hubo representantes asignados muestro msg de notificacion
			echo "<table width=\"...\"><tr><td>";mostrar_box("inf",false,"","No existen representantes asignados al estudiante");echo "</td></tr></table>";
		}
 if ($array_permisos["crear"]==true) {?>
  <button href="repre_agregar_frm.php?id_func=<?php echo $_GET["id_func"];?>&accion=add_repre&id_per=<?php echo $id_personal;?>" class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all fancybox.iframe resize" <?php if (isset($_GET["accion"]) && strtoupper($_GET["accion"])=="NUEVO"){echo " disable title='Debe guardar primero los datos personales para agregar tel&eacute;fonos'";}?>>
    <span class="ui-button-text"><img src="../images/sistema/agt_family.png" width="24" height="24" align="absmiddle">&nbsp;Asignar representante</span>
    </button>
    <?php if (isset($_GET["accion"]) && strtoupper($_GET["accion"])=="NUEVO"){echo " <h3 style=\"color:red\">Debe guardar primero los datos personales para agregar tel&eacute;fonos</h3>";}?></fieldset>

  <?php } // fin de si permite agrgar?>
  </fieldset>
</form>
<!-- FIN DEL FORM REPRESENTANTE-->

<!-- INICIO FORM TELEFONOS -->
<form id="form" name="form" action="" method="post" enctype="multipart/form-data" class="uniForm">
<!-- Fieldset -->
  
<fieldset>
<legend>TEL&Eacute;FONOS:</legend>
<?php
$consul_telf=ejecuta_sql("select tip_telf.tipo_telefono,num_telf,id_telf,telf_pers.fecha_g,datos_per.nombres,datos_per.apellidos from (telf_pers 
inner join tip_telf on tip_telf.cod_tip_telf=telf_pers.cod_tip_telf
inner join datos_per on datos_per.id_personal=telf_pers.guardado_por
) where telf_pers.id_personal='$id_personal' order by tip_telf.tipo_telefono ASC",false);
//si se encontro la consulta muestro los telefonos
if ($consul_telf && mysql_num_rows($consul_telf)>0){
?>
<table id="tabla_tel" class="letra_16 mouse_hover" > 
        <thead> 
          <tr>
            <th  width="130px">TIPO TELEFONO</th>
            <th width="140px">N&deg; TELEFONO</th>
            <?php if ($array_permisos["editar"]==true) {?>
            <?php }?>
            <?php if ($array_permisos["eliminar"]==true) {?>
            <th title="ELIMINAR REGISTROS"  width="60px">ELIM.</th>
            <?php }?>
            <th title="Usuario que realiz&oacute; la actuaci&oacute;n" width="40px">Usu.</th>
          </tr> 
        </thead> 
        <tbody> 
        <?php 
				while($fila=mysql_fetch_array($consul_telf)) {
				?>
          <tr>
            <td><?php echo $fila["tipo_telefono"];?></td>
            <td><?php echo $fila["num_telf"];?></td>
            <!-- si permite editar muestro el boton que permite enviar la varible edicion oculta y permite editar -->
            <?php if ($array_permisos["editar"]==true) {?>
            <?php 
							} 
						?>
            <!-- agrego la opcion de eliminar -->
            <?php if ($array_permisos["eliminar"]==true) {?>
            <td width="70" align="center">
            
 							<a id="resize" onclick="return confirm_elim_telf()" href="datos_per.php?<?php echo "id_func={$array_permisos['id_func']}&accion=eliminar_telf&id_telf_elim={$fila['id_telf']}&id_per=$id_personal"?>" class=" ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" style="font-size:10px;padding:2px; color:#000000;" width="45%" height="90%" title="Eliminar registro" >&nbsp;
                  <img src='../images/icons_menu/x32/telephone_delete.png' width='18' height="18" heigth='16px' align='absmiddle'></img>&nbsp;Elim.&nbsp;
              </a>            </td>
            <?php }?>
            <td align="center"><?php $fecha=formato_fecha("LH",$fila["fecha_g"]);echo "<img src='../images/sistema/user_comment.png' width='20' height='20' class='tooltip' title='".$fila["nombres"]." ".$fila["apellidos"]."<br/>".$fecha."'/>";?></td>
          </tr> 
          
         <?php
					} //cierro el ciclo while
				 ?>
        </tbody> 
  </table>
<?php
	} // fin de si se econtraron registros de telefonos
?>
  <?php if ($array_permisos["crear"]==true) {?>
  <button href="telf_agregar_frm.php?id_func=<?php echo $_GET["id_func"];?>&accion=add_telf&id_per=<?php echo $id_personal;?>" class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all resize_small fancybox.iframe" <?php if (isset($_GET["accion"]) && strtoupper($_GET["accion"])=="NUEVO"){echo " disable title='Debe guardar primero los datos personales para agregar tel&eacute;fonos'";}?>>
    <span class="ui-button-text"><img src="../images/icons_menu/x32/telephone_add.png" width="20" height="20" align="absmiddle">&nbsp;Nuevo tel&eacute;fono</span>
    </button>
    <?php if (isset($_GET["accion"]) && strtoupper($_GET["accion"])=="NUEVO"){echo " <h3 style=\"color:red\">Debe guardar primero los datos personales para agregar tel&eacute;fonos</h3>";}?></fieldset>

  <?php } // fin de si permite agrgar?>
  </fieldset>
</form>
<!-- FIN DEL FORM  TELEFONOS-->

<!-- INICIO FORM DIRECCION -->
<form id="form" name="form" action="" method="post" enctype="multipart/form-data" class="uniForm">
<!-- Fieldset -->
  
<fieldset>
<legend>DIRECCIONES:</legend>
<?php
$consulta_dir="Select direcc_personas.*,tip_direcc.tipo_direcc,terr_estados.estado_ter,terr_municipios.municipio,terr_parroquias.parroquia,terr_poblados.poblado,direcc_personas.fecha_g,datos_per.nombres,datos_per.apellidos from (direcc_personas
INNER JOIN tip_direcc ON direcc_personas.cod_tip_dir=tip_direcc.cod_tip_dir 
INNER JOIN terr_estados ON direcc_personas.cod_estado_ter=terr_estados.cod_estado_ter 
INNER JOIN terr_municipios ON direcc_personas.cod_municipio=terr_municipios.id_municipio 
INNER JOIN terr_parroquias ON direcc_personas.cod_parroquia=terr_parroquias.id_parroquia 
INNER JOIN terr_poblados ON direcc_personas.cod_poblado=terr_poblados.id_poblado 
inner join datos_per on datos_per.id_personal=direcc_personas.guardado_por
) where direcc_personas.id_personal='$id_personal'";
$consulta_dir=ejecuta_sql($consulta_dir,false);
if ($consulta_dir && mysql_num_rows($consulta_dir)>0){
?>
<table id="tabla_dir" class="letra_16 mouse_hover" > 
        <thead> 
          <tr>
            <th width="120px">TIPO DIRECCI&Oacute;N</th>
            <th width="auto">DIRECCI&Oacute;N</th>
            <!--
            <?php if ($array_permisos["editar"]==true) {?>
            <th title="EDITAR REGISTROS">EDIT.</th>
            <?php }?>
            -->
            <?php if ($array_permisos["eliminar"]==true) {?>
            <th title="ELIMINAR REGISTROS" width="75px">ELIM.</th>
            <?php }?>
            <th title="Usuario que realiz&oacute; la actuaci&oacute;n" width="40px">Usu.</th>
          </tr> 
        </thead> 
        <tbody> 
        <?php 
					while ($fila=mysql_fetch_array($consulta_dir)){
						
				?>
          <tr>
            <td><?php echo $fila["tipo_direcc"];?></td>
            <td><?php echo strtoupper("ESTADO ".$fila["estado_ter"]." / MUNICIPIO ".$fila["municipio"]." / PAROQUIA ".$fila["parroquia"]." / POBLADO-SECTOR ".$fila["poblado"]." / ".$fila["direccion"]);?></td>
            <!-- si permite editar muestro el boton que permite enviar la varible edicion oculta y permite editar -->
            <!--
            <?php if ($array_permisos["editar"]==true) {?>
            <td width="70" align="center">

                  <a id="resize" href="editar_funciones_frm.php?<?php echo "id_func=&id_func_edit="?>" class="resize fancybox.iframe ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" style="font-size:10px;padding:2px; color:#000000;" title="Editar el registro">&nbsp;
                  <img src='../images/icons_menu/x32/world_edit.png' width='16px' heigth='16px' align='absmiddle'></img>&nbsp;Edit.
                  </a>
            </td>
            <?php 
							} 
						?>
            -->
            <!-- agrego la opcion de eliminar -->
            <?php if ($array_permisos["eliminar"]==true) {?>
            <td width="70" align="center">
            
 							<a id="resize" onclick="return confirm_elim_dir()" href="datos_per.php?<?php echo "id_func={$array_permisos['id_func']}&accion=eliminar_dir&id_tipo_dir={$fila['cod_tip_dir']}&id_per=$id_personal"?>" class=" ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" style="font-size:10px;padding:2px; color:#000000;" width="45%" height="90%" title="Eliminar registro" >&nbsp;
                  <img src='../images/icons_menu/x32/world_delete.png' width='18' height="18" heigth='16px' align='absmiddle'></img>&nbsp;Elim.&nbsp;
              </a>            </td>
            <?php }?>
            <td><?php $fecha=formato_fecha("LH",$fila["fecha_g"]);echo "<img src='../images/sistema/user_comment.png' width='20' height='20' class='tooltip' title='".$fila["nombres"]." ".$fila["apellidos"]."<br/>".$fecha."'/>";?></td>
          </tr> 
         <?php
					} // fin del  while
				 ?>
        </tbody> 
  </table>
<?php
	} //fin de si hay mas de un registro y si se ejecuto la consulta
	
?>
<?php if ($array_permisos["crear"]==true) {?>
<button href="datos_per_agr_dir.php?id_func=<?php echo $_GET["id_func"];?>&accion=agr_dir&id_per=<?php echo $id_personal;?>" class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all window_direcc fancybox.iframe" <?php if (isset($_GET["accion"]) && strtoupper($_GET["accion"])=="NUEVO"){echo " disabled title='Debe guardar primero los datos personales para agregar direcciones'";}?>>
<span class="ui-button-text"><img src="../images/icons_menu/x32/world_add.png" width="20" height="20" align="absmiddle">&nbsp;Nueva direcci&oacute;n</span>
</button>
<?php if (isset($_GET["accion"]) && strtoupper($_GET["accion"])=="NUEVO"){echo " <h3 style=\"color:red\">Debe guardar primero los datos personales para agregar direcciones</h3>";}?>
<?php } // fin de si permite agrgar?>
</fieldset>
</form>
<!-- fin del form direcciones-->

<!-- INICIO FORM EMAIL -->
<form id="form" name="form" action="" method="post" enctype="multipart/form-data" class="uniForm">
<!-- Fieldset -->
  
<fieldset>
<legend>EMAIL:</legend>
<?php
$consul_telf=ejecuta_sql("select id_email,email,emails_pers.fecha_g,datos_per.nombres,datos_per.apellidos from (emails_pers 
inner join datos_per on datos_per.id_personal=emails_pers.guardado_por
) where emails_pers.id_personal='$id_personal' order by email ASC",false);
//si se encontro la consulta muestro los telefonos
if ($consul_telf && mysql_num_rows($consul_telf)>0){
?>
<table id="tabla_email" name="tabla_email" class="letra_16 mouse_hover" > 
        <thead> 
          <tr>
            <th width="...">EMAIL</th>
            <th title="Opciones"  width="100px">CORREO</th>
            <?php if ($array_permisos["editar"]==true) {?>
            <?php }?>
            <?php if ($array_permisos["eliminar"]==true) {?>
            <th title="ELIMINAR REGISTROS"  width="60px">ELIM.</th>
            <?php }?>
            <th title="Usuario que realiz&oacute; la actuaci&oacute;n" width="40px">Usu.</th>
          </tr> 
        </thead> 
        <tbody> 
        <?php 
				while($fila=mysql_fetch_array($consul_telf)) {
				?>
          <tr>
            <td><?php echo $fila["email"];?></td>
            <td width="70" align="center">
<a id="resize" href="mailto:<?php echo $fila["email"];?>" class=" ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" style="font-size:10px;padding:2px; color:#000000;" width="45%" height="90%" title="Enviar correo electr&oacute;nico a: <?php echo $fila["email"];?>" >&nbsp;
                  <img src='../images/sistema/email_Forward32.png' width='18' height="18" heigth='16px' align='absmiddle'></img>&nbsp;Redactar&nbsp;
              </a>            </td>
            <!-- si permite editar muestro el boton que permite enviar la varible edicion oculta y permite editar -->
            <?php if ($array_permisos["editar"]==true) {?>
            <?php 
							} 
						?>
            <!-- agrego la opcion de eliminar -->
            <?php if ($array_permisos["eliminar"]==true) {?>
            <td width="70" align="center">
            
 							<a id="resize" onclick="return confirm_elim_email()" href="datos_per.php?<?php echo "id_func={$array_permisos['id_func']}&accion=eliminar_email&id_email_elim={$fila['id_email']}&id_per=$id_personal"?>" class=" ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" style="font-size:10px;padding:2px; color:#000000;" width="45%" height="90%" title="Eliminar registro" >&nbsp;
                  <img src='../images/icons_menu/x32/telephone_delete.png' width='18' height="18" heigth='16px' align='absmiddle'></img>&nbsp;Elim.&nbsp;
              </a>            </td>
            <?php }?>
            <td align="center"><?php $fecha=formato_fecha("LH",$fila["fecha_g"]);echo "<img src='../images/sistema/user_comment.png' width='20' height='20' class='tooltip' title='".$fila["nombres"]." ".$fila["apellidos"]."<br/>".$fecha."'/>";?></td>
          </tr> 
          
         <?php
					} //cierro el ciclo while
				 ?>
        </tbody> 
  </table>
<?php
	} // fin de si se econtraron registros de telefonos
?>
  <?php if ($array_permisos["crear"]==true) {?>
  <button href="email_agregar_frm.php?id_func=<?php echo $_GET["id_func"];?>&accion=add_email&id_per=<?php echo $id_personal;?>" class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all resize_small fancybox.iframe" <?php if (isset($_GET["accion"]) && strtoupper($_GET["accion"])=="NUEVO"){echo " disable title='Debe guardar primero los datos personales para agregar tel&eacute;fonos'";}?> title="Agregar nueva direcci&oacute;n de correo electr&oacute;nico">
    <span class="ui-button-text"><img src="../images/sistema/email-add48.png" width="20" height="20" align="absmiddle">&nbsp;Nuevo email</span>
    </button>
    <?php if (isset($_GET["accion"]) && strtoupper($_GET["accion"])=="NUEVO"){echo " <h3 style=\"color:red\">Debe guardar primero los datos personales para agregar tel&eacute;fonos</h3>";}?></fieldset>

  <?php } // fin de si permite agrgar?>
  </fieldset>
</form>
<!-- fin del form EMAIL-->
<?php
  } //cierro si se encontro la consulta y si no hubo error
	}  //cierro si se envio por url el id a mostrar
?>

