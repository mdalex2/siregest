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
if (isset($_SESSION["array_permisos"]) && ($_SESSION["array_permisos"]["editar"]==true) && isset($_GET["id_func_edit"])){
	$array_permisos=$_SESSION["array_permisos"]; //vuelvo a asignar la variable al array
	$id_func_edit=$_GET["id_func_edit"];
	//echo "valor del id_padre: ".$array_permisos["id_func"];
	//echo "<br>Valor del id a editar: {$_GET['id_func_edit']}";
	}
else {
	$_SESSION["error"]="Acceso no autorizado, usted no tiene acceso a editar funciones del sistema";
	$_SESSION["titulo_msg"]="Control de acceso";
	header("location:../controlador/msgs_menu.php");
		exit();
		}
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
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
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
<form id="form" name="form" action="edita_funcion.php" method="post" enctype="multipart/form-data" class="uniForm">
										<!-- Fieldset -->
                                        
										<fieldset>
										  <!--<legend>Configuración:</legend>-->
                      <h1 align="left" class="titulo_form_blue">
                      <img src="../images/icons_menu/x32/config.png" width="32" height="32" align="absmiddle"> MÓDULO: EDITAR FUNCIONES DEL SISTEMA</h1><hr>
                      <?php
												$sql="select * from sis_funciones where id_func='".$id_func_edit."'";
												$consulta=ejecuta_sql($sql,true);
												if (!$consulta){
													exit();}
												else {
													while ($fila = mysql_fetch_array($consulta)){
														?>
                      <table align="center">
                        <tr>
                                            <td>
										  <div class="ctrlHolder">
          
          <label for="txt_id_func">Id funci&oacute;n</label><br>
            <input name="txt_id_func" type="text" autofocus class="validate[required,minSize[5]] text-input sf"  id="txt_id_func" tabindex="0" value="<?php echo $fila["id_func"];?>" maxlength="5"/><input type="hidden" id="txt_id_ant" name="txt_id_ant" value="<?php echo $fila["id_func"];?>">
<p class="formHint"> (*) Ejm: 000001</p>
        </div>
          </td>
                                            <td>                                              <div class="ctrlHolder">
            <label for="txt_texto_icono">Funci&oacute;n</label><br>
            
            <input name="txt_texto_icono" type="text" class="validate[required,maxSize[40]] text-input lf" id="txt_texto_icono" value="<?php echo $fila["texto_icono"];?>"  size="41" maxlength="41"/>
			<p class="formHint"> (*) Ejm: administrador de funciones</p>
        </div>									
</td>
          <td></td>
</tr>
<tr><td colspan="2">
  <div class="ctrlHolder">
    <label for="txt_descripcion_func">Descripci&oacute;n</label><br>
    <textarea name="txt_descripcion_func" cols="50" rows="4" class='validate[optional,maxSize[400]] textarea_small' id="txt_descripcion_func"><?php echo $fila["descrip_func"];?></textarea>
    <p class="formHint"> (Opcional) Escriba la descripci&oacute;n de lo que la funci&oacute;n realiza</p>
    
    </div>									
</td>
  <td>&nbsp;</td>
  </tr>
          <tr>
            <td colspan="3">
						<div class="ctrlHolder">
            <a id="pos_menu"></a>
            <label for="txt_padre">Colocar dentro del menú</label><br>
            <input name="txt_padre" type="text" class="validate[required,minSize[2]] text-input sf" id="txt_padre" value="<?php echo $fila["id_padre"];?>"   maxlength="5" /><input type="hidden" name="tmp_padre" id="tmp_padre" value="<?php echo $fila["id_padre"];?>">
            <input <?php if ($fila["id_padre"]=='-1') {echo "checked=\"checked\"";} ?> id="chk_raiz" name="chk_raiz" type="checkbox" title="Seleccione esta opción si es una función principal" align="bottom" style="margin-right:0px;
  vertical-align:middle;" 
  onclick='
	if($("#chk_raiz").is(":checked") == true){
    $("#txt_texto_enlace").val("#");
    $("#txt_padre").val("-1");
    $("#chk_raiz").val("on");
    //$("#txt_padre").attr("disabled",true);
    //$("#txt_texto_enlace").attr("disabled",true);
    $("#menu_seleccionado").text("");
    //alert("Un men&uacute; raíz o padre debe configurarse como enlace a la p&aacute;gina (#), el sistema corregir&aacute; autom&aacute;ticamente el enlace a la p&aacute;gina")
	} else {
	  //texto box no seleccionado
    //$("#txt_texto_enlace").removeAttr("disabled");
    $("#chk_raiz").val("off");
    //$("#txt_padre").removeAttr("disabled");
    $("#txt_texto_enlace").val($("#tmp_url").val());
    $("#txt_padre").val($("#tmp_padre").val());

	}    
  $("#txt_padre").focus();' />
      <label for="chk_raiz" title="Seleccione esta opción si es una función principal">Es padre</label>
      &nbsp;&nbsp;
      <label for="txt_orden" title="Orden de aparición en el menú (valor predeterminado=2)">Orden</label>
      <input type="text" name="txt_orden" id="txt_orden" value="<?php echo $fila["orden"];?>" class="sf validate[required,custom[integer],min[0]]" title="Orden de aparición en el menú (valor predeterminado=2)">
      <!--validate[required,custom[integer],min[0]]-->
      &nbsp;<label id="menu_seleccionado"></label>
      <br>
     				
<p class="formHint"> (*) Código del contenedor. Ejm: 00001. Si no recuerda el código puede seleccionarlo en el siguiente menú</p>
        </div>
        </td>
            </tr>
            <tr bgcolor="#163350"><td colspan="3">
<?php 
	require_once("../funciones/crear_menu_frm_agregar.php");
	//$menu= crear_menu_frm_agregar();
	$menu=crear_menu_usuario_add();
?>
</tr></td>
          <tr>
            <td colspan="3"><div class="ctrlHolder">
              <label for="txt_texto_enlace">Enlace a la pagina</label>
              <br>
              <input name="txt_texto_enlace" type="text" class="validate[required] text-input lfX" id="txt_texto_enlace" value="<?php echo $fila["url"];?>" size="40" maxlength="1000"/><input type="hidden" name="tmp_url" id="tmp_url" value="<?php echo $fila["url"];?>">
              <p class="formHint"> (*) Ejm: ../carpeta web/nombre archivo.php</p>
              </div></td>
          </tr>
            
          <tr>
            <td colspan="2"><div class="ctrlHolder">
              <p>
                <label for="txt_icono">Icono 48 pixeles</label>
                <br>
                <?php echo "<img src='".$_SESSION['ruta_iconos32'].$fila["icono32"]."' align='absmiddle' width='28px' height='28px'>"?><input type="file" id="txt_icono" accept="image/*"  name="txt_icono"  class="validate[] fileUpload text-input lf" onChange='LimitAttach(this,1);cargar(this.value);'  />
                <input type="hidden" id="txt_icono_anterior" name="txt_icono_anterior" value="<?php echo $fila["icono32"];?>">
              </p>
              <p class="formHint">(*) Icono de la funcion - requerido</p>
            </div></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2"><div class="ctrlHolder" id="ctrl_estatus">
                <label for="chk_func_act">Estatus</label>
                <input <?php if ($fila["activa"]) {echo "checked=\"checked\"";} ?> type="checkbox" name="chk_func_act" id="chk_func_act" class="active">
                <label for="chk_func_act">
                Activada</label>
            </div></td>
            <td>&nbsp;</td>
          </tr>
          <tr><td colspan="2">
							<button class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" type="submit">
<span class="ui-button-text"><img src="../images/icons_menu/x32/save1_x32.png" width="20" height="20" align="absmiddle">&nbsp;Guardar función</span>
</button>
<button id="btn_reset" name="btn_reset" class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" type="reset" onclick="jQuery('#form').validationEngine('hide');$('#txt_id_func').focus();">
<span class="ui-button-text"><img src="../images/icons_menu/x32/limpiar_x32.png" width="20" height="20" align="absmiddle"> Deshacer cambios</span>
</button>
<button class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" onclick="parent.$.fancybox.close();" title="Regresar">
<span class="ui-button-text"><img src="../images/icons_menu/x32/stop_32.png" width="20" height="20" align="absmiddle"> Cerrar</span>
</button>
          		<p>&nbsp;</p></td>
         <td>&nbsp;</td>
         </tr>
         </table>
         <?php 
					} //fin else de que si hay registros
					} // fin de while fecth array
				 ?>
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
