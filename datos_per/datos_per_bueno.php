<!DOCTYPE HTML>
<html>
<?php 
include_once("../funciones/aplica_config_global.php");
require_once("../funciones/conexion.php");
require_once("../funciones/funcionesPHP.php");
//require_once("../funciones/fechas_func.php");
include_once("../funciones/mostrar_iconos_comandos.php");
session_start();
if (isset($_REQUEST["id_func"])){
$array_permisos=verificar_acceso_pagina($_REQUEST['id_func']);} else{
$array_permisos=verificar_acceso_pagina("000");}

 //verifico si el usuario tiene acceso a la pagina o si el usuario ingreso la url correcta (que corresponde al id de la funcion ejecutada)
//print_r($array_permisos); muestro los valores obtenidos del array consulta de permisos
//verificar_accion();//verifico si se ha presionado editar o eliminar y ejecuta las acciones solicitadas
?><head>

	
		<!-- Meta -->
		<meta http-equiv="Content-Type" content="text/html; 
charset=<?php $_SESSION['juego_caracteres'];//esta variable se declara en modulo verificar login?>">
		<!-- End of Meta -->
		
		<title>SIREGEST: Sistema de Registros Estudiantiles V.2012.1</title>

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
			jQuery("#form").validationEngine({autoHidePrompt:true,autoHideDelay: 3500}); 
			jQuery("#form1").validationEngine({autoHidePrompt:true,autoHideDelay: 3500}); //cambiar #form por el nombre del formulario a validar
			//$('#txt_id_func').focus(); //coloco el cursor en el primer text
		});
	</script>
	<!-- fin de las validaciones -->

  <!-- tema wide -->
  <link href="../ccs/forms/default.uni-form.css" title="Default Style" media="all" rel="stylesheet"/>
  <link type="text/css" href="../wideadmin_files/layout.css" rel="stylesheet">	
  <!--fin del validacion uniform-->
    
		<!-- End of Libraries -->
   <!-- para el datatables ================================================== -->
		<style type="text/css" media="all">
    @import url("../js/DataTables-1.9.0/media/themes/<?php if (isset($_SESSION["tema"])) echo $_SESSION['tema']; else echo "siregest";?>/jquery-ui-1.8.18.custom.css");
    </style>
<script type="text/javascript" src="../wideadmin_files/custom.js"></script>    
	</head>
  <body>
		<!-- Container -->
		<div id="container">
		
			<!-- Header -->
			<div id="header" class="fondo_superior">
                <!--comioenza el menu-->
                <?php 
				//crea el menu de cada usuario
				require_once("../funciones/crear_menu_usuario.php");
				crear_menu_usuario();?>  
               </div>          
			<!-- End of Header -->
			<!-- Background wrapper -->
			<div id="bgwrap">
		
				<!-- Main Content -->
				<div id="content">
				  <div id="main">
				    
                    <!-- muestro el array para saber que browser es solo a manera de informacion del programador

 -->
					
					
					<div class="pad20">
					<!-- Big buttons -->
						<h1 align="left" class="titulo_form_blue">
                      <img src="../images/icons_menu/x32/config.png" width="32" height="32" align="absmiddle"> MÓDULO: DATOS PERSONALES <?php if (isset($_GET["accion"])) echo " / " .strtoupper($_GET["accion"]); else echo " / BUSCAR";?></h1><hr>
					<!--  VERIFICO LA ACCION Y DEPENDE LA ACCION HAGO LO QUE SE DEBA -->
           <?php
					 if (!isset($_GET["accion"])){
						 $accion="BUSCAR";
						 } else { // fin si se declaro la accion
						 	$accion=strtoupper($_GET["accion"]);
						 }
						 switch ($accion){
							 case "BUSCAR":
							 	include_once("datos_per_bus.php");
								break;
							 case "NUEVO":
							 	include_once("datos_per_crea.php");
								break;
						 } // fin switch
					 ?>
						<!-- End of Big buttons -->
					</div>
          
					</div>
				</div>
				<!-- fin de los iconos de menu iconos grandes de lado derecho -->
               
				<!-- Sidebar -->
			  <div id="sidebar"><!-- inicio sidebar-->
				
				<!-- Sidebar -->
			  <div id="sidebar"><!-- inicio sidebar-->
				<div class="sort ui-sortable"><!--inicio sortable-->
				  <?php
						echo mostrar_cajaizq_sup("","Opciones disponibles");?>
            <?php //muestro botones de accion diponibles
						if ($array_permisos["mostrar"]==true) {?>
              <a id="resize" href="<?php echo "datos_per.php?id_func=".$_GET["id_func"]."&accion=buscar"?>" class="resize fancybox.iframe" title="Consultar datos">
                                <img src='../images/icons_menu/x32/search_x32.png' width='24px' heigth='24px' align='absmiddle' style="padding:2px;"></img>&nbsp;Nueva búsqueda
                              </a><br> 
            <?php 
						   } //cierro el si permite mostrar
						?>  
            
            <?php          
						if ($array_permisos["crear"]==true) {?>
								<a id="resize" href="<?php echo "datos_per.php?id_func=".$_GET["id_func"]."&accion=nuevo" ?>" class="resize fancybox.iframe" title="Agregar nueva función">
									<img src='../images/icons_menu/x32/editar_x32.png' width='24px' heigth='24px' align='absmiddle' style="padding:2px;"></img>&nbsp;Agregar nueva&nbsp;               
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

     </div><!--fin de side bar -->
		  </div>     
	
            
            
		<!-- Footer -->
		<div id="footer">
			<?php 
			  echo crear_pie_pagina();
			?>
		</div>
		<!-- End of Footer -->
     </div><!--fin de side bar -->

 </div>
 </body>
 </html>
