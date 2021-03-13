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
			$cod_pla_est_me=$_POST["txt_cod"];
			$pla_est=$_POST["txt_pla_est"];
			$not=$_POST["txt_not"];
			if (empty($_POST["chk_act"])){
				$vis=false;
			} else {
				$vis=true;
			}
			$fecha_pub=date("Y-m-d",strtotime($_POST["txt_fecha"]));
			$fecha_g=date("Y-m-d H:i:s");	 //fecha para guardar a mysql		
	
			include_once("../funciones/conexion.php");
			$conexion=conectarse();
			$consulta_sql=mysql_query("insert into plan_est_tip (cod_plan_nivel_me,nivel_plan_est,notas,visible,guardado_por,fecha_g,fecha_pub) values 
			('$cod_pla_est_me',
			'$pla_est',
			'$not',
			'$vis',
			'".$_SESSION["id_usuario"]."',
			'$fecha_g',
			'$fecha_pub'
			)",$conexion);
			if (!$consulta_sql){
				  $error=obtener_error(mysql_errno());
					$botones= mostrar_btn_imp_reg();
					echo mostrar_box("err",false,"INFORMACIÓN","No se pudo guardar el plan de estudio en la base de datos: <br>".$error);	
					echo mostrar_btn_imp_reg();
					}		else {
						
						$_SESSION["msg"]="Los datos del plan de estudio se guardaron correctamente";
						$ultimo_ID = mysql_insert_id();
						$url="plan_est.php?id_func=".$_GET['id_func']."&accion=mostrar&id_mos=".$ultimo_ID;
					echo '
					<script type="text/javascript">
						window.location="'.$url.'";
					</script>';
					//exit();
				
				//header("location:".$url);
			}
		}
		
}
?>
</html>