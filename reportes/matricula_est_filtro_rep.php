<!DOCTYPE HTML>
<html>
<head>
<!-- Meta -->
<meta http-equiv="Content-Type" content="text/html; 
charset=<?php echo $_SESSION['juego_caracteres'];//esta variable se declara en modulo verificar login?>">
</head>
<!-- PARA BUSCAR-->    
                  
<form id="form_buscar" name="form_buscar" action="<?php echo "matricula_est_rep.php?id_func=".$_GET["id_func"]."&accion=ver_reporte" ?>" method="post" enctype="multipart/form-data" class="uniForm" target="_blank" class="formular">
<fieldset>
<legend>Buscar asignaciones:</legend>
<table align="center" width="100%">
<tr>
  <td colspan="4"><div class="ctrlHolder">
<?php
if (isset($_SESSION['id_grupo_usuario']) && $_SESSION['id_grupo_usuario']=="G0001"){
$sql="select cod_plantel,den_plantel from instituciones where activa=true order by den_plantel,id_dis_esc asc";
} else {
$sql="select cod_plantel,den_plantel from instituciones where activa=true and cod_plantel='".$_SESSION["cod_plantel_ses"]."' order by den_plantel,id_dis_esc asc";
}
$consulta=ejecuta_sql($sql,0);
?>
<label for="cmb_plan">Plantel o instituci&oacute;n</label><br>
            <SELECT NAME="cmb_plan" id="cmb_plan" SIZE=1  class="lf validate[required]" style="width:98%" onChange="$('#cmb_anno_esc option:selected').removeAttr('selected');$('#cmb_director').html('');"> 
            
            
                
                <?php 
								//si esta vacio el codigo de sesion del plantel es porq es administrador entonces pido que seleccione el plantel si no lo coloco directamente para buscar las secciones por grado para el codigo sesion del plantel
								if (empty($_SESSION["cod_plantel_ses"])){
									echo '<option value="">SELECCIONE...</option>';
								} 
if ($consulta && mysql_num_rows($consulta)>0){
while ($fila=mysql_fetch_array($consulta)) {
	?>
                <OPTION VALUE='<?php echo $fila['cod_plantel']?>' <?php if (isset($_POST["cmb_plan"]) && $_POST["cmb_plan"]==$fila['cod_plantel']){echo " selected";} ?>><?php echo $fila["den_plantel"]; ?></OPTION>";
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

<label for="cmb_director">Director(a)</label>
<br>
   <SELECT NAME="cmb_director" id="cmb_director" SIZE=1  class="lf validate[required]" style="width:98%"> 
     <option value="">SELECCIONE...</option>
   </SELECT>
              <p class="formHint"> (*) Seleccione qui&eacute;n firmar&aacute; la constancia</p>
</div></td>
  <td><div class="ctrlHolder">
<label for="fecha_desde">Fecha desde<br>
<input  name="fecha_desde" type="text" class="fecha_corta validate[custom[date],required]" id="fecha_desde" value="<?php if (!empty($_POST["fecha_desde"])){echo $_POST["fecha_desde"];} else {$fecha=date("d-m-Y"); echo $fecha;}?>"  maxlength="10"/>
<!--<a name='fecha_desde' style="cursor:pointer;">
</a>-->
</label>
<p class="formHint"> (*) Formato dd-mm-yyyy</p>
<!-- SCRIPT PARA EL CALENDARIO-->
<script type="text/javascript">
$("#fecha_desde").datepicker({
showOn: "both",
regional:"es",
dateFormat: "dd-mm-yy",
minDate: new Date(1920, 1 - 1, 1), 
buttonImage: "../images/icons_menu/x32/calendario1_x32.png",
showButtonPanel: true,
buttonImageOnly: true,
changeYear: true,
numberOfMonths: 1,
onClose: function(dateText, inst) {
						var endDateTextBox = $("#fecha_hasta");
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
								$("#fecha_hasta").datetimepicker("option", "minDate", new Date(start.getTime()));
						}
									});
</script>  

<!--FIN DEL CALENDARIO DESDE-->																		
</div></td>
<td>
<div class="ctrlHolder">
  <label for="fecha_hasta">Fecha hasta<br>
  <input  name="fecha_hasta" type="text" class="fecha_corta validate[custom[date],required]" id="fecha_hasta" value="<?php if (!empty($_POST["fecha_hasta"])){echo $_POST["fecha_hasta"];} else {$fecha=date("d-m-Y"); echo $fecha;}?>"  maxlength="10"/>
  <!--<a name='fecha_desde' style="cursor:pointer;">
</a>-->
  </label>
  <p class="formHint"> (*) Formato dd-mm-yyyy </p>
  <!-- SCRIPT PARA EL CALENDARIO-->
  <script type="text/javascript">
$("#fecha_hasta").datepicker({
showOn: "both",
regional:"es",
dateFormat: "dd-mm-yy",
minDate: new Date(1920, 1 - 1, 1), 
buttonImage: "../images/icons_menu/x32/calendario1_x32.png",
showButtonPanel: true,
buttonImageOnly: true,
changeYear: true,
numberOfMonths: 1,
onClose: function(dateText, inst) {
        var startDateTextBox = $("#fecha_desde");
        if (startDateTextBox.val() != "") {
            var testStartDate = new Date(startDateTextBox.val());
            var testEndDate = new Date(dateText);
            if (testStartDate > testEndDate)
                startDateTextBox.val(dateText);
        }
        else {
            startDateTextBox.val(dateText);
        }
    },
    onSelect: function (selectedDateTime){
        var end = $(this).datetimepicker("getDate");
        $("#fecha_desde").datetimepicker("option", "maxDate", new Date(end.getTime()) );
    }
}); 
</script>  
    
  <!--FIN DEL CALENDARIO DESDE-->																		
  </div>
</td>
</tr>
<tr>
  <td width="5px"><div class="ctrlHolder">
    <label for="cmb_anno_esc">A&ntilde;o escolar</label>
    <br>
    <SELECT NAME="cmb_anno_esc" id="cmb_anno_esc" SIZE=1 class="sf validate[required]" onchange="$('#cmb_gra').html('');$('#cmb_secc').html('');$('#cmb_asig').html('');"> 
    <option value="">SELECCIONE...</option>
    <?php
      //include_once("../funciones/funcionesPHP.php");
			if (isset($_SESSION['id_grupo_usuario']) && ($_SESSION['id_grupo_usuario']=="G0001" ||  $_SESSION['id_grupo_usuario']=="G0002" ||  $_SESSION['id_grupo_usuario']=="G0003")){
      $consulta=ejecuta_sql("select	cod_anno_esc from anno_esc_me where visible=true order by cod_anno_esc DESC",true);} else {
				$consulta=ejecuta_sql("select	cod_anno_esc from anno_esc_me where cerrado=false order by cod_anno_esc DESC",true);
				
			}      //si hay registros para mostrar
      if ($consulta){
			
      while ($fila=mysql_fetch_array($consulta)){
        //if (!empty($_POST["cmb_anno_esc"]) && $_POST["cmb_anno_esc"]==$fila['cod_anno_esc']){$seleccionado= " SELECTED=SELECTED ";} else {$seleccionado= "";};			
        echo "<OPTION VALUE='".$fila['cod_anno_esc']."' >".$fila["cod_anno_esc"]."</OPTION>";
      }
      }
    ?>
    </SELECT>
    <p class="formHint"> (*) a&ntilde;o escolar a inscribir</p>
    </div></td>
<td><button formaction="<?php echo "matricula_est_rep.php?id_func=".$_GET["id_func"]."&accion=ver_reporte" ?>" class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" type="submit" formtarget="_blank"> <span class="ui-button-text"><img src="../images/sistema/mos_rep.png" width="20" height="20" align="absmiddle">&nbsp;Mostrar reporte</span> </button>
  <input type="checkbox" name="chk_des" id="chk_des">
  <label for="chk_des">Descargar</label></td>
<td>

</td>
<td>&nbsp;</td>  
</tr>
</table>   
</fieldset>            
</form>
</html>