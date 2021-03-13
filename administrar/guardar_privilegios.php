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
<form id="form" name="form" action="guarda_privilegio.php" method="post" enctype="multipart/form-data" class="uniForm">
										<!-- Fieldset -->
                                        
										<fieldset>
										  <!--<legend>Configuración:</legend>-->
                      <h1 align="left" class="titulo_form_blue">
                      <img src="../images/icons_menu/x32/00411.png" width="32" height="32" align="absmiddle"> MÓDULO: EDITAR PRIVILEGIOS DE ACCESO</h1><hr>
<?php
	//echo $_POST["tot_reg"];
if(!empty($_POST['txt_id_grupo'])){
$error=false;
include_once("../funciones/conexion.php");
$conex=conectarse();
mysql_query("BEGIN",$conex);

$id_func=$_POST["txt_id_func"];
    for($j = 0; $j < count($_POST['txt_id_grupo']); $j++){
        //$sql = "INSERT INTO tbl_quiera_asistir_a (id_evento) VALUES (". $_POST['eleccion'][$j] .")";
				$id_gru_usu=$_POST['txt_id_grupo'][$j];
				$id_privileg=$id_func.$id_gru_usu;
				if (!empty($_POST['mostrar'.$id_gru_usu])){
					$mostrar=1;
				} else {
					$mostrar=0;
				}
				if (!empty($_POST['crear'.$id_gru_usu])){
					$crear=1;
				} else {
					$crear=0;
				}
				if (!empty($_POST['editar'.$id_gru_usu])){
					$editar=1;
				} else {
					$editar=0;
				}
				if (!empty($_POST['eliminar'.$id_gru_usu])){
					$eliminar=1;
				} else {
					$eliminar=0;
				}		
				if (!empty($_POST['imprimir'.$id_gru_usu])){
					$imprimir=1;
				} else {
					$imprimir=0;
				}	
				if (!empty($_POST['exportar'.$id_gru_usu])){
					$exportar=1;
				} else {
					$exportar=0;
				}
				if (!empty($_POST['otro'.$id_gru_usu])){
					$otro=1;
				} else {
					$otro=0;
				}	
				/*												
        echo " - mostrar: ".$_POST["txt_id_grupo"][$j]." mostrar: ".$mostrar;//completar el codigo grabar en la bd Mysql
				echo " - crear:    - ".$crear;
				echo " - editar:   - ".$editar;
				echo " - eliminar: - ".$eliminar;				
				echo " - imprimir: - ".$imprimir;
				echo " - exportar: - ".$exportar;				
				echo " - otro:     - ".$otro;
				echo "<br />";
				*/
				//comienzo la transancción
				//elimino todos los privilegios del grupo usuario viejo
				$sql_elim="delete from sis_priv_grup where id_func='".$id_func."' and id_grupo='".$id_gru_usu."'";
				//echo $sql_elim."<br>";
				$resultado=mysql_query($sql_elim,$conex);
				if (!$resultado) {
					$error=true;
					$msg_error[]=mysql_error();
				}
				
				$sql_guardar="insert into sis_priv_grup (id_privilegio,id_func,id_grupo,mostrar,crear,editar,eliminar,imprimir,exportar,otro) values 
				('$id_privileg','$id_func','$id_gru_usu',$mostrar,$crear,$editar,$eliminar,$imprimir,$exportar,$otro)";
				if (!mysql_query($sql_guardar,$conex)) {
					$error=true;
					$msg_error[]=mysql_error();
				}
				
    }
}
if($error==true) {
mysql_query("ROLLBACK",$conex);
echo "<h2>No se establecieron los privilegios de acceso:</h2><pre>";
print_r($msg_error);
echo "</pre>";

} else {
mysql_query("COMMIT",$conex);
echo '<h2><img src="../images/sistema/seguridad_accesos.jpg" width="200px" height="auto" align="absmiddle">';
echo "Los privilegios se establecieron con &eacute;xito</h2>";

}
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
          <h4 align="center">
<button class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" onclick="javascript:history.go(-1);" title="Regresar">
<span class="ui-button-text"><img src="../images/icons_menu/x32/atras_azul-1.png" width="20" height="20" align="absmiddle"> Regresar</span>
</button>          
          <button class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" onclick="parent.$.fancybox.close();" title="Regresar">
<span class="ui-button-text"><img src="../images/icons_menu/x32/stop_32.png" width="20" height="20" align="absmiddle"> Cerrar</span>
</button>
</h4>
</body>
 </html>
