<!DOCTYPE HTML>
<html>
<head>
<!-- Meta -->
<meta http-equiv="Content-Type" content="text/html; charset=<?php if (isset($_SESSION['juego_caracteres'])) echo $_SESSION['juego_caracteres']; else echo "utf-8";//esta variable se declara en modulo verificar login?>">
</head>
                 
<?php

function guardar_datos(){
	if (empty($_POST)){ //si no se han recibido datos muestro error
			echo "<h2>No se han recibido datos para almacenar</h2>";
		} else {
			//pongo zona horaria para evitar errores al obtener fecha actual del servidor
			date_default_timezone_set("America/Caracas");
			$cod_tip_doc_per=$_POST["txt_cod"];
			$tipo_doc=$_POST["txt_tip_doc"];
			$tipo_doc_abr=$_POST["txt_tip_doc_abr"];
			$obs=$_POST["txt_obs"];
			$orden=$_POST["txt_ord"];
			$separador=$_POST["txt_sep"];
			if (empty($_POST["chk_act"])){
				$visible=false;
			} else {
				$visible=true;
			}
			
			if (empty($_POST["chk_pon_num"])){
				$pon_num=false;
			} else {
				$pon_num=true;
			}			
			
			if (empty($_POST["chk_for_mill"])){
				$formato_mill=false;
			} else {
				$formato_mill=true;
			}			

			
			include_once("../funciones/conexion.php");
			$conexion=conectarse();
			$consulta_sql=mysql_query("insert into tip_doc_per  (cod_tip_doc_per,tipo_doc,tipo_doc_abr,poner_num,separador,num_con_punto,observaciones,visible,orden) values 
			('$cod_tip_doc_per',
			'$tipo_doc',
			'$tipo_doc_abr',
			'$pon_num',
			'$separador',
			'$formato_mill',
			'$obs',
			'$visible',
			$orden
			)",$conexion);
			if (!$consulta_sql){
				  $error=obtener_error(mysql_errno($conexion));
					$botones= mostrar_btn_imp_reg();
					mostrar_box("err",false,"INFORMACIÓN","No se pudo guardar tipo de documento de identidad en la base de datos: <br>".$error);	
					echo mostrar_btn_imp_reg();
					}		else {
						$_SESSION["msg"]="Los datos del tipo de documento de identidad se guardaron correctamente";
						$url="tip_doc.php?id_func=".$_GET['id_func']."&accion=mostrar&id_mos=".$cod_tip_doc_per;
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