<!DOCTYPE HTML>
<html>
<head>
<!-- Meta -->
<meta http-equiv="Content-Type" content="text/html; 
charset=<?php echo $_SESSION['juego_caracteres'];//esta variable se declara en modulo verificar login?>">
</head>
<!-- PARA BUSCAR-->    
                  
<table align="center" width="100%">
<tr>
  <td width="180PX">
  <?php
  $txt_desde="txt_desde";
	$txt_hasta="txt_hasta";
	$id_btn_cal1="boton1";
	$id_btn_cal2="boton2";
	if (!empty($_GET["id_func"])) {
		$id_func=$_GET["id_func"];
	} else {
		if (!empty($_GET["id_func"])) {
			$id_func=$_GET["id_func"];
		} else
		$id_func="";
	}
	
	if (!empty($_POST["txt_desde"]) && !empty($_POST["txt_hasta"])){
		$val_desde=$_POST["txt_desde"];
		$val_hasta=$_POST["txt_hasta"];
	} else {
		$val_desde="";
		$val_hasta="";

	}
		
	$box_agenda='<!----BOX1............................................ -->
		<div class="box ui-widget ui-widget-content ui-corner-all portlet ui-helper-clearfix">
	  	<div class="portlet-header ui-widget-header ui-corner-all">
       	<!--<span class="ui-icon ui-icon-circle-arrow-s"></span>-->
      	Consulta de conexiones:
      </div> <!--fin de portlet header-->
			<div class="portlet-content">
      	<p>
        <form action="logs.php?id_func='.$id_func.'&accion=mostrar" method="post" name="frm_con_agenda" class="">
				<label for="{$txt_desde}">Desde<br>
					<input type="text" name="'.$txt_desde.'" id="'.$txt_desde.'" class="fecha_corta"  maxlength="10" value="'.$val_desde.'"/>
						<a name='.$txt_desde."1".' style="cursor:pointer;">
						</a>
				</label>
				<!-- SCRIPT PARA EL CALENDARIO-->
          <script type="text/javascript">
					$("#'.$txt_desde.'").datepicker({
   					showOn: "both",
						regional:"es",
						dateFormat: "dd-mm-yy",
						minDate: new Date(2012, 1 - 1, 1), 
   					buttonImage: "../images/icons_menu/x32/calendario1_x32.png",
						showButtonPanel: true,
   					buttonImageOnly: true,
   					changeYear: true,
   					numberOfMonths: 1,
						onClose: function(dateText, inst) {
						var endDateTextBox = $("#'.$txt_hasta.'");
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
								$("#'.$txt_hasta.'").datetimepicker("option", "minDate", new Date(start.getTime()));
						}
									}); 
        </script>  
				<!--FIN DEL CALENDARIO DESDE-->																		
																						
		<label for="{$txt_hasta}">Hasta<br>
			<input type="text"  name="'.$txt_hasta.'" id="'.$txt_hasta.'" class="fecha_corta"  maxlength="10" value="'.$val_hasta.'"/>
			<a name='.$txt_hasta."1".' style="cursor:pointer;"></a>
		</label>
						<!-- SCRIPT PARA EL CALENDARIO-->
          <script type="text/javascript">
					$("#'.$txt_hasta.'").datepicker({						
   					showOn: "both",
						regional:"es",
						dateFormat: "dd-mm-yy",
						minDate: new Date(2012, 1 - 1, 1), 
   					buttonImage: "../images/icons_menu/x32/calendario1_x32.png",
   					buttonImageOnly: true,
						showButtonPanel: true,
   					changeYear: true,
   					numberOfMonths: 1,
						
 onClose: function(dateText, inst) {
        var startDateTextBox = $("#'.$txt_desde.'");
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
        $("#'.$txt_desde.'").datetimepicker("option", "maxDate", new Date(end.getTime()) );
    }
							}); 
				</script><!--FIN DEL CALENDARIO-->
<input name="mostrar" type="submit" value="Mostrar"  class="ui-button ui-widget ui-state-default ui-corner-all" title="Consultar registros para el rango de fecha seleccionado">

			<input name="limpiar" type="reset"  value="Limpiar"  class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" title="Limpiar campos de fecha">
		<input type="hidden" value="$id_func" id="id_func" name="id_func">
		</form>   
		
		</p>
</div> <!--fin de portlet content-->
</div> <!--FIN BOX1............................................................. -->';
echo $box_agenda;
?>
  </td>
</tr>
</table>   
<?php 

	if (!empty($_POST["txt_desde"]) && !empty($_POST["txt_hasta"])){
		$desde=date("Y/m/d",strtotime($_POST['txt_desde']));
		$hasta=date("Y/m/d",strtotime($_POST['txt_hasta']));
		$consulta=ejecuta_sql("select * from logs where  date(fecha) BETWEEN '$desde' AND '$hasta' order by fecha desc",true);
		//$sql_q=("select * from logs where  date(fecha) BETWEEN '$desde' AND '$hasta' order by fecha desc");		
	} else {
		date_default_timezone_set("America/Caracas");
		$desde=date("Y/m/d");
		$hasta=date("Y/m/d");

$consulta=ejecuta_sql("select * from logs where  date(fecha) BETWEEN '$desde' AND '$hasta' order by fecha desc",true);	}
		if ($consulta)
			{
				
?>
<table id="tablasinbtn" class="letra_16 mouse_hover" width="..."> 
<tfoot>hola</tfoot>
        <thead> 
        
          <tr>
          	<th>N&deg;</th>
            <th>DIRECCI&Oacute;N IP&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
            <th>PUERTO</th>
            <th>DETALLES</th>
            <th>URL</th>
            <th>USUARIO</th>
            <th>FECHA</th>
          </tr> 
        </thead> 
        <tbody> 
        <?php
				include_once("../funciones/funcionesPHP.php");
				$tot_registros=0;
				while ($fila=mysql_fetch_array($consulta))
				{
					$tot_registros++;
				?>
          <tr>
            <td><?php echo "$tot_registros";?></td>
            <td><?php echo $fila["ip"]?></td>
            <td><?php echo $fila["puerto"]?></td>
            <td><?php echo $fila["detalles"]?></td>
            <td><?php echo $fila["url_pagina"]?></td>
            <td><?php echo $fila["usuario"]?></td>
            <td><?php echo formato_fecha("CH",$fila["fecha"])?></td>
            <!-- si permite editar muestro el boton que permite enviar la varible edicion oculta y permite editar -->
            <!-- agrego la opcion de eliminar -->
            <?php if ($array_permisos["mostrar"]==true) {?>
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
			//}// fin de si hubo consulta
	} //cierro el si se envio el form  
	?>
<!-- FIN DE BUSCAR-->		
</html>