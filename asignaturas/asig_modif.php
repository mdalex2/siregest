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
			$id_anterior=$_POST["txt_id_mos_ant"];
			date_default_timezone_set("America/Caracas");
			$cod_asig=$_POST["txt_cod"];
			$tip_asi=$_POST["cmb_tip"];
			$asi_prog=$_POST["txt_asi_pro"];
			$med=$_POST["txt_med"];
			$abr=$_POST["txt_abr"];
			$uc=$_POST["txt_uc"];
			$hor_max=$_POST["txt_hor_max"];
			$ord=$_POST["txt_ord"];
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
			$consulta_sql=mysql_query("update asig_prog set 
			cod_asig_prog='$cod_asig',
			tip_asig='$tip_asi',
			des_mat_prog='$asi_prog',
			mat_prog_med='$med',
			mat_prog_cor='$abr',
			uc='$uc',
			orden='$ord',
			horas_max_sem='$hor_max',
			observaciones='$obs',
			visible='$visible',
			guardado_por='".$_SESSION["id_usuario"]."',
			fecha_g	='$fecha_g' 
			where cod_asig_prog='$id_anterior'",$conexion);
			if (!$consulta_sql){
					mostrar_box("err",true,"INFORMACIÓN","No se pudo modificar los datos de la asignatura o programa: ".mysql_error())." N&deg;: ".mysql_errno();
					echo mostrar_btn_imp_reg();
					}		else {
						$_SESSION["msg"]="Los datos de la asignatura o programa se modificaron correctamente";
						$url="asignaturas.php?id_func=".$_GET['id_func']."&accion=mostrar&id_mos=".$cod_asig;
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