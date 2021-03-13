<!DOCTYPE HTML>
<html>
<head>
<!-- Meta -->
<meta http-equiv="Content-Type" content="text/html; charset=<?php if (isset($_SESSION['juego_caracteres'])) echo $_SESSION['juego_caracteres']; else echo "utf-8";//esta variable se declara en modulo verificar login?>">
</head>
                 
<?php

function guardar_datos_per(){
	if (empty($_POST)){ //si no se han recibido datos muestro error
			echo "No se han recibido datos";
		} else {
			//pongo zona horaria para evitar errores al obtener fecha actual del servidor
			date_default_timezone_set("America/Caracas");
			$id_personal=$_POST["cmb_tip_doc"]."_".$_POST["txt_num_ced"];
			$cod_tip_doc=$_POST["cmb_tip_doc"];
			$cod_tip_reg=$_POST["cmb_tip_reg"];
			$num_id_pers=$_POST["txt_num_ced"];
			$cedula=$_POST["txt_num_ced"];
			$nombres=$_POST["txt_nombres"];
			$apellidos=$_POST["txt_apellidos"];
			$cod_nacionalidad=$_POST["cmb_nac"];
			$id_edo_civ=$_POST["cmb_edo_civil"];
			$cod_profesion=$_POST["cmb_pro"];
			$sexo=strtoupper($_POST["cmb_sex"]);
			$fecha_nac=date("Y-m-d",strtotime($_POST["txt_fec_nac"]));
			$cod_edo_nac=$_POST["cmb_estado"];
			$lugar_nac=$_POST["txt_lug_nac"];
			$observaciones=$_POST["txt_obs"];
			$fecha_g=date("Y-m-d H:i:s");			
			//para la foto
			$carp_per=$_SESSION["carp_per_fotos"].$id_personal;
			if (!file_exists($carp_per)){
				//echo $carp_per;
				rmkdir($carp_per,0777);
				if (!file_exists($carp_per)){echo "No se pudo crear el directorio para almacenar la foto en: $carp_per";exit();} // si no se pudo crear la foto salgo
				}
	
	$foto="";
	$nombre_foto="";
	$foto=$_FILES["txt_foto"]["name"];
	//si existen datos y se ha enviado el fomrulario
	if(!empty($_FILES['txt_foto']) && $_FILES['txt_foto']['error'] == UPLOAD_ERR_OK) {

			$image = new ModifiedImage($_FILES['txt_foto']['tmp_name'], true);
			$image->resizeTofit(200,250);
			//obtengo la extension del archivo
			$extension=pathinfo($foto, PATHINFO_EXTENSION);
			//asigno el nombre del archivo al id de la persona como es unico no se repetirá
			$nombre_foto = $id_personal.".".$extension;
			$ruta_foto = $carp_per."/".$id_personal.".".$extension;
			$image->save($ruta_foto);
			//echo 'Imagen grabada: <img src="'.$ruta_icono32.'"/><br>';
			} //fin de si se envio archivos de imagen
			else
			{
				$msg_icono=", sin embargo la foto no se pudo almacenar, debe modificarla usando la opción editar, es posible que exista un error el formato o tamaño del archivo de imagen seleccionado";
				//mostrar_box("exc",true,"ERROR EN EL ICONO","No se pudo  almacenar el icono de la función, puede intentar volver a actualizarlo en otro momento utilizando la opción editar");
				}
	
			include_once("../funciones/conexion.php");
			$conexion=conectarse();
			$consulta_sql=mysql_query("insert into datos_per (id_personal,cod_tip_doc_per,num_identificacion,id_grupo,cod_nac, 	id_edo_civ,sexo,nombres,apellidos,cod_tip_ocup,fecha_nac,cod_estado_ter,lugar_nac,observaciones,guardado_por,fecha_g,foto_perfil) values 
			('$id_personal',
			'$cod_tip_doc',
			'$num_id_pers',
			'$cod_tip_reg',
			'$cod_nacionalidad',
			$id_edo_civ,
			'$sexo',
			'$nombres',
			'$apellidos',
			'$cod_profesion',
			'$fecha_nac',
			'$cod_edo_nac',
			'$lugar_nac',
			'$observaciones',
			'".$_SESSION["id_usuario"]."',
			'$fecha_g',
			'$nombre_foto'
			)",$conexion);
			if (!$consulta_sql){
				  $error=obtener_error(mysql_errno());
					$botones= mostrar_btn_imp_reg();
					mostrar_box("err",false,"INFORMACIÓN","No se pudo guardar los datos personales en la base de datos: <br>".$error);	
					echo utf8_decode(mostrar_btn_imp_reg());
					}		else {
						$_SESSION["msg"]="Los datos personales se guardaron correctamente, ahora puede agregar los telefonos, direcci&oacute;n, email y dem&aacute;s informaci&oacute;n general";
						$url="datos_per.php?id_func=".$_GET['id_func']."&accion=mostrar&id_per=".$id_personal;
					echo '
					<script type="text/javascript">
						window.location="'.$url.'";
					</script>';
					exit();
				
				//header("location:".$url);
			}
		}
		
}
?>
</html>