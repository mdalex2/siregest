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
			$consulta_sql=mysql_query("insert into asig_prog (cod_asig_prog,tip_asig,des_mat_prog,mat_prog_med,mat_prog_cor,uc,orden,horas_max_sem,observaciones,visible,guardado_por,fecha_g) values 
			('$cod_asig',
			'$tip_asi',
			'$asi_prog',
			'$med',
			'$abr',
			$uc,
			$ord,
			$hor_max,
			'$obs',
			'$visible',
			'".$_SESSION["id_usuario"]."',
			'$fecha_g'
			)",$conexion);
			if (!$consulta_sql){
				  $error=obtener_error(mysql_errno());
					$botones= mostrar_btn_imp_reg();
					mostrar_box("err",false,"INFORMACIÓN","No se pudo guardar la asignatura o programa en la base de datos: <br>".$error);	
					echo mostrar_btn_imp_reg();
					}		else {
						$_SESSION["msg"]="Los datos de la asignatura o programa se guardaron correctamente";
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