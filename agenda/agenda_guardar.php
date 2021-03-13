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
			$consulta_sql=mysql_query("insert into agenda_pers (id_personal,fecha_act,descripcion,cerrada) values 
			('$id_personal',
			'$fecha_apunte',
			'$tarea',
			'$cerrada')",$conexion);
			if (!$consulta_sql){
				  $error=obtener_error(mysql_errno($conexion));
					mostrar_box("err",false,"INFORMACIÓN","No se pudo guardar el apunte de agenda en la base de datos: <br>".$error);	
					echo mostrar_btn_imp_reg();
					}		else {
						$id_apunte=mysql_insert_id();
						$_SESSION["msg"]="El apunte de agenda se guard&oacute; correctamente";
						$url="agenda.php?id_func=".$_GET['id_func']."&accion=mostrar&id_mos=".$id_apunte;
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