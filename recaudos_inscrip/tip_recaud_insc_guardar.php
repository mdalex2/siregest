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
			$cod_gra=$_POST["cmb_gra"];
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
			$consulta_sql=mysql_query("insert into tip_recaudos (cod_grado,todos,descrip_recaudo 	,observaciones,visible,guardado_por,fecha_g) values 
			('$cod_gra',
			'$todos',
			'$recaudo',
			'$obs',
			'$visible',
			'$id_guard_por',
			'$fecha_g'
			)",$conexion);
			if (!$consulta_sql){
				  $error=obtener_error(mysql_errno($conexion));
					$botones= mostrar_btn_imp_reg();
					mostrar_box("err",false,"INFORMACIÓN","No se pudo guardar el recaudo de inscripci&oacute;n en la base de datos: <br>".$error);	
					echo mostrar_btn_imp_reg();
					}		else {
						$id_insertado=mysql_insert_id($conexion);
						$_SESSION["msg"]="Los datos del recaudo se guardaron correctamente";
						$url="tip_recaud_insc.php?id_func=".$_GET['id_func']."&accion=mostrar&id_mos=".$id_insertado;
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