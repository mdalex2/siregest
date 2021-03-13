<!DOCTYPE HTML>
<html>
<head>
<!-- Meta -->
<meta http-equiv="Content-Type" content="text/html; charset=<?php if (isset($_SESSION['juego_caracteres'])) echo $_SESSION['juego_caracteres']; else echo "utf-8";//esta variable se declara en modulo verificar login?>">
</head>
                 
<?php

function guardar_datos(){
	if (empty($_POST)){ //si no se han recibido datos muestro error
			echo "<h2>No se han recibido datos para guardar</h2>";
			mostrar_btn_imp_reg();
		} else {
			//pongo zona horaria para evitar errores al obtener fecha actual del servidor
			date_default_timezone_set("America/Caracas");
			$id_usuario=$_POST["cmb_tip_doc"]."_".$_POST["txt_num_ced"];
			$cod_gru_usu=$_POST["cmb_gru_usu"];
			$login=$_POST["txt_log"];
			$pwd=$_POST["txt_pwd"];
			$observaciones=$_POST["txt_obs"];
			if (!empty($_POST["chk_usu_bloq"])){
				$usu_bloq=1;}
			else
				{$usu_bloq=0;}
			$fecha_g=date("Y-m-d h:i");			
			//para la foto
			include_once("../funciones/conexion.php");
			$conexion=conectarse();
			$consulta_sql=mysql_query("INSERT into usuarios (id_usuario,id_grupo_cuenta,login,clave,bloqueado,observaciones,fecha_g,guardado_por) values 
			('$id_usuario',
			'$cod_gru_usu',
			'$login',
			AES_ENCRYPT($pwd,$pwd),
			$usu_bloq,
			'$observaciones',
			'$fecha_g',
			'".$_SESSION["id_usuario"]."'			
			)",$conexion);
			if (!$consulta_sql){
				  $error=obtener_error(mysql_errno());
					$botones= mostrar_btn_imp_reg();
					mostrar_box("err",false,"INFORMACIÓN","No se pudo crear el usuario: <br>".$error);	
					echo mostrar_btn_imp_reg();
					}		else {
						$_SESSION["msg"]="Usuario creado correctamente";
						$url="usuarios.php?id_func=".$_GET['id_func']."&accion=mostrar&id_per=".$id_usuario;
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