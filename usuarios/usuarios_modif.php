<!DOCTYPE HTML>
<html>
<head>
<!-- Meta -->
<meta http-equiv="Content-Type" content="text/html; charset=<?php if (isset($_SESSION['juego_caracteres'])) echo $_SESSION['juego_caracteres']; else echo "utf-8";//esta variable se declara en modulo verificar login?>">
</head>
                 
<?php
function modif_datos(){
	if (empty($_POST)){ //si no se han recibido datos muestro error
			echo "<h2>No se han recibido los datos para mod&iacute;ficar</h2>";
		} else {
			$id_per_anterior=$_POST["id_personal"];
			$cod_gru_usu=$_POST["cmb_gru_usu"];
			$login=$_POST["txt_log"];
			$pwd=$_POST["txt_pwd"];
			$observaciones=$_POST["txt_obs"];
			if (!empty($_POST["chk_usu_bloq"])){
				$usu_bloq=1;}
			else
				{$usu_bloq=0;}
			if (!empty($_POST["chk_cam_pwd"])){
				$camb_pwd=1;}
			else
				{$camb_pwd=0;}
				
			$fecha_g=fecha_actual("mysql");
			include_once("../funciones/conexion.php");
			$conexion=conectarse();
			//si variable de cambiar clave==true ejecuto el cambio de password de lo contrario solo modifico los demas datos sin encrytacion
			if ($camb_pwd==1){
			$consulta_sql=mysql_query("update usuarios set 
			id_grupo_cuenta='$cod_gru_usu',
			login='$login',
			clave=AES_ENCRYPT($pwd,$pwd),
			bloqueado='$usu_bloq',
			observaciones='$observaciones',
			guardado_por='".$_SESSION["id_usuario"]."',
			fecha_g	='$fecha_g' 
			where id_usuario='$id_per_anterior'",$conexion);
			} else {
				$consulta_sql=mysql_query("update usuarios set 
			id_grupo_cuenta='$cod_gru_usu',
			login='$login',
			bloqueado='$usu_bloq',
			observaciones='$observaciones',
			guardado_por='".$_SESSION["id_usuario"]."',
			fecha_g	='$fecha_g' 
			where id_usuario='$id_per_anterior'",$conexion);				
			}
			if (!$consulta_sql){
					mostrar_box("err",true,"INFORMACIÓN","No se pudo modificar los datos del usuario: ".mysql_error())." N&deg;: ".mysql_errno();
					echo mostrar_btn_imp_reg();
					}		else {
						$_SESSION["msg"]="Los datos del usuario se modificaron correctamente";
						$url="usuarios.php?id_func=".$_GET['id_func']."&accion=mostrar&id_per=".$id_per_anterior;
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