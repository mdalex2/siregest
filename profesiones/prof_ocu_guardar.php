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
			$consulta_sql=mysql_query("insert into tip_ocup  (cod_tip_ocup,ocup_profesion,observaciones,visible) values 
			('$cod_ocu',
			'$ocu_prof',
			'$obs',
			'$visible'
			)",$conexion);
			if (!$consulta_sql){
				  $error=obtener_error(mysql_errno($conexion));
					$botones= mostrar_btn_imp_reg();
					mostrar_box("err",false,"INFORMACIÓN","No se pudo guardar la profesi&oacute;n en la base de datos: <br>".$error);	
					echo mostrar_btn_imp_reg();
					}		else {
						$_SESSION["msg"]="Los datos de la profesi&oacute;n guardaron correctamente";
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