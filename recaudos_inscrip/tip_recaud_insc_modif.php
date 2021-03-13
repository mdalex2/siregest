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
			$cod_gra=$_POST["cmb_gra"];
			$id_anterior=$_POST["txt_cod"];
			$recaudo=$_POST["txt_reca"];
			$obs=$_POST["txt_obs"];
			if (empty($_POST["chk_act"])){
				$visible=false;
			} else {
				$visible=true;
			}
			if (empty($_POST["chk_tod"])){
				$todos=false;
			} else {
				$todos=true;
			}			
			$fecha_g=date("Y-m-d H:i:s");	 //fecha para guardar a mysql	
			$id_guard_por=$_SESSION["id_usuario"];	
	
			include_once("../funciones/conexion.php");
			$conexion=conectarse();
			//inicio la transanccion
			$consulta_sql=mysql_query("update 
			tip_recaudos set 
			cod_grado='$cod_gra',
			descrip_recaudo='$recaudo',
			observaciones='$obs',
			visible='$visible',
			todos='$todos',
			guardado_por='$id_guard_por',
			fecha_g	='$fecha_g' 
			where id_tip_recaudo='$id_anterior'",$conexion);
			if (!$consulta_sql){
					$error=obtener_error(mysql_errno($conexion));
					mostrar_box("err",true,"INFORMACIÓN","No se pudo modificar el recaudo de inscripci&oacute;n: ".$error);
					echo mostrar_btn_imp_reg();
					}		else {
						$_SESSION["msg"]="Los datos del recaudo de inscripci&oacute;n se modificaron correctamente";
						$url="tip_recaud_insc.php?id_func=".$_GET['id_func']."&accion=mostrar&id_mos=".$id_anterior;
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