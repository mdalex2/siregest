<!DOCTYPE HTML>
<html>
<head>
<!-- Meta -->
<meta http-equiv="Content-Type" content="text/html; charset=<?php if (isset($_SESSION['juego_caracteres'])) echo $_SESSION['juego_caracteres']; else echo "utf-8";//esta variable se declara en modulo verificar login?>">
</head>
                 
<?php
function modif_datos_per(){
	
	if (empty($_POST)){ //si no se han recibido datos muestro error
			echo "No se han recibido datos";
		} else {
			date_default_timezone_set("America/Caracas");
			$id_per_anterior=$_POST["txt_id_per_ant"];
			$id_personal_modif=$_POST["cmb_tip_doc"]."_".$_POST["txt_num_ced"];
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
			if (isset($_POST["txt_foto"])){
				$nombre_foto=$_POST["txt_foto"];
			} else {
				$nombre_foto=$_POST["foto_ant"];}
			$fecha_nac=date("Y-m-d",strtotime($_POST["txt_fec_nac"]));
			$cod_edo_nac=$_POST["cmb_estado"];
			$lugar_nac=$_POST["txt_lug_nac"];
			$observaciones=$_POST["txt_obs"];
			$fecha_g=date("Y-m-d H:i:s");
			//para la foto
			$carp_per=$_SESSION["carp_per_fotos"].$id_personal_modif;
			$carp_per_ant=$_SESSION["carp_per_fotos"].$id_per_anterior;
			//si se cambiola cedula renombrola carpeta personal para evitar perder el linck de la foto
			if 	($id_per_anterior!=$id_personal_modif){
				if (file_exists($carp_per_ant)){
					rename($carp_per_ant, $carp_per);
				}
			}
			if (!file_exists($carp_per)){
				//echo $carp_per;
				rmkdir($carp_per,0777);
				if (!file_exists($carp_per)){echo "No se pudo crear el directorio para almacenar la foto en: $carp_per";exit();} // si no se pudo crear la foto salgo
				
				}
	
	$foto="";
	
	
	//si existen datos y se ha enviado el fomrulario
	if(!empty($_FILES['txt_foto']) && $_FILES['txt_foto']['error'] == UPLOAD_ERR_OK) {
  	  $foto=$_FILES["txt_foto"]["name"];
			$image = new ModifiedImage($_FILES['txt_foto']['tmp_name'], true);
			$image->resizeTofit(200,250);
			//obtengo la extension del archivo
			$extension=pathinfo($foto, PATHINFO_EXTENSION);
			//asigno el nombre del archivo al id de la persona como es unico no se repetirá
			$nombre_foto = $id_personal_modif.".".$extension;
			$ruta_foto = $carp_per."/".$id_personal_modif.".".$extension;
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
			//inicio la transanccion
			$error_transacc=false;
			$msg_error_transacc[]="";
			mysql_query("begin");
			$consulta_sql=mysql_query("update datos_per set 
			id_personal='$id_personal_modif',
			cod_tip_doc_per='$cod_tip_doc',
			num_identificacion='$num_id_pers',
			id_grupo='$cod_tip_reg',
			cod_nac='$cod_nacionalidad',
			id_edo_civ='$id_edo_civ',
			sexo='$sexo',
			nombres='$nombres',
			apellidos='$apellidos',
			cod_tip_ocup='$cod_profesion',
			fecha_nac='$fecha_nac',
			cod_estado_ter='$cod_edo_nac',
			lugar_nac='$lugar_nac',
			observaciones='$observaciones',
			guardado_por='".$_SESSION["id_usuario"]."',
			fecha_g	='$fecha_g',
			foto_perfil='$nombre_foto'
			where id_personal='$id_per_anterior'",$conexion);
			if (!$consulta_sql){
				$error_transacc=true;
				$msg_error_transacc[].="error modif ".mysql_error($conexion);
			}
			$sql_actualiza_guard_por="update datos_per set guardado_por='$id_personal_modif' where guardado_por='$id_per_anterior'";
			$consulta_guar_por=mysql_query($sql_actualiza_guard_por);
			if (!$consulta_guar_por){
				$error_transacc=true;
				$msg_error_transacc[].="error update gua por: ".mysql_error($conexion);
			}
			if ($error_transacc==true){
				  mysql_query("rollback");
					utf8_encode(mostrar_box("err",false,"INFORMACIÓN","No se pudo modificar los datos personales: ".mysql_error($conexion))." N&deg;: ".mysql_errno($conexion));
					echo "<pre>".print_r($msg_error_transacc)."</pre>";
					echo utf8_decode(mostrar_btn_imp_reg());
					}		else {
						mysql_query("commit");
						$_SESSION["msg"]="Los datos personales se modificaron correctamente";
						$url="datos_per.php?id_func=".$_GET['id_func']."&accion=mostrar&id_per=".$id_personal_modif;
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