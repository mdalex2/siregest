<!DOCTYPE HTML>
<html>
<?php 
include_once("../funciones/aplica_config_global.php");
require_once("../funciones/conexion.php");
include_once("../funciones/funcionesPHP.php");
require_once("../funciones/encriptado.php");
//require_once("../funciones/fechas_func.php");
//include_once("../funciones/mostrar_iconos_comandos.php");
session_start();
verifica_caducidad_sesion();
/*
if (isset($_REQUEST["id_func"])){
$array_permisos=verificar_acceso_pagina($_REQUEST['id_func']);} else{
$array_permisos=verificar_acceso_pagina("000");}
*/
 //verifico si el usuario tiene acceso a la pagina o si el usuario ingreso la url correcta (que corresponde al id de la funcion ejecutada)
//print_r($array_permisos); muestro los valores obtenidos del array consulta de permisos
//verificar_accion();//verifico si se ha presionado editar o eliminar y ejecuta las acciones solicitadas?>
<head>
<style>
	td a:hover {color: #06F;} 
</style>
  <!-- Meta -->
  <meta http-equiv="Content-Type" content="text/html; charset=<?php if (isset($_SESSION['juego_caracteres'])) echo $_SESSION['juego_caracteres']; else echo "utf-8";//esta variable se declara en modulo verificar login?>">
	<title>SIREGEST V.2012.1 - Agregar funciones</title>
  <!-- End of Meta -->
    <!-- Scripts Graybox -->

  <!-- ojo dejarlo en este orden porq si no no funciona la validacioon del form-->
  <script type="text/javascript" src="../js/jquery-1.7.1.min.js" charset="utf-8"></script>
	<script type="text/javascript" src="../js/valida_input_file.js" charset="utf-8"></script>
  <script type="text/javascript" src="../js/jquery-ui-1.8.18.custom.min.js" charset="utf-8"></script>
  <!-- para las validaciones del formulario es -->  
	<link rel="stylesheet" href="../js/validaciones/jQuery-Validation/css/validationEngine.jquery.css" type="text/css"/>
	<link rel="stylesheet" href="../js/validaciones/jQuery-Validation/css/template.css" type="text/css"/>
	<script src="../js/validaciones/jQuery-Validation/js/languages/jquery.validationEngine-es.js" type="text/javascript" charset="utf-8"></script>
	<script src="../js/validaciones/jQuery-Validation/js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
	<script>
		jQuery(document).ready( function() {
			// binds form submission and fields to the validation engine
			jQuery("#form_buscar").validationEngine({autoHidePrompt:true}); //cambiar #form por el nombre del formulario a validar
			$('#txt_id_func').focus(); //coloco el cursor en el primer text
		});
	</script>
	<!-- fin de las validaciones -->

  <!-- tema wide -->
  <link href="../ccs/forms/default.uni-form.css" title="Default Style" media="all" rel="stylesheet"/>
  <link type="text/css" href="../wideadmin_files/layout.css" rel="stylesheet">	
  <!--fin del validacion uniform-->

 <!-- para el datatables ================================================== -->
  <style type="text/css" media="all">
  @import url("../js/DataTables-1.9.0/media/themes/<?php if (isset($_SESSION["tema"])) echo $_SESSION['tema']; else echo "siregest";?>/jquery-ui-1.8.18.custom.css");
  </style>
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
	//-------------- congiguro el datatables
				$('#tablasinbtn').dataTable( {
					"oLanguage": {
			"sUrl": "../js/DataTables-1.9.0/media/lang/es_es.txt"
		},	
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
					
				$('#tabla_pla').dataTable( {
					"oLanguage": {
			"sUrl": "../js/DataTables-1.9.0/media/lang/es_es.txt"
		},	
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
				$('#tabla_email').dataTable( {
					"oLanguage": {
			"sUrl": "../js/DataTables-1.9.0/media/lang/es_es.txt"
		},	
					"aaSorting": [[ 0, "asc" ]],
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
					

});	

</script>  
    <script type="text/javascript" src="../wideadmin_files/custom.js"></script>

	</head>
  <body background="">
                      <h1 align="left" class="titulo_form_blue">
                      <img src="../images/icons_menu/x32/config.png" width="32" height="32" align="absmiddle"> ASIGNAR PLANTEL</h1>
                      <hr>  
                      
<?php
// si se envio la accion guardo el registro y salgo
if (isset($_GET["accion"]) && $_GET["accion"]=="guarda_asig" ){
	include_once("plantel_asig_guardar.php");
	guardar_asignacion();
}
                      
?>                   
                      
<form id="form_buscar" name="form_buscar" action="plantel_asig_frm.php?id_func=<?php if (isset($_GET["id_func"])){echo $_GET['id_func'];}?>&id_per=<?php echo $_GET["id_per"];?>" method="post" enctype="multipart/form-data" class="uniForm">
<fieldset>
<legend>Buscar:</legend>
<table align="center" width="100%">
<tr>
<td width="180PX">
<div class="ctrlHolder">
<label for="cmb_tip_bus">Tipo de busqueda</label>
<br>
<SELECT NAME="cmb_tip_bus" id="cmb_tip_bus" SIZE=1 class="sf validate[required]" onChange='
var valor = $("#cmb_tip_bus option:selected").html().toLowerCase();
$("#lbl_text_busc").text("Escriba "+valor+" a buscar");
$("#lbl_text_busc1").val("Escriba "+valor+" a buscar");
$("#txt_buscar").focus();'> 
<OPTION VALUE="cod" <?php if (isset($_POST["cmb_tip_bus"]) && $_POST["cmb_tip_bus"]=="cod") echo " selected " ?>>C&Oacute;DIGO DEA</OPTION>
<OPTION VALUE="den" <?php if (isset($_POST["cmb_tip_bus"]) && $_POST["cmb_tip_bus"]=="den") echo " selected " ?>>DENOMINACION</OPTION>
</SELECT>
<p class="formHint"> (*) Seleccione el tipo de b&uacute;squeda</p>
</div></td>
<td width="200">
<div class="ctrlHolder">

  <label for="txt_buscar" id="lbl_text_busc"><?php if (isset($_POST["lbl_text_busc1"])) echo $_POST["lbl_text_busc1"]; else echo " Escriba el c&oacute;digo a buscar"; ?></label><br>
  <input name="txt_buscar" type="text" class="validate[required,minSize[1]] text-input sf"  id="txt_buscar" tabindex="0" value="<?php if (isset($_POST['txt_buscar'])){ echo $_POST['txt_buscar'];}?>" maxlength="20" autofocus/>
  <input type="hidden" id="lbl_text_busc1" name="lbl_text_busc1" value="<?php if (isset($_POST["lbl_text_busc1"])) echo $_POST["lbl_text_busc1"]; else echo " Escriba el c&oacute;digo a buscar"; ?>">
  
  <p class="formHint"> (*) Requerido</p>
</div>
</td>
<td>  
<button formaction="plantel_asig_frm.php?id_func=<?php if (isset($_GET["id_func"])){echo $_GET['id_func'];}?>&id_per=<?php echo $_GET["id_per"];?>" class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" type="submit">
<span class="ui-button-text"><img src="../images/icons_menu/x32/find_x32.png" width="20" height="20" align="absmiddle">&nbsp;Buscar</span>
</button> &nbsp;
          <button class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" onclick="parent.$.fancybox.close();" title="Regresar">
          <span class="ui-button-text"><img src="../images/icons_menu/x32/stop_32.png" width="20" height="20" align="absmiddle"> Cerrar</span>
          </button>

</td>
</tr>
</table>   
</fieldset>            
</form>
</legend>
<?php 
	if (isset($_POST["txt_buscar"]) && isset($_POST["cmb_tip_bus"]) && isset($_GET['id_func'])){
		$sel_combo=strtoupper($_POST['cmb_tip_bus']);
		$texto_buscar=$_POST["txt_buscar"];
		switch ($sel_combo){
			case "COD":
				$campo_buscar="cod_plantel";
				break;
			case "DEN":
				$campo_buscar="den_plantel";
				break;
				$campo_buscar="cod_plantel";
				break;
		} //fin swith
		if ($texto_buscar=="*" || strtoupper($texto_buscar)=="TODO"){
			
		$consulta=ejecuta_sql("select cod_plantel,den_plantel,terr_estados.cod_estado_ter ,terr_estados.estado_ter,terr_poblados.poblado,instituciones.fecha_g,datos_per.nombres,datos_per.apellidos from (instituciones
INNER JOIN terr_poblados ON instituciones.id_poblado=terr_poblados.id_poblado 
INNER JOIN terr_estados ON terr_poblados.cod_estado_ter=terr_estados.cod_estado_ter
INNER JOIN datos_per ON datos_per.id_personal=instituciones.guardado_por
 ) ",true);}  else {
			
		$consulta=ejecuta_sql("select cod_plantel,den_plantel,terr_estados.cod_estado_ter ,terr_estados.estado_ter,terr_poblados.poblado,instituciones.fecha_g,datos_per.nombres,datos_per.apellidos from (instituciones
INNER JOIN terr_poblados ON instituciones.id_poblado=terr_poblados.id_poblado 
INNER JOIN terr_estados ON terr_poblados.cod_estado_ter=terr_estados.cod_estado_ter
INNER JOIN datos_per ON datos_per.id_personal=instituciones.guardado_por
 ) where $campo_buscar like '%".$texto_buscar."%'",true);} 
		if ($consulta)
			{
?>
<table id="tablasinbtn" class="letra_16 mouse_hover" width="..."> 
        <thead> 
          <tr>
            <th width="85px">C&Oacute;DIGO DEA</th>
            <th width="500px">PLANTEL / INSTITUCI&Oacute;N</th>
            <th width="190">UBICACI&Oacute;N</th>
             <th width="40px">USU.</th>
             <th width="120px">Guardar</th>

          </tr> 
        </thead> 
        <tbody> 
        <?php
				while ($fila=mysql_fetch_array($consulta))
				{
				?>
          <tr>
            <td><?php echo $fila["cod_plantel"]?></td>
            <td><?php echo $fila["den_plantel"]?></td>
            <td><?php echo $fila["estado_ter"]." / ".$fila["poblado"]?></td>
            <td align="center"><?php $fecha=formato_fecha("LH",$fila["fecha_g"]);echo "<img src='../images/sistema/user_comment.png' width='20' height='20' class='tooltip' title='".$fila["nombres"]." ".$fila["apellidos"]."<br/>".$fecha."'/>";?></td>
            <!-- si permite editar muestro el boton que permite enviar la varible edicion oculta y permite editar -->
            <!-- agrego la opcion de eliminar -->
            <td align="center">
            <form id="guarda_asig" name="guarda_asig" action="plantel_asig_frm.php?accion=guarda_asig&id_func=<?php if (isset($_GET["id_func"])){echo $_GET['id_func'];}?>&id_per=<?php echo $_GET["id_per"];?>" method="post" enctype="multipart/form-data">
            	<input type="hidden" name="txt_cod_pla_ocu" value="<?php echo $fila["cod_plantel"]?>">
              <input type="hidden" name="txt_id_usu_ocu" value="<?php echo $_GET["id_per"];?>">
 							<button type="submit" formaction="plantel_asig_frm.php?accion=guarda_asig&id_func=<?php if (isset($_GET["id_func"])){echo $_GET['id_func'];}?>&id_per=<?php echo $_GET["id_per"];?>" id="resize" class=" ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" style="font-size:10px;padding:2px; color:#000000;" width="45%" height="90%" title="Guardar asignaci&oacute;n" >&nbsp;
                  <img src='../images/sistema/computer_edit.png' width='20' height="20" heigth='16px' align='absmiddle'></img>&nbsp;Guardar asig.&nbsp;
              </button>            
              </form>
              </td>
            
          </tr> 
         <?php 
         } //fin de ciclo while
         ?>
        </tbody> 
  </table>
  <?php
			}// fin de si hubo consulta
			$_SESSION["msg"]="";
	} //cierro el si se envio el form  
	
	?>
<!-- FIN DE BUSCAR-->		

 
            </body>
 </html>
