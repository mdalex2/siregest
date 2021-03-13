
 <?php
	include_once("../funciones/funcionesPHP.php");

if (isset($_GET["id_mos"])){
	$consulta_edit=ejecuta_sql("select * from instituciones where cod_plantel='".$_GET["id_mos"]."'",true);
if ($consulta_edit){
	$registro=mysql_fetch_array($consulta_edit);
	$cod_pla=$registro["cod_plantel"];
	$den_pla=htmlspecialchars($registro["den_plantel"]);
	$den_pla_abr=htmlspecialchars($registro["den_plantel_corta"]);
	$id_pob=$registro["id_poblado"];
	$id_dis_esc=$registro["id_dis_esc"];
	$cod_sec_edu=$registro["id_sector_educ"];
	$id_tip_ins=$registro["id_tip_ins"];
	$email=htmlspecialchars($registro["email"]);
	$dir=htmlspecialchars($registro["direccion_detalle"]);
	$fecha_cre=date("d-m-Y",strtotime($registro["fecha_creada"]));
	$observaciones=htmlspecialchars($registro["observaciones"]);
	if ($registro["activa"]==true){
		$activa="checked";
	} else {
		$activa="";
	}
	$id_guard_por=$registro["guardado_por"];
	$fecha_g=trans_texto(formato_fecha("LH",$registro["fecha_g"]),"MA");
						if (isset($_GET["id_edo_ter"])){
							$var_edo="&id_edo_ter=".$_GET["id_edo_ter"];
						} else {
							$var_edo="";
						}

?>                 
<form id="form_editar" name="form_editar" action="<?php echo "inst_educativa.php?id_func=".$_GET["id_func"]."&accion=modificar".$var_edo ?>" method="post" enctype="multipart/form-data" class="uniForm">
<!-- Fieldset -->
  
<fieldset>
<legend>DATOS DEL PLANTEL / INSTITUCI&Oacute;N:</legend>
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
								if (isset($_GET["id_pob"])){$id_pob_url=$_GET["id_pob"];} else {$id_pob_url="";}
if ($consulta && mysql_num_rows($consulta)>0){
while ($fila=mysql_fetch_array($consulta)) {
	?>
                <OPTION VALUE='<?php echo $fila['id_poblado']?>' <?php 
								if ($id_pob_url!="" && $id_pob_url==$fila['id_poblado']){echo " selected";} else
								if ($id_pob==$fila['id_poblado'] && $id_pob_url==""){echo " selected";} ?>><?php echo $fila["poblado"]." / (".$fila["estado_ter"].")"; ?></OPTION>";
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
<button href="inst_educativa_agr_dir.php?id_func=<?php echo $_GET["id_func"];?>&accion=mostrar&id_mos=<?php echo $cod_pla;?>" class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all fancybox.iframe resize_small" title="Busqueda avanzada del poblado">
<span class="ui-button-text"><img src="../images/icons_menu/x32/world_add.png" width="20" height="20" align="absmiddle">&nbsp;Busqueda avanzada</span>
</button>

<?php } // fin de si permite agrgar?> 
</td>
</tr>
<tr>
  <td>
    <div class="ctrlHolder">
      
  <label for="txt_cod_pla">C&oacute;digo del plantel</label><br>
  <input name="txt_cod_pla" type="text" autofocus class="validate[required,minSize[7]] text-input sf"  id="txt_cod_pla" tabindex="0" value="<?php echo $cod_pla;?>" maxlength="20"/>
  <input id="txt_cod_ant" name="txt_cod_ant" type="hidden" value="<?php echo $cod_pla;?>">
  <p class="formHint"> (*) Ejm: SD-324353-1</p>
  </div>
  </td>
  <td>
<div class="ctrlHolder">
				<label for="txt_fecha">Fecha creada<br>
					<input name="txt_fecha" type="text" class="fecha_corta validate[required,custom[date]]" id="txt_fecha" value="<?php echo $fecha_cre;?>"  maxlength="10"/>
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
<label for="txt_email">Denominaci&oacute;n del plantel</label>
<br>
<textarea name="txt_den_pla" id="txt_den_pla" rows="4" class='validate[required,minSize[5]] textarea_small'  style="width:99%"><?php echo $den_pla;?></textarea>
<p class="formHint"> (*) Ejm: Unidad Educativa Dr. Jos&eacute; Ram&oacute;n Vega</p>

</div>
</td>
</tr>
<tr>
  <td colspan="2"><div class="ctrlHolder">
<label for="txt_email">Denominaci&oacute;n del plantel (abreviada-corta)</label>
<br>
<input name="txt_den_pla_abr" type="text" class='validate[required,minSize[5]] lf' id="txt_den_pla_abr"  style="width:99%" value="<?php echo $den_pla_abr;?>" maxlength="50" rows="4"></textarea>
<p class="formHint">(*) Ejm: U. E. Dr. Jos&eacute; Ram&oacute;n Vega</p>

</div>
</td>
</tr>
<tr>
  <td><div class="ctrlHolder">
<label for="txt_email">Email</label>
<br>
<input name="txt_email" type="text" class='validate[optional,custom[email]] lf' id="txt_email" value="<?php echo $email;?>" rows="4"></textarea>
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
                <OPTION VALUE='<?php echo $fila['id_sector_educ']?>' <?php if ($fila['id_sector_educ']==$cod_sec_edu){echo " selected";} ?>><?php echo $fila["sector_educ"]; ?></OPTION>;
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
               
              <label for="cmb_dis_esc">Distrito escolar</label>
              <br>
            <SELECT NAME="cmb_dis_esc" id="cmb_dis_esc" SIZE=1  class="mf validate[required]"> 
                <option value="">SELECCIONE...</option>
                <?php 
if ($consulta && mysql_num_rows($consulta)>0){
while ($fila=mysql_fetch_array($consulta)) {
	?>
                <OPTION VALUE='<?php echo $fila['id_dis_esc']?>' <?php if ($id_dis_esc==$fila['id_dis_esc']){echo " selected";} ?>><?php echo $fila["num_dist"]." - ".$fila["dis_esc"]; ?></OPTION>";
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
                <OPTION VALUE='<?php echo $fila['id_tip_ins']?>' <?php if ($id_tip_ins==$fila['id_tip_ins']){echo " selected";} ?>><?php echo $fila["tip_ins"]; ?></OPTION>";
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
<td colspan="2">
<div class="ctrlHolder">
<label for="txt_email">Direcci&oacute;n</label>
<br>
<textarea name="txt_dir" id="txt_dir" rows="4" class='validate[required] textarea_small'  style="width:99%"><?php echo $dir;?></textarea>
<p class="formHint"> (*) Av. / calle / edificio - casa / piso / N&deg; vivienda</p>

</div>  
</td>
</tr>  
<tr>
<td colspan="2">
<div class="ctrlHolder">
<label for="txt_email">Observaciones</label>
<br>
<textarea name="txt_obs" id="txt_obs" rows="4" class='validate[optional,maxSize[500]] textarea_small'  style="width:99%"><?php echo $observaciones;?></textarea>
<p class="formHint"> Cualquier otra informaci&oacute;n importante</p>

</div>  
</td>
</tr>
<tr>
  <td colspan="2"><div class="ctrlHolder" id="ctrl_estatus">
                <label for="chk_act">Estatus</label>
                <label for="chk_act">
                  <input type="checkbox" name="chk_act" id="chk_act" <?php echo $activa;?>>
                  Activa</label>
            </div></td>
</tr>
<?php
	$sql_usu_dat_per="select nombres,apellidos,fecha_g from datos_per where id_personal='".$id_guard_por."'";
	$con_usu_guar=ejecuta_sql($sql_usu_dat_per,true);
	if ($con_usu_guar && mysql_num_rows($con_usu_guar)==1){
		$fila=mysql_fetch_array($con_usu_guar);
	?>  
<tr><td colspan="2">
  <div class="ctrlHolder message warning ui-icon-close" ><img id="usuario" src="../images/icons_menu/x32/vcard.png" width="32" height="32" align="absbottom"/>
      <label for="usuario"><?php echo "<b>GUARDADO:</b> ". $fila["nombres"]." ". $fila["apellidos"]."<br><b>FECHA:</b> ".$fecha_g; ?></label>
      </div>
  </td>
 </tr> 
 <?php } ?>

<tr><td colspan="3">

  <?php if ($array_permisos["editar"]==true) { ?>         
  <button type="submit" formaction="<?php echo "inst_educativa.php?id_func=".$_GET["id_func"]."&accion=modificar".$var_edo ?>" class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all">
  <span class="ui-button-text"><img src="../images/icons_menu/x32/save1_x32.png" width="20" height="20" align="absmiddle">&nbsp;Guardar cambios</span>
  </button>
  <?php } // cierro si permite crear=guardar ?>
  <?php 
if ($array_permisos["eliminar"]==true) { 
	$url_elim="inst_educativa.php?id_func=".$_GET["id_func"]."&accion=eliminar&id_elim=".$cod_pla;
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
<form id="form" name="form" action="" method="post" enctype="multipart/form-data" class="uniForm">
<!-- Fieldset -->
  
<fieldset>
<legend>TEL&Eacute;FONOS:</legend>
<?php
$consul_telf=ejecuta_sql("select departamento,num_telf,id_telf,inst_telefonos.fecha_g,datos_per.nombres,datos_per.apellidos from (inst_telefonos 
inner join datos_per on datos_per.id_personal=inst_telefonos.guardado_por
) where inst_telefonos.cod_plantel='$cod_pla' order by departamento,num_telf ASC",false);
//si se encontro la consulta muestro los telefonos
if ($consul_telf && mysql_num_rows($consul_telf)>0){
?>
<table id="tabla_tel" class="letra_16 mouse_hover" > 
        <thead> 
          <tr>
            <th  width="130px">DEPARTAMENTO / PERSONA</th>
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
            <td><?php echo $fila["departamento"];?></td>
            <td><?php echo $fila["num_telf"];?></td>
            <!-- si permite editar muestro el boton que permite enviar la varible edicion oculta y permite editar -->
            <?php if ($array_permisos["editar"]==true) {?>
            <?php 
							} 
						?>
            <!-- agrego la opcion de eliminar -->
            <?php if ($array_permisos["eliminar"]==true) {?>
            <td width="70" align="center">
            
 							<a id="resize" onclick="return confirm_elim_telf()" href="inst_educativa.php?<?php echo "id_func={$array_permisos['id_func']}&accion=eliminar_telf&id_telf_elim={$fila['id_telf']}&cod_pla=$cod_pla".$var_edo;?>" class=" ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" style="font-size:10px;padding:2px; color:#000000;" width="45%" height="90%" title="Eliminar registro" >&nbsp;
                  <img src='../images/icons_menu/x32/telephone_delete.png' width='16px' heigth='16px' align='absmiddle'></img>&nbsp;Elim.&nbsp;
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
  <button href="telf_agregar_frm.php?id_func=<?php echo $_GET["id_func"];?>&accion=add_telf&cod_pla=<?php echo $cod_pla.$var_edo;?>" class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all fancybox.iframe window_telf" <?php if (isset($_GET["accion"]) && strtoupper($_GET["accion"])=="NUEVO"){echo " disable title='Debe guardar primero los datos personales para agregar tel&eacute;fonos'";}?>>
    <span class="ui-button-text"><img src="../images/icons_menu/x32/telephone_add.png" width="20" height="20" align="absmiddle">&nbsp;Nuevo tel&eacute;fono</span>
    </button>
    <?php if (isset($_GET["accion"]) && strtoupper($_GET["accion"])=="NUEVO"){echo " <h3 style=\"color:red\">Debe guardar primero los datos personales para agregar tel&eacute;fonos</h3>";}?></fieldset>

  <?php } // fin de si permite agrgar?>
  </fieldset>
</form>
<!-- FIN DEL FORM UBICACION TELEFONOS-->

<?php
  } //cierro si se encontro la consulta y si no hubo error
	}  //cierro si se envio por url el id a mostrar
?>