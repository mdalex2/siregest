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
			$cod_anno_esc=$_POST["txt_cod"];
			$descrip_anno_esc=$_POST["txt_ann_esc"];
			$fecha_inicio=date("Y-m-d",strtotime($_POST["txt_inicio"]));
			$fecha_fin=date("Y-m-d",strtotime($_POST["txt_fin"]));
			$obs=$_POST["txt_obs"];
			$calif_min=$_POST["txt_cal_min"];
			$cmb_dias_hab=$_POST["cmb_dias_hab"];
			$cmb_porc_inas=$_POST["cmb_porc_inas"];
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
			$consulta_sql=mysql_query("insert into anno_esc_me (cod_anno_esc,descrip_anno_esc,fecha_inicio,fecha_fin,calif_min,dias_habiles,porcen_inas_aplazado,observaciones,visible,cerrado,guardado_por,fecha_g) values 
			('$cod_anno_esc',
			'$descrip_anno_esc',
			'$fecha_inicio',
			'$fecha_fin',
			$calif_min,
			$cmb_dias_hab,
			$cmb_porc_inas,
			'$obs',
			'$visible',
			'$cerrado',
			'".$_SESSION["id_usuario"]."',
			'$fecha_g'
			)",$conexion);
			if (!$consulta_sql){
				  $error=obtener_error(mysql_errno($conexion));
					mostrar_box("err",false,"INFORMACIÓN","No se pudo crear el año escolar: <br>".$error);	
					echo mostrar_btn_imp_reg();
					}		else {
						$_SESSION["msg"]="El año escolar se apertu&oacute; correctamente";
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