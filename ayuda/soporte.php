<!DOCTYPE HTML>
<html>
<?php 
include_once("../funciones/aplica_config_global.php");
require_once("../funciones/conexion.php");
require_once("../funciones/funcionesPHP.php");
require_once("../funciones/fechas_func.php");
//include_once("../funciones/mostrar_iconos_comandos.php");
session_start();
?>
<head>
<link href="../images/sistema/siregest.ico" type="image/x-icon" rel="shortcut icon" />
		<!-- Meta -->
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<!-- End of Meta -->
		
<title>SIREGEST: Sistema de Registros Estudiantiles V.2012.1</title>

		<link type="text/css" href="../wideadmin_files/layout.css" rel="stylesheet">	
    <link type="text/css" href="../wideadmin_files/login.css" rel="stylesheet">	
  <!-- fin fancy box -->
		<script type="text/javascript" src="../js/jquery-1.7.1.min.js"></script>
    <script type="text/javascript" src="../js/jquery-ui-1.8.18.custom.min.js"></script>
    <script type="text/javascript" src="../wideadmin_files/custom.js" charset="utf-8"></script>
    <script type="text/javascript">
function confirmacion()
{
var agree=confirm("¿Prueba de si validacion?");
if (agree)
return true ;
else
return false ;
}
</script>

<?php
	 //si la cookie del tema es vacio pongo el tema predeterminado de lo contrario pongo el tema almacenado en la cookie
	if (empty($_COOKIE["tema"])){
	$_SESSION["tema"]="siregest"; //variable que controla el color del tema 
	}
	else
	{$_SESSION["tema"]=$_COOKIE["tema"];}

?>
		<!-- End of Libraries -->
   <!-- para el datatables ================================================== -->
		<style type="text/css" media="all">
    @import url("../js/DataTables-1.9.0/media/themes/<?php if (!empty($_SESSION["tema"])) echo $_SESSION['tema']; else echo "siregest";?>/jquery-ui-1.8.18.custom.css");
    </style>
	<script type="text/javascript" src="../js/msg_alertas/facebox/mootools.js"></script>
	<script type="text/javascript" src="../js/msg_alertas/facebox/facebox.js"></script>
    <link type="text/css" rel="stylesheet" href="../js/msg_alertas/facebox/facebox.css"/>

<script type="text/javascript">
function openFacebox(titulo,mensaje) {
var box = new Facebox({title: titulo,message: mensaje,ajaxDelay: 400,cancelValue:'Aceptar'});
box.show();
}
</script>    
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
                    <a href="index.php" title="Ir a menu principal" class="tooltip"><img src="../wideadmin_files/logo.png" alt="Menú principal" width="600" height="89px"></a>
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
                   	  <form action="../funciones/verifica_login.php" method="post" name="login" target="_self" class="form_marco">
                      <h3>Acceso al sistema:</h3>
                       <label id="login_label">Nombre de usuario<br />
		<input type="text" name="log" id="user_login" class="user_login" value="<?php if (!empty($_GET["login"])) echo $_GET["login"];?>"  autofocus/></label>
        &nbsp;&nbsp;
        <label id="login_label">Contraseña<br />
		<input type="password" name="pwd" id="user_pass" class="user_pass" value=""  size="7em"/></label>
	<br>
<input type="submit" class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" value="Iniciar sesión">
      <!--<label id="login_label"><a href="../acceso_sis/olvido_clave.php" id="link_login" alt="Haga clic aqui">Olvid&oacute; su clave</a></label>-->
</form>					</div>
					<!-- End of Meta information -->

				</div>
				<!-- End of Top-->
			
				<!-- The navigation bar -->
                
                <div id="navbar">
<ul class='nav sf-js-enabled sf-shadow'>             
						<!--<li><a href="../acceso_sis/registro_usuario.php"><img src="../images/icons_menu/x32/llavero.png" align="absmiddle" width="20" height="20"> ¿No tiene una cuenta? <b>Regístrese</b></a></li>
            -->
						<li><a href="../ayuda/soporte.php"><img src="../images/icons_menu/x32/soporte.png" align="absmiddle" width="20" height="20"> Soporte</a></li>
            
<li class=""><a class="sf-with-ul" href="#"><img src="../images/icons_menu/x32/help.png" align="top" height="20px" width="20px">  Ayuda<span class="sf-sub-indicator"></span></a>
						<ul style="visibility: hidden; display: none;">
						
						 <li><a href="../ayuda/manual_usu.htm"  target="_blank"><img src="../images/sistema/manual.png" align="top" height="20px" width="20px">  Manual de usuario</a></li>
             
</ul>                
</li>
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
					  echo mostrar_box("inf",true,"Seguridad del sistema",utf8_encode("Usted ha sido desconectado del sistema porque transcurrió un tiempo largo de inactividad, el sistema se desconecta automaticamente luego de cierto tiempo de inactividad, para volver acceder use su nombre de usuario y clave de acceso"));
						break;
					case 1:
						
						$intentos_rest=$_SESSION["IR"];
						if (!empty($_SESSION["mos_int_acc"]) && ($_SESSION["mos_int_acc"]==true)) {
							$msg_restantes="<br>Le quedan $intentos_rest intentos, al superar el límite su usuario ser&aacute; bloqueado";
						} else {$msg_restantes="";}
					  echo mostrar_box("err",true,"Seguridad del sistema",utf8_encode("Error en nombre de usuario o clave de acceso".$msg_restantes));
						break;
					case "UB":
					 echo mostrar_box("err",true,"Seguridad del sistema",utf8_encode("El usuario se encuentra bloqueado, contacte con el administrador del sistema para proceder desbloquearlo. Es probable que haya ingresado más de tres veces la clave incorrecta y el sistema bloquea automáticamente el usuario por medidas de seguridad"));
					 unset($_SESSION["IA"]);
						break;
						
					}
			}
								//else
					//{echo "NO SE DEFINIO ERROR AL INICIO";}

			?>
            <h2>Bienvenido al sistema, para ingresar use el nombre de usuario y clave de acceso suministrado por el departamento técnico</h2><hr>

					  <!-- End of Three columns content --></div>
					<div class="pad20">
							<!-- End of Progressbar -->
							<fieldset>
              <p><b>Información de contacto para soporte:</b></p>
              <p><b>Programador:</b> Jairo Alexi Mendoza</p>
              <p><b>Información de contacto:</b></p> 						<p><b>Tel&eacute;fono:</b> 0424-715.60.00</p>
              <p><b>Email:</b> mdalex2@yahoo.es</p>
              </fieldset>
					  </div>	
						
					</div>
				</div>
				<!-- End of Main Content -->
				
				<!-- Sidebar -->
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
			<!-- End of bgwrap -->

		</div>
		<!-- End of Container -->
    
		</div>
		<!-- Footer -->
    <div id="footer" class="footer">
			<p class="mid"><br>
      <br>
				<!-- Change this to your own once purchased -->Programador: Jairo  Alexi Mendoza &copy;. Todos los derechos reservados.<!-- -->
			</p>
	  </div>
		<!-- End of Footer -->


</body></html>
<?php
			if (isset($_SESSION["err"])){
				switch ($_SESSION["err"]){
					case 1:
						if (!empty($_SESSION["mos_int_acc"]) && $_SESSION["mos_int_acc"]==true){
							$msg_restantes="\\n\\nQuedan {$_SESSION['IR']} intentos para acceder correctamente, de lo contrario su usuario será bloqueado";
						} else {$msg_restantes="";}
					
						echo "<script type='text/javascript'> alert('Error en nombre de usuario o clave de acceso. $msg_restantes');</script>";
						break;
					case "UB":
						echo "<script type=\"text/javascript\"> alert(\"El usuario se encuentra bloqueado, contacte con el administrador del sistema para desbloquearlo\")</script>";
						
						break;
						
					}
			}
								//else
					//{echo "NO SE DEFINIO ERROR AL INICIO";}

			?>