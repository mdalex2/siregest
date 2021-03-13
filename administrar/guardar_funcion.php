<!DOCTYPE HTML>
<html>
<?php 
include_once("../funciones/aplica_config_global.php");
require_once("../funciones/conexion.php");
require_once("../funciones/funcionesPHP.php");
require_once("../funciones/encriptado.php");
require_once("../funciones/img.thumbail.rezise.php");
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
	a:hover {color: #06F;} 
</style>
  <!-- Meta -->
  <meta http-equiv="Content-Type" content="text/html; charset=<?php if (isset($_SESSION['juego_caracteres'])) echo $_SESSION['juego_caracteres']; else echo "utf-8";//esta variable se declara en modulo verificar login?>">
	<title>SIREGEST V.2012.1 - Agregar funciones</title>
  <!-- End of Meta -->
    <!-- Scripts Graybox -->

  <!-- ojo dejarlo en este orden porq si no no funciona la validacioon del form-->
  <script type="text/javascript" src="../js/jquery-1.7.1.min.js" charset="utf-8"></script>
	<script type="text/javascript" src="../js/valida_input_file.js" charset="utf-8"></script>
  <!--
  <script type="text/javascript" src="../js/jquery-ui-1.8.18.custom.min.js" charset="utf-8"></script>
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
  <!--
  <link href="../ccs/forms/default.uni-form.css" title="Default Style" media="all" rel="stylesheet"/>
  -->
  <link type="text/css" href="../wideadmin_files/layout.css" rel="stylesheet">	
  <!--fin del validacion uniform-->

 <!-- para el datatables ================================================== -->

  <style type="text/css" media="all">
  @import url("../js/DataTables-1.9.0/media/themes/<?php if (isset($_SESSION["tema"])) echo $_SESSION['tema']; else echo "siregest";?>/jquery-ui-1.8.18.custom.css");
  
  </style>

    <script type="text/javascript" src="../wideadmin_files/custom.js"></script>

</head>
<body>
<?php
	include_once("../funciones/conexion.php");
	if (!file_exists($_SESSION['ruta_iconos32'])){
		mkdir($_SESSION['ruta_iconos32'],0777);}
	
	$archivo32="";
	$archivo48="";
	$msg_icono="";
			$id_func=$_POST["txt_id_func"];
	$texto_icono=$_POST["txt_texto_icono"];
	$descrip_func=$_POST["txt_descripcion_func"];
	$url=$_POST["txt_texto_enlace"];
	$id_padre=$_POST["txt_padre"];
	$icono=$_FILES["txt_icono"]["name"];
	if (isset($_POST["chk_raiz"]) and $_POST["chk_raiz"]=="on" ){
		$es_raiz=true;} 
	else 
		{$es_raiz=false;}
		
	if (isset($_POST["chk_func_act"]) and $_POST["chk_func_act"]=="on" ){
		$activa=true;} 
	else 
		{$activa=false;}		
	$orden=$_POST["txt_orden"];
	
	//si existen datos y se ha enviado el fomrulario
	if(!empty($_POST)){
	if(!empty($_FILES['txt_icono']) && $_FILES['txt_icono']['error'] == UPLOAD_ERR_OK) {

			$image32 = new ModifiedImage($_FILES['txt_icono']['tmp_name'], true);
			$image32->resizeTofit(32,32);
			//obtengo la extension del archivo
			$extension=pathinfo($icono, PATHINFO_EXTENSION);
			//asigno el nombre del archivo al id de la funcion como es unico no se repetirá
			$archivo32 = $id_func.".".$extension;
			$ruta_icono32 = $_SESSION['ruta_iconos32'].$id_func.".".$extension;
			$image32->save($ruta_icono32);
			//echo 'Imagen grabada: <img src="'.$ruta_icono32.'"/><br>';
			//----------------------- MISMO PROCEDIMIENTO PARA ICONO 48 PIXELES
			$image48 = new ModifiedImage($_FILES['txt_icono']['tmp_name'], true);
			$image48->resizeTofit(48,48);
			//obtengo la extension del archivo
			$extension=pathinfo($icono, PATHINFO_EXTENSION);
			//asigno el nombre del archivo al id de la funcion como es unico no se repetirá
			//$image48->stringWatermark('Alexi mendoza', 100, 'FFFFFF', 'bottom left');
			$archivo48=$id_func.".".$extension;
			$ruta_icono48 = $_SESSION['ruta_iconos48'].$id_func.".".$extension;
			$image48->save($ruta_icono48);
			//echo 'Imagen 48 pixeles grabada: <img src="'.$ruta_icono48.'"/><br>';
			} //fin de si se envio archivos de imagen
			else
			{
				$msg_icono=", sin embargo el ícono no se pudo almacenar, debe modificarlo usando la opción editar, es posible que exista un error el formato o tamaño del archivo de imagen";
				//mostrar_box("exc",true,"ERROR EN EL ICONO","No se pudo  almacenar el icono de la función, puede intentar volver a actualizarlo en otro momento utilizando la opción editar");
				}
	/*echo "<br> id_func: $id_func <hr> 
	id padre: $id_padre <hr>
	texto icono :$texto_icono <hr>
	texto Descrip :$descrip_func <hr>
	url: $url <hr>
	raiz: $es_raiz <hr>
	icono: $icono <hr>
	activa: $activa";*/
			$sql="INSERT INTO sis_funciones (id_func,id_padre,texto_icono,icono32,icono48,descrip_func,orden,url,activa) values ('$id_func','$id_padre','$texto_icono','$archivo32','$archivo48','$descrip_func',$orden,'$url',$activa);";
			$conexion=conectarse();
			$consulta=mysql_query($sql,$conexion);
			if ($consulta){
				
				echo "<br>".mostrar_box("inf",false,"Registro almacenado","El registro se almacenó correctamente en la base de datos".$msg_icono);
				unset($_SESSION['var_menu']);
			} else {
				switch (mysql_errno()){
				case 1062: 
					echo mostrar_box("err",false,"INFORMACIÓN","El código ($id_func) ya existe en la base de datos, no se permiten valores repetidos");
					break;
					default:
						echo "error: ".mysql_error()." Nº: ".mysql_errno();
						break;
				}
			}

		} // fin de si se enviaron los datos
	else
	{echo utf8_decode("No se han recibido los datos, es posible que el archivo del icono no sea correcto o excedan el límite de MB permitido<hr>");}
	
	echo '<button class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" onclick="javascript:history.go(-1);" title="Regresar">
<span class="ui-button-text"><img src="../images/icons_menu/x32/atras_azul.png" width="20" height="20" align="absmiddle"> Regresar</span>
</button>&nbsp;';
echo '<button class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" onclick="parent.$.fancybox.close();" title="Cerrar">
<span class="ui-button-text"><img src="../images/icons_menu/x32/stop_32.png" width="20" height="20" align="absmiddle"> Cerrar</span>
</button>';


?>
</body>
</html>