<!DOCTYPE HTML>
<html>
<?php 
include_once("../funciones/aplica_config_global.php");
require_once("../funciones/conexion.php");
require_once("../funciones/funcionesPHP.php");
require_once("../funciones/encriptado.php");
include_once("../funciones/errores_genericos.php");
//require_once("../funciones/fechas_func.php");
//include_once("../funciones/mostrar_iconos_comandos.php");
session_start();
/*
if (isset($_REQUEST["id_func"])){
$array_permisos=verificar_acceso_pagina($_REQUEST['id_func']);} else{
$array_permisos=verificar_acceso_pagina("000");}
*/
 //verifico si el usuario tiene acceso a la pagina o si el usuario ingreso la url correcta (que corresponde al id de la funcion ejecutada)
//print_r($array_permisos); muestro los valores obtenidos del array consulta de permisos
//verificar_accion();//verifico si se ha presionado editar o eliminar y ejecuta las acciones solicitadas
?><head>
<script type="text/javascript">
function confirmSubmit()
{
var agree=confirm("¿Está seguro de eliminar este registro?, también se eliminarán los privilegios asociados a ésta función; tenga en cuenta que esta acción es irreversible por lo tanto debe tener cuidado al eliminar una función.");
if (agree)
return true ;
else
return false ;
}
function confirm_elim_telf()
{
var agree=confirm("¿Está seguro de eliminar este teléfono?");
if (agree)
return true ;
else
return false ;
}
function confirma_elim_varios()
{
var agree=confirm("¿Está seguro de eliminar los registros seleccionados, también se eliminarán los privilegios asociados a ésta función; tenga en cuenta que esta acción es irreversible por lo tanto debe tener cuidado al eliminar una función.");
if (agree)
return true ;
else
return false ;
}

</script>

  <!-- Meta -->
  <meta http-equiv="Content-Type" content="text/html; charset=<?php if (isset($_SESSION['juego_caracteres'])){ echo $_SESSION['juego_caracteres'];} else echo "utf-8";//esta variable se declara en modulo verificar login?>">
	<title><?php echo $_SESSION["app_nombre"]."-".$_SESSION["app_version"]; ?> - Agregar direcci&oacute;n de habitaci&oacute;n</title>
  <!-- End of Meta -->
    <!-- Scripts Graybox -->

  <!-- ojo dejarlo en este orden porq si no no funciona la validacioon del form-->
  <script type="text/javascript" src="../js/jquery-1.7.1.min.js" charset="utf-8"></script>
	<script type="text/javascript" src="../js/valida_input_file.js" charset="utf-8"></script>
  <script type="text/javascript" src="../js/jquery-ui-1.8.18.custom.min.js" charset="utf-8"></script>
  <script type="text/javascript" src="../js/validaciones/check_all.js" charset="utf-8"></script>
  
  <!-- para las validaciones del formulario es -->  
	<link rel="stylesheet" href="../js/validaciones/jQuery-Validation/css/validationEngine.jquery.css" type="text/css"/>
	<link rel="stylesheet" href="../js/validaciones/jQuery-Validation/css/template.css" type="text/css"/>
	<script src="../js/validaciones/jQuery-Validation/js/languages/jquery.validationEngine-es.js" type="text/javascript" charset="utf-8"></script>
	<script src="../js/validaciones/jQuery-Validation/js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
	<script>
		jQuery(document).ready( function() {
			// binds form submission and fields to the validation engine
			jQuery("#form").validationEngine({autoHidePrompt:true,autoHideDelay: 3500});
			$('#cmb_estado').focus(); //coloco el cursor en el primer campo
		});
	</script>
	<!-- fin de las validaciones -->

  <!-- tema wide -->
  <link href="../ccs/forms/default.uni-form.css" title="Default Style" media="all" rel="stylesheet"/>
  <link type="text/css" href="../wideadmin_files/layout.css" rel="stylesheet">	
  <!--fin del validacion uniform-->

 <!-- para el datatables ================================================== -->
  <style type="text/css" media="all">
  @import url("../js/DataTables-1.9.0/media/css/TableTools_JUI.css");
  @import url("../js/DataTables-1.9.0/media/themes/<?php if (isset($_SESSION["tema"])) echo $_SESSION['tema']; else echo "siregest";?>/jquery-ui-1.8.18.custom.css");
  </style>
 
 
  <script charset="utf-8" src="../js/DataTables-1.9.0/media/js/jquery.dataTables.min.js"></script>
  <script charset="utf-8" src="../js/DataTables-1.9.0/media/js/ZeroClipboard.js"></script>
  <script charset="utf-8" src="../js/DataTables-1.9.0/media/js/TableTools.js"></script>
  <script charset="utf-8" src="../js/DataTables-1.9.0/media/js/ColReorderWithResize.js"></script>
  <script charset="utf-8" src="../js/DataTables-1.9.0/media/js/ColVis.min.js"></script>

 
<!-- para los box encima de las paginas -->
<!-- Add mousewheel plugin (this is optional) -->
<!--<script type="text/javascript" src="/fancybox/lib/jquery.mousewheel-3.0.6.pack.js"></script>-->

<!-- Add fancyBox -->
<link rel="stylesheet" href="../js/fancybox/jquery.fancybox.css?v=2.0.5" type="text/css" media="screen" />
<script type="text/javascript" src="../js/fancybox/jquery.fancybox.pack.js?v=2.0.5"></script>

<!-- Optionally add button and/or thumbnail helpers -->
<!--<link rel="stylesheet" href="../js/fancybox/helpers/jquery.fancybox-buttons.css?v=2.0.5" type="text/css" media="screen" />
<script type="text/javascript" src="../js/fancybox/helpers/jquery.fancybox-buttons.js?v=2.0.5"></script>

<link rel="stylesheet" href="../js/fancybox/helpers/jquery.fancybox-thumbs.css?v=2.0.5" type="text/css" media="screen" />
<script type="text/javascript" src="../js/fancybox/helpers/jquery.fancybox-thumbs.js?v=2.0.5"></script>-->
<script type="text/javascript">
$(document).ready(function() {
	//el id del a href que queremos cambiar siempre sera resize y el tamaño se debe agregar en la propiedad width y heigh al hacer el enlace
	// tamaño fijo:
		$(".resize").fancybox({
		maxWidth	: 1024,
		maxHeight	: 768,
		fitToView	: false,
		width     : '75%',
    height    : '95%',
		autoSize	: false,
		closeClick	: true,
		openEffect	: 'fade',
		closeEffect	: 'fade'
	});
		$(".resize_small").fancybox({
		maxWidth	: 1024,
		maxHeight	: 768,
		fitToView	: false,
		width     : '50%',
    height    : '70%',
		autoSize	: false,
		closeClick	: true,
		openEffect	: 'fade',
		closeEffect	: 'fade'
	});
	
	//-------------- congiguro el datatables
				$('#tabla_tel').dataTable( {
					"aaSorting": [[ 1, "asc" ]],
						/*"aoColumns": [
							null,
							null,
							null,
							null
						],
						*/
					"bJQueryUI": true,
					"aLengthMenu": [[10, 25, 50, 100,500, -1], [10, 25, 50, 100,500, "Mostrar todos"]],
					"sPaginationType": "full_numbers",
					"sDom": '<""R>t<"">',
					"oTableTools": {
					}										
					})

				$('#tabla_dir').dataTable( {
					"aaSorting": [[ 1, "asc" ]],
						/*"aoColumns": [
							null,
							null,
							null,
							null
						],
						*/
					"bJQueryUI": true,
					"aLengthMenu": [[10, 25, 50, 100,500, -1], [10, 25, 50, 100,500, "Mostrar todos"]],
					"sPaginationType": "full_numbers",
					"sDom": '<""R>t<"">',
					"oTableTools": {
					}										
					})
				$('#tablasinbtn').dataTable( {
					"aaSorting": [[ 1, "asc" ]],
						/*"aoColumns": [
							null,
							null,
							null,
							null
						],
						*/
					"bJQueryUI": true,
					"aLengthMenu": [[10, 25, 50, 100,500, -1], [10, 25, 50, 100,500, "Mostrar todos"]],
					"sPaginationType": "full_numbers",
					"sDom": '<"H"Rflip>t<"F"flip>',
					"oTableTools": {
						"sSwfPath": "../js/DataTables-1.9.0/media/swf/copy_cvs_xls_pdf.swf",
						"aButtons": [
							"copy", "csv", "xls", "pdf",//"print",
							{
								"sExtends":    "collection",
								"sButtonText": "Guardar",
								"aButtons":    [ "csv", "xls", "pdf" ]
							}
						]
					}										
					})

});	

</script>
  <!-- fin fancy box -->
  <!-- este debe ir siempre al final para que me pueda mostrar el menu -->
   <script type="text/javascript" src="../wideadmin_files/custom.js"></script>
   
	</head>
  <body background="">

<form id="form" name="form"  action="datos_per_agr_dir.php?id_func=<?php if (isset($_GET["id_func"])){echo $_GET['id_func'];}?>&accion=guardar_dir&id_per=<?php echo $_GET["id_per"];?>"  method="post" enctype="multipart/form-data" class="uniForm">
										<!-- Fieldset -->
	<fieldset>
										  <!--<legend>Configuración:</legend>-->
                      <h1 align="left" class="titulo_form_blue">
                      <img src="../images/world_add.png" width="32" height="32" align="absmiddle"> AGREGAR DIRECCI&Oacute;N DE HABITACI&Oacute;N</h1>
    <?php
if (isset($_GET["accion"])){
	$accion=strtoupper($_GET["accion"]);
	switch ($accion){
		case "GUARDAR_DIR":
			include_once("guardar_dir.php");
			guardar_direccion();
			break;
		default:
			//echo "No se recibio la accion a ejecutar";
			break;
	}
}

?>                      
                          <table align="center" width="...">
          <tr>
            <td><div class="ctrlHolder">
<?php

$sql_estado="select * from terr_estados";
$consulta=ejecuta_sql($sql_estado,0);
?>
              <label for="cmb_tip_dir">Estado</label>
              <br>
              <SELECT NAME="cmb_estado" id="cmb_estado" SIZE=1  class="mf validate[required]" onchange = "$('#cmb_pob option:selected').removeAttr('selected');this.form.submit()
"> 
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
              <p class="formHint"> Seleccione el estado territorial</p>
              
</div> </td>
            <td>
<div class="ctrlHolder">
<?php

$sql_estado="select * from tip_direcc";
$consulta=ejecuta_sql($sql_estado,0);
?>
              <label for="cmb_tip_dir">Tipo de direcci&oacute;n</label>
              <br>
              <SELECT NAME="cmb_tip_dir" id="cmb_tip_dir" SIZE=1  class="mf validate[required]"> 
                <option value="">SELECCIONE...</option>
                <?php 
if ($consulta && mysql_num_rows($consulta)>0){
while ($fila=mysql_fetch_array($consulta)) {
	?>
                <OPTION VALUE='<?php echo $fila['cod_tip_dir']?>' <?php if (isset($_POST["cmb_tip_dir"]) && $_POST["cmb_tip_dir"]==$fila['cod_tip_dir']){echo " selected";} ?>><?php echo $fila["tipo_direcc"]; ?></OPTION>";
<?php
	} // fin ciclo while
} // fin si hay mas registros >0
?>
              </SELECT>
              <p class="formHint"> Seleccione el tipo de direcci&oacute;n</p>
              
</div>            	
            </td>
            </tr> 
          <tr>
            <td><div class="ctrlHolder">
              <?php
if (isset($_POST["cmb_estado"])) {$cod_est=$_POST["cmb_estado"];} else {$cod_est="";}

$sql_mcpio="select * from terr_municipios where cod_estado_ter='$cod_est'";
$consulta=ejecuta_sql($sql_mcpio,0);
?>
              <label for="cmb_mcpio">Municipio</label>
              <br>
              <SELECT NAME="cmb_mcpio" id="cmb_mcpio" SIZE=1  class="mf validate[required]" onchange = "$('#cmb_pob option:selected').removeAttr('selected');;this.form.submit()"> 
                <option value="">SELECCIONE...</option>
                <?php 
if ($consulta && mysql_num_rows($consulta)>0){
while ($fila=mysql_fetch_array($consulta)) {
	?>
                <OPTION VALUE='<?php echo $fila['id_municipio']?>' <?php if (isset($_POST["cmb_mcpio"]) && $_POST["cmb_mcpio"]==$fila['id_municipio']){echo " selected";} ?>><?php echo $fila["municipio"]; ?></OPTION>";
<?php
	} // fin ciclo while
} // fin si hay mas registros >0
?>
              </SELECT>
              <p class="formHint"> Seleccione el estado territorial</p>
              
</div> </td>
<td rowspan="3">
<div class="ctrlHolder">
    <label for="txt_des_dir">Detalle de la direcci&oacute;n</label><br>
    <textarea name="txt_des_dir" id="txt_des_dir"  class='validate[required,maxSize[400],minSize[15]] textarea_large' cols="30"><?PHP if (!empty($_POST["txt_des_dir"])) echo $_POST["txt_des_dir"]; else echo "";?></textarea>
    <p class="formHint"> (*) Av. / calle / edificio - casa / piso / N&deg; vivienda</p>
    				</div>
</td>
            </tr>          
<tr>
            <td><div class="ctrlHolder">
              <?php
if (isset($_POST["cmb_mcpio"])) {$cod_mcpio=$_POST["cmb_mcpio"];} else {$cod_mcpio="";}
$sql_mcpio="select * from terr_parroquias where cod_estado_ter='$cod_est' and id_municipio='$cod_mcpio'";
$consulta=ejecuta_sql($sql_mcpio,0);
?>
              <label for="cmb_pob">Parroquia</label>
              <br>
              <SELECT NAME="cmb_par" id="cmb_par" SIZE=1  class="mf validate[required]" onchange = "this.form.submit()"> 
                <option value="">SELECCIONE...</option>
                <?php 
if ($consulta && mysql_num_rows($consulta)>0){
while ($fila=mysql_fetch_array($consulta)) {
	?>
                <OPTION VALUE='<?php echo $fila['id_parroquia']?>' <?php if (isset($_POST["cmb_par"]) && $_POST["cmb_par"]==$fila['id_parroquia']){echo " selected";} ?>><?php echo $fila["parroquia"]; ?></OPTION>";
<?php
	} // fin ciclo while
} // fin si hay mas registros >0
?>
              </SELECT>
              <p class="formHint"> Seleccione el estado territorial</p>
              
</div> </td>
            </tr> 
<tr>
            <td><div class="ctrlHolder">
              <?php
if (isset($_POST["cmb_par"])) {$cod_par=$_POST["cmb_par"];} else {$cod_par="";}
$sql_par="select * from terr_poblados where id_parroquia='".$cod_par."'  order by poblado";
$consulta=ejecuta_sql($sql_par,0);
?>
              <label for="cmb_pob">Poblado o sector</label>
              <br>
              <SELECT NAME="cmb_pob" id="cmb_pob" SIZE=1  class="mf validate[required]"> 
                <option value="">SELECCIONE...</option>
                <?php 
if ($consulta && mysql_num_rows($consulta)>0){
while ($fila=mysql_fetch_array($consulta)) {
	?>
                <OPTION VALUE='<?php echo $fila['id_poblado']?>' <?php if (isset($_POST["cmb_pob"]) && $_POST["cmb_pob"]==$fila['id_poblado']){echo " selected";} ?>><?php echo $fila["poblado"]; ?></OPTION>";
<?php
	} // fin ciclo while
} // fin si hay mas registros >0
?>
              </SELECT>
              <p class="formHint"> Seleccione el sector</p>
              
</div> </td>
</tr>          
<tr><td colspan="2">
					<button formaction="datos_per_agr_dir.php?id_func=<?php if (isset($_GET["id_func"])){echo $_GET['id_func'];}?>&accion=guardar_dir&id_per=<?php echo $_GET["id_per"];?>"  class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" type="submit" >
<span class="ui-button-text"><img src="../images/icons_menu/x32/diskette_x32.png" width="20" height="20" align="absmiddle">&nbsp;Guardar</span>
</button>



<button id="btn_reset" name="btn_reset" class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" type="reset" onclick="jQuery('#form').validationEngine('hide');$('#txt_id_func').focus();">
<span class="ui-button-text"><img src="../images/icons_menu/x32/limpiar_x32.png" width="20" height="20" align="absmiddle"> Reestablecer</span>
</button>

</td>
        </tr>
    </table><br>


	  </fieldset>
										<!-- End of fieldset -->
                                        
<!--
$tipo = array("", "gif", "jpg", "png");
$d = dir("../images/icons_menu/x32/");
echo "<table style='width=100%' border=\"1\"><tr><th><font <b>Imagen</b></font></th><th>Descripción</th></tr>";
$i = 1;
while($entry=$d->read()) {
if (is_dir($d->path.'/'.$entry)) {
}
$elemento = $d->path.'/'.$entry;
if (is_file($elemento)) {
$img = GetImageSize($elemento, $info);
if (isset($img))    {
    $mostrar = "<tr><td width=20% align=center valign=middle><img src=".$elemento." ></td><td>ancho: ".$img[0]."<br>alto: ".$img[1]."<br>";
    $mostrar .= "tipo: ".$tipo[$img[2]]."<br>valores: ".$img[3]."<br>info:".$info."</td></tr>";
    echo $mostrar;
    }
}
$i++;
}
echo "</table>";
$d->close();

-->
					</form> 
            </body>
 </html>
