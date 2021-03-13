<!DOCTYPE HTML>
<html>
<?php 
include_once("../funciones/aplica_config_global.php");
require_once("../funciones/conexion.php");
require_once("../funciones/funcionesPHP.php");
//require_once("../funciones/fechas_func.php");
include_once("../funciones/mostrar_iconos_comandos.php");
session_start();
?>
<head>

	
		<!-- Meta -->
		<meta http-equiv="Content-Type" content="text/html; 
charset=<?php $_SESSION['juego_caracteres'];//esta variable se declara en modulo verificar login?>">
		<!-- End of Meta -->
		
		<title>SIREGEST: Sistema de Registros Estudiantiles V.2012.1</title>

		<link type="text/css" href="../wideadmin_files/layout.css" rel="stylesheet">	
      <!-- ojo dejarlo en este orden porq si no no funciona la validacioon del form-->
		<!--<script type="text/javascript" src="../wideadmin_files/easyTooltip.js" charset="utf-8"></script>
		<script type="text/javascript" src="../wideadmin_files/jquery-ui-1.js" charset="utf-8"></script>-->
		<script type="text/javascript" src="../js/jquery-1.7.1.min.js"></script>
    <script type="text/javascript" src="../js/jquery-ui-1.8.18.custom.min.js"></script>
    <script type="text/javascript" src="../wideadmin_files/custom.js" charset="utf-8"></script>
		<!-- End of Libraries -->
   <!-- para el datatables ================================================== -->
		<style type="text/css" media="all">
    @import url("../js/DataTables-1.9.0/media/themes/<?php if (isset($_SESSION["tema"])) echo $_SESSION['tema']; else echo "siregest";?>/jquery-ui-1.8.18.custom.css");
    </style>
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
				    
					<h2></h2>
					
					<div class="pad20">
					<!-- Big buttons -->
						<ul class="dash">
            <br>
							<?php
								error_reporting(0);
								mostrar_box("err",false,($_SESSION["titulo_msg"]),($_SESSION['error']));
								echo ('<hr><div align="right">

<button class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all"  onClick="window.print();">
<span class="ui-button-text"><img src="../images/icons_menu/x32/printer2_x32.png" width="20" height="20" align="absmiddle"> Imprimir</span>
</button>

<button class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all"  onClick="javascript:history.back(1)">
<span class="ui-button-text"><img src="../images/icons_menu/x32/atras_azul.png" width="20" height="20" align="absmiddle"> Ir atr&aacute;s</span>
</button>
</div>');
							?>
								
						</ul>
						<!-- End of Big buttons -->
					</div>
					</div>
				</div>
				<!-- fin de los iconos de menu iconos grandes de lado derecho -->
               
				<!-- Sidebar -->
			  <div id="sidebar"><!-- inicio sidebar-->
				
				<div class="sort ui-sortable"><!--inicio sortable-->
                	<?php
					    //muestro el calendario negro con blanco en el panel izquierdo del menu principal
						echo ver_calendario();
					?>
	
                                    							
                	<?php
						//llama a la funcion que esta en modulo funcionesPHP.php
						//dentro de la carpeta funciones que permite consultar agenda
						echo mostrar_box_consulta_agenda("texto1","caja1");
						
					?>                   
                    
				</div>	<!--fin de sort ui-sortable-->	
			  </div><!--fin de sort ui-sortable-->	
			  </div>     
	
            
            
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
