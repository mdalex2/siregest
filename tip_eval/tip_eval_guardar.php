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
			$tipo_evaluacion=eliminar_comillas($_POST["txt_tip_eva"]);
			$tipo_evaluacion_abrev=eliminar_comillas($_POST["txt_tip_eva_abr"]);
			$obs=eliminar_comillas($_POST["txt_obs"]);
			if (empty($_POST["chk_act"])){
				$visible=false;
			} else {
				$visible=true;
			}
			$fecha_g=date("Y-m-d H:i:s");	 //fecha para guardar a mysql		
	
			include_once("../funciones/conexion.php");
			$conexion=conectarse();
			$consulta_sql=mysql_query("insert into tip_eval_calif (tipo_evaluacion,tipo_evaluacion_abrev,observaciones,visible,guardado_por,fecha_g) values 
			('$tipo_evaluacion',
			'$tipo_evaluacion_abrev',
			'$obs',
			'$visible',
			'".$_SESSION["id_usuario"]."',
			'$fecha_g'
			)",$conexion);
			if (!$consulta_sql){
				  $error=obtener_error(mysql_errno($conexion));
					mostrar_box("err",false,"INFORMACIÓN","No se pudo guardar el tipo de evaluaci&Oacute;n en la base de datos: <br>".$error);	
					echo mostrar_btn_imp_reg();
					}		else {
						$id_tip_eval=mysql_insert_id($conexion);
						$_SESSION["msg"]="Los datos del tipo de evaluaci&oacute;n se guardaron correctamente";
						$url="tip_eval.php?id_func=".$_GET['id_func']."&accion=mostrar&id_mos=".$id_tip_eval;
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