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
<link href="../images/sistema/siregest.ico" type="image/x-icon" rel="shortcut icon" />
	
		<!-- Meta -->
		<meta http-equiv="Content-Type" content="text/html; charset=<?php if (isset($_SESSION['juego_caracteres'])){ echo $_SESSION['juego_caracteres'];} else echo "utf-8";//esta variable se declara en modulo verificar login?>">
		<!-- End of Meta -->
		
<title><?php echo $_SESSION["app_nombre"]."-".$_SESSION["app_version"]; ?> - Menú Principal</title>

		<link type="text/css" href="../wideadmin_files/layout.css" rel="stylesheet">	
      <!-- ojo dejarlo en este orden porq si no no funciona la validacioon del form-->
		<!--<script type="text/javascript" src="../wideadmin_files/easyTooltip.js" charset="utf-8"></script>
		<script type="text/javascript" src="../wideadmin_files/jquery-ui-1.js" charset="utf-8"></script>-->
		<script type="text/javascript" src="../js/jquery-1.7.1.min.js"></script>
    <script type="text/javascript" src="../js/jquery-ui-1.8.18.custom.min.js"></script>
    
    
    <!-- Add fancyBox -->
<link rel="stylesheet" href="../js/fancybox/jquery.fancybox.css?v=2.0.5" type="text/css" media="screen" />
<script type="text/javascript" src="../js/fancybox/jquery.fancybox.pack.js?v=2.0.5"></script>
<script type="text/javascript">
$(document).ready(function() {
	//el id del a href que queremos cambiar siempre sera resize y el tamaño se debe agregar en la propiedad width y heigh al hacer el enlace
	// tamaño fijo:
		$(".resize").fancybox({
		maxWidth	: 1024,
		maxHeight	: 768,
		fitToView	: false,
		width     : '85%',
    height    : '95%',
		autoSize	: false,
		closeClick	: true,
		openEffect	: 'fade',
		closeEffect	: 'fade'
	})
});	

</script>
     
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
				    
                    <!-- muestro el array para saber que browser es solo a manera de informacion del programador

 -->
					<h2>&iquest;Que le gustar&iacute;a hacer hoy?</h2>
					
					<div class="pad20">
					<!-- Big buttons -->
						<ul class="dash">
							<?php
								echo mostrar_iconos_comandos();	
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
	
            
            
		<!-- Footer -->
		<div id="footer">
			<?php 
			  echo crear_pie_pagina();
				$_SESSION["msg"]="";
			?>
		</div>
		<!-- End of Footer -->
     </div><!--fin de side bar -->

 </div>
 </body>
 </html>
