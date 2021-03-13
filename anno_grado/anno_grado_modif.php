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
			$cod_gra=$_POST["txt_cod"];
			$ann_gra_l=$_POST["txt_ann_gra_l"];
			$ann_gra_nl=$_POST["txt_ann_gra_nl"];
			$ann_gra_m=$_POST["txt_ann_gra_m"];
			$ann_gra_c=$_POST["txt_ann_gra_c"];
			$obs=$_POST["txt_obs"];
			$ord=$_POST["txt_ord"];
			if (empty($_POST["chk_act"])){
				$visible=false;
			} else {
				$visible=true;
			}
			$fecha_g=date("Y-m-d H:i:s");	 //fecha para guardar a mysql		
	
			include_once("../funciones/conexion.php");
			$conexion=conectarse();
			//inicio la transanccion
			$consulta_sql=mysql_query("update grados_esc set 
			cod_grado='$cod_gra',
			grado_letras='$ann_gra_l',
			grado_num_letra='$ann_gra_nl',
			grado_med='$ann_gra_m',
			grado_corto='$ann_gra_c',
			orden='$ord',
			observaciones='$obs',
			visible='$visible',
			guardado_por='".$_SESSION["id_usuario"]."',
			fecha_g	='$fecha_g' 
			where cod_grado='$id_anterior'",$conexion);
			if (!$consulta_sql){
					$error=obtener_error(mysql_errno($conexion));
					mostrar_box("err",true,"INFORMACIÓN","No se pudo modificar el a&ntilde; o grado: ".$error);
					echo mostrar_btn_imp_reg();
					}		else {
						$_SESSION["msg"]="Los datos del a&ntilde;o grado se modificaron correctamente";
						$url="anno_grado.php?id_func=".$_GET['id_func']."&accion=mostrar&id_mos=".$cod_gra;
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