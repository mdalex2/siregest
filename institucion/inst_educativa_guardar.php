<!DOCTYPE HTML>
<html>
<head>
<!-- Meta -->
<meta http-equiv="Content-Type" content="text/html; charset=<?php if (isset($_SESSION['juego_caracteres'])) echo $_SESSION['juego_caracteres']; else echo "utf-8";//esta variable se declara en modulo verificar login?>">
</head>
                 
<?php

function guardar_datos(){
	if (empty($_POST)){ //si no se han recibido datos muestro error
			echo "<H1>No se han recibido datos</H1>";
		} else {
			//pongo zona horaria para evitar errores al obtener fecha actual del servidor
			date_default_timezone_set("America/Caracas");
			$cod_pla=$_POST["txt_cod_pla"];
			$fec_cre=date("Y-m-d",strtotime($_POST["txt_fecha"]));
			$id_pob=$_POST["cmb_pob"];
			$den_pla=arregla_pa_guardar($_POST["txt_den_pla"]);
			$den_pla_abr=arregla_pa_guardar($_POST["txt_den_pla_abr"]);
			$email=arregla_pa_guardar($_POST["txt_email"]);
			$dis_esc=$_POST["cmb_dis_esc"];
			$tip_pla=$_POST["cmb_tip_pla"];
			$cod_sec_edu=$_POST["cmb_sec_edu"];
			$dir=arregla_pa_guardar($_POST["txt_dir"]);
			$obs=arregla_pa_guardar($_POST["txt_obs"]);
			$fecha_g=date("Y-m-d H:i:s");			
			if (empty($_POST["chk_act"])){
				$activa=false;
			} else {
				$activa=true;
			}

			include_once("../funciones/conexion.php");
			$conexion=conectarse();
			$consulta_sql=mysql_query("insert into instituciones (cod_plantel,den_plantel,den_plantel_corta,email,id_poblado,id_dis_esc,id_tip_ins,id_sector_educ,direccion_detalle,fecha_creada,observaciones,activa,guardado_por,fecha_g) values 
			('$cod_pla',
			'$den_pla',
			'$den_pla_abr',
			'$email',
			'$id_pob',
			'$dis_esc',
			'$tip_pla',
			'$cod_sec_edu',
			'$dir',
			'$fec_cre',
			'$obs',
			'$activa',
			'".$_SESSION["id_usuario"]."',
			'$fecha_g'
			)",$conexion);
			if (!$consulta_sql){
				  $error=obtener_error(mysql_errno($conexion));
					$botones= mostrar_btn_imp_reg();
					mostrar_box("err",false,"INFORMACIÓN","No se pudo guardar los datos del plantel en la base de datos: <br>".$error);	
					echo mostrar_btn_imp_reg();
					}		else {
						$_SESSION["msg"]="Los datos del plantel se guardaron correctamente, ahora puede agregar los telefonos y emails";
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