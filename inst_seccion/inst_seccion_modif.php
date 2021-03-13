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
			$id_seccion=$_POST["cmb_pla"].$_POST["cmb_pla_est"].$_POST["cmb_men"].$_POST["cmb_sec_pla_est"].$_POST["cmb_gra"].$_POST["txt_sec_c"];
			$cod_plantel=$_POST["cmb_pla"];
			$id_plan_nivel_est=$_POST["cmb_pla_est"];
			$cod_mencion_educ=$_POST["cmb_men"];
			$id_sector_educ=$_POST["cmb_sec_pla_est"];
			$cod_grado=$_POST["cmb_gra"];
			$seccion_largo=$_POST["txt_sec_l"];
			$seccion_med=$_POST["txt_sec_m"];
			$seccion_corto=$_POST["txt_sec_c"];
			$max_alumn=$_POST["txt_max_alu"];
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
			$consulta_sql=mysql_query("update inst_secciones set 
			id_seccion='$id_seccion',
			cod_plantel='$cod_plantel',
			id_plan_nivel_est='$id_plan_nivel_est',
			cod_mencion_educ='$cod_mencion_educ',
			id_sector_educ='$id_sector_educ',
			cod_grado='$cod_grado',
			seccion_largo='$seccion_largo',
			seccion_med='$seccion_med',
			seccion_corto='$seccion_corto',
			max_alumn=$max_alumn,
			observaciones='$obs',
			visible='$visible',
			guardado_por='".$_SESSION["id_usuario"]."',
			fecha_g	='$fecha_g' 
			where id_seccion='$id_anterior'",$conexion);
			if (!$consulta_sql){
					$error=obtener_error(mysql_errno($conexion));
					mostrar_box("err",true,"INFORMACIÓN","No se pudo modificar la secci&oacute;n: ".$error);
					echo mostrar_btn_imp_reg();
					}		else {
						$_SESSION["msg"]="Los datos de la secci&oacute;n se modificaron correctamente";
						$url="inst_seccion.php?id_func=".$_GET['id_func']."&accion=mostrar&id_mos=".$id_seccion;
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