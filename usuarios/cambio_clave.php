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
<script type="text/javascript">
function confirmSubmit()
{
var agree=confirm("¿Está seguro de eliminar ésta profesión o ocupación?");
if (agree)
return true ;
else
return false ;
}
function confirm_elim()
{
var agree=confirm("¿ESTÁ SEGURO QUE DESEA ELIMINAR LA PROFESIÓN U OCUPACIÓN? \n\n NOTA: SE RECOMIENDA NO ELIMINAR PROFESIONES U OCUPACIONES AL MENOS QUE LA MISMA SE HALLA REGISTRADO POR ERROR");
if (agree){
	var agree=confirm("¿En realidad deseas eliminar la profesión u ocupación?\n\n Ésta acción no se podrá deshacer.");
	if (agree)
		return true ;}
else
return false ;
}
</script>

  <!-- Meta -->
  <meta http-equiv="Content-Type" content="text/html; charset=<?php if (isset($_SESSION['juego_caracteres'])){ echo $_SESSION['juego_caracteres'];} else echo "utf-8";//esta variable se declara en modulo verificar login?>">
	<title><?php echo $_SESSION["app_nombre"]."-".$_SESSION["app_version"]; ?> - Profesiones / ocupaciones</title>
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
 
 
					<h2 align="left" class="titulo_form_blue">
                      <img src="<?php 
											if (isset($_GET["accion"])){
												$accion=strtoupper($_GET["accion"]);
											switch ($accion){
												case "NUEVO" :
													echo "../images/icons_menu/x32/00048.png";
													break;
													
												} // fin switch
												} else // fin si se obtiene la accion de la url
												{echo "../images/icons_menu/x32/00048.png";}
											?>
                      
                      " width="32" height="32" align="absmiddle"> M&Oacute;DULO: CAMBIO DE CLAVE DE ACCESO					</h2>
					<hr>
					<!--  VERIFICO LA ACCION Y DEPENDE LA ACCION HAGO LO QUE SE DEBA -->
          
      

				<div class="pad20">
<?php
if (!empty($_POST)){
	$pwda=eliminar_comillas($_POST["txt_pwa"]);
	$pwdn=eliminar_comillas($_POST["txt_pass_n"]);
	$pwdnc=eliminar_comillas($_POST["txt_pw_c"]);
	$id_usuario=$_SESSION["id_usuario"];
	$paso_val=false;
	$sql_acceso="select id_usuario from usuarios
	where id_usuario='$id_usuario' and AES_DECRYPT(clave,'$pwda')='$pwda'";
	$registros=ejecuta_sql($sql_acceso,false);
	if ($registros && mysql_num_rows($registros)==1){
		$paso_val=true;
	} //FIN SI HUBO CONSULTA
if ($paso_val){
	$sql_upd_pass="update usuarios set
	clave=AES_ENCRYPT('$pwdn','$pwdn') WHERE
	id_usuario='$id_usuario'";
	$conexion=conectarse();
	$con_update=mysql_query($sql_upd_pass,$conexion);
	if ($con_update){
		mostrar_box("suc",true,"Notificaci&oacute;n","La clave de acceso se cambi&oacute; correctamente, recuerde su nueva clave de acceso es muy importante para acceder al sistema. En caso de olvido o bloqueo contacte con un administrador para que la clave sea cambiada o desbloqueada.");
		unset($_POST["txt_pwa"]);unset($_POST["txt_pass_n"]);unset($_POST["txt_pw_c"]);
	} else {
		mostrar_box("err",true,"Notificaci&oacute;n","No se pudo cambiar la clave de acceso, intente mas tarde");
	}
} else {
	mostrar_box("exc",true,"Notificaci&oacute;n","La clave de acceso actual es incorrecta, verifiquela e intente de nuevo");
}
}//FIN DE SI NO HUBO POST
?>
					<!-- comienzo la tabla de mostrar -->
<form id="form_crear" name="form_crear" action="<?php echo "cambio_clave.php?id_func=".$_GET["id_func"]."&accion=guardar" ?>" method="post" enctype="multipart/form-data" class="uniForm" autocomplete="off">
<!-- Fieldset -->
  
<fieldset>
<legend>VALIDACI&Oacute;N DE DATOS:</legend>

<table  width="..." border="0">

<tr>
  <td  width="50" colspan="2">
  
  <div class="ctrlHolder">
  <label for="txt_asi_pro">Nombres y apellidos del usuario</label>
  <label style="font-weight:bold;"><?php echo $_SESSION["nombre_usuario"];?>  </label> 
  </div>									
</td>
</tr> 
<tr>
  <td colspan="2"><div class="ctrlHolder">
    <label for="txt_pwa">Constrase&ntilde;a actual</label>
    <br>
  <input name="txt_pwa" type="password" autofocus class="validate[required,minSize[4]] text-input sf"  id="txt_pwa" value="<?php if (!empty($_POST["txt_pwa"])) echo $_POST["txt_pwa"];?>"/>
  <p class="formHint"> (*) Escriba la clave actual</p>
  </div></td>
</tr>
<tr>
<td>
<div class="ctrlHolder">
  <label for="txt_pass_n">Clave nueva</label><br>
  <input name="txt_pass_n" type="password" class="validate[required,minSize[6]  text-input sf"  id="txt_pass_n" value="<?php if (!empty($_POST["txt_pass_n"])) echo $_POST["txt_pass_n"];?>"/>
  <p class="formHint"> (*) Escriba una nueva clave</p>
  </div>
  </td>
<td><div class="ctrlHolder">
      
  <label for="txt_pw_c">Confirme la clave nueva</label>
  <br>
  <input name="txt_pw_c" type="password" class="validate[required,equals[txt_pass_n],minSize[6] text-input sf"  id="txt_pw_c" value="<?php if (!empty($_POST["txt_pw_c"])) echo $_POST["txt_pw_c"];?>"/>
  <p class="formHint"> (*) Vuelva a escribir la nueva clave</p>
  </div></td>

</tr>
<tr>
  <td></td>
</tr>
<tr><td colspan="2">
  <?php if ($array_permisos["crear"]==true) { ?>         
  <button type="submit" formaction="<?php echo "cambio_clave.php?id_func=".$_GET["id_func"]."&accion=guardar" ?>" class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" id="btn_guardar">
  <span class="ui-button-text"><img src="../images/icons_menu/x32/save1_x32.png" width="20" height="20" align="absmiddle">&nbsp;Guardar</span>
  </button>
  <?php } // cierro si permite crear=guardar ?>
  
  <button id="btn_reset" name="btn_reset" class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" type="reset" onclick="jQuery('#form1').validationEngine('hide');$('#txt_id_func').focus();">
  <span class="ui-button-text"><img src="../images/icons_menu/x32/limpiar_x32.png" width="20" height="20" align="absmiddle"> Reestablecer</span>
  </button>
  </td>
</tr>
</table>
</fieldset>
<!-- End of fieldset -->
</form> 						
          </div>
					</div>
				</div>
				<!-- fin de los iconos de menu iconos grandes de lado derecho -->
               
				<!-- Sidebar -->
			  <div id="sidebar"><!-- inicio sidebar-->
				<div class="sort ui-sortable"><!--inicio sortable-->
				  <?php
						echo mostrar_cajaizq_sup("","Opciones disponibles");?>

            
            
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
