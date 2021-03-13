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
			$consulta_sql=mysql_query("insert into inst_secciones  (id_seccion,cod_plantel,id_plan_nivel_est,cod_mencion_educ,id_sector_educ,cod_grado,seccion_largo,seccion_med,seccion_corto,max_alumn,observaciones,visible,guardado_por,fecha_g) values 
			('$id_seccion',
			'$cod_plantel',
			'$id_plan_nivel_est',
			'$cod_mencion_educ',
			'$id_sector_educ',
			'$cod_grado',
			'$seccion_largo',
			'$seccion_med',
			'$seccion_corto',
			$max_alumn,
			'$obs',
			'$visible',
			'".$_SESSION["id_usuario"]."',
			'$fecha_g'
			)",$conexion);
			if (!$consulta_sql){
				  $error=obtener_error(mysql_errno($conexion));
					$botones= mostrar_btn_imp_reg();
					mostrar_box("err",false,"INFORMACIÓN","No se pudo guardar la secci&oacute;n en la base de datos: <br>".$error);	
					echo mostrar_btn_imp_reg();
					}		else {
						$_SESSION["msg"]="Los datos de la secci&oacute;n se guardaron correctamente";
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