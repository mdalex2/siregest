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
			$id_anterior=$_POST["txt_id_ant"];
			 include_once("../funciones/aplica_config_global.php");

date_default_timezone_set("America/Caracas");
			
			$id_personal=$_SESSION["id_usuario"];
			$fecha=date("Y-m-d",strtotime($_POST["texto11"]));
			$hora = str_replace(" ","",$_POST["hora"]);
			$hora = strtotime($hora);
			$hora = date("H:i", $hora);
			$fecha_apunte=$fecha." ".$hora;
			$tarea=eliminar_comillas($_POST["txt_tarea"]);
			if (empty($_POST["chk_ter"])){
				$cerrada=false;
			} else {
				$cerrada=true;
			}
	
			include_once("../funciones/conexion.php");
			$conexion=conectarse();
			//inicio la transanccion
			$consulta_sql=mysql_query("update agenda_pers set 
			id_personal='$id_personal',
			fecha_act='$fecha_apunte',
			descripcion='$tarea',
			cerrada='$cerrada' 
			where	id_apunte='$id_anterior'",$conexion);
			if (!$consulta_sql){
					$error=obtener_error(mysql_errno($conexion));
					mostrar_box("err",true,"INFORMACIÓN","No se pudo modificar el apunte de agenda: ".$error);
					echo mostrar_btn_imp_reg();
					}		else {
						$_SESSION["msg"]="Los datos del apunte de agenda se modificaron correctamente";
						$url="agenda.php?id_func=".$_GET['id_func']."&accion=mostrar&id_mos=".$id_anterior;
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