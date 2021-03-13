<!DOCTYPE HTML>
<html>
<head>
<!-- Meta -->
<meta http-equiv="Content-Type" content="text/html; 
charset=<?php $_SESSION['juego_caracteres'];//esta variable se declara en modulo verificar login?>">
</head>
                  
<form id="form_crear" name="form_crear" action="<?php echo "agenda.php?id_func=".$_GET["id_func"]."&accion=guardar" ?>" method="post" enctype="multipart/form-data" class="uniForm">
<!-- Fieldset -->
  
<fieldset>
<legend>DATOS:</legend>

<table  width="..." border="0">
<tr>
<td width="...">
  
  <div class="ctrlHolder">
<label for="texto11">Fecha apunte<br>
<input  name="texto11" type="text" class="fecha_corta validate[custom[date],required]" id="texto11" value="<?php if (!empty($_POST["texto11"])){echo $_POST["texto11"];} else {$fecha=date("d-m-Y"); echo $fecha;}?>"  maxlength="10"/>
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
  <textarea name="txt_tarea" id="txt_tarea" rows="4" class='validate[required,maxSize[1000]] textarea_small'  style="width:450px"></textarea>
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
                echo "<option value=".$hora_val.">".$hora."</option>";
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
      <input type="checkbox" name="chk_ter" id="chk_ter" class="active">
      Terminada</label>
    <hr />

    <div>
  </div></td>
</tr>
<tr><td colspan="2">
<?php if ($array_permisos["crear"]==true) { ?>         
<button type="submit" formaction="<?php echo "agenda.php?id_func=".$_GET["id_func"]."&accion=guardar" ?>" class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" id="btn_guardar">
<span class="ui-button-text"><img src="../images/icons_menu/x32/save1_x32.png" width="20" height="20" align="absmiddle">&nbsp;Guardar</span>
</button>
<?php } // cierro si permite crear=guardar ?>

<button id="btn_reset" name="btn_reset" class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" type="reset" onclick="jQuery('#form_crear').validationEngine('hide');$('#txt_id_func').focus();">
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