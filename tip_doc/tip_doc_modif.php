<!DOCTYPE HTML>
<html>
<head>
<!-- Meta -->
<meta http-equiv="Content-Type" content="text/html; charset=<?php if (isset($_SESSION['juego_caracteres'])) echo $_SESSION['juego_caracteres']; else echo "utf-8";//esta variable se declara en modulo verificar login?>">
</head>
                 
<?php
function modif_datos(){
	if (empty($_POST)){ //si no se han recibido datos muestro error
			echo "<h2>No se han recibido datos para mod&iacute;ficar</h2>";
		} else {
			$cod_tip_doc_ant=$_POST["txt_id_ant"];
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
			//inicio la transanccion
			$consulta_sql=mysql_query("update tip_doc_per set 			cod_tip_doc_per='$cod_tip_doc_per',
			tipo_doc='$tipo_doc',
		 	tipo_doc_abr='$tipo_doc_abr',
			poner_num='$pon_num',
			separador='$separador',
			num_con_punto='$formato_mill',
			observaciones='$obs',
			visible='$visible',
			orden='$orden' 
			where cod_tip_doc_per='$cod_tip_doc_ant'",$conexion);
			if (!$consulta_sql){
				  $error=obtener_error(mysql_errno($conexion));
					mostrar_box("err",true,"INFORMACIÓN","No se pudo modificar el tipo de documento de identificaci&oacute;n: ".$error);
					echo mostrar_btn_imp_reg();
					}		else {
						$_SESSION["msg"]="Los datos del tipo de documento de identificaci&oacute;n se modificaron correctamente";
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