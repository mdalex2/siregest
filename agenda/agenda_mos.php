
 <?php
if (isset($_GET["id_mos"])){
	$consulta_edit=ejecuta_sql("select agenda_pers.*,datos_per.nombres,datos_per.apellidos from (agenda_pers INNER JOIN datos_per on datos_per.id_personal=agenda_pers.id_personal) where id_apunte='".$_GET["id_mos"]."'",true);
if ($consulta_edit){
	date_default_timezone_set("America/Caracas");
	$registro=mysql_fetch_array($consulta_edit);
			$id_apunte=$registro["id_apunte"];
			$fecha=date("d-m-Y",strtotime($registro["fecha_act"]));
			$hora_bd=formato_fecha("H12",$registro["fecha_act"]);
			$hora_bd = str_replace(" ","",$hora_bd);
			$hora_bd = str_replace(".","",$hora_bd);
			$tarea=$registro["descripcion"];
	
	if ($registro["cerrada"]==true){
		$cerrado="checked";
	} else {
		$cerrado="";
	}
	$guardado_por=strtoupper($registro["nombres"]." ".$registro["apellidos"]);
  $fecha_g=strtoupper(formato_fecha("LH",$registro["fecha_act"]));
?>                 
<form id="form_editar" name="form_editar" action="<?php echo "agenda.php?id_func=".$_GET["id_func"]."&accion=modificar" ?>" method="post" enctype="multipart/form-data" class="uniForm">
<!-- Fieldset -->
  
<fieldset>
<legend>DATOS:</legend>

<table  width="..." border="0">
<tr>
<td width="...">
  
  <div class="ctrlHolder">
<label for="texto11">Fecha apunte<br>
<input type="hidden" name="txt_id_ant" value="<?php echo $id_apunte?>" />
<input  name="texto11" type="text" class="fecha_corta validate[custom[date],required]" id="texto11" value="<?php echo $fecha;?>"  maxlength="10"/>
<!--<a name='texto11' style="cursor:pointer;">
</a>-->
</label>
<p class="formHint"> (*) Formato dd-mm-yyyy</p>
<!-- SCRIPT PARA EL CALENDARIO-->
<script type="text/javascript">
$("#texto11").datepicker({
showOn: "both",
regional:"es",
dateFormat: "dd-mm-yy",
minDate: new Date(1920, 1 - 1, 1), 
buttonImage: "../images/icons_menu/x32/calendario1_x32.png",
showButtonPanel: true,
buttonImageOnly: true,
showTimepicker: true,
changeYear: true,
numberOfMonths: 1,
}); 
</script>  

<!--FIN DEL CALENDARIO DESDE-->																		
</div>									
</td>
<td rowspan="2"><div class="ctrlHolder">
  <label for="txt_tarea">Tarea a realizar</label>
  <br>
  <textarea name="txt_tarea" id="txt_tarea" rows="4" class='validate[required,maxSize[1000]] textarea_small'  style="width:450px"><?php echo $tarea;?>
  </textarea>
  <p class="formHint"> Descripci&oacute;n de la actividad a realizar</p>
</div></td>
</tr>
<tr>
  <td><div class="ctrlHolder">
    <label for="txt_tip_eva_abr2">Hora</label>
    <br>
    <select name="hora" size="1" class="negro4">
      <option value="">Elegir Hora</option>
      <?php
					 include_once("../funciones/aplica_config_global.php");
            
					$fecha = date("Y-m-d");
            $timestamp = strtotime($fecha.' 07:00:00')-900;
            $timestamp_limite = strtotime($fecha.' 19:00:00');
            do
            {
                  $timestamp += 900;
                  $hora = date("h:i a", $timestamp);
									$hora_val = str_replace(" ","",$hora);
									if ($hora_bd==$hora_val){$seleccionado="SELECTED = SELECTED";} else {$seleccionado="";}
                echo "<option value=".$hora_val."  $seleccionado>".$hora."</option>";
            } while ($timestamp < $timestamp_limite);
                   
            ?>
    </select>
    <p class="formHint"> (*) Seleccione</p>
  </div></td>
</tr> 


<tr>
  <td colspan="2"><div class="ctrlHolder" id="ctrl_estatus">
    <label for="chk_ter">Estatus</label>
    <label for="chk_ter">
      <input type="checkbox" name="chk_ter" id="chk_ter" class="active" <?php echo $cerrado;?>>
      Terminada</label>
    <hr />

    <div>
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
  <button type="submit" formaction="<?php echo "agenda.php?id_func=".$_GET["id_func"]."&accion=modificar" ?>" class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all">
  <span class="ui-button-text"><img src="../images/icons_menu/x32/save1_x32.png" width="20" height="20" align="absmiddle">&nbsp;Guardar cambios</span>
  </button>
  <?php } // cierro si permite crear=guardar ?>
  <?php 
if ($array_permisos["eliminar"]==true) { 
	$url_elim="agenda.php?id_func=".$_GET["id_func"]."&accion=eliminar&id_elim=".$id_apunte;
	
?>

  <button onclick="if (confirmElim()){window.location='<?php echo $url_elim;?>';}" type="button"  class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all">
  <span class="ui-button-text"><img src=../images/icons_menu/x32/elim_papelera_x32.png width="20" height="20" align="absmiddle">&nbsp;Eliminar</span>
  </button>
  <?php 
} 
//fin de si muestra boton elminar
?>
  <button id="btn_reset" name="btn_reset" class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" type="reset" onclick="jQuery('#form_editar').validationEngine('hide');$('#txt_id_func').focus();">
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