<!DOCTYPE HTML>
<html>
<?php 
include_once("../funciones/aplica_config_global.php");
require_once("../funciones/conexion.php");
include_once("../funciones/funcionesPHP.php");
require_once("../funciones/encriptado.php");
//require_once("../funciones/fechas_func.php");
//include_once("../funciones/mostrar_iconos_comandos.php");
session_start();
unset($_SESSION["msg"]);

verifica_caducidad_sesion();
/*
if (isset($_REQUEST["id_func"])){
$array_permisos=verificar_acceso_pagina($_REQUEST['id_func']);} else{
$array_permisos=verificar_acceso_pagina("000");}
*/
 //verifico si el usuario tiene acceso a la pagina o si el usuario ingreso la url correcta (que corresponde al id de la funcion ejecutada)
//print_r($array_permisos); muestro los valores obtenidos del array consulta de permisos
//verificar_accion();//verifico si se ha presionado editar o eliminar y ejecuta las acciones solicitadas?>
<head>
<style>
	td a:hover {color: #06F;} 
</style>
  <!-- Meta -->
  <meta http-equiv="Content-Type" content="text/html; charset=<?php if (isset($_SESSION['juego_caracteres'])) echo $_SESSION['juego_caracteres']; else echo "utf-8";//esta variable se declara en modulo verificar login?>">
	<title>SIREGEST V.2012.1 - Agregar funciones</title>
  <!-- End of Meta -->
    <!-- Scripts Graybox -->

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
			jQuery("#form").validationEngine({autoHidePrompt:true}); //cambiar #form por el nombre del formulario a validar
			$('#txt_id_func').focus(); //coloco el cursor en el primer text
		});
	</script>
	<!-- fin de las validaciones -->

  <!-- tema wide -->
  <link href="../ccs/forms/default.uni-form.css" title="Default Style" media="all" rel="stylesheet"/>
  <link type="text/css" href="../wideadmin_files/layout.css" rel="stylesheet">	
  <!--fin del validacion uniform-->

 <!-- para el datatables ================================================== -->
  <style type="text/css" media="all">
  @import url("../js/DataTables-1.9.0/media/themes/<?php if (isset($_SESSION["tema"])) echo $_SESSION['tema']; else echo "siregest";?>/jquery-ui-1.8.18.custom.css");
  </style>
    <script type="text/javascript" src="../wideadmin_files/custom.js"></script>

	</head>
  <body background="">
  <?php
		if (isset($_GET["id_edo_ter"])){
			$var_edo="&id_edo_ter=".$_GET["id_edo_ter"];
		} else {
			$var_edo="";
		}
?>
<form id="form" name="form" action="telf_agregar_frm.php?id_func=<?php if (isset($_GET["id_func"])){echo $_GET['id_func'];}?>&accion=guardar_telf&cod_pla=<?php echo $_GET["cod_pla"].$var_edo;?>"  method="post" enctype="multipart/form-data" class="uniForm">
										<!-- Fieldset -->
	<fieldset>
										  <!--<legend>Configuración:</legend>-->
                      <h1 align="left" class="titulo_form_blue">
                      <img src="../images/icons_menu/x32/config.png" width="32" height="32" align="absmiddle"> AGREGAR TELEFONO</h1>
                      <hr>
<?php
if (isset($_GET["accion"])){
	$accion=strtoupper($_GET["accion"]);
	switch ($accion){
		case "GUARDAR_TELF":
			include_once("guardar_telf.php");
			guardar_telf();
			break;
		default:
			//echo "No se recibio la accion a ejecutar";
			break;
	}
}

?>                      
                          <table align="center" width="...">
                            <tr>
                              <td colspan="2">
										  <div class="ctrlHolder">
            <label for="txt_dep_per">Departamento o persona</label>
            <br>
            
            <input name="txt_dep_per" type="text" class="validate[required] text-input mf" id="txt_dep_per"  size="30" maxlength="41"/>
			<p class="formHint"> (*) Ejm: Prof. Maria Diaz</p>
        </div> 
</td>
                            </tr>
                            <tr>
                              <td colspan="2"><div class="ctrlHolder">
                                <label for="txt_dep_per">N&uacute;mero de tel&eacute;fono</label><br>
                                
                                <input name="txt_num_tel" type="text" class="validate[required,custom[phone]] text-input sf" id="txt_num_tel"  size="20" maxlength="20"/>
                                <p class="formHint"> (*) Ejm: (0274)-882.78.90</p>
                              </div></td>
                            </tr>
          <tr><td>
							<button  class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" type="submit" >
<span class="ui-button-text"><img src="../images/icons_menu/x32/telephone_add.png" width="20" height="20" align="absmiddle">&nbsp;Guardar n&uacute;mero</span>
</button>



<button id="btn_reset" name="btn_reset" class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" type="reset" onclick="jQuery('#form').validationEngine('hide');$('#txt_id_func').focus();">
<span class="ui-button-text"><img src="../images/icons_menu/x32/limpiar_x32.png" width="20" height="20" align="absmiddle"> Limpiar formulario</span>
</button>

</td>
</tr>
    </table>
	  </fieldset>
										<!-- End of fieldset -->
                                        
<!--
$tipo = array("", "gif", "jpg", "png");
$d = dir("../images/icons_menu/x32/");
echo "<table style='width=100%' border=\"1\"><tr><th><font <b>Imagen</b></font></th><th>Descripción</th></tr>";
$i = 1;
while($entry=$d->read()) {
if (is_dir($d->path.'/'.$entry)) {
}
$elemento = $d->path.'/'.$entry;
if (is_file($elemento)) {
$img = GetImageSize($elemento, $info);
if (isset($img))    {
    $mostrar = "<tr><td width=20% align=center valign=middle><img src=".$elemento." ></td><td>ancho: ".$img[0]."<br>alto: ".$img[1]."<br>";
    $mostrar .= "tipo: ".$tipo[$img[2]]."<br>valores: ".$img[3]."<br>info:".$info."</td></tr>";
    echo $mostrar;
    }
}
$i++;
}
echo "</table>";
$d->close();

-->
					</form> 
            </body>
 </html>
