<!DOCTYPE HTML>
<html><head>

	
		<!-- Meta -->
		<meta http-equiv="Content-Type" content="text/html; 
charset=utf-8">
		<!-- End of Meta -->
		
		<!-- Page title -->
		<title>SIREGEST: Sistema de Registros Estudiantiles V.2012.1</title>
		<!-- End of Page title -->
		
		<!-- Libraries -->
		<link type="text/css" href="../wideadmin_files/layout.css" 
rel="stylesheet">	
		
		<script type="text/javascript" src="../wideadmin_files/jquery-1.js"></script>
		<script type="text/javascript" src="../wideadmin_files/easyTooltip.js"></script>
		<script type="text/javascript" src="../wideadmin_files/jquery-ui-1.js"></script>
		<script type="text/javascript" src="../wideadmin_files/jquery.js"></script>
		<script type="text/javascript" src="../wideadmin_files/hoverIntent.js"></script>
		<script type="text/javascript" src="../wideadmin_files/superfish.js"></script>
		<script type="text/javascript" src="../wideadmin_files/custom.js"></script>
		<!-- End of Libraries -->	
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
src="../wideadmin_files/logo.png" alt="Wide Admin"></a> 
					</div>
					<!-- End of Logo -->
					
					<!-- Meta information -->
					<div class="meta">
						<p>Bienvenido(a) Maria Omaira Diaz! <a href="#" title="1 new private message
 from Elaine!" class="tooltip">1 nuevo mensaje!</a></p>
						<ul>
							<li><a href="#" title="End administrator session" class="tooltip"><span
 class="ui-icon ui-icon-power"></span>Salir</a></li>
							<li><a href="#" title="Change current settings" class="tooltip"><span
 class="ui-icon ui-icon-wrench"></span>Configuración</a></li>
							<li><a href="#" title="Go to your account" class="tooltip"><span 
class="ui-icon ui-icon-person"></span>Información de la cuenta</a></li>
						</ul>	
					</div>
					<!-- End of Meta information -->

				</div>
				<!-- End of Top-->
			
				<!-- The navigation bar -->
                
                <div id="navbar">
                
                <?php
/**
  ------ CREA MENU PARA USUARIOS
*/
    
   IF (session_start()==true){
	   session_destroy();
	   session_start();
   }
   else{
	   session_start();
	   }

    require_once("../funciones/conexion.php");
    require_once("../funciones/funcionesPHP.php");
    
    $link = conectarse($host, $usuario, $password, $bd);
    
     $menu = "<ul class='nav sf-js-enabled sf-shadow'>
	 ";

    
    function getHijos($id){
        $sql = "SELECT * FROM sis_funciones WHERE id_padre = '$id' ORDER BY orden ASC";
        $res = mysql_query($sql);
        $hijos = mysql_affected_rows();
        return($hijos);
    }
    
    function menu($id, &$m, $profundidad = 0) { 
         //echo "[ $id, $profundidad ]";
         $sql = "SELECT * FROM sis_funciones WHERE id_padre = '$id' ORDER BY orden ASC"; 
         $res = mysql_query($sql); 
         $j = 1;
         while ($row = mysql_fetch_array($res)){ 
                 //pregunto la cantidad de hijos que tiene el item que entra al primero le agrego <ul> y al ultimo hijo le agrego </ul>
                $hijos = getHijos($row['id_func']);
                /* muestro mensaje con el nombre del icono o funcion*/
                /*echo "<br>HIJOS: $hijos - ";echo $row['texto_icono']."  --  ";
                  echo "<a href=\"{$row['url']}\">{$row['texto_icono']}</a>";echo "$profundidad, $j";*/
                 if($hijos > 0)
					{
												$m .= "<li class=''><a class='sf-with-ul' href='{$row['url']}'>".$row['texto_icono']."<span 
class='sf-sub-indicator'> »</span></a>";
					}
					else
					{
						$m .= "<li><a href='{$row['url']}'>".$row['texto_icono']."</a>";
					}					
				

                if($hijos > 0)
					{
						/*$m .= "<ul>";   original*/
						$m.= "<ul style='display: none; visibility: hidden;'>";
					}

                if( ($row['id_padre'] != 0) && (getHijos($row['id_padre']) == $j) && (getHijos($row['id_func']) == 0)){
                    $m .= "</li></ul>";
                }
                //caso especial
                /*if( ($row['id_padre'] != 0) && (getHijos($row['id_padre']) == $j) && (getHijos($row['id_func']) == 0)){
                    $m .= "</ul></ul>";
                }*/
                 $j++;
                  menu($row['id_func'], $m, $profundidad + 1); 
         }
         
    }
    menu(-1, $menu);
    /*echo"<br><br>";*/
    $menu .= "</ul>";
    print_r($menu);
    
   
               
					/*echo "<ul class='nav sf-js-enabled sf-shadow'>
					         <li class=''> 
								  <a class='sf-with-ul' href='#'><img src='../wideadmin_files/prof.png' align='top'></img>&nbsp;Profesores</a>
							      <ul style='display: none; visibility: hidden;'> 
							 		<li><a href='#'>prueba</a></li>
									<li><a href='#'>prueba1</a></li>
								  </ul>
							 </li>"*/
					?>
                   
				</div>
				<!-- End of navigation bar" -->
				
				<!-- Search bar -->
				<div id="search">
					<form action="/search/" method="POST">
						<p>
							<input value="" class="but" type="submit">
							<input name="q" value="Buscar en el panel de funciones" 
onfocus="if(this.value==this.defaultValue)this.value='';" 
onblur="if(this.value=='')this.value=this.defaultValue;" type="text">
						</p>
					</form>
				</div>
				<!-- End of Search bar -->
			
			</div>
			<!-- End of Header -->
			
			<!-- Background wrapper -->
			<div id="bgwrap">
		
				<!-- Main Content -->
				<div id="content">
					<div id="main">
					<h1>Bienvenido(a), <span>Maria Omaria</span>!</h1>
					<p>&iquest;Que le gustar&iacute;a hacer hoy?</p>
					
					<div class="pad20">
					<!-- Big buttons -->
						<ul class="dash">
							<li>
								<a href="otra.php" title="Agregar Alumnos" class="tooltip">
									<img src="../wideadmin_files/8_48x48.png" alt="">
									<span>Nuevo alumno</span>
								</a>
							</li>
							<li>
								<a href="#" title="Efectuar constancias de notas para los alumnos" class="tooltip">
									<img src="../wideadmin_files/7_48x48.png" alt="">
									<span>Const. de notas</span>
								</a>
							</li>
							<li>
								<a href="#" title="Administrar las cuentas de usuarios" class="tooltip">
									<img src="../wideadmin_files/16_48x48.png" alt="">
									<span>Adm. Usuarios</span>
								</a>
							</li>
							<li>
								<a href="#" title="Estadisticas" class="tooltip">
									<img src="../wideadmin_files/4_48x48.png" alt="">
									<span>Hacer estadisticas</span>
								</a>
							</li>
							<li>
								<a href="#" title="Ver usuarios conectado" class="tooltip">
									<img src="../wideadmin_files/14_48x48.png" alt="">
									<span>Conexiones</span>
								</a>
							</li>
							<li>
								<a href="#" title="Server warnings" class="tooltip">
									<img src="../wideadmin_files/5_48x48.png" alt="">
									<span>Server warnings</span>
								</a>
							</li>
							<li>
								<a href="#" title="Manage downloads" class="tooltip">
									<img src="../wideadmin_files/3_48x48.png" alt="">
									<span>Downloads</span>
								</a>
							</li>
							<li>
								<a href="#" title="Lorem ipsum" class="tooltip">
									<img src="../wideadmin_files/9_48x48.png" alt="">
									<span>Listings</span>
								</a>
							</li>
							<li>
								<a href="#" title="Users' photo gallery" class="tooltip">
									<img src="../wideadmin_files/1_48x48.png" alt="">
									<span>Gallery</span>
								</a>
							</li>
							<li>
								<a href="#" title="0 new messages" class="tooltip">
									<img src="../wideadmin_files/25_48x48.png" alt="">
									<span>Inbox</span>
								</a>
							</li>
							<li>
								<a href="#" title="Browse for files" class="tooltip">
									<img src="../wideadmin_files/21_48x48.png" alt="">
									<span>File browser</span>
								</a>
							</li>
							<li>
								<a href="#" title="Calculator" class="tooltip">
									<img src="../wideadmin_files/30_48x48.png" alt="">
									<span>Calculator</span>
								</a>
							</li>
							<li>
								<a href="#" title="RSS Feeds" class="tooltip">
									<img src="../wideadmin_files/29_48x48.png" alt="">
									<span>Feeds</span>
								</a>
							</li>
							<li>
								<a href="#" title="Lorem ipsum" class="tooltip">
									<img src="../wideadmin_files/20_48x48.png" alt="">
									<span>Media</span>
								</a>
							</li>
							<?php
							$num = 1;
							while ($num <= 200) {
								
								echo "<li><a href='../SIREGEST/template_siregest.php' title='Nueva función disponible' class='tooltip'><img src='../wideadmin_files/3_48x48.png' alt=''><span>Nueva Func. $num</span></a></li>";
								
								$num++;
							}
							?>
								
							<li>
								<a href="#" title="Lorem ipsum" class="tooltip">
									<img src="../wideadmin_files/26_48x48.png" alt="">
									<span>Latest comments</span>
								</a>
							</li>
						</ul>
						<!-- End of Big buttons -->
					</div>
					<hr>
					
					<h1>Notifications</h1>
					<div class="pad20">
						<p>Wide Admin provides some nice graphics and effects for custom 
notification messages. Clicking on one message will make it disappear! 
This is optional, of course!</p>
						<div class="message success close">
							<h2>Congratulations!</h2>
							<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla
 vulputate ligula est, ut facilisis magna. Quisque vitae est sapien. 
Etiam in diam ipsum. Etiam condimentum euismod eleifend. Lorem! 
Vestibulum quis turpis eu justo porta tincidunt.</p>
						</div>
						<div class="message warning close">
							<h2>Warning!</h2>
							<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla
 vulputate ligula est, ut facilisis magna. Quisque vitae est sapien. 
Etiam in diam ipsum. Etiam condimentum euismod eleifend. Vivamus gravida
 nunc in augue accumsan vitae pharetra tellus pretium. Vestibulum non 
mauris in nunc dictum faucibus.</p>
						</div>
						<div class="message error close">
							<h2>Error!</h2>
							<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla
 vulputate ligula est, ut facilisis magna. Quisque vitae est sapien. 
Etiam in diam ipsum. Etiam condimentum euismod eleifend. Vestibulum quis
 turpis eu justo porta tincidunt. </p>
						</div>
						<div class="message information close">
							<h2>Information</h2>
							<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla
 vulputate ligula est, ut facilisis magna. Quisque vitae est sapien. 
Etiam in diam ipsum. Etiam condimentum euismod eleifend. Lorem! 
Vestibulum quis turpis eu justo porta tincidunt.</p>
						</div>
					</div>
			
					<hr>
								
					<h1>Three columns, sortable content</h1>
					<div class="pad20">
					
						<!-- Three columns content -->
						<div id="columns" class="sortable">
						
							<!-- Column one -->
							<div style="-moz-user-select: none;" unselectable="on" 
class="cols3 column ui-sortable">
								<div class="portlet ui-widget ui-widget-content 
ui-helper-clearfix ui-corner-all">
									<div class="portlet-header ui-widget-header ui-corner-all"><span
 class="ui-icon ui-icon-circle-arrow-s"></span>Dummy content 1</div>
									<div class="portlet-content">
										<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. 
Aenean commodo ligula eget dolor. Aenean massa.</p>
										<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
Nam eu orci quam, vitae molestie nulla. Etiam tempus suscipit imperdiet.
 Nam vitae purus neque, nec placerat dui. Aenean tristique sapien metus.
 Mauris tempus arcu vel sapien tristique vitae sagittis nisi hendrerit.</p>
	
									</div>
								</div>
							</div>
							<!-- End of Column one -->
							
							<!-- Column two -->
							<div style="-moz-user-select: none;" unselectable="on" 
class="cols3 column ui-sortable">
								<div class="portlet ui-widget ui-widget-content 
ui-helper-clearfix ui-corner-all">
									<div class="portlet-header ui-widget-header ui-corner-all"><span
 class="ui-icon ui-icon-circle-arrow-s"></span>Dummy content 2</div>
									<div class="portlet-content">
										<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. 
Aenean commodo ligula eget dolor. Aenean massa.</p>
										<p>Cum sociis natoque penatibus et magnis dis parturient 
montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, 
pellentesque eu, pretium quis, sem.</p>
										<p>Nullam dictum felis eu pede mollis pretium. Integer 
tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate
 eleifend tellus.</p>
									</div>
								</div>
								
								<div class="portlet ui-widget ui-widget-content 
ui-helper-clearfix ui-corner-all">
									<div class="portlet-header ui-widget-header ui-corner-all"><span
 class="ui-icon ui-icon-circle-arrow-s"></span>Dummy content 4</div>
									<div class="portlet-content">
										<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. 
Aenean commodo ligula eget dolor. Aenean massa.</p>
										<p>Cum sociis natoque penatibus et magnis dis parturient 
montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, 
pellentesque eu, pretium quis, sem.</p>
										<p>Nullam dictum felis eu pede mollis pretium. Integer 
tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate
 eleifend tellus.</p>
									</div>
								</div>
							</div>
							<!-- End of Column two -->
							
							<!-- Column three -->
							<div style="-moz-user-select: none;" unselectable="on" 
class="cols3 column ui-sortable">
								<div class="portlet ui-widget ui-widget-content 
ui-helper-clearfix ui-corner-all">
									<div class="portlet-header ui-widget-header ui-corner-all"><span
 class="ui-icon ui-icon-circle-arrow-s"></span>Dummy content 3</div>
									<div class="portlet-content">
										<p>Cum sociis natoque penatibus et magnis dis parturient 
montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, 
pellentesque eu, pretium quis, sem.</p>
										<p>Nulla consequat massa quis enim. Donec pede justo, 
fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus
 ut, imperdiet a, venenatis vitae, justo.</p>
										<p>Nullam dictum felis eu pede mollis pretium. Integer 
tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate
 eleifend tellus.</p>
									</div>
								</div>
							</div>
							<!-- End of Column three -->
							
						</div>
						<!-- End of Three columns content -->
					</div>
					
					<hr>
					
					<h1>Tabs (Forms, Tables, Icons and Buttons)</h1>
					<div class="pad20">
					
						<!-- Tabs -->
						<div class="ui-tabs ui-widget ui-widget-content ui-corner-all" 
id="tabs">
							<ul class="ui-tabs-nav ui-helper-reset ui-helper-clearfix 
ui-widget-header ui-corner-all">
								<li class="ui-state-default ui-corner-top ui-tabs-selected 
ui-state-active"><a href="#tabs-1">Forms Preview</a></li>
								<li class="ui-state-default ui-corner-top"><a href="#tabs-2">Tables</a></li>
								<li class="ui-state-default ui-corner-top"><a href="#tabs-3">Framework
 Icons &amp; Buttons</a></li>
							</ul>
							
							<!-- First tab -->
							<div class="ui-tabs-panel ui-widget-content ui-corner-bottom" 
id="tabs-1">
									<!-- Form -->
									<form method="post" action="#">
										<!-- Fieldset -->
										<fieldset>
											<legend>This is a simple fieldset</legend>
											<p>
												<label for="sf">Small field: </label>
												<input class="sf" name="sf" value="small input field" 
type="text">
												<span class="field_desc">Field description</span>
											</p>
											<p>
												<label for="mf">Medium Field: </label>
 												<input class="mf" name="mf" value="medium input field" 
type="text"> <span class="validate_success">A positive message!</span>
											</p>
											<p>
												<label for="lf">Large Field: </label>
 												<input class="lf" name="lf" value="large input field" 
type="text"> <span class="validate_error">A negative message!</span>
											</p>
											<p>
												<label>Linecheckboxes: </label>
												<input type="checkbox">Lorem Ipsum
												<input type="checkbox">Lorem Ipsum
												<input type="checkbox">Lorem Ipsum
												<input type="checkbox">Lorem Ipsum
											</p>
											<p>
												<label for="dropdown">DropDown: </label>
												<select name="dropdown" class="dropdown">
													<option selected="selected">Please select an option</option>
													<option>Upload</option>
													<option>Change</option>
													<option>Remove</option>
												</select>
											</p>
											<p>
												<label>Vertical:</label>
												</p><div class="inpcol">
													<p><input type="checkbox">Lorem Ipsum</p>
													<p><input type="checkbox">Lorem Ipsum</p>
													<p><input type="checkbox">Lorem Ipsum</p>
													<p><input type="checkbox">Lorem Ipsum</p>
												</div>
												<div class="inpcol">
													<p><input type="radio">Lorem Ipsum</p>
													<p><input type="radio">Lorem Ipsum</p>
													<p><input type="radio">Lorem Ipsum</p>
													<p><input type="radio">Lorem Ipsum</p>
												</div>
											
											<p>
												<!-- WYSIWYG editor -->
												<div class="wysiwyg" style="width: 500px;"><ul role="menu" 
class="panel"><li><a title="Bold" class="bold" role="menuitem" 
tabindex="-1" href="javascript:;">bold</a></li><li><a title="Italic" 
class="italic" role="menuitem" tabindex="-1" href="javascript:;">italic</a></li><li><a
 title="Strike-through" class="strikeThrough" role="menuitem" 
tabindex="-1" href="javascript:;">strikeThrough</a></li><li><a 
title="Underline" class="underline" role="menuitem" tabindex="-1" 
href="javascript:;">underline</a></li><li role="separator" 
class="separator"></li><li><a title="Justify Left" class="justifyLeft" 
role="menuitem" tabindex="-1" href="javascript:;">justifyLeft</a></li><li><a
 title="Justify Center" class="justifyCenter" role="menuitem" 
tabindex="-1" href="javascript:;">justifyCenter</a></li><li><a 
title="Justify Right" class="justifyRight" role="menuitem" tabindex="-1"
 href="javascript:;">justifyRight</a></li><li><a title="Justify Full" 
class="justifyFull" role="menuitem" tabindex="-1" href="javascript:;">justifyFull</a></li><li
 role="separator" class="separator"></li><li><a title="Indent" 
class="indent" role="menuitem" tabindex="-1" href="javascript:;">indent</a></li><li><a
 title="Outdent" class="outdent" role="menuitem" tabindex="-1" 
href="javascript:;">outdent</a></li><li role="separator" 
class="separator"></li><li><a title="Subscript" class="subscript" 
role="menuitem" tabindex="-1" href="javascript:;">subscript</a></li><li><a
 title="Superscript" class="superscript" role="menuitem" tabindex="-1" 
href="javascript:;">superscript</a></li><li role="separator" 
class="separator"></li><li><a title="Undo" class="undo" role="menuitem" 
tabindex="-1" href="javascript:;">undo</a></li><li><a title="Redo" 
class="redo" role="menuitem" tabindex="-1" href="javascript:;">redo</a></li><li
 role="separator" class="separator"></li><li><a title="Insert Ordered 
List" class="insertOrderedList" role="menuitem" tabindex="-1" 
href="javascript:;">insertOrderedList</a></li><li><a title="Insert 
Unordered List" class="insertUnorderedList" role="menuitem" 
tabindex="-1" href="javascript:;">insertUnorderedList</a></li><li><a 
title="Insert Horizontal Rule" class="insertHorizontalRule" 
role="menuitem" tabindex="-1" href="javascript:;">insertHorizontalRule</a></li><li
 role="separator" class="separator"></li><li><a title="Create link" 
class="createLink" role="menuitem" tabindex="-1" href="javascript:;">createLink</a></li><li><a
 title="Insert image" class="insertImage" role="menuitem" tabindex="-1" 
href="javascript:;">insertImage</a></li><li role="separator" 
class="separator"></li><li><a title="Header 1" class="h1" 
role="menuitem" tabindex="-1" href="javascript:;">h1</a></li><li><a 
title="Header 2" class="h2" role="menuitem" tabindex="-1" 
href="javascript:;">h2</a></li><li><a title="Header 3" class="h3" 
role="menuitem" tabindex="-1" href="javascript:;">h3</a></li><li 
role="separator" class="separator"></li><li><a title="Cut" class="cut" 
role="menuitem" tabindex="-1" href="javascript:;">cut</a></li><li><a 
title="Copy" class="copy" role="menuitem" tabindex="-1" 
href="javascript:;">copy</a></li><li><a title="Paste" class="paste" 
role="menuitem" tabindex="-1" href="javascript:;">paste</a></li><li 
role="separator" class="separator"></li><li><a title="Remove formatting"
 class="removeFormat" role="menuitem" tabindex="-1" href="javascript:;">removeFormat</a></li><li><a
 title="Header 4" class="h4" role="menuitem" tabindex="-1" 
href="javascript:;">h4</a></li><li><a title="Header 5" class="h5" 
role="menuitem" tabindex="-1" href="javascript:;">h5</a></li><li><a 
title="Header 6" class="h6" role="menuitem" tabindex="-1" 
href="javascript:;">h6</a></li></ul><div style="clear: both;"><!-- --></div><iframe
 tabindex="0" id="IFrame" style="min-height: 154px; width: 492px;" 
src="javascript:false;" frameborder="0"></iframe></div><textarea 
style="display: none;" cols="80" rows="10" class="wysiwyg"></textarea>
												<!-- End of WYSIWYG editor -->
											</p>
											<p>
												<input class="button" value="Submit" type="submit">
												<input class="button" value="Reset" type="reset">
											</p>
										</fieldset>
										<!-- End of fieldset -->
									</form>
									<!-- End of Form -->	
									<p>Proin vel ullamcorper purus. Pellentesque accumsan magna 
volutpat lacus volutpat quis lacinia metus vehicula. In hac habitasse 
platea dictumst. Aenean lorem mauris, iaculis sit amet condimentum 
luctus, volutpat ac nunc. Pellentesque cursus, eros ac lobortis 
dignissim, diam tortor malesuada lorem, cursus tempus dui sapien 
hendrerit mi. Nulla facilisi. Nulla facilisi. Fusce tincidunt dui sed 
eros interdum vel dignissim enim tempus. Vestibulum massa ipsum, 
volutpat eget blandit ac, semper eu dui. Nam eget mi sapien. </p>
								</div>
								<!-- End of First tab -->
								
								<!-- Second tab -->
								<div class="ui-tabs-panel ui-widget-content ui-corner-bottom 
ui-tabs-hide" id="tabs-2">
									<p>A simple full width table</p>
									<p>Cras adipiscing, nisl ut rutrum vulputate, risus eros 
tincidunt justo, pellentesque dapibus elit massa vel risus. Nulla ac leo
 in ipsum sodales malesuada. Cras sit amet est nisl, at tristique augue.
 Class aptent taciti sociosqu ad litora torquent per conubia nostra, per
 inceptos himenaeos.</p>
									<table class="fullwidth" border="0" cellpadding="0" 
cellspacing="0">
										<thead>
											<tr>
												<td><input class="checkall" type="checkbox"></td>
												<td>Name</td>
												<td>E-Mail</td>
												<td>Birthdate</td>
											</tr>
										</thead>
										<tbody>
											<tr class="odd">
												<td><input type="checkbox"></td>
												<td>Johnatan Doe</td>
												<td>johndoe@someservice.web</td>
												<td>28/09/1978</td>
											</tr>
											<tr>
												<td><input type="checkbox"></td>
												<td>Johnatan Doe</td>
												<td>johndoe@someservice.web</td>
												<td>28/09/1978</td>
											</tr>
											<tr class="odd">
												<td><input type="checkbox"></td>
												<td>Johnatan Doe</td>
												<td>johndoe@someservice.web</td>
												<td>28/09/1978</td>
											</tr>
											<tr>
												<td><input type="checkbox"></td>
												<td>Johnatan Doe</td>
												<td>johndoe@someservice.web</td>
												<td>28/09/1978</td>
											</tr>
											<tr class="odd">
												<td><input type="checkbox"></td>
												<td>Johnatan Doe</td>
												<td>johndoe@someservice.web</td>
												<td>28/09/1978</td>
											</tr>
											<tr>
												<td><input type="checkbox"></td>
												<td>Johnatan Doe</td>
												<td>johndoe@someservice.web</td>
												<td>28/09/1978</td>
											</tr>
										</tbody>
									</table>
									<p>This is a normal table, content defines its width.</p>
									<table class="normal" border="0" cellpadding="0" 
cellspacing="0">
										<thead>
											<tr>
												<td>No.</td>
												<td>Image</td>
												<td>E-mail</td>
												<td>Name</td>
												<td>Submission date</td>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>1</td>
												<td><img src="../wideadmin_files/1.jpg" alt=""></td>
												<td>johndoe@something.web</td>
												<td>Johnatan Doe</td>
												<td>23/01/2010</td>
											</tr>
											<tr class="odd">
												<td>2</td>
												<td><img src="../wideadmin_files/2.jpg" alt=""></td>
												<td>johndoe@something.web</td>
												<td>Johnatan Doe</td>
												<td>23/01/2010</td>
											</tr>
											<tr>
												<td>3</td>
												<td><img src="../wideadmin_files/3.jpg" alt=""></td>
												<td>johndoe@something.web</td>
												<td>Johnatan Doe</td>
												<td>23/01/2010</td>
											</tr>
											<tr class="odd">
												<td>4</td>
												<td><img src="../wideadmin_files/4.jpg" alt=""></td>
												<td>johndoe@something.web</td>
												<td>Johnatan Doe</td>
												<td>23/01/2010</td>
											</tr>
										</tbody>
									</table>
								</div>
								<!-- End of Second tab -->
								
								<!-- Third tab -->
								<div class="ui-tabs-panel ui-widget-content ui-corner-bottom 
ui-tabs-hide" id="tabs-3">
									<!-- Framework icons -->
									<ul id="icons" class="ui-widget ui-helper-clearfix">
		
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-carat-1-n"><span class="ui-icon ui-icon-carat-1-n"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-carat-1-ne"><span class="ui-icon ui-icon-carat-1-ne"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-carat-1-e"><span class="ui-icon ui-icon-carat-1-e"></span></li>
		
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-carat-1-se"><span class="ui-icon ui-icon-carat-1-se"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-carat-1-s"><span class="ui-icon ui-icon-carat-1-s"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-carat-1-sw"><span class="ui-icon ui-icon-carat-1-sw"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-carat-1-w"><span class="ui-icon ui-icon-carat-1-w"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-carat-1-nw"><span class="ui-icon ui-icon-carat-1-nw"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-carat-2-n-s"><span class="ui-icon ui-icon-carat-2-n-s"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-carat-2-e-w"><span class="ui-icon ui-icon-carat-2-e-w"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-triangle-1-n"><span class="ui-icon ui-icon-triangle-1-n"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-triangle-1-ne"><span class="ui-icon 
ui-icon-triangle-1-ne"></span></li>
		
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-triangle-1-e"><span class="ui-icon ui-icon-triangle-1-e"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-triangle-1-se"><span class="ui-icon 
ui-icon-triangle-1-se"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-triangle-1-s"><span class="ui-icon ui-icon-triangle-1-s"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-triangle-1-sw"><span class="ui-icon 
ui-icon-triangle-1-sw"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-triangle-1-w"><span class="ui-icon ui-icon-triangle-1-w"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-triangle-1-nw"><span class="ui-icon 
ui-icon-triangle-1-nw"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-triangle-2-n-s"><span class="ui-icon 
ui-icon-triangle-2-n-s"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-triangle-2-e-w"><span class="ui-icon 
ui-icon-triangle-2-e-w"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-arrow-1-n"><span class="ui-icon ui-icon-arrow-1-n"></span></li>
		
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-arrow-1-ne"><span class="ui-icon ui-icon-arrow-1-ne"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-arrow-1-e"><span class="ui-icon ui-icon-arrow-1-e"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-arrow-1-se"><span class="ui-icon ui-icon-arrow-1-se"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-arrow-1-s"><span class="ui-icon ui-icon-arrow-1-s"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-arrow-1-sw"><span class="ui-icon ui-icon-arrow-1-sw"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-arrow-1-w"><span class="ui-icon ui-icon-arrow-1-w"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-arrow-1-nw"><span class="ui-icon ui-icon-arrow-1-nw"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-arrow-2-n-s"><span class="ui-icon ui-icon-arrow-2-n-s"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-arrow-2-ne-sw"><span class="ui-icon 
ui-icon-arrow-2-ne-sw"></span></li>
		
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-arrow-2-e-w"><span class="ui-icon ui-icon-arrow-2-e-w"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-arrow-2-se-nw"><span class="ui-icon 
ui-icon-arrow-2-se-nw"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-arrowstop-1-n"><span class="ui-icon 
ui-icon-arrowstop-1-n"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-arrowstop-1-e"><span class="ui-icon 
ui-icon-arrowstop-1-e"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-arrowstop-1-s"><span class="ui-icon 
ui-icon-arrowstop-1-s"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-arrowstop-1-w"><span class="ui-icon 
ui-icon-arrowstop-1-w"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-arrowthick-1-n"><span class="ui-icon 
ui-icon-arrowthick-1-n"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-arrowthick-1-ne"><span class="ui-icon 
ui-icon-arrowthick-1-ne"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-arrowthick-1-e"><span class="ui-icon 
ui-icon-arrowthick-1-e"></span></li>
		
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-arrowthick-1-se"><span class="ui-icon 
ui-icon-arrowthick-1-se"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-arrowthick-1-s"><span class="ui-icon 
ui-icon-arrowthick-1-s"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-arrowthick-1-sw"><span class="ui-icon 
ui-icon-arrowthick-1-sw"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-arrowthick-1-w"><span class="ui-icon 
ui-icon-arrowthick-1-w"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-arrowthick-1-nw"><span class="ui-icon 
ui-icon-arrowthick-1-nw"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-arrowthick-2-n-s"><span class="ui-icon 
ui-icon-arrowthick-2-n-s"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-arrowthick-2-ne-sw"><span class="ui-icon 
ui-icon-arrowthick-2-ne-sw"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-arrowthick-2-e-w"><span class="ui-icon 
ui-icon-arrowthick-2-e-w"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-arrowthick-2-se-nw"><span class="ui-icon 
ui-icon-arrowthick-2-se-nw"></span></li>
		
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-arrowthickstop-1-n"><span class="ui-icon 
ui-icon-arrowthickstop-1-n"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-arrowthickstop-1-e"><span class="ui-icon 
ui-icon-arrowthickstop-1-e"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-arrowthickstop-1-s"><span class="ui-icon 
ui-icon-arrowthickstop-1-s"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-arrowthickstop-1-w"><span class="ui-icon 
ui-icon-arrowthickstop-1-w"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-arrowreturnthick-1-w"><span class="ui-icon 
ui-icon-arrowreturnthick-1-w"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-arrowreturnthick-1-n"><span class="ui-icon 
ui-icon-arrowreturnthick-1-n"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-arrowreturnthick-1-e"><span class="ui-icon 
ui-icon-arrowreturnthick-1-e"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-arrowreturnthick-1-s"><span class="ui-icon 
ui-icon-arrowreturnthick-1-s"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-arrowreturn-1-w"><span class="ui-icon 
ui-icon-arrowreturn-1-w"></span></li>
		
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-arrowreturn-1-n"><span class="ui-icon 
ui-icon-arrowreturn-1-n"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-arrowreturn-1-e"><span class="ui-icon 
ui-icon-arrowreturn-1-e"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-arrowreturn-1-s"><span class="ui-icon 
ui-icon-arrowreturn-1-s"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-arrowrefresh-1-w"><span class="ui-icon 
ui-icon-arrowrefresh-1-w"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-arrowrefresh-1-n"><span class="ui-icon 
ui-icon-arrowrefresh-1-n"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-arrowrefresh-1-e"><span class="ui-icon 
ui-icon-arrowrefresh-1-e"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-arrowrefresh-1-s"><span class="ui-icon 
ui-icon-arrowrefresh-1-s"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-arrow-4"><span class="ui-icon ui-icon-arrow-4"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-arrow-4-diag"><span class="ui-icon ui-icon-arrow-4-diag"></span></li>
		
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-extlink"><span class="ui-icon ui-icon-extlink"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-newwin"><span class="ui-icon ui-icon-newwin"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-refresh"><span class="ui-icon ui-icon-refresh"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-shuffle"><span class="ui-icon ui-icon-shuffle"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-transfer-e-w"><span class="ui-icon ui-icon-transfer-e-w"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-transferthick-e-w"><span class="ui-icon 
ui-icon-transferthick-e-w"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-folder-collapsed"><span class="ui-icon 
ui-icon-folder-collapsed"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-folder-open"><span class="ui-icon ui-icon-folder-open"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-document"><span class="ui-icon ui-icon-document"></span></li>
		
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-document-b"><span class="ui-icon ui-icon-document-b"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-note"><span class="ui-icon ui-icon-note"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-mail-closed"><span class="ui-icon ui-icon-mail-closed"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-mail-open"><span class="ui-icon ui-icon-mail-open"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-suitcase"><span class="ui-icon ui-icon-suitcase"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-comment"><span class="ui-icon ui-icon-comment"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-person"><span class="ui-icon ui-icon-person"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-print"><span class="ui-icon ui-icon-print"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-trash"><span class="ui-icon ui-icon-trash"></span></li>
		
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-locked"><span class="ui-icon ui-icon-locked"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-unlocked"><span class="ui-icon ui-icon-unlocked"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-bookmark"><span class="ui-icon ui-icon-bookmark"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-tag"><span class="ui-icon ui-icon-tag"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-home"><span class="ui-icon ui-icon-home"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-flag"><span class="ui-icon ui-icon-flag"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-calculator"><span class="ui-icon ui-icon-calculator"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-cart"><span class="ui-icon ui-icon-cart"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-pencil"><span class="ui-icon ui-icon-pencil"></span></li>
				
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-clock"><span class="ui-icon ui-icon-clock"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-disk"><span class="ui-icon ui-icon-disk"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-calendar"><span class="ui-icon ui-icon-calendar"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-zoomin"><span class="ui-icon ui-icon-zoomin"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-zoomout"><span class="ui-icon ui-icon-zoomout"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-search"><span class="ui-icon ui-icon-search"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-wrench"><span class="ui-icon ui-icon-wrench"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-gear"><span class="ui-icon ui-icon-gear"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-heart"><span class="ui-icon ui-icon-heart"></span></li>
		
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-star"><span class="ui-icon ui-icon-star"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-link"><span class="ui-icon ui-icon-link"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-cancel"><span class="ui-icon ui-icon-cancel"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-plus"><span class="ui-icon ui-icon-plus"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-plusthick"><span class="ui-icon ui-icon-plusthick"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-minus"><span class="ui-icon ui-icon-minus"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-minusthick"><span class="ui-icon ui-icon-minusthick"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-close"><span class="ui-icon ui-icon-close"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-closethick"><span class="ui-icon ui-icon-closethick"></span></li>
			
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-key"><span class="ui-icon ui-icon-key"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-lightbulb"><span class="ui-icon ui-icon-lightbulb"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-scissors"><span class="ui-icon ui-icon-scissors"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-clipboard"><span class="ui-icon ui-icon-clipboard"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-copy"><span class="ui-icon ui-icon-copy"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-contact"><span class="ui-icon ui-icon-contact"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-image"><span class="ui-icon ui-icon-image"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-video"><span class="ui-icon ui-icon-video"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-script"><span class="ui-icon ui-icon-script"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-alert"><span class="ui-icon ui-icon-alert"></span></li>
		
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-info"><span class="ui-icon ui-icon-info"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-notice"><span class="ui-icon ui-icon-notice"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-help"><span class="ui-icon ui-icon-help"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-check"><span class="ui-icon ui-icon-check"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-bullet"><span class="ui-icon ui-icon-bullet"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-radio-off"><span class="ui-icon ui-icon-radio-off"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-radio-on"><span class="ui-icon ui-icon-radio-on"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-pin-w"><span class="ui-icon ui-icon-pin-w"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-pin-s"><span class="ui-icon ui-icon-pin-s"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-play"><span class="ui-icon ui-icon-play"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-pause"><span class="ui-icon ui-icon-pause"></span></li>
		
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-seek-next"><span class="ui-icon ui-icon-seek-next"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-seek-prev"><span class="ui-icon ui-icon-seek-prev"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-seek-end"><span class="ui-icon ui-icon-seek-end"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-seek-first"><span class="ui-icon ui-icon-seek-first"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-stop"><span class="ui-icon ui-icon-stop"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-eject"><span class="ui-icon ui-icon-eject"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-volume-off"><span class="ui-icon ui-icon-volume-off"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-volume-on"><span class="ui-icon ui-icon-volume-on"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-power"><span class="ui-icon ui-icon-power"></span></li>
		
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-signal-diag"><span class="ui-icon ui-icon-signal-diag"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-signal"><span class="ui-icon ui-icon-signal"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-battery-0"><span class="ui-icon ui-icon-battery-0"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-battery-1"><span class="ui-icon ui-icon-battery-1"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-battery-2"><span class="ui-icon ui-icon-battery-2"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-battery-3"><span class="ui-icon ui-icon-battery-3"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-circle-plus"><span class="ui-icon ui-icon-circle-plus"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-circle-minus"><span class="ui-icon ui-icon-circle-minus"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-circle-close"><span class="ui-icon ui-icon-circle-close"></span></li>
		
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-circle-triangle-e"><span class="ui-icon 
ui-icon-circle-triangle-e"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-circle-triangle-s"><span class="ui-icon 
ui-icon-circle-triangle-s"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-circle-triangle-w"><span class="ui-icon 
ui-icon-circle-triangle-w"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-circle-triangle-n"><span class="ui-icon 
ui-icon-circle-triangle-n"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-circle-arrow-e"><span class="ui-icon 
ui-icon-circle-arrow-e"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-circle-arrow-s"><span class="ui-icon 
ui-icon-circle-arrow-s"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-circle-arrow-w"><span class="ui-icon 
ui-icon-circle-arrow-w"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-circle-arrow-n"><span class="ui-icon 
ui-icon-circle-arrow-n"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-circle-zoomin"><span class="ui-icon 
ui-icon-circle-zoomin"></span></li>
		
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-circle-zoomout"><span class="ui-icon 
ui-icon-circle-zoomout"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-circle-check"><span class="ui-icon ui-icon-circle-check"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-circlesmall-plus"><span class="ui-icon 
ui-icon-circlesmall-plus"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-circlesmall-minus"><span class="ui-icon 
ui-icon-circlesmall-minus"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-circlesmall-close"><span class="ui-icon 
ui-icon-circlesmall-close"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-squaresmall-plus"><span class="ui-icon 
ui-icon-squaresmall-plus"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-squaresmall-minus"><span class="ui-icon 
ui-icon-squaresmall-minus"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-squaresmall-close"><span class="ui-icon 
ui-icon-squaresmall-close"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-grip-dotted-vertical"><span class="ui-icon 
ui-icon-grip-dotted-vertical"></span></li>
		
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-grip-dotted-horizontal"><span class="ui-icon 
ui-icon-grip-dotted-horizontal"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-grip-solid-vertical"><span class="ui-icon 
ui-icon-grip-solid-vertical"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-grip-solid-horizontal"><span class="ui-icon 
ui-icon-grip-solid-horizontal"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-gripsmall-diagonal-se"><span class="ui-icon 
ui-icon-gripsmall-diagonal-se"></span></li>
										<li class="ui-state-default ui-corner-all" 
title=".ui-icon-grip-diagonal-se"><span class="ui-icon 
ui-icon-grip-diagonal-se"></span></li>
									</ul>
									<!-- End of Framework Icons -->
									<p>This icons can be used for buttons, header buttons, etc.</p>
									<p>Buttons made with these icons: </p>
									<p><a href="#" class="button tooltip" title="This is a random 
button"><span class="ui-icon ui-icon-trash"></span>Remove</a><a href="#"
 class="button"><span class="ui-icon ui-icon-radio-off"></span>Radio off</a><a
 href="#" class="button"><span class="ui-icon ui-icon-play"></span>Play</a></p>
								</div>
								<!-- End of Third tab -->
							</div>
							<!-- End of Tabs -->
						</div>
						
						<hr>
						
						<h1>Sliders, Progressbar, Dialogs!</h1>
						<div class="pad20">
							<p><a href="#" class="button tooltip" title="Click me to open the
 dialog!" id="dialog_link"><span class="ui-icon ui-icon-newwin"></span>Open
</a></p>
							<!-- Dialog -->
							
							<!-- End of Dialog -->
			
							<h2 class="demoHeaders">Slider</h2>
							<!-- Slider -->
							<div class="ui-slider ui-slider-horizontal ui-widget 
ui-widget-content ui-corner-all" id="slider"><div style="left: 20%; 
width: 50%;" class="ui-slider-range ui-widget-header"></div><a 
style="left: 20%;" class="ui-slider-handle ui-state-default 
ui-corner-all" href="#"></a><a style="left: 70%;" 
class="ui-slider-handle ui-state-default ui-corner-all" href="#"></a></div>
							<!-- End of Slider -->
							
							<h2 class="demoHeaders">Progressbar</h2>
							<!-- Progressbar -->	
							<div aria-valuenow="40" aria-valuemax="100" aria-valuemin="0" 
role="progressbar" class="ui-progressbar ui-widget ui-widget-content 
ui-corner-all" id="progressbar"><div style="width: 40%;" 
class="ui-progressbar-value ui-widget-header ui-corner-left"></div></div>
							<!-- End of Progressbar -->
							
						</div>	
						
					</div>
				</div>
				<!-- End of Main Content -->
				
				<!-- Sidebar -->
				<div id="sidebar">
				
					<h2>Accordion</h2>
					<!-- Accordion -->
					<div role="tablist" class="ui-accordion ui-widget ui-helper-reset" 
id="accordion">
						<div>
							<h3 tabindex="0" aria-expanded="true" role="tab" 
class="ui-accordion-header ui-helper-reset ui-state-active 
ui-corner-top"><span class="ui-icon ui-icon-triangle-1-s"></span><a 
tabindex="-1" href="#" title="First slide" class="tooltip">First</a></h3>
							<div role="tabpanel" style="height: 181px;" 
class="ui-accordion-content ui-helper-reset ui-widget-content 
ui-corner-bottom ui-accordion-content-active">Praesent augue urna, 
vehicula sed sollicitudin quis, dignissim nec est. Quisque dignissim 
lorem at metus vehicula ut feugiat eros vestibulum. Suspendisse 
ultrices, massa luctus aliquam faucibus, sem quam fermentum nisl, non 
posuere quam nunc vel tellus.</div>
						</div>
						<div>
							<h3 tabindex="-1" aria-expanded="false" role="tab" 
class="ui-accordion-header ui-helper-reset ui-state-default 
ui-corner-all"><span class="ui-icon ui-icon-triangle-1-e"></span><a 
tabindex="-1" href="#" title="Second slide" class="tooltip">Second</a></h3>
							<div role="tabpanel" style="height: 181px; display: none;" 
class="ui-accordion-content ui-helper-reset ui-widget-content 
ui-corner-bottom">Sed sem elit, porttitor quis vestibulum ut, euismod id
 purus. Praesent vulputate dolor vel nisi mattis sollicitudin. Curabitur
 placerat quam at sem tempor ac sodales nunc dapibus. Nullam mi purus, 
adipiscing in facilisis sed, posuere ut ipsum.</div>
						</div>
						<div>
							<h3 tabindex="-1" aria-expanded="false" role="tab" 
class="ui-accordion-header ui-helper-reset ui-state-default 
ui-corner-all"><span class="ui-icon ui-icon-triangle-1-e"></span><a 
tabindex="-1" href="#" title="Third slide" class="tooltip">Third</a></h3>
							<div role="tabpanel" style="height: 181px; display: none;" 
class="ui-accordion-content ui-helper-reset ui-widget-content 
ui-corner-bottom">Praesent augue urna, vehicula sed sollicitudin quis, 
dignissim nec est. Quisque dignissim lorem at metus vehicula ut feugiat 
eros vestibulum. Suspendisse ultrices, massa luctus aliquam faucibus, 
sem quam fermentum nisl, non posuere quam nunc vel tellus.</div>
						</div>
					</div>
					<!-- End of Accordion-->
						
					<h2>Datepicker</h2>
					<!-- Datepicker -->
					<div class="hasDatepicker" id="datepicker"><div 
class="ui-datepicker-inline ui-datepicker ui-widget ui-widget-content 
ui-helper-clearfix ui-corner-all"><div class="ui-datepicker-header 
ui-widget-header ui-helper-clearfix ui-corner-all"><a 
class="ui-datepicker-prev ui-corner-all" 
onclick="DP_jQuery.datepicker._adjustDate('#datepicker', -1, 'M');" 
title="Prev"><span class="ui-icon ui-icon-circle-triangle-w">Prev</span></a><a
 class="ui-datepicker-next ui-corner-all" 
onclick="DP_jQuery.datepicker._adjustDate('#datepicker', +1, 'M');" 
title="Next"><span class="ui-icon ui-icon-circle-triangle-e">Next</span></a><div
 class="ui-datepicker-title"><span class="ui-datepicker-month">February</span>
 <span class="ui-datepicker-year">2010</span></div></div><table 
class="ui-datepicker-calendar"><thead><tr><th 
class="ui-datepicker-week-end"><span title="Sunday">Su</span></th><th><span
 title="Monday">Mo</span></th><th><span title="Tuesday">Tu</span></th><th><span
 title="Wednesday">We</span></th><th><span title="Thursday">Th</span></th><th><span
 title="Friday">Fr</span></th><th class="ui-datepicker-week-end"><span 
title="Saturday">Sa</span></th></tr></thead><tbody><tr><td class=" 
ui-datepicker-week-end ui-datepicker-other-month 
ui-datepicker-unselectable ui-state-disabled">&nbsp;</td><td class=" " 
onclick="DP_jQuery.datepicker._selectDay('#datepicker',1,2010, 
this);return false;"><a class="ui-state-default" href="#">1</a></td><td 
class=" " onClick="DP_jQuery.datepicker._selectDay('#datepicker',1,2010,
 this);return false;"><a class="ui-state-default" href="#">2</a></td><td
 class=" " 
onclick="DP_jQuery.datepicker._selectDay('#datepicker',1,2010, 
this);return false;"><a class="ui-state-default" href="#">3</a></td><td 
class=" " onClick="DP_jQuery.datepicker._selectDay('#datepicker',1,2010,
 this);return false;"><a class="ui-state-default" href="#">4</a></td><td
 class=" ui-datepicker-days-cell-over  ui-datepicker-current-day 
ui-datepicker-today" 
onclick="DP_jQuery.datepicker._selectDay('#datepicker',1,2010, 
this);return false;"><a class="ui-state-default ui-state-highlight 
ui-state-active ui-state-hover" href="#">5</a></td><td class=" 
ui-datepicker-week-end " 
onclick="DP_jQuery.datepicker._selectDay('#datepicker',1,2010, 
this);return false;"><a class="ui-state-default" href="#">6</a></td></tr><tr><td
 class=" ui-datepicker-week-end " 
onclick="DP_jQuery.datepicker._selectDay('#datepicker',1,2010, 
this);return false;"><a class="ui-state-default" href="#">7</a></td><td 
class=" " onClick="DP_jQuery.datepicker._selectDay('#datepicker',1,2010,
 this);return false;"><a class="ui-state-default" href="#">8</a></td><td
 class=" " 
onclick="DP_jQuery.datepicker._selectDay('#datepicker',1,2010, 
this);return false;"><a class="ui-state-default" href="#">9</a></td><td 
class=" " onClick="DP_jQuery.datepicker._selectDay('#datepicker',1,2010,
 this);return false;"><a class="ui-state-default" href="#">10</a></td><td
 class=" " 
onclick="DP_jQuery.datepicker._selectDay('#datepicker',1,2010, 
this);return false;"><a class="ui-state-default" href="#">11</a></td><td
 class=" " 
onclick="DP_jQuery.datepicker._selectDay('#datepicker',1,2010, 
this);return false;"><a class="ui-state-default" href="#">12</a></td><td
 class=" ui-datepicker-week-end " 
onclick="DP_jQuery.datepicker._selectDay('#datepicker',1,2010, 
this);return false;"><a class="ui-state-default" href="#">13</a></td></tr><tr><td
 class=" ui-datepicker-week-end " 
onclick="DP_jQuery.datepicker._selectDay('#datepicker',1,2010, 
this);return false;"><a class="ui-state-default" href="#">14</a></td><td
 class=" " 
onclick="DP_jQuery.datepicker._selectDay('#datepicker',1,2010, 
this);return false;"><a class="ui-state-default" href="#">15</a></td><td
 class=" " 
onclick="DP_jQuery.datepicker._selectDay('#datepicker',1,2010, 
this);return false;"><a class="ui-state-default" href="#">16</a></td><td
 class=" " 
onclick="DP_jQuery.datepicker._selectDay('#datepicker',1,2010, 
this);return false;"><a class="ui-state-default" href="#">17</a></td><td
 class=" " 
onclick="DP_jQuery.datepicker._selectDay('#datepicker',1,2010, 
this);return false;"><a class="ui-state-default" href="#">18</a></td><td
 class=" " 
onclick="DP_jQuery.datepicker._selectDay('#datepicker',1,2010, 
this);return false;"><a class="ui-state-default" href="#">19</a></td><td
 class=" ui-datepicker-week-end " 
onclick="DP_jQuery.datepicker._selectDay('#datepicker',1,2010, 
this);return false;"><a class="ui-state-default" href="#">20</a></td></tr><tr><td
 class=" ui-datepicker-week-end " 
onclick="DP_jQuery.datepicker._selectDay('#datepicker',1,2010, 
this);return false;"><a class="ui-state-default" href="#">21</a></td><td
 class=" " 
onclick="DP_jQuery.datepicker._selectDay('#datepicker',1,2010, 
this);return false;"><a class="ui-state-default" href="#">22</a></td><td
 class=" " 
onclick="DP_jQuery.datepicker._selectDay('#datepicker',1,2010, 
this);return false;"><a class="ui-state-default" href="#">23</a></td><td
 class=" " 
onclick="DP_jQuery.datepicker._selectDay('#datepicker',1,2010, 
this);return false;"><a class="ui-state-default" href="#">24</a></td><td
 class=" " 
onclick="DP_jQuery.datepicker._selectDay('#datepicker',1,2010, 
this);return false;"><a class="ui-state-default" href="#">25</a></td><td
 class=" " 
onclick="DP_jQuery.datepicker._selectDay('#datepicker',1,2010, 
this);return false;"><a class="ui-state-default" href="#">26</a></td><td
 class=" ui-datepicker-week-end " 
onclick="DP_jQuery.datepicker._selectDay('#datepicker',1,2010, 
this);return false;"><a class="ui-state-default" href="#">27</a></td></tr><tr><td
 class=" ui-datepicker-week-end " 
onclick="DP_jQuery.datepicker._selectDay('#datepicker',1,2010, 
this);return false;"><a class="ui-state-default" href="#">28</a></td><td
 class=" ui-datepicker-other-month ui-datepicker-unselectable 
ui-state-disabled">&nbsp;</td><td class=" ui-datepicker-other-month 
ui-datepicker-unselectable ui-state-disabled">&nbsp;</td><td class=" 
ui-datepicker-other-month ui-datepicker-unselectable ui-state-disabled">&nbsp;</td><td
 class=" ui-datepicker-other-month ui-datepicker-unselectable 
ui-state-disabled">&nbsp;</td><td class=" ui-datepicker-other-month 
ui-datepicker-unselectable ui-state-disabled">&nbsp;</td><td class=" 
ui-datepicker-week-end ui-datepicker-other-month 
ui-datepicker-unselectable ui-state-disabled">&nbsp;</td></tr></tbody></table></div></div>
					<!-- End of Datepicker -->
				
					<!-- Sortable Dialogs -->
					<h2>Sortable Dialogs</h2>
					<div class="sort ui-sortable">
						<div class="box ui-widget ui-widget-content ui-corner-all portlet 
ui-helper-clearfix">
						<div class="portlet-header ui-widget-header ui-corner-all"><span 
class="ui-icon ui-icon-circle-arrow-s"></span>Sortable 1</div>
							<div class="portlet-content">
								<p>This is a sortable dialog. Praesent augue urna, vehicula sed 
sollicitudin quis, dignissim nec est.</p>
							</div>
						</div>
						
						<div class="box ui-widget ui-widget-content ui-corner-all portlet 
ui-helper-clearfix">
							<div class="portlet-header ui-widget-header ui-corner-all"><span 
class="ui-icon ui-icon-circle-arrow-s"></span>Sortable 2</div>
							<div class="portlet-content">
								<p>This is a sortable dialog. Praesent augue urna, vehicula sed 
sollicitudin quis, dignissim nec est.</p>
							</div>
						</div>
						
						<div class="box ui-widget ui-widget-content ui-corner-all portlet 
ui-helper-clearfix">
							<div class="portlet-header ui-widget-header ui-corner-all"><span 
class="ui-icon ui-icon-circle-arrow-s"></span>Sortable 3</div>
							<div class="portlet-content">
								<p>This is a sortable dialog. Praesent augue urna, vehicula sed 
sollicitudin quis, dignissim nec est.</p>
							</div>
						</div>
					</div>
					<!-- End of Sortable Dialogs -->
					
					<!-- Lists -->
					<h2>Lists / Navigation</h2>
					<ul>
						<li><a href="">Lorem Ipsum</a></li>
						<li><a href="">Artificial Intelligence</a></li>
						<li><a href="">jQuery Power</a>
							<ul>
								<li><a href="">Lorem Ipsum</a></li>
								<li><a href="">Artificial Intelligence</a></li>
								<li><a href="">Lorem Ipsum</a>
									<ul>
										<li><a href="">Lorem Ipsum</a></li>
										<li><a href="">Artificial Intelligence</a></li>
										<li><a href="">Lorem Ipsum</a></li>
										<li class="last"><a href="">Artificial Intelligence</a></li>
									</ul>
								</li>
								<li class="last"><a href="">Artificial Intelligence</a></li>
							</ul>
						</li>
						<li><a href="">Another category</a></li>
					</ul>
					<!-- End of Lists -->
					
					<!-- Statistics -->
					<h2>Statistics</h2>
					<p><b>Articles:</b> 2201</p>
					<p><b>Comments:</b> 17092</p>
					<p><b>Users:</b> 3788</p>
					<!-- End of Statistics -->
				
				</div>
				<!-- End of Sidebar -->
				
			</div>
			<!-- End of bgwrap -->
		</div>
		<!-- End of Container -->
		
		<!-- Footer -->
		<div id="footer">
			<p class="mid">
				<a href="#" title="Top" class="tooltip">Top</a>·<a href="#" 
title="Main Page" class="tooltip">Home</a>·<a href="#" title="Change 
current settings" class="tooltip">Settings</a>·<a href="#" title="End 
administrator session" class="tooltip">Logout</a>
			</p>
			<p class="mid">
				<!-- Change this to your own once purchased -->
				© Wide Admin 2010. All rights reserved.
				<!-- -->
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
