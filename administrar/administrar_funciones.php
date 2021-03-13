<!DOCTYPE HTML>
<html>
<?php
include_once("../funciones/aplica_config_global.php");
require_once("../funciones/conexion.php");
require_once("../funciones/funcionesPHP.php");
require_once("../funciones/encriptado.php");
//require_once("../funciones/fechas_func.php");
//include_once("../funciones/mostrar_iconos_comandos.php");
session_start();
if (isset($_REQUEST["id_func"])){
$array_permisos=verificar_acceso_pagina($_REQUEST['id_func']);} else{
$array_permisos=verificar_acceso_pagina("000");}
 //verifico si el usuario tiene acceso a la pagina o si el usuario ingreso la url correcta (que corresponde al id de la funcion ejecutada)
//print_r($array_permisos); muestro los valores obtenidos del array consulta de permisos
//verificar_accion();//verifico si se ha presionado editar o eliminar y ejecuta las acciones solicitadas
?>
<head>
<link href="../images/sistema/siregest.ico" type="image/x-icon" rel="shortcut icon" />
<script type="text/javascript">
function confirmSubmit()
{
var agree=confirm("¿Está seguro de eliminar este registro?, también se eliminarán los privilegios asociados a ésta función; tenga en cuenta que esta acción es irreversible por lo tanto debe tener cuidado al eliminar una función.");
if (agree)
return true ;
else
return false ;
}
function confirma_elim_varios()
{
var agree=confirm("¿Está seguro de eliminar los registros seleccionados, también se eliminarán los privilegios asociados a ésta función; tenga en cuenta que esta acción es irreversible por lo tanto debe tener cuidado al eliminar una función.");
if (agree)
return true ;
else
return false ;
}

</script>
  <!-- Meta -->
  <meta http-equiv="Content-Type" content="text/html; charset=<?php if (isset($_SESSION['juego_caracteres'])){ echo $_SESSION['juego_caracteres'];} else echo "utf-8";//esta variable se declara en modulo verificar login?>">
	<title>SIREGEST V.2012.1 - Administrar funciones</title>
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
			jQuery("#form").validationEngine(); //cambiar #form por el nombre del formulario a validar
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
	//-------------- congiguro el datatables
				$('#tabla1').dataTable( {
					"oLanguage": {
			"sUrl": "../js/DataTables-1.9.0/media/lang/es_es.txt"
		},				
					"aaSorting": [[0,"asc"]],
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
					"sDom": '<"H"RTflipm>t<"F"flip>',
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
 
 
					<h2><img src="../images/icons_menu/x32/config.png" width="32" height="32" align="absmiddle"> Administrador de funciones del sistema</h2>
      

					<div class="pad20">

					<!-- comienzo la tabla de mostrar -->

					<div style="width:100%"> 
            <?php
	//verifico si tiene permiso de eliminar y si se envió la variable id_func_elim  de eliminar lo proceso (elimino)
						if (isset($_GET["id_func_elim"]) && ($array_permisos["eliminar"]==true)){
							$id_func_elim=$_GET["id_func_elim"];
							$sql_elim="delete from sis_funciones where id_func='$id_func_elim'";
							$cnn_elim=conectarse();
							$eliminado=mysql_query($sql_elim,$cnn_elim);
							if (!$eliminado){ 
							switch (mysql_errno()){
							case 1451: mostrar_box("err",true,"INFORMACIÓN","No se puede eliminar el registro porque tiene sub-menus asociados, por medidas de seguridad, para eliminar un menú de tipo contenedor, primero debe eliminar los sub-menu ");
							break;
							default: mostrar_box("err",true,"INFORMACIÓN","No se han eliminado los registros seleccionados, información técnica: (". mysql_error().", Nº: ".mysql_errno().")");
							break;
							} // fin  switch
							} else {
								unset($_SESSION['var_menu']); // elimino el var menupara que actualice el menu
								//header("location:".$_SERVER['HTTP_REFERER']);
								if (mysql_affected_rows()>0){
								mostrar_box("inf",true,utf8_encode("Resultado de la eliminación"),"Se han eliminado (". mysql_affected_rows().") registros");}
								
								}
						} 
					?>
          <?php 
					
					
         					$registros=ejecuta_sql("select id_func,texto_icono,activa,icono32 from sis_funciones ORDER BY texto_icono ASC",true);
					//si hay registros muestro los datos
					if (isset($registros) and $registros<>false){
 					?>
<form id="eliminar_varios" name="eliminar_varios" action="eliminar_varios_registros.php" method="post">
          
			  <table id="tabla1" class="letra_16 mouse_hover"> 
        <thead> 
          <tr>
            <th width="17%">ID. FUNCIÓN</th>
            <th>FUNCIÓN</th>
            <th>ESTATUS</th>
            <?php if ($array_permisos["editar"]==true) {?>
            <th title="EDITAR REGISTROS">EDIT.</th>
            <?php }?>
            <?php if ($array_permisos["eliminar"]==true) {?>
            <th title="ELIMINAR REGISTROS">ELIM.</th>
            <?php }?>
            <?php if ($array_permisos["editar"]==true) {?>
            <th title="EDITAR PRIVILEGIOS">PRIV.</th>
            <?php }?>
            
          </tr> 
        </thead> 
        <tbody> 
        	<?php
					while ($fila=mysql_fetch_array($registros))
					{ $id_func_fila=$fila["id_func"]; ?>
          <tr>
          
            <td><input type='checkbox' name='<?php echo "campos[".$id_func_fila."]"; ?>' id='<?php echo $id_func_fila; ?>' class="check" style="vertical-align:middle;"><label for="<?php echo $id_func_fila; ?>"><?php echo $id_func_fila; ?></label></td>
            <td><?php echo "<img src='../images/icons_menu/x32/".$fila['icono32']."' width='18px' height='18px' align='absmiddle'>&nbsp;".$fila["texto_icono"]; ?></td>
            <td width="100">
							<?php 
									$activa=(bool) $fila["activa"];
									if ($activa==true){
								 	echo "ACTIVA"; }
								 else {
								 	echo "DESHABILITADA $activa";}
							?>
             </td>
            <!-- si permite editar muestro el boton que permite enviar la varible edicion oculta y permite editar -->
            <?php if ($array_permisos["editar"]==true) {?>
            <td width="70" align="center">

                  <a id="resize" href="editar_funciones_frm.php?<?php echo "id_func={$array_permisos['id_func']}&id_func_edit={$fila['id_func']}"?>" class="resize fancybox.iframe ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" style="font-size:10px;padding:2px; color:#000000;" title="Editar el registro">&nbsp;
                  <img src='../images/icons_menu/x32/editar_x32.png' width='16px' heigth='16px' align='absmiddle'></img>&nbsp;Edit.
                  </a>
             </td>
            <?php 
							} 
						?>
            <!-- agrego la opcion de eliminar -->
            <?php if ($array_permisos["eliminar"]==true) {?>
            <td width="70" align="center">
            
 							<a id="resize" onclick="return confirmSubmit()" href="administrar_funciones.php?<?php echo "accion=elim&id_func_elim={$fila['id_func']}"?>" class=" ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" style="font-size:10px;padding:2px; color:#000000;" width="45%" height="90%" title="Eliminar registro" >&nbsp;
                  <img src='../images/icons_menu/x32/elim_papelera_x32.png' width='16px' heigth='16px' align='absmiddle'></img>&nbsp;Elim.&nbsp;
                  </a>            </td>
            <?php }?>
            <?php if ($array_permisos["editar"]==true) {?>
            <td width="90" align="center">

                  <a id="resize" href="editar_privil_frm.php?<?php echo "id_func={$array_permisos['id_func']}&id_func_edit={$fila['id_func']}"?>" class="resize fancybox.iframe ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" style="font-size:10px;padding:2px; color:#000000;" title="Establecer privilegios de acceso">&nbsp;
                  <img src='../images/sistema/privilegios.png' width='18' height="18" align='absmiddle' heigth='16px'></img>&nbsp;Config.
                  </a>
             </td>
            <?php 
							} 
						?>
            
          </tr> 
          <?php
							} //fin de si hay registros
						} //cierro el ciclo que muestra las filas
					?>
         
        </tbody> 
      </table> 
      
      <p><input id="checkAll" onclick="checkTodos(this.id,'tabla1');" name="checkAll" type="checkbox" title="Seleccionar todos / quitar selección" align="bottom" style="margin-right:-5px;
  vertical-align:middle;" />
      <label for="checkAll" title="Seleccionar todos / quitar selección"><img src='../images/icons_menu/x32/check_verde_x32.png' width='16px' heigth='16px' align='absmiddle' style="padding:2px;">Seleccionar todos</label>
      </p>
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
						if ($array_permisos["crear"]==true) {?>
								<a id="resize" href="agregar_funciones_frm.php" class="resize fancybox.iframe" title="Agregar nueva función">
									<img src='../images/icons_menu/x32/editar_x32.png' width='24px' heigth='24px' align='absmiddle' style="padding:2px;"></img>&nbsp;Agregar nueva&nbsp;
								</a><br>
            <?php } //cierro el si tiene permiso de crear ?>
            
             <?php if ($array_permisos["eliminar"]==true) {?>
             <input id="checkAll" onclick="checkTodos(this.id,'tabla1');" name="checkAll" type="hidden" title="Seleccionar todos / quitar selección" align="bottom" style="margin-right:-5px;
  vertical-align:middle;" />
      <label for="checkAll" title="Seleccionar todos / quitar selección" style="font-size:11px; color:#333333;" class="subrayado_hover"><img src='../images/icons_menu/x32/check_verde_x32.png' width='24px' heigth='24px' align='absmiddle' style="padding:2px;">&nbsp;Seleccionar todos</label><br>
 							<a href="#" id="eliminar" class="" title="Eliminar registros seleccionados" onclick="if (confirma_elim_varios()==true){document.eliminar_varios.submit();}" >
                  <img src='../images/icons_menu/x32/elim_papelera_x32.png' width='24px' heigth='24px' align='absmiddle' style="padding:2px;"></img>&nbsp;Eliminar selección&nbsp;
                  </a><br>
                  
      
            <?php }?> <!--cierro el si tiene permiso elminar-->
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
