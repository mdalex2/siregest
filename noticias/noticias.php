<!DOCTYPE HTML>
<html>
<?php 
require_once("../funciones/conexion.php");
require_once("../funciones/funcionesPHP.php");
require_once("../funciones/encriptado.php");
include_once("../funciones/errores_genericos.php");
//require_once("../funciones/img.thumbail.rezise.php");
//require_once("../funciones/fechas_func.php");
//include_once("../funciones/mostrar_iconos_comandos.php");
session_cache_limiter('nocache,private'); //evita mensaje de sesion expirada al presionar atras en el navegador

session_start();

if (isset($_REQUEST["id_func"])){
$array_permisos=verificar_acceso_pagina($_REQUEST['id_func']);} else{
$array_permisos=verificar_acceso_pagina("-000");}

 //verifico si el usuario tiene acceso a la pagina o si el usuario ingreso la url correcta (que corresponde al id de la funcion ejecutada)
//print_r($array_permisos); muestro los valores obtenidos del array consulta de permisos
//verificar_accion();//verifico si se ha presionado editar o eliminar y ejecuta las acciones solicitadas
?><head>
<link href="../images/sistema/siregest.ico" type="image/x-icon" rel="shortcut icon" />
<script type="text/javascript">
function confirmElim()
{
var agree=confirm("¿Está seguro de eliminar ésta noticia?");
if (agree)
return true ;
else
return false ;
}

  <!-- Meta -->
  <meta http-equiv="Content-Type" content="text/html; charset=<?php if (isset($_SESSION['juego_caracteres'])){ echo $_SESSION['juego_caracteres'];} else echo "utf-8";//esta variable se declara en modulo verificar login?>">
	<title><?php echo $_SESSION["app_nombre"]."-".$_SESSION["app_version"]; ?> - Administrar año escolar</title>
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
				$('#tablasinbtn').dataTable( {
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
				$('#tablasinbtn_desc').dataTable( {
					"oLanguage": {
			"sUrl": "../js/DataTables-1.9.0/media/lang/es_es.txt"
		},	
					"aaSorting": [[ 0, "desc" ]],
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
<script type="text/javascript" src="../js/tinymce/jscripts/tiny_mce/tiny_mce.js">


</script>
<script type="text/javascript">
	tinyMCE.init({
		// General options
		mode : "textareas",
		theme : "advanced",
		skin : "o2k7",
		plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,inlinepopups,autosave",

		// Theme options
		//tablecontrols,|,insertlayer,pagebreak,template
		theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
		theme_advanced_buttons3 : "hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,image,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
		theme_advanced_buttons4 : "moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,restoredraft",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,

		// Example word content CSS (should be your site CSS) this one removes paragraph margins
		content_css : "css/word.css",

		// Drop lists for link/image/media/template dialogs
		template_external_list_url : "lists/template_list.js",
		external_link_list_url : "lists/link_list.js",
		external_image_list_url : "lists/image_list.js",
		media_external_list_url : "lists/media_list.js",

		// Replace values for the template plugin
		template_replace_values : {
			username : "Some User",
			staffid : "991234"
		}
	});
</script>  
   <script type="text/javascript" src="../wideadmin_files/custom.js"></script>
   
	<meta charset="utf-8">
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
													echo "../images/sistema/noticia_add.png";
													break;
												case "GUARDAR" :
													echo "../images/sistema/computer_edit.png";
													break;
													
												case "MOSTRAR":
													echo "../images/sistema/computer_edit.png";
													break;
												case "ELIMINAR":
													echo "../images/sistema/noticia_delete.png";
													break;
												case "BUSCAR":
													echo "../images/sistema/noticia_mostrar.png";
													break;
													
												} // fin switch
												} else // fin si se obtiene la accion de la url
												{echo "../images/sistema/computer_go.png";}
											?>
                      
                      " width="32" height="32" align="absmiddle"> M&Oacute;DULO: NOTICIAS 
<?php 
if (isset($_GET["accion"])){
  $accion=strtoupper($_GET["accion"]);
	if ($accion=="MOSTRAR" && $array_permisos["editar"]==true)
			echo " / MODIFICAR";
		else
		   echo " / $accion";
	}
	else // de lo contrario de si no se ha pasado la accion pongo buscar como predeterminado
	{echo " / BUSCAR";}
?></h1><hr>
					<!--  VERIFICO LA ACCION Y DEPENDE LA ACCION HAGO LO QUE SE DEBA -->
          
      

				<div class="pad20">

					<!-- comienzo la tabla de mostrar -->

					<div style="width:100%"> 
 <?php
					 if (!isset($_GET["accion"])){
						 $accion="BUSCAR";
						 } else { // fin si se declaro la accion
						 	$accion=strtoupper($_GET["accion"]);
						 }
						 switch ($accion){
							 case "BUSCAR":
							 	include_once("noticias_bus.php");
								break;
							 case "NUEVO":
							 	include_once("noticias_crea.php");
								break;
							 case "MOSTRAR":
						    if (isset($_SESSION["msg"]) && $_SESSION["msg"]!=""){
									mostrar_box("inf",true,"NOTIFICACI&Oacute;N",$_SESSION["msg"]);
									//unset($_SESSION["msg"]);
									}
							 	include_once("noticias_mos.php");
								break;	
								case "GUARDAR":
							 	include_once("noticias_guardar.php");
								guardar_datos(); //llamo a la funcion que me guarda los datos en la BD
								break;			
								case "MODIFICAR":
							 	include_once("noticias_modif.php");
								modif_datos(); //llamo a la funcion que me guarda los datos en la BD
								break;
								case "ELIMINAR":
									include_once("noticias_elim.php");
									eliminar_datos();
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
            <?php //muestro botones de accion diponibles
						if ($array_permisos["mostrar"]==true) {?>
          <a id="nb" href="<?php echo "noticias.php?id_func=".$_GET["id_func"]."&accion=buscar"?>"  title="Consultar datos">
                                <img src='../images/icons_menu/x32/search_x32.png' width='24px' heigth='24px' align='absmiddle' style="padding:2px;"></img>&nbsp;Buscar
                              </a><br> 
            <?php 
						   } //cierro el si permite mostrar
						?>  
            
            <?php          
						if ($array_permisos["crear"]==true) {?>
								<a id="an" href="<?php echo "noticias.php?id_func=".$_GET["id_func"]."&accion=nuevo" ?>"  title="Agregar nuevo">
									<img src='../images/sistema/computer_add.png' width='24px' heigth='24px' align='absmiddle' style="padding:2px;"></img>&nbsp;Crear nuevo&nbsp;               
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
   <script type="text/javascript" src="../wideadmin_files/custom.js"></script>