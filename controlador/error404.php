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
charset=ISO-8859-9">
		<!-- End of Meta -->
		
		<title>SIREGEST: Sistema de Registros Estudiantiles V.2012.1</title>

		<link type="text/css" href="../wideadmin_files/layout.css" rel="stylesheet">	
    <link type="text/css" href="../wideadmin_files/login.css" rel="stylesheet">	
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
				
				<!-- Top -->
				<div id="top">
					<!-- Logo -->
					<div class="logo"> 
                    <a href="index.php" title="Ir a menu principal" class="tooltip"><img src="../wideadmin_files/logo.png" alt="Menú principal" width="500" height="89px"></a>
					<!-- End of Logo -->
<?php
					//require("../funciones/mostrar_logo_sup.php");
					//echo mostrar_logo_sup();	
				?>
                        </a> 
</div>
					<!-- End of Logo -->
					
					<!-- Meta information -->
					<div class="meta">
                   	  <form action="../funciones/verifica_login.php" method="post" class="form_marco"  name="login" target="_self">
                      <h3>Acceso al sistema:</h3>
                       <label id="login_label">Nombre de usuario<br />
		<input type="text" name="log" id="user_login" class="input" value="" size="12" /></label>
        &nbsp;&nbsp;
        <label id="login_label">Contraseña<br />
		<input type="password" name="pwd" id="user_pass" class="input" value="" size="12"  /></label>
	<br>

	  <input type="submit" name="wp-submit" class="button" value="Iniciar sesión" align="left" />
      &nbsp;
      <label id="login_label"><a href="../acceso_sis/olvido_clave.php" id="link_login" alt="Haga clic aqui">Olvid&oacute; su clave</a></label>
    <script type="text/javascript">
try{document.getElementById('user_login').focus();}catch(e){}
</script>
</form>					</div>
					<!-- End of Meta information -->

				</div>
				<!-- End of Top-->
			
				<!-- The navigation bar -->
                
                <div id="navbar">
<ul class='nav sf-js-enabled sf-shadow'>             
						<li><a href="../acceso_sis/registro_usuario.php"><img src="../images/icons_menu/x32/llavero.png" align="absmiddle" width="20" height="20"> ¿No tiene una cuenta? <b>Regístrese</b></a></li>
						<li><a href="../ayuda/soporte.php"><img src="../images/icons_menu/x32/soporte.png" align="absmiddle" width="20" height="20"> Soporte</a></li>
						<li><a href="../ayuda/ayuda.php"><img src="../images/icons_menu/x32/help.png" align="absmiddle" width="20" height="20"> Ayuda</a></li>
</ul>                
</div>
				<!-- End of navigation bar" -->
				
				<!-- Search bar --><!-- End of Search bar -->
			
			</div>
			<!-- End of Header -->
			
			<!-- Background wrapper -->
			<div id="bgwrap">
		
				<!-- Main Content -->
				<div id="content">
					<div id="main">
					<div class="pad20">
					<?php
					
			if (isset($_SESSION["err"])){
				switch ($_SESSION["err"]){
					case "nl":
						echo mostrar_box("exc",true,utf8_encode("Atención!"),utf8_encode("Usted no ha ingresado correctamente al sistema, debe ingresar usando su <b>nombre de usuario y contraseña</b>"));
						break;
					case "sesse":
					  echo mostrar_box("inf",false,"Seguridad del sistema",utf8_encode("Usted ha sido desconectado del sistema porque transcurrió un tiempo largo de inactividad, el sistema se desconecta automaticamente luego de cierto tiempo de inactividad, para volver acceder use su nombre de usuario y clave de acceso"));
						break;
						
					}
			}
								//else
					//{echo "NO SE DEFINIO ERROR AL INICIO";}

			?>
            <h2>Bienvenido al sistema, para ingresar use el nombre de usuario y clave de acceso suministrado por el departamento técnico</h2><hr>
						<!-- Three columns content -->
					  <div id="columns" class="sortable">
						
							<!-- Columna uno -->
                            
                            
<?php
  $pagina = $_SERVER['REQUEST_URI'];
  mostrar_box("err",false,utf8_encode("La página a la que ha accedido no existe:"),utf8_encode($pagina."<br><br>Se ha roto el enlace a la página web, si el problema persiste se debe verificar la ruta a la página a través de la opción administrar funciones del sistema")); 
// La variable $_SERVER almacena
// entre otras cosas la URL solicitada
?>
<p>
  <?php 
  echo '<hr><div align="right">

<button class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all"  onClick="window.print();">
<span class="ui-button-text"><img src="../images/icons_menu/x32/printer2_x32.png" width="20" height="20" align="absmiddle"> Imprimir</span>
</button>

<button class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all"  onClick="javascript:history.back(1)">
<span class="ui-button-text"><img src="../images/icons_menu/x32/atras_azul.png" width="20" height="20" align="absmiddle"> Ir atrás</span>
</button>
</div>';
  ?>
</p>

<!--<p>Páginas relacionadas:</p>-->
<?php
// Obtenemos la última palabra
// Si la URL acaba en "/" lo quitamos
if (strrpos($pagina, "/") == strlen($pagina) -1) {
$pagina = substr($pagina, 0, strlen($pagina)-2);
}
// Obtenemos la parte de la URL que va desde
// la última aparición de la barra "/"
// hasta el final
$ultimaPalabra = substr($pagina, strrpos($pagina, "/")+1);
// Eliminamos la extensión del script (.jsp, .php, ...)
$ultimaPalabra = substr($ultimaPalabra, 0, strrpos($ultimaPalabra, "."));

// Realizamos la llamada al proceso de búsqueda en nuestra web
// con lo obtenido en $ultimaPalabra
// Mostramos los resultados
/*
	$entradas = $wpdb->get_results("SELECT guid, post_title, post_content FROM $wpdb->posts WHERE UPPER(post_title) RLIKE '$ultimaPalabra' OR  UPPER(post_content) RLIKE '$ultimaPalabra'", ARRAY_N);
?>
<ul>
<?php
foreach ($entradas as $entrada) {
?>
<li><a href="<?php echo $entrada[0]; ?>"><?php echo $entrada[1]; ?></a></li>
<?php
}
?>
</ul>
*/
?>
							<!-- fin de columna 1 -->
						</div>
					  <!-- End of Three columns content --></div>
					<div class="pad20">
							<!-- End of Progressbar -->
							
					  </div>	
						
					</div>
				</div>
				<!-- End of Main Content -->
				
				<!-- Sidebar -->
				<div id="sidebar">
				<!-- Datepicker -->
        <h2>Calendario</h2>
		  <div id="datepicker"  align="center"></div>
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
<form action="clave_acceso.php" method="post" name="form_con_noticia" ">
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
							  	</p>
								  <p>
								    <label for="cmb_year">Año</label>
								    <select name="cmb_year" id="cmb_year">
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
              </p>
                                <p>
                                <center><input name="txt_buscar" type="submit" class="button" id="txt_buscar" value="Mostrar noticias" style="margin-top:7px"></center>
</form>

							</div>
						</div>
					</div>
					<!-- End of Sortable Dialogs -->
				</div>
				<!-- End of Sidebar -->
			</div>
			<!-- End of bgwrap -->
		</div>
		<!-- End of Container -->
		</div>
		<!-- Footer -->
		<div id="footer">
			<p class="mid">
				<!-- Change this to your own once purchased -->Programador: Jairo  Alexi Mendoza &copy;. Todos los derechos reservados.<!-- -->
			</p>
	</div>
		<!-- End of Footer -->


	<div aria-labelledby="ui-dialog-title-dialog" role="dialog" 
tabindex="-1" class="ui-dialog ui-widget ui-widget-content ui-corner-all
  ui-draggable ui-resizable" style="display: none; position: absolute; 
overflow: hidden; z-index: 1000; outline: 0px none;"><div 
style="-moz-user-select: none;" unselectable="on" 
class="ui-dialog-titlebar ui-widget-header ui-corner-all 
ui-helper-clearfix"><span style="-moz-user-select: none;" 
unselectable="on" id="ui-dialog-title-dialog" class="ui-dialog-title">Welcome
 message!</span><a style="-moz-user-select: none;" unselectable="on" 
role="button" class="ui-dialog-titlebar-close ui-corner-all" href="#"><span
 style="-moz-user-select: none;" unselectable="on" class="ui-icon 
ui-icon-closethick">close</span></a></div><div class="ui-dialog-content 
ui-widget-content" id="dialog">
								<p>Welcome to <b>Wide Admin</b>!</p>
								<p>Wide Admin is one powerful customizable backend user 
interface. Check the demo to see what it can do!</p>
								<p>And this is a custom message text that you can modify to fit 
your needs.</p>
							</div><div style="-moz-user-select: none;" unselectable="on" 
class="ui-resizable-handle ui-resizable-n"></div><div 
style="-moz-user-select: none;" unselectable="on" 
class="ui-resizable-handle ui-resizable-e"></div><div 
style="-moz-user-select: none;" unselectable="on" 
class="ui-resizable-handle ui-resizable-s"></div><div 
style="-moz-user-select: none;" unselectable="on" 
class="ui-resizable-handle ui-resizable-w"></div><div unselectable="on" 
style="z-index: 1001; -moz-user-select: none;" 
class="ui-resizable-handle ui-resizable-se ui-icon 
ui-icon-gripsmall-diagonal-se ui-icon-grip-diagonal-se"></div><div 
unselectable="on" style="z-index: 1002; -moz-user-select: none;" 
class="ui-resizable-handle ui-resizable-sw"></div><div unselectable="on"
 style="z-index: 1003; -moz-user-select: none;" 
class="ui-resizable-handle ui-resizable-ne"></div><div unselectable="on"
 style="z-index: 1004; -moz-user-select: none;" 
class="ui-resizable-handle ui-resizable-nw"></div><div 
class="ui-dialog-buttonpane ui-widget-content ui-helper-clearfix"><button
 class="ui-state-default ui-corner-all" type="button">Ok</button><button
 class="ui-state-default ui-corner-all" type="button">Cancel</button></div></div><div
 id="ui-datepicker-div" class="ui-datepicker ui-widget ui-widget-content
 ui-helper-clearfix ui-corner-all ui-helper-hidden-accessible"></div></body></html>
