
 <?php
if (isset($_GET["id_per"])){
	$consulta_edit=ejecuta_sql("select usuarios.id_usuario,usuarios.id_grupo_cuenta,usuarios.login,usuarios.bloqueado,usuarios.observaciones,usuarios.fecha_g,usuarios.guardado_por,datos_per.nombres,datos_per.apellidos,datos_per.foto_perfil from (usuarios INNER JOIN datos_per on usuarios.id_usuario=datos_per.id_personal) where id_usuario='".$_GET["id_per"]."'",true);
if ($consulta_edit){
	$registro=mysql_fetch_array($consulta_edit);
	$id_usuario=$registro["id_usuario"];
	$id_gru_usu=$registro["id_grupo_cuenta"];
	$nombres=strtoupper($registro["nombres"]);
	$apellidos=strtoupper($registro["apellidos"]);
	$login=$registro["login"];
	$nombre_foto=$registro["foto_perfil"];
	$observaciones=$registro["observaciones"];
	$id_guard_por=$registro["guardado_por"];
	if ($registro["bloqueado"]==true){
		$bloqueado="checked";}
	else {
		$bloqueado="";
	}
	$guardado_por=strtoupper($registro["nombres"]." ".$registro["apellidos"]);
  $fecha_g=strtoupper(formato_fecha("LH",$registro["fecha_g"]));
	
?>                 
<form id="form_editar" name="form_editar" action="<?php echo "usuarios.php?id_func=".$_GET["id_func"]."&accion=modificar" ?>" method="post" enctype="multipart/form-data" class="uniForm">
<!-- Fieldset -->
  
<fieldset>
<legend>ADMINISTRACI&Oacute;N DE USUARIOS:</legend>

<table  width="..." border="0">
<tr>
<td>

</td>
<td rowspan="4" bordercolorlight="#666666" border="1" >   <div id="foto" name="foto" style="height:190px; width:170px; border:#666666; border-radius:5px; border-style:solid">

<?php 
  $ruta_foto=$_SESSION["carp_per_fotos"].$id_usuario."/".$nombre_foto;
	if (file_exists($ruta_foto) && $nombre_foto!=''){
		echo "<img src='$ruta_foto' width='170px' height='190px'>";}
	else {
		echo "<img src='../images/sistema/no-pict.jpg' width='170' height='190'>";}
?></div>                                           								
</td>
<td rowspan="3" width="auto" >&nbsp;</td>
</tr>
<tr>
  <td width="300px">
    <div class="ctrlHolder">
   <h2>  
   <input name="id_personal" id="id_personal" type="hidden" value="<?php echo $id_usuario?>" />
  <label for="txt_num_ced">Id usuario</label><br>
  <?php echo $id_usuario?>
  </h2>
  </div>
  </td>
  </tr>
<tr>
<td width="50">
  
  <div class="ctrlHolder">
  <h2>
  <label for="txt_nombres">Nombres</label><br>
	<?php echo $nombres; ?>
  </h2>
  </div>									
</td>
</tr>
<tr>
  <td>
  <div class="ctrlHolder">
  <h2>
<label for="txt_apellidos">Apellidos</label>
<br>
<?php echo $apellidos;?>
</h2>
</div>	 
  </td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td>
	<div class="ctrlHolder">
  <label for="txt_log">Login</label><br>
  <input name="txt_log" type="text" class="validate[required,minSize[3]] text-input mf"  id="txt_log" maxlength="35" tabindex="0" value="<?php echo $login?>"/>
  <p class="formHint"> (*) Escriba el login o nombre de usuario</p>
  </div>	  
  </td>
  <td>
	<div class="ctrlHolder">
  <label for="txt_pwd">Password</label>
  <br>
  <input name="txt_pwd" type="password" class=" text-input mf"  id="txt_pwd" maxlength="35" tabindex="0" autocomplete="off"/>
  <p class="formHint"> (*) Escriba la clave de acceso</p>
  </div>	  
  </td>
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
  if ($consulta){
	
	while ($fila=mysql_fetch_array($consulta)){
		if ($fila['id_grupo']==$id_gru_usu){$selected=" selected ";} else {$selected="";};
		echo "<OPTION VALUE='".$fila['id_grupo']."' ".$selected.">".$fila["nombre_grupo_usuario"]."</OPTION>";
	}
	}
?></SELECT>
<p class="formHint"> (*) Seleccione el tipo de usuario</p>
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
<tr>
  <td colspan="1">
  <div class="ctrlHolder" id="ctrl_estatus">
                <label for="chk_cam_pwd" title="Chequeado=usuario bloqueado">Usuario bloqueado</label>
                  <input type="checkbox" name="chk_usu_bloq" id="chk_usu_bloq" title="Chequeado=usuario bloqueado" <?php echo $bloqueado;?>>
                        

          </div>
  </td>
  <td>
  <label for="chk_cam_pwd" title="Chequeado=usuario bloqueado">Modificar la clave</label>
                  <input type="checkbox" name="chk_cam_pwd" id="chk_cam_pwd" title="Chequeado=usuario bloqueado">   
  </td>
</tr>
<?php
	$sql_usu_dat_per="select nombres,apellidos from datos_per where id_personal='".$id_guard_por."'";
	$con_usu_guar=ejecuta_sql($sql_usu_dat_per,true);
	if ($con_usu_guar && mysql_num_rows($con_usu_guar)==1){
		$fila=mysql_fetch_array($con_usu_guar);
	?>  
<tr><td colspan="3">
  <div class="ctrlHolder message warning ui-icon-close" ><img id="usuario" src="../images/icons_menu/x32/vcard.png" width="32" height="32" align="absbottom"/>
      <label for="usuario"><?php echo "<b>GUARDADO:</b> ". $fila["nombres"]." ". $fila["apellidos"]."<br><b>FECHA:</b> ".$fecha_g; ?></label>
      </div>
  </td>
 </tr> 
 <?php } ?> 

<tr><td colspan="3">
  <?php if ($array_permisos["editar"]==true) { ?>  
  <button type="submit" formaction="<?php echo "usuarios.php?id_func=".$_GET["id_func"]."&accion=modificar" ?>" class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all">
  <span class="ui-button-text"><img src="../images/icons_menu/x32/save1_x32.png" width="20" height="20" align="absmiddle">&nbsp;Guardar cambios</span>
  </button>
  <?php } // cierro si permite crear=guardar ?>
  <?php 
if ($array_permisos["eliminar"]==true) { 
	$url_elim="usuarios.php?id_func=".$_GET["id_func"]."&accion=eliminar&id_elim=".$id_usuario;
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
<form id="form" name="form" action="" method="post" enctype="multipart/form-data" class="uniForm">
<!-- Fieldset -->
  
<fieldset>
<legend>PERMITIR ACCESO A LOS REGISTROS DE NOTAS DE LOS ESTUDIANTES EN LAS INSTITUCIONES:</legend>
<?php
$consul_telf=ejecuta_sql("select usuario_plantel.id_personal,usuario_plantel.cod_plantel,instituciones.den_plantel,usuario_plantel.fecha_g,datos_per.nombres,datos_per.apellidos,terr_estados.estado_ter,terr_poblados.poblado from (usuario_plantel 
 inner join datos_per on datos_per.id_personal=usuario_plantel.guardado_por 
 inner join instituciones on instituciones.cod_plantel=usuario_plantel.cod_plantel
INNER JOIN terr_poblados ON instituciones.id_poblado=terr_poblados.id_poblado 
INNER JOIN terr_estados ON terr_poblados.cod_estado_ter=terr_estados.cod_estado_ter
) where usuario_plantel.id_personal='$id_usuario' order by den_plantel ASC",false);
//si se encontro la consulta muestro los telefonos
if ($consul_telf && mysql_num_rows($consul_telf)>0){
?>
<table id="tabla_pla" class="letra_16 mouse_hover" > 
        <thead> 
          <tr>
            <th width="...">INSTITUCI&Oacute;N</th>
            <th title="ELIMINAR REGISTROS" width="...%">UBICACI&Oacute;N</th>
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
            <td><?php echo $fila["den_plantel"]."&nbsp;";?></td>
						<td><?php echo $fila["estado_ter"]." / ".$fila["poblado"]?></td>            <!-- si permite editar muestro el boton que permite enviar la varible edicion oculta y permite editar -->
            <?php if ($array_permisos["editar"]==true) {?>
            <?php 
							} 
						?>
            <!-- agrego la opcion de eliminar -->
            <?php if ($array_permisos["eliminar"]==true) {?>
            <td width="70" align="center">
            
 							<a id="resize" onclick="return confirm_elim_email()" href="usuarios.php?<?php echo "id_func={$array_permisos['id_func']}&accion=eliminar_plant&id_plant_elim={$fila['cod_plantel']}&id_per=$id_usuario"?>" class=" ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" style="font-size:10px;padding:2px; color:#000000;" width="45%" height="90%" title="Eliminar registro" >&nbsp;
                  <img src='../images/sistema/computer_delete.png' width='20' height="20" heigth='16px' align='absmiddle'></img>&nbsp;Elim.&nbsp;
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
	} // fin de si se econtraron planteles asigandos
	else {
		echo "<table><tr><td>";
	mostrar_box("exc",true,"INFORMACIÓN","No existen planteles asignados debe asignar al menos un plantel al usuario para darles acceso al sistema, de lo contrario el usuario no podrá acceder");
  	echo "</td></tr></table>";
	} //fin else
	
	
?>
  <?php if ($array_permisos["crear"]==true) {?>
  <button href="plantel_asig_frm.php?id_func=<?php echo $_GET["id_func"];?>&accion=add_plantel&id_per=<?php echo $id_usuario;?>" class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all fancybox.iframe resize" <?php if (isset($_GET["accion"]) && strtoupper($_GET["accion"])=="NUEVO"){echo " disable title='Debe guardar primero el usuario para poder asigar planteles'";}?> title="Asignar nuevo plantel al usuario">
    <span class="ui-button-text"><img src="../images/sistema/computer_add.png" width="20" height="20" align="absmiddle">&nbsp;Asignar nuevo plantel</span>
    </button>
    <?php if (isset($_GET["accion"]) && strtoupper($_GET["accion"])=="NUEVO"){echo " <h3 style=\"color:red\">Debe guardar primero los datos personales para agregar acceso a los planteles</h3>";}?></fieldset>

  <?php } // fin de si permite agrgar?>
  </fieldset>
</form>
<?php
  } //cierro si se encontro la consulta y si no hubo error
	}  //cierro si se envio por url el id a mostrar
?>