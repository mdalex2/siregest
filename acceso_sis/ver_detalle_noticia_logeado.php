<!DOCTYPE HTML>
<html>
<?php 
include_once("../funciones/aplica_config_global.php");
require_once("../funciones/conexion.php");
require_once("../funciones/funcionesPHP.php");
require_once("../funciones/fechas_func.php");
include_once("../funciones/mostrar_iconos_comandos.php");
session_start();
?>
<head>

	
		<!-- Meta -->
		<meta http-equiv="Content-Type" content="text/html; 
charset=<?php echo $_SESSION['juego_caracteres'];//esta variable se declara en modulo verificar login?>">
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
    @import url("../js/DataTables-1.9.0/media/themes/<?php if (!empty($_SESSION["tema"])) echo $_SESSION['tema']; else echo "siregest";?>/jquery-ui-1.8.18.custom.css");
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
					
			if (isset($_SESSION["err"])){
				switch ($_SESSION["err"]){
					case "nl":
						echo '<div class="message warning close">
							<h2><b>Atención!</b></h2>
							<p>Usted no ha ingresado correctamente al sistema, debe ingresar usando su <b>nombre de usuario y contraseña</b>.</p>
						</div>	';
						break;
					case "sesse":
						echo '<div class="message warning close">
							<h2><b>Seguridad del sistema!</b></h2>
							<p>Usted ha sido desconectado del sistema porque transcurrió un tiempo largo de inactividad, el sistema se desconecta automaticamente luego de cierto tiempo de inactividad, para volver acceder use su nombre de usuario y clave de acceso</p>
						</div>	';
						break;
						
					}
			}
								//else
					//{echo "NO SE DEFINIO ERROR AL INICIO";}

			?>
						<!-- Three columns content -->
					 
						
							<!-- Columna uno -->
                            <?php 
							$link = conectarse();
							//si no se paso el id de noticia por la url
							if (!isset($_REQUEST['id_noticia'])){ 
								echo '<div class="message warning">
									<h2>Información</h2>
									<p>No se encontró la noticia, es probable el vinculo se halla roto o la noticia fué eliminada.  <B><a href="clave_acceso.php"><img src="../images/icons_menu/x32/atras_azul.png" align="absmiddle" width="18px" heigth="18px">  Volver Atrás</a></b></p>
						</div>';}
						else { // de lo contrario de si no hay por el url un id de noticia
						$id_not=$_REQUEST['id_noticia'];
						$consulta = mysql_query("SELECT id_noticia,titulo,contenido,fecha_publicacion FROM noticias where id_noticia='$id_not'",$link);
							if (mysql_num_rows($consulta)>0){
							while ($fila = mysql_fetch_array($consulta)){	
							//consulto para verificar si hay foto para la noticia
								$consulta_foto=mysql_query("SELECT id_foto_noticia,foto_noticia from noti_fotos where id_noticia='".$fila["id_noticia"]."' limit 0,1",$link);
								$fecha_publicacion= strtotime($fila['fecha_publicacion']); //transformo el texto a fecha
								//$fecha_publicacion=strftime("%A, %d de %B de %Y",$fecha_publicacion); 
								$fecha_publicacion=strftime("%A, %d-%B-%Y",$fecha_publicacion); //formateo el estilo de la fecha

								//si existen registros muestro la miniatura de la foto
								echo "<h2>".$fila['titulo']."</h2><hr>";
								if (mysql_num_rows($consulta_foto)>0) {
								while ($fila_foto = mysql_fetch_array($consulta_foto)){
									if (file_exists("../images/".$fila_foto["foto_noticia"])){
										echo '<img src="../images/'.$fila_foto["foto_noticia"].'" align="left" border="1" width="200px" height="200px" style="margin-right:7px">';} else
									if (file_exists("../images/icons_menu/x48/icono_rss.jpg")) {
										echo "<img src='../images/icons_menu/x48/icono_rss.jpg' text align='left' border='0' width='100px' height='100px' style='margin-right:7px'>";}

								} //end while
								
								} else//END IF EXISTEN FOTOS (MYSQL_NUM_ROW>0)
									if (file_exists("../images/icons_menu/x48/icono_rss.jpg")) {
										echo "<img src='../images/icons_menu/x48/icono_rss.jpg' text align='left' border='0' width='100px' height='100px' style='margin-right:7px'> ";}
										echo "<p align='justify'>".$fila['contenido'].'</p></font><h4 align="right">Publicado: '.$fecha_publicacion.'
										<hr><div align="right">

<button class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all"  onClick="window.print();">
<span class="ui-button-text"><img src="../images/icons_menu/x32/printer2_x32.png" width="20" height="20" align="absmiddle"> Imprimir</span>
</button>

<button class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all"  onClick="javascript:history.back(1)">
<span class="ui-button-text"><img src="../images/icons_menu/x32/atras_azul.png" width="20" height="20" align="absmiddle"> Ir atrás</span>
</button>
</div>
';
							}
							} //fin de si mysql_num_row >0 (consulta de noticias)
							else // si no hay registros
								echo '<div class="message information close">
							<h2>Información</h2>
							<p>No se pudo consultar la noticia en la base de datos.</p></div>';
							}
						
							?>
								
						</ul>
						<!-- End of Big buttons -->
					</div>
          
					</div>
				</div>
				<!-- fin de los iconos de menu iconos grandes de lado derecho -->
               
				<div id="sidebar">
				<!-- Datepicker -->
        <h2>Calendario</h2>
		  <div id="datepicker"   align="center"></div>
		  <!-- End of Datepicker -->
			<script type="text/javascript"> 
				$("#datepicker").datepicker(); 
			</script>					<!-- End of Datepicker -->
	        <h2>Noticias anteriores</h2>
					<div class="sort ui-sortable">
						<div class="box ui-widget ui-widget-content ui-corner-all portlet 
ui-helper-clearfix">
						<div class="portlet-header ui-widget-header ui-corner-all">Seleccione la fecha a consultar:</div>
							<div class="portlet-content">
<form action="clave_acceso.php" method="post" name="form" id="form">
								    <label for="cmb_mes">Mes</label>
								    <select name="cmb_mes" id="cmb_mes" style="margin-bottom:3px">
								      <option selected>SELECCIONAR</option>
                                      <?php //lleno el combo con los meses
									  
										  for ($i=0;$i<=12;$i++){									
											  	$mes_letras=obtener_mes_letras($i);
												if (isset($mes_letras)){
												echo "<option ";
												if (isset($_POST["cmb_mes"]) and $_POST["cmb_mes"]==$mes_letras) echo "selected>"; else echo ">";
												echo $mes_letras;
												echo "</option>";}
										  }
									  ?>
	          </select>
							  	
								    <br><label for="cmb_year">Año</label>
								    <select name="cmb_year" id="cmb_year" >
                                    <option selected>SELECCIONAR</option>
								      <?php
									  	$year=date("Y")-1;
									  	echo $year;
										for ($i = $year; $i <= $year+5; $i++) {
										echo "<option ";
									    if (isset($_POST["cmb_year"]) and $_POST["cmb_year"]==$i) 
											echo ' selected>'; else echo ">";
											echo $i;
											echo '</option>';								  										
										
										}
										?>
				        </select>
              
<div align="center">
<br><button class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" formaction="clave_acceso.php">
<span class="ui-button-text"><img src="../images/icons_menu/x32/search_x32.png" width="20" height="20" align="absmiddle"> Mostrar noticias</span>
</button>
</div>
 </form>


							</div>
						</div>
					</div>
					<!-- End of Sortable Dialogs -->
				</div>
				<!-- End of Sidebar -->
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
