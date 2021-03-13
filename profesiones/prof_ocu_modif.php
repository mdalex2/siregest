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
			$id_anterior=$_POST["txt_id_ant"];
			$cod_ocu=$_POST["txt_cod"];
			$ocu_prof=$_POST["txt_pro_ocu"];
			$obs=$_POST["txt_obs"];
			if (empty($_POST["chk_act"])){
				$visible=false;
			} else {
				$visible=true;
			}
			
			include_once("../funciones/conexion.php");
			$conexion=conectarse();
			//inicio la transanccion
			$consulta_sql=mysql_query("update tip_ocup set 
			cod_tip_ocup='$cod_ocu',
			ocup_profesion='$ocu_prof',
			observaciones='$obs',
			visible='$visible' 
			where cod_tip_ocup='$id_anterior'",$conexion);
			if (!$consulta_sql){
				  $error=obtener_error(mysql_errno($conexion));
					mostrar_box("err",true,"INFORMACIÓN","No se pudo modificar la profesi&oacute;n o ocupaci&oacute;n: ".$error);
					echo mostrar_btn_imp_reg();
					}		else {
						$_SESSION["msg"]="Los datos de la profesi&oacute;n u ocupaci&oacute;n se modificaron correctamente";
						$url="prof_ocu.php?id_func=".$_GET['id_func']."&accion=mostrar&id_mos=".$cod_ocu;
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