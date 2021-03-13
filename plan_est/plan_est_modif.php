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
			date_default_timezone_set("America/Caracas");
			$id_anterior=$_POST["txt_id_mos_ant"];
			$cod_plan_nivel_me=$_POST["txt_cod"];
			$plan_est=$_POST["txt_pla_est"];
			$notas=$_POST["txt_not"];
			if (empty($_POST["chk_act"])){
				$visible=false;
			} else {
				$visible=true;
			}
			$fecha_pub=date("Y-m-d",strtotime($_POST["txt_fecha"]));
			$fecha_g=date("Y-m-d H:i:s");	 //fecha para guardar a mysql		
			include_once("../funciones/conexion.php");
			$conexion=conectarse();
			//inicio la transanccion
			$consulta_sql=mysql_query("update plan_est_tip set 
			cod_plan_nivel_me='$cod_plan_nivel_me',
			nivel_plan_est='$plan_est',
			notas='$notas',
			visible='$visible',
			guardado_por='".$_SESSION["id_usuario"]."',
			fecha_g	='$fecha_g',
			fecha_pub='$fecha_pub' 
			where id_plan_nivel_est='$id_anterior'",$conexion);
			if (!$consulta_sql){
				 	$error=obtener_error(mysql_errno($conexion));
					mostrar_box("err",true,"INFORMACIÓN","No se pudo modificar los datos del plan de estudio: ".$error);
					echo mostrar_btn_imp_reg();
					}		else {
						$_SESSION["msg"]="Los datos del plan de estudio se modificaron correctamente";
						$url="plan_est.php?id_func=".$_GET['id_func']."&accion=mostrar&id_mos=".$id_anterior;
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