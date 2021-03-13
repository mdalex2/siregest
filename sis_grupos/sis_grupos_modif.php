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
			$cod_sis_grupos_ant=$_POST["txt_id_ant"];
			$id_grupo=$_POST["txt_cod"];
			$sis_grupo=$_POST["txt_sis_grupos"];
			$notas=trans_texto($_SESSION['nombre_usuario'].formato_fecha("LH",$fecha_g=date("Y-m-d H:i:s")),"MA");
			if (empty($_POST["chk_act"])){
				$visible=false;
			} else {
				$visible=true;
			}
			
			include_once("../funciones/conexion.php");
			$conexion=conectarse();
			//inicio la transanccion
			$consulta_sql=mysql_query("update sis_grupos set 						 			id_grupo='$id_grupo',
			nombre_grupo_usuario='$sis_grupo',
			notas='$notas',
			visible='$visible' 
			where id_grupo='$cod_sis_grupos_ant'",$conexion);
			if (!$consulta_sql){
				  $error=obtener_error(mysql_errno($conexion));
					mostrar_box("err",true,"INFORMACIÓN","No se pudo modificar el grupo de usuario: ".$error);
					echo mostrar_btn_imp_reg();
					}		else {
						$_SESSION["msg"]="Los datos del grupo de usuario se modificaron correctamente";
						$url="sis_grupos.php?id_func=".$_GET['id_func']."&accion=mostrar&id_mos=".$id_grupo;
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