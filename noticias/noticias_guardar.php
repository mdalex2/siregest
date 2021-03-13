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
			$id_noticia=date("dmYhms");
			date_default_timezone_set("America/Caracas");
			$titulo=$_POST["txt_tit"];
			$contenido=$_POST["txt_con"];
			if (empty($_POST["chk_act"])){
				$visible=false;
			} else {
				$visible=true;
			}
			$fecha_g=date("Y-m-d H:i:s");	 //fecha para guardar a mysql		
	
			include_once("../funciones/conexion.php");
			$conexion=conectarse();
			$consulta_sql=mysql_query("insert into noticias ( 	id_noticia,titulo,contenido,visible,fecha_publicacion,id_usuario_not) values 
			('$id_noticia',
			'$titulo',
			'$contenido',
			'$visible',
			'$fecha_g',
			'".$_SESSION["id_usuario"]."'
			)",$conexion);
			if (!$consulta_sql){
				  $error=obtener_error(mysql_errno($conexion));
					mostrar_box("err",false,"INFORMACIÓN","No se pudo crear la noticia: <br>".$error);	
					echo mostrar_btn_imp_reg();
					}		else {
						$_SESSION["msg"]="La noticia se public&oacute; correctamente";
						$url="noticias.php?id_func=".$_GET['id_func']."&accion=mostrar&id_mos=".$id_noticia;
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