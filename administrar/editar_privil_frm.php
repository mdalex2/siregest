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
	.tablepriv {border-collapse:collapse}
	.tablepriv td,th {border:1px solid #666}
</style>	
  <!-- Meta -->
  <meta http-equiv="Content-Type" content="text/html; charset=<?php if (isset($_SESSION['juego_caracteres'])){ echo $_SESSION['juego_caracteres'];} else echo "utf-8";//esta variable se declara en modulo verificar login?>">
	<title>SIREGEST V.2012.1 - Establecer privilegios</title>
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
<script type="text/javascript">
$(document).ready(function() {
	//el id del a href que queremos cambiar siempre sera resize y el tamaño se debe agregar en la propiedad width y heigh al hacer el enlace
	// tamaño fijo:
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
					"sDom": '<"H"TRflipm>t<"F"Tpli>',
					"oTableTools": {
						"sSwfPath": "../js/DataTables-1.9.0/media/swf/copy_cvs_xls_pdf.swf",
						"aButtons": [
							"pdf",//"print",
							{
								"sExtends":    "collection",
								"sButtonText": "...",
								"aButtons":    [ "pdf","xls" ]
							}
						]
					}										
					})

});	
</script>  
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
<form id="form" name="form" action="guardar_privilegios.php" method="post" enctype="multipart/form-data" class="uniForm">
										<!-- Fieldset -->
                                        
										<fieldset>
										  <!--<legend>Configuración:</legend>-->
                      <h1 align="left" class="titulo_form_blue">
                      <img src="../images/icons_menu/x32/00411.png" width="32" height="32" align="absmiddle"> MÓDULO: EDITAR PRIVILEGIOS DE ACCESO</h1><hr>
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
                                            <td colspan="7">
										  <div class="ctrlHolder">
          
          <label for="txt_id_func">Id funci&oacute;n</label><br>
          <h2><input type="hidden" name="txt_id_func" value="<?php echo $fila["id_func"];?>"><?php echo $fila["id_func"];?></h2>
            
        </div>
          </td>
                                            <td>                                              <div class="ctrlHolder">
            <label for="txt_texto_icono">Funci&oacute;n</label><br>
            
            <h2><?php echo $fila["texto_icono"];?></h2>							
</td>
          </tr>
                        <tr>
                          <td colspan="8"><h2>Seleccione los privilegios a usar para cada grupo de usuario:</h2></td>
                        </tr>
                        <tr>
                        
                        <table id="tabla1" class="letra_16">
                         <thead>
                         <tr>
                          <th>GRUPO DE USUARIO</th>
                          <th>MOSTRAR</th>
                          <th>CREAR</th>
                          <th>EDITAR</th>
                          <th>ELIMINAR</th>
                          <th>IMPRIMIR</th>
                          <th>EXPORTAR</th>
                          <th>OTRO</th>
                          </tr>
                          </thead>
                          <?php
													$sql_priv="select * from sis_grupos order by nombre_grupo_usuario asc";
													$consulta=ejecuta_sql($sql_priv,true);
													if (!$consulta){
															echo "<td><h2>No existen grupos de usuarios almacenados para aplicar niveles de seguridad</h2></td>";
													} else {
														$i=0;
														while ($fila=mysql_fetch_array($consulta)){
															$i++;
															$sql_obt_priv="select * from sis_priv_grup where id_func='$id_func_edit' and id_grupo='".$fila["id_grupo"]."'";
															$consulta_obt_priv=ejecuta_sql($sql_obt_priv,false);
															if ($consulta_obt_priv && mysql_num_rows($consulta_obt_priv)==1){
																$privil=mysql_fetch_array($consulta_obt_priv);
																if ($privil["mostrar"]==1){$chk_mostrar="checked";} else {$chk_mostrar="";}
																if ($privil["crear"]==1){$chk_crear="checked";} else {$chk_crear="";}
																if ($privil["editar"]==1){$chk_editar="checked";} else {$chk_editar="";}
																if ($privil["eliminar"]==1){$chk_eliminar="checked";} else {$chk_eliminar="";}
																if ($privil["imprimir"]==1){$chk_imprimir="checked";} else {$chk_imprimir="";}
																if ($privil["exportar"]==1){$chk_exportar="checked";} else {$chk_exportar="";}
																if ($privil["otro"]==1){$chk_otro="checked";} else {$chk_otro="";}
															} else {$chk_mostrar="";$chk_crear="";$chk_editar="";$chk_eliminar="";$chk_imprimir="";$chk_exportar="";$chk_otro="";}
																													
															
												?>
                        	
                          <tr>
                          	<td><input type="hidden" name="txt_id_grupo[]" value="<?php echo $fila["id_grupo"];?>"><?php echo $fila["id_grupo"]."-".$fila["nombre_grupo_usuario"];?></td>
                          <td align="center"><input type="checkbox" name="mostrar<?php echo $fila['id_grupo'];?>" id="<?php echo $fila['id_grupo'];?>" <?php echo $chk_mostrar; ?>></td>
                          <td align="center"><input type="checkbox" name="crear<?php echo $fila['id_grupo'];?>" id="<?php echo $fila['id_grupo'];?>" <?php echo $chk_crear; ?>></td>
                          <td align="center"><input type="checkbox" name="editar<?php echo $fila['id_grupo'];?>" id="<?php echo $fila['id_grupo'];?>" <?php echo $chk_editar; ?>></td>
                          <td align="center"><input type="checkbox" name="eliminar<?php echo $fila['id_grupo'];?>" id="<?php echo $fila['id_grupo'];?>" <?php echo $chk_eliminar; ?>></td>
                          <td align="center"><input type="checkbox" name="imprimir<?php echo $fila['id_grupo'];?>" id="<?php echo $fila['id_grupo'];?>" <?php echo $chk_imprimir; ?>></td>
                          <td align="center"><input type="checkbox" name="exportar<?php echo $fila['id_grupo'];?>" id="<?php echo $fila['id_grupo'];?>" <?php echo $chk_exportar; ?>></td>
                          <td align="center"><input type="checkbox" name="otro<?php echo $fila['id_grupo'];?>" id="<?php echo $fila['id_grupo'];?>" <?php echo $chk_otro; ?>></td>
                          </tr>
                          <?php 
													} // fin del else
													} // fin de while
													?>
                          <input type="hidden" name="tot_reg" value="<?php echo $i;?>">
                          </table>
                        </tr>
          <tr><td colspan="8"></br>
							<button class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" type="submit">
<span class="ui-button-text"><img src="../images/icons_menu/x32/save1_x32.png" width="20" height="20" align="absmiddle">&nbsp;Aplicar cambios</span>
</button>
<button id="btn_reset" name="btn_reset" class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" type="reset" onclick="jQuery('#form').validationEngine('hide');$('#txt_id_func').focus();">
<span class="ui-button-text"><img src="../images/icons_menu/x32/limpiar_x32.png" width="20" height="20" align="absmiddle"> Reestablecer</span>
</button>
<button class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" onclick="parent.$.fancybox.close();" title="Regresar">
<span class="ui-button-text"><img src="../images/icons_menu/x32/stop_32.png" width="20" height="20" align="absmiddle"> Cerrar</span>
</button>
         </td>
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
