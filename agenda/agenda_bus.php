<!DOCTYPE HTML>
<html>
<head>
<?php 			
	unset($_SESSION["msg"]);
?>
<!-- Meta -->
<meta http-equiv="Content-Type" content="text/html; 
charset=<?php echo $_SESSION['juego_caracteres'];//esta variable se declara en modulo verificar login?>">
</head>
<!-- PARA BUSCAR-->    
                  
<form id="form_buscar" name="form_buscar" action="<?php echo "agenda.php?id_func=".$_GET["id_func"]."&accion=buscar" ?>" method="post" enctype="multipart/form-data" class="uniForm">
<fieldset>
<legend>Buscar:</legend>
<table align="center" width="100%">
<tr>
<td width="180PX">
<div class="ctrlHolder">
<label for="texto11">Fecha desde<br>
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
changeYear: true,
numberOfMonths: 1,
onClose: function(dateText, inst) {
						var endDateTextBox = $("#texto12");
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
								$("#texto12").datetimepicker("option", "minDate", new Date(start.getTime()));
						}
}); 
</script>  

<!--FIN DEL CALENDARIO DESDE-->																		
</div>
</td>
<td width="200">
  <div class="ctrlHolder">
  <label for="txt_fin">Fecha hasta<br>
  <input  name="texto12" type="text" class="fecha_corta validate[custom[date],required]" id="texto12" value="<?php if (!empty($_POST["texto12"])){echo $_POST["texto12"];} else {$fecha=date("d-m-Y"); echo $fecha;}?>"  maxlength="10"/>
  <!--<a name='texto11' style="cursor:pointer;">
</a>-->
  </label>
  <p class="formHint"> (*) Formato dd-mm-yyyy </p>
  <!-- SCRIPT PARA EL CALENDARIO-->
  <script type="text/javascript">
$("#texto12").datepicker({
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
        var startDateTextBox = $("#texto11");
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
        $("#texto11").datetimepicker("option", "maxDate", new Date(end.getTime()) );
    }
}); 
</script>  
    
  <!--FIN DEL CALENDARIO DESDE-->																		
  </div>
</td>
<td>  
  <button formaction="<?php echo "agenda.php?id_func=".$_GET["id_func"]."&accion=buscar" ?>" class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" type="submit">
  <span class="ui-button-text"><img src="../images/icons_menu/x32/find_x32.png" width="20" height="20" align="absmiddle">&nbsp;Buscar</span>
  </button>
 
</td>
</tr>
</table>   
</fieldset>            
</form>
</legend>
<?php 
	if (isset($_POST["texto11"]) && isset($_POST["texto12"]) && isset($_GET['id_func'])){
		 include_once("../funciones/aplica_config_global.php");
		$id_personal=$_SESSION["id_usuario"];
		$desde=date("Y-m-d",strtotime($_POST['texto11']));
		$hasta=date("Y-m-d",strtotime($_POST["texto12"]));
		$consulta=ejecuta_sql("select agenda_pers.*,datos_per.nombres,datos_per.apellidos from (agenda_pers INNER JOIN datos_per on datos_per.id_personal=agenda_pers.id_personal) where date(fecha_act) BETWEEN '$desde' AND '$hasta' AND agenda_pers.id_personal='$id_personal' ORDER BY fecha_act ASC",true); 
		if ($consulta)
			{
				if (mysql_num_rows($consulta)==1) {
					$fila=mysql_fetch_array($consulta);
					$url="agenda.php?id_func=".$_GET['id_func']."&accion=mostrar&id_mos=".$fila['id_apunte'];
					echo '
					<script type="text/javascript">
						window.location="'.$url.'";
					</script>';
					//header("location:$url");
					exit();
					} 
					//cierro si solo se encontro un registro
				else
				{
?>
<table id="tablasinbtn" class="letra_16 mouse_hover" width="..."> 
        <thead> 
          <tr>
            <th width="70px">FECHA</th>
            <th width="70px">HORA</th>
            <th width="...">TAREA</th>

            <th width="...">ESTATUS</th>
            <th width="..." title="Usuario que efectu&oacute; la actuaci&oacute;n">U.</th>
            <?php if ($array_permisos["mostrar"]==true) {?>
            <th title="DETALLES" width="80px">DETALLE</th>
            <th width="80px">ELIM</th>
            <?php }?>
          </tr> 
        </thead> 
        <tbody> 
        
        <?php

				while ($fila=mysql_fetch_array($consulta))
				{
					$hora=formato_fecha("H12",$fila["fecha_act"]);
					//$hora=date("h:m a",strtotime($fila["fecha_act"]));
					$fecha_act=date("d-m-Y",strtotime($fila["fecha_act"]));

					$tarea=$fila["descripcion"];
					$id_apunte=$fila["id_apunte"];
				?>
          <tr>
            <td align="center"><?php echo $fecha_act;?></td>
            <td align="center"><?php echo $hora;?></td>
            <td align="left"><?php echo $tarea;?></td>
            
            <td align="center"><?php 
							if ($fila["cerrada"]==true){
								echo "Finalizada";
							} else {
							echo "Pendiente";}
						?></td>
            <td align="center">
            
							<a href="#" class="tooltip" title="<?php echo $fila["nombres"]." ".$fila["apellidos"]."<br>".formato_fecha("LH",$fila["fecha_act"]);?>"><img src="../images/sistema/user_comment.png" width="20px" height="20px" ></a>
            </td>
            <!-- si permite editar muestro el boton que permite enviar la varible edicion oculta y permite editar -->
            <!-- agrego la opcion de eliminar -->
            <?php if ($array_permisos["mostrar"]==true) {?>
            <td align="center">
 							<a id="resize" href="agenda.php?<?php echo "id_func=".$_GET['id_func']."&accion=mostrar&id_mos={$fila['id_apunte']}";?>" class=" ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" style="font-size:10px;padding:2px; color:#000000;" width="45%" height="90%" title="Mostrar / editar" >&nbsp;
                  <img src='../images/sistema/computer_go.png' width='20' heigth='16px' align='absmiddle'></img>&nbsp;Mostrar&nbsp;
              </a>            
              </td>
              <?php
									$url_elim="agenda.php?id_func=".$_GET["id_func"]."&accion=eliminar&id_elim=".$id_apunte;
							?>
            <td align="center"> 							<a id="resize" href="<?php echo $url_elim;?>" class=" ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" style="font-size:10px;padding:2px; color:#000000;" width="45%" height="90%" title="Eliminar" onClick="return confirmElim()" >&nbsp;
                  <img src='../images/icons_menu/x32/elim_papelera_x32.png' width='20' heigth='16px' align='absmiddle'></img>&nbsp;Elim.&nbsp;</td>
            <?php 
              }
            ?>
            
          </tr> 
         <?php 
         } //fin de ciclo while
         ?>
        </tbody> 
  </table>
  <?php
			}
			}// fin de si hubo consulta
	} //cierro el si se envio el form  
	?>
<!-- FIN DE BUSCAR-->		
</html>