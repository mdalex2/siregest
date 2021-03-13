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
			date_default_timezone_set("America/Caracas");
			$cod_sec=$_POST["txt_cod"];
			$sector_educ=$_POST["txt_sec_edu"];
			$sector_educ_abrev=$_POST["txt_sec_edu_abr"];
			$obs=$_POST["txt_obs"];
			if (empty($_POST["chk_act"])){
				$visible=false;
			} else {
				$visible=true;
			}
			$fecha_g=date("Y-m-d H:i:s");	 //fecha para guardar a mysql		
	
			include_once("../funciones/conexion.php");
			$conexion=conectarse();
			//inicio la transanccion
			$consulta_sql=mysql_query("update sectores_educ set 
			id_sector_educ='$cod_sec',
			sector_educ='$sector_educ',
			sector_educ_abrev='$sector_educ_abrev',
			observaciones='$obs',
			visible='$visible',
			guardado_por='".$_SESSION["id_usuario"]."',
			fecha_g	='$fecha_g' 
			where id_sector_educ='$id_anterior'",$conexion);
			if (!$consulta_sql){
					$error=obtener_error(mysql_errno($conexion));
					mostrar_box("err",true,"INFORMACIÓN","No se pudo modificar el sector educativo: ".$error);
					echo mostrar_btn_imp_reg();
					}		else {
						$_SESSION["msg"]="Los datos del sector educativo se modificaron correctamente";
						$url="sectores_educ.php?id_func=".$_GET['id_func']."&accion=mostrar&id_mos=".$cod_sec;
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