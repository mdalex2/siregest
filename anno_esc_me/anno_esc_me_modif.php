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
			$cod_anno_esc=$_POST["txt_cod"];
			$descrip_anno_esc=$_POST["txt_ann_esc"];
			$fecha_inicio=date("Y-m-d",strtotime($_POST["txt_inicio"]));
			$fecha_fin=date("Y-m-d",strtotime($_POST["txt_fin"]));
			$calif_min=$_POST["txt_cal_min"];
			$cmb_dias_hab=$_POST["cmb_dias_hab"];
			$cmb_porc_inas=$_POST["cmb_porc_inas"];			
			$obs=$_POST["txt_obs"];
			if (empty($_POST["chk_act"])){
				$visible=false;
			} else {
				$visible=true;
			}
			if (empty($_POST["chk_cerrado"])){
				$cerrado=false;
			} else {
				$cerrado=true;
			}			
			$fecha_g=date("Y-m-d H:i:s");	 //fecha para guardar a mysql		
	
			include_once("../funciones/conexion.php");
			$conexion=conectarse();
			//inicio la transanccion
			$consulta_sql=mysql_query("update anno_esc_me set 
			cod_anno_esc='$cod_anno_esc',
			descrip_anno_esc='$descrip_anno_esc',
			fecha_inicio='$fecha_inicio',
			fecha_fin='$fecha_fin',
			calif_min=$calif_min,
			dias_habiles=$cmb_dias_hab,
			porcen_inas_aplazado=$cmb_porc_inas,
			observaciones='$obs',
			visible='$visible',
			cerrado='$cerrado',
			guardado_por='".$_SESSION["id_usuario"]."',
			fecha_g	='$fecha_g' 
			where cod_anno_esc='$id_anterior'",$conexion);
			if (!$consulta_sql){
					$error=obtener_error(mysql_errno($conexion));
					mostrar_box("err",true,"INFORMACIÓN","No se pudo modificar la configuraci&oacute;n del año escolar: ".$error);
					echo mostrar_btn_imp_reg();
					}		else {
						$_SESSION["msg"]="Los datos del año escolar se modificaron correctamente";
						$url="anno_esc_me.php?id_func=".$_GET['id_func']."&accion=mostrar&id_mos=".$cod_anno_esc;
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