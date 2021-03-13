<!DOCTYPE HTML>
<html>
<head>
<!-- Meta -->
<meta http-equiv="Content-Type" content="text/html; charset=<?php if (isset($_SESSION['juego_caracteres'])) echo $_SESSION['juego_caracteres']; else echo "utf-8";//esta variable se declara en modulo verificar login?>">
</head>
                 
<?php
function modif_datos(){
	
	if (empty($_POST)){ //si no se han recibido datos muestro error
			echo "<h1>No se han recibido datos</h1>";
		} else {
			date_default_timezone_set("America/Caracas");
			$id_anterior=$_POST["txt_cod_ant"];
			$cod_pla=$_POST["txt_cod_pla"];
			$fec_cre=date("Y-m-d",strtotime($_POST["txt_fecha"]));
			$id_pob=$_POST["cmb_pob"];
			$den_pla=arregla_pa_guardar($_POST["txt_den_pla"]);
			$den_pla_abr=arregla_pa_guardar($_POST["txt_den_pla_abr"]);
			$dis_esc=$_POST["cmb_dis_esc"];
			$tip_pla=$_POST["cmb_tip_pla"];
			$cod_sec_edu=$_POST["cmb_sec_edu"];
			$dir=arregla_pa_guardar($_POST["txt_dir"]);
			$obs=arregla_pa_guardar($_POST["txt_obs"]);
			$email=arregla_pa_guardar($_POST["txt_email"]);
			$fecha_g=date("Y-m-d H:i:s");			
			if (empty($_POST["chk_act"])){
				$activa=false;
			} else {
				$activa=true;
			}

			include_once("../funciones/conexion.php");
			$conexion=conectarse();
			$consulta_sql=mysql_query("update instituciones set 
			cod_plantel='$cod_pla',
			den_plantel='$den_pla',
			den_plantel_corta='$den_pla_abr',
			email='$email',
			id_poblado='$id_pob',
			id_dis_esc='$dis_esc',
			id_tip_ins='$tip_pla',
			id_sector_educ='$cod_sec_edu',
			direccion_detalle='$dir',
			fecha_creada='$fec_cre',
			observaciones='$obs',
			activa='$activa',
			guardado_por='".$_SESSION['id_usuario']."',
			fecha_g	='$fecha_g' 
			where cod_plantel='$id_anterior'",$conexion);
			if (!$consulta_sql){
					include_once("../funciones/errores_genericos.php");
					$msg=obtener_error(mysql_errno($conexion));
					mostrar_box("err",true,"INFORMACIÓN","No se pudo modificar los datos del plantel: <br>".$msg);
					echo mostrar_btn_imp_reg();
					}		else {
						$_SESSION["msg"]="Los datos del plantel se modificaron correctamente";
						if (isset($_GET["id_edo_ter"])){
							$var_edo="&id_edo_ter=".$_GET["id_edo_ter"];
						} else {
							$var_edo="";
						}
						$url="inst_educativa.php?id_func=".$_GET['id_func']."&accion=mostrar&id_mos=".$cod_pla.$var_edo;
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