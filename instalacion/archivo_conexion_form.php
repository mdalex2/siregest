<!DOCTYPE HTML>
<html><head>

	
		<!-- Meta -->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<!-- End of Meta -->
		
		<!-- Page title -->
<title>SIREGEST: Sistema de Registros Estudiantiles</title>
		<!-- End of Page title -->
		
		<!-- Libraries -->
		<link type="text/css" href="../wideadmin_files/layout.css" 
rel="stylesheet">	
		<link type="text/css" href="../wideadmin_files/login.css" 
rel="stylesheet">	
		
      <!-- ojo dejarlo en este orden porq si no no funciona la validacioon del form-->
		<!--<script type="text/javascript" src="../wideadmin_files/jquery-1.js" charset="utf-8"></script>-->
		<!--<script type="text/javascript" src="../wideadmin_files/easyTooltip.js" charset="utf-8"></script>-->
		<!--<script type="text/javascript" src="../wideadmin_files/jquery-ui-1.js" charset="utf-8"></script>-->
		<script type="text/javascript" src="../js/jquery-1.7.1.min.js" charset="utf-8"></script>
		<!--<script type="text/javascript" src="../wideadmin_files/hoverIntent.js" charset="utf-8"></script>-->
    <script type="text/javascript" src="../wideadmin_files/custom.js" charset="utf-8"></script>
		<!--<script type="text/javascript" src="../wideadmin_files/superfish.js" charset="utf-8"></script>-->
    <!-- para el uniform validacion de aqui para abajo-->
		<script type="text/javascript" src="../js/jquery-1.7.1.min.js" charset="utf-8"></script>
		<script type="text/javascript" src="../js/uni-form-validation.jquery.min.js" charset="utf-8"></script>
  	<script type="text/javascript">
      $(function(){
        $('form.uniForm').uniform({
          prevent_submit : true
        });
      });
    </script>
		<!-- End of Libraries -->
    <link href="../ccs/forms/default.uni-form.css" title="Default Style" media="screen" rel="stylesheet"/>
</style>
</head><body>
<!-- Container -->
  <div id="container">
		
			<!-- Header -->
			<div id="header" class="fondo_superior">
				
				<!-- Top -->
				<div id="top">
					<!-- Logo -->
					<div class="logo"> 
						<a href="#" title="Administration Home" class="tooltip"><img 
src="../wideadmin_files/logo.png" width="500" height="89px" alt="Inicio"></a> 
					</div>
					<!-- End of Logo -->
					
					<!-- Meta information -->
					<div class="meta">
                   	  <form action="../funciones/verifica_login.php" method="post" name="login" class="form_marco" target="_self">
                      <h3>Acceso al sistema:</h3>
                       <label id="login_label">Nombre de usuario<br />
		<input type="text" name="log" id="user_login" class="input" value="" size="12" /></label>
        &nbsp;&nbsp;
        <label id="login_label">Contrase&ntilde;a<br />
		<input type="password" name="pwd" id="user_pass" class="input" value="" size="12"  /></label>
	<br>

	  <input type="submit" name="wp-submit" class="button" value="Iniciar sesión" align="left" />
      &nbsp;
      <!--<label id="login_label"><a href="../acceso_sis/olvido_clave.php" id="link_login" alt="Haga clic aqui">Olvid&oacute; su clave</a></label>-->
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
						<!--<li><a href="../acceso_sis/registro_usuario.php"><img src="../images/icons_menu/x32/llavero.png" align="absmiddle" width="20" height="20"> ¿No tiene una cuenta? <b>Regístrese</b></a></li>-->
						<li><a href="../ayuda/soporte.php"><img src="../images/icons_menu/x32/soporte.png" align="absmiddle" width="20" height="20"> Soporte</a></li>
						<li><a href="../ayuda/manual_usu.htm" target="_blank"><img src="../images/icons_menu/x32/help.png" align="absmiddle" width="20" height="20"> Ayuda</a></li>
            
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
                    <!-- Three columns content -->
						<?php
					if (isset($_REQUEST["error"]))
					{
						$error=$_REQUEST["error"];
						switch ($error) {
							case "NCS":
							 echo '<div class="message warning close">
							<h2>Atención!</h2>
							<p>Has llegado a ésta página porque <b>los datos del archivo de conexión al servidor contiene valores incorrectos</b>. Para corregir el inconveniente debe suministrar los datos correctos a continuación.</p>
						</div>	';
						break;
							case "ESBD":
							 echo '<div class="message warning close">
							<h2>Atención!</h2>
							<p><b>No se puede conectar con la base de datos</b>, verifíque el nombre de la base de datos e intente de nuevo, si el problema persiste el probable que no exista la base de datos en el servidor.</p>
						</div>	';
						break;
							case "NEAC":
							 echo '<div class="message warning close">
							<h2>INSTALACIÓN!</h2>
							<p><b>No existe el archivo de conexión al servidor de base de datos</b>, este asistente le ayudara a crear su archivo de conexión, por favor ingrese los siguientes datos.</p>
						</div>	';
						break;
						
						case "E0":
							echo '<div class="message success close">
							<h2>Información</h2>
							<p>El archivo de conexión al servidor se ha creado correctamente, ahora puede acceder al sistema. <a href="../acceso_sis/index.php"><b>Haga clic aqui para ir a pantalla inicial</b></a></p>
						</div>';
						break;						

						default:
						 echo '<div class="message information close">
							<h2>Información</h2>
							<p>Por favor ingrese los datos solicitados a continuación.</p>
						</div>';
						break;						
						}
						}
												else
						echo '<div class="message information close">
							<h2>Información</h2>
							<p>Por favor ingrese los datos solicitados a continuación.</p>
						</div>';

					?>
							<!-- Column one -->

                    
                  <form method="post" action="crear_archivo_config.php" class="uniForm">
										<!-- Fieldset -->
                                        
										<fieldset>
										  <legend>Configuración:</legend>
                                            <h2><img src="../images/icons_menu/x48/local_network_48.png" width="36" height="36" align="absmiddle"> Creación de archivo de conexión al servidor </h2>
                                            <table width="...">
                                            <tr>
                                            <td>
										  <div class="ctrlHolder">
          
            <label for="txt_servidor">Direccción IP o nombre del servidor</label></BR>
            <input name="txt_servidor" id="txt_servidor" data-default-value="Ejm: MERMRDPC01" size="30" maxlength="30" type="text" class="textInput required alphanum" value="<?php if(isset($_REQUEST['servidor'])) {echo $_REQUEST['servidor'];} ?>"/>
<p class="formHint"> (*) Ejm: MERMRDPC01</p>
        </div>
          </td>
          <td>
			<div class="ctrlHolder">
            <label for="txt_bd">Nombre de la base de datos</label></BR>
            <input name="txt_bd" id="txt_bd" data-default-value="Ejm: siregest" size="30" maxlength="30" type="text" class="textInput required" value="<?php if(isset($_REQUEST['bd'])) {echo $_REQUEST['bd'];} ?>"/>
			<p class="formHint"> (*) Ejm: siregest</p>
        </div>									
          </td>
</tr>
<tr><td>
			<div class="ctrlHolder">
            <label for="txt_id_usu">ID usuario</label></br>
            <input name="txt_id_usu" id="txt_id_usu" data-default-value="Ejm: root" size="30" maxlength="30" type="text" class="textInput required" value="<?php if(isset($_REQUEST['id_usu'])) {echo $_REQUEST['id_usu'];} ?>"/>
			<p class="formHint"> (*) Ejm: root</p>
        </div>									
</td>
<td>
			<div class="ctrlHolder">
            <label for="txt_clave">Contraseña</label></br>
            <input name="txt_clave" id="txt_clave" data-default-value="Ejm: @SisTema2011#" size="30" maxlength="30" type="password" class="textInput required"/>
			<p class="formHint"> (*) Ejm: @SisTema2011#</p>
        </div>
</td>
</tr>

          <tr><td>
												<input name="Enviar" type="submit" class="button" value="Guardar configuraci&oacute;n" >
         </td>
         <td>
												<input class="button" value="Limpiar" type="reset">
         </td>
         </tr>
         </table>
							  </fieldset>
										<!-- End of fieldset -->
                                        

					  </form>

						<!-- Three columns content -->
<div id="columns" class="sortable">
							
							<!-- Column two --><!-- End of Column two -->
							
							<!-- Column three --><!-- End of Column three -->
<!--prueba de otras columnas-->
							
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
	        <h2>OPCIONES:</h2>
					<div class="sort ui-sortable">
						<div class="box ui-widget ui-widget-content ui-corner-all portlet 
ui-helper-clearfix">
						<div class="portlet-header ui-widget-header ui-corner-all">Configuraci&oacute;n del sistema</div>
							<div class="portlet-content">
								<p><a href="archivo_conexion_form.php" target="_self"><img src="../images/icons_menu/x32/local_network_32.png" width="16" height="16" align="absmiddle"> Crear archivo de conexión</a></p>
								<p><a href="../acceso_sis/index.php"> <img src="../images/icons_menu/x32/home.png" width="16" height="16" align="absmiddle"> Ir a página principal</a></p>
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
				<!-- Change this to your own once purchased -->
				© Alexi Mendoza Diaz 2011.				<!-- -->
			</p>
		</div>
        
		<!-- End of Footer --></body>

        </html>
