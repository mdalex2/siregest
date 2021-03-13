<!DOCTYPE HTML>
<html>
<?php 
include_once("../funciones/aplica_config_global.php");
require_once("../funciones/conexion.php");
require_once("../funciones/funcionesPHP.php");
require_once("../funciones/encriptado.php");
include_once("../funciones/errores_genericos.php");
require_once("../funciones/img.thumbail.rezise.php");
//require_once("../funciones/fechas_func.php");
//include_once("../funciones/mostrar_iconos_comandos.php");
session_start();

if (isset($_REQUEST["id_func"])){
$array_permisos=verificar_acceso_pagina($_REQUEST['id_func']);} else{
$array_permisos=verificar_acceso_pagina("000");}

 //verifico si el usuario tiene acceso a la pagina o si el usuario ingreso la url correcta (que corresponde al id de la funcion ejecutada)
//print_r($array_permisos); muestro los valores obtenidos del array consulta de permisos
//verificar_accion();//verifico si se ha presionado editar o eliminar y ejecuta las acciones solicitadas
?><head>
<link href="../images/sistema/siregest.ico" type="image/x-icon" rel="shortcut icon" />
<script type="text/javascript">
function confirmSubmit()
{
var agree=confirm("�Est� seguro de eliminar este registro?, tambi�n se eliminar�n los privilegios asociados a �sta funci�n; tenga en cuenta que esta acci�n es irreversible por lo tanto debe tener cuidado al eliminar una funci�n.");
if (agree)
return true ;
else
return false ;
}
function confirm_elim_dir()
{
var agree=confirm("�Est� seguro de eliminar �sta direcci�n?");
if (agree)
return true ;
else
return false ;
}
function confirm_elim()
{
var agree=confirm("�EST� SEGURO QUE DESEA ELIMINAR �STE EXPEDIENTE PERSONAL? \n\n Tambi�n se eliminar�n todos los datos como inscripciones, configuraciones del sistema, notas o calificaciones entre otras actividades asignadas a �ste expediente. \n\n NOTA: SE RECOMIENDA NO ELIMINAR NING�N EXPEDIENTE AL MENOS QUE EL MISMO SE HALLA REGISTRADO POR ERROR");
if (agree){
	var agree=confirm("�En realidad deseas eliminar un expediente?\n\n �sta acci�n no se podr� deshacer y puede provocar fallos o p�rdida de informaci�n.");
	if (agree)
		return true ;}
else
return false ;
}
function confirm_elim_telf()
{
var agree=confirm("�Est� seguro de eliminar este tel�fono?");
if (agree)
return true ;
else
return false ;
}
function confirma_elim_varios()
{
var agree=confirm("�Est� seguro de eliminar los registros seleccionados, tambi�n se eliminar�n los privilegios asociados a �sta funci�n; tenga en cuenta que esta acci�n es irreversible por lo tanto debe tener cuidado al eliminar una funci�n.");
if (agree)
return true ;
else
return false ;
}

</script>

  <!-- Meta -->
  <meta http-equiv="Content-Type" content="text/html; charset=<?php if (isset($_SESSION['juego_caracteres'])){ echo $_SESSION['juego_caracteres'];} else echo "utf-8";//esta variable se declara en modulo verificar login?>">
	<title><?php echo $_SESSION["app_nombre"]."-".$_SESSION["app_version"]; ?> - Respaldar base de datos</title>
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
			jQuery("#form_crear").validationEngine({autoHidePrompt:true,autoHideDelay: 3500}); 
			jQuery("#form_buscar").validationEngine({autoHidePrompt:true,autoHideDelay: 3500});			
			jQuery("#form_editar").validationEngine({autoHidePrompt:true,autoHideDelay: 3500}); //cambiar #form por el nombre del formulario a validar
			//$('#txt_id_func').focus(); //coloco el cursor en el primer text
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
<style type="text/css">
a:hover {
	color: #036;
}
</style>
<script type="text/javascript" src="../js/fancybox/jquery.fancybox.pack.js?v=2.0.5"></script>

<!-- Optionally add button and/or thumbnail helpers -->
<!--<link rel="stylesheet" href="../js/fancybox/helpers/jquery.fancybox-buttons.css?v=2.0.5" type="text/css" media="screen" />
<script type="text/javascript" src="../js/fancybox/helpers/jquery.fancybox-buttons.js?v=2.0.5"></script>

<link rel="stylesheet" href="../js/fancybox/helpers/jquery.fancybox-thumbs.css?v=2.0.5" type="text/css" media="screen" />
<script type="text/javascript" src="../js/fancybox/helpers/jquery.fancybox-thumbs.js?v=2.0.5"></script>-->
<script type="text/javascript">
$(document).ready(function() {
	//el id del a href que queremos cambiar siempre sera resize y el tama�o se debe agregar en la propiedad width y heigh al hacer el enlace
	// tama�o fijo:
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
	$(".window_direcc").fancybox({
		maxWidth	: 1024,
		maxHeight	: 768,
		fitToView	: false,
		width     : '65%',
    height    : '90%',
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
  <body >

		<!-- Container -->
		<div id="container">
			<!-- Header -->
			<div id="header" class="fondo_superior">
      <!--comioenza el menu-->
         <?php 
					//crea el menu de cada usuario
					require_once("../funciones/crear_menu_usuario.php");
					crear_menu_usuario();
				?> 
         
      </div>          
			<!-- End of Header -->
			<!-- Background wrapper -->

			<div id="bgwrap">
		
				<!-- Main Content -->
				<div id="content">
				  <div id="main">
				    <!--<div id="pad20">-->
                    <!-- muestro el array para saber que browser es solo a manera de informacion del programador
 -->
 
 
					<h1 align="left" class="titulo_form_blue">
                      <img src="<?php 
											if (isset($_GET["accion"])){
												$accion=strtoupper($_GET["accion"]);
											switch ($accion){
												case "NUEVO" :
													echo "../images/icons_menu/x32/00413.png";
													break;
												case "DESCARGA" :
													echo "../images/icons_menu/x32/00413.png";
													break;
													
													
												} // fin switch
												} else // fin si se obtiene la accion de la url
												{echo "../images/icons_menu/x32/00413.png";}
											?>
                      
                      " width="32" height="32" align="absmiddle"> M&Oacute;DULO: RESPALDO DE LA BASE DE DATOS 
<?php 
if (isset($_GET["accion"])){
  $accion=strtoupper($_GET["accion"]);
	if ($accion=="INFORMAR" && $array_permisos["crear"]==true)
			echo " / INFORMACI&Oacute;N GENERAL";
		else
		   echo " / $accion";
	}
	else // de lo contrario de si no se ha pasado la accion pongo buscar como predeterminado
	{echo " / INFORMACI&Oacute;N GENERAL";}
?></h1><hr>
					<!--  VERIFICO LA ACCION Y DEPENDE LA ACCION HAGO LO QUE SE DEBA -->
          
      

				<div class="pad20">

					<!-- comienzo la tabla de mostrar -->

					<div style="width:100%"> 
 <?php
					 if (!isset($_GET["accion"])){
						 $accion="INFORMAR";
						 } else { // fin si se declaro la accion
						 	$accion=strtoupper($_GET["accion"]);
						 }
						 switch ($accion){
							 case "INFORMAR":
							 	echo "<h2>Bienvenido al asistente que le permitir&aacute; obtener copias de seguridad de la base de datos del sistema; para iniciar haga clic en el siguiente enlace:</h2></br>";
						if ($array_permisos["crear"]==true) {?>
								<h1 id="tit_cre"><a id="an" href="<?php echo "respaldar.php?id_func=".$_GET["id_func"]."&accion=nuevo" ?>"  title="Crear nuevo">
									<img src='../images/icons_menu/x48/00413.png' width='48px' heigth='48px' align='absmiddle' style="padding:2px;"></img>&nbsp;Crear respaldo&nbsp;               
                  </a><br> 
            </h1> 
            
       
          <?php } //cierro el si tiene permiso de crear 								
								break;																												
							 
							 case "NUEVO":
							 	include_once("respaldar_proc.php");
								break;																												
						 } // fin switch
					 ?>          
	  </div>
         
          </div>
					</div>
				</div>
				<!-- fin de los iconos de menu iconos grandes de lado derecho -->
               
				<!-- Sidebar -->
			  <div id="sidebar"><!-- inicio sidebar-->
				<div class="sort ui-sortable"><!--inicio sortable-->
				  <?php
						echo mostrar_cajaizq_sup("","Opciones disponibles");?>
            <?php          
						if ($array_permisos["crear"]==true) {?>
								<a id="an" href="<?php echo "respaldar.php?id_func=".$_GET["id_func"]?>"  title="Crear nuevo">
									<img src='../images/icons_menu/x32/00413.png' width='24px' heigth='24px' align='absmiddle' style="padding:2px;"></img>&nbsp;Nuevo respaldo&nbsp;               
                  </a><br>              
          <?php } //cierro el si tiene permiso de crear ?>
            
            <!--agrego boton de volver--> 
					<a href="javascript:history.go(-1);"><img src="../images/icons_menu/x32/atras_azul.png" width="24px" height="24px" align="absmiddle" style="padding:2px;"> Regresar</a>
						<?php
						echo mostrar_cajaizq_inf();
						//llama a la funcion que esta en modulo funcionesPHP.php
						//dentro de la carpeta funciones que permite consultar agenda			
						echo ver_calendario();
						echo mostrar_box_consulta_agenda("texto1","caja1");
						?>   
        <!--</div> <!-- fin div pad 20       
				</div>	
				<!--fin de sort ui-sortable-->	
			  </div><!--fin de sort ui-sortable-->	
			  </div>     
                  </form>

     </div><!--fin de side bar -->
        <!-- Footer -->
        <div id="footer">
          <?php 
            echo crear_pie_pagina();
          ?>
        </div>
        <!-- End of Footer -->

 </div>
 </body>
 </html>
