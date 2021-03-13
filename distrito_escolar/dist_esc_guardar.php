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
			$num_dis=$_POST["txt_num_dis"];
			$cod_edo_ter=$_POST["cmb_estado"];
			$dis_esc=$_POST["txt_dis_esc"];
			$dis_esc_abr=$_POST["txt_dis_esc_abr"];
			$obs=$_POST["txt_obs"];
			if (empty($_POST["chk_act"])){
				$visible=false;
			} else {
				$visible=true;
			}
			$fecha_g=date("Y-m-d H:i:s");	 //fecha para guardar a mysql		
	
			include_once("../funciones/conexion.php");
			$conexion=conectarse();
			$consulta_sql=mysql_query("insert into dis_esc  (cod_estado_ter,num_dist,dis_esc,dis_esc_abr,observaciones,visible,guardado_por,fecha_g) values 
			('$cod_edo_ter',
			'$num_dis',
			'$dis_esc',
			'$dis_esc_abr',
			'$obs',
			'$visible',
			'".$_SESSION["id_usuario"]."',
			'$fecha_g'
			)",$conexion);
			if (!$consulta_sql){
				  $error=obtener_error(mysql_errno($conexion));
					$botones= mostrar_btn_imp_reg();
					mostrar_box("err",false,"INFORMACIÓN","No se pudo guardar el distrito escolar en la base de datos: <br>".$error);	
					echo mostrar_btn_imp_reg();
					}		else {
						$id_mos=mysql_insert_id($conexion);  
						$_SESSION["msg"]="Los datos del distrito escolar se guardaron correctamente";
						$url="dist_esc.php?id_func=".$_GET['id_func']."&accion=mostrar&id_mos=".$id_mos;
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