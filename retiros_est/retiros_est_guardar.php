<!DOCTYPE HTML>
<html>
<head>
<!-- Meta -->
<meta http-equiv="Content-Type" content="text/html; charset=<?php if (isset($_SESSION['juego_caracteres'])) echo $_SESSION['juego_caracteres']; else echo "utf-8";//esta variable se declara en modulo verificar login?>">
</head>
                 
<?php
//echo "<pre>".print_r($_POST)."</pre>";
//exit();
include_once("../funciones/funcionesPHP.php");
function guardar_datos(){
	if (empty($_POST)){ //si no se han recibido datos muestro error
			echo "<h2>No se han recibido datos del retiro del estudiante</h2>";
			mostrar_btn_imp_reg();
		} else {
			//echo "<pre>".print_r($_POST)."</pre>";
			//pongo zona horaria para evitar errores al obtener fecha actual del servidor
			date_default_timezone_set("America/Caracas");
			$id_alum=$_POST["txt_id_per"];
			$cod_anno_esc=$_POST["txt_cod_anno_esc"];
			$cod_plantel=$_POST["txt_cod_plan"];
			$id_seccion=$_POST["txt_cod_sec"];
			$fecha_ret=date("Y-m-d",strtotime($_POST["txt_fecha1"]));
			$motivo_ret=$_POST["txt_mot"];
			$observaciones=$_POST["txt_obs"];
			$fecha_g=date("Y-m-d H:i:s");	
			$id_director=$_POST["cmb_director"];
			if (!empty($_REQUEST["chk_enc"])){
				$dir_encarg="(E)";
			} else {
				$dir_encarg="";
			}			
		  $guardado_usuario=$_SESSION["id_usuario"];

			$sql_ret_alu="INSERT INTO alumn_retiros (id_personal,cod_anno_esc,cod_plantel ,id_seccion,fecha_ret,motivo_retiro,observaciones,guardado_por,fecha_g) VALUES
			 ('$id_alum','$cod_anno_esc','$cod_plantel','$id_seccion','$fecha_ret','$motivo_ret','$observaciones','$guardado_usuario','$fecha_g')";
			//echo $cod_asig[$i]." - ".$chk_cod_mat[$i]."-".$ha[$i]." - ".$hp[$i]." - ".$orden[$i]."<br />";
			$conex=conectarse();
			$cons_ret=mysql_query($sql_ret_alu,$conex);
			$error_mysql=mysql_errno($conex);
			if ($cons_ret){
				$url="<a href=\"constancia_retiro_planilla.php?id_per=$id_alum&cod_plan=$cod_plantel&cod_anno_esc=$cod_anno_esc&id_dir=$id_director&dir_enc=$dir_encarg&id_secc=$id_seccion\" class='fancybox.iframe resize'> haga clic aqu&iacute;</a>";
				mostrar_box("inf",false,"Notificaci&oacute;n","El retiro del estudiante se proces&oacute; satisfactoriamente, si desea ver la constancia de retiro <b>$url</b>");
			} else {
				if ($error_mysql=1062){
					mostrar_box("exc",false,"Estudiante ya retirado","Para el periodo $cod_anno_esc, el estudiante ya se encuentra retirado, puede generar la constancia de retiro a trav&eacute;s de la opci&oacute;n \"Consultar retiro\" en el panel de la izquierda");
					echo mostrar_btn_imp_reg();
				} else {
				$error=obtener_error(mysql_errno($conex));
				mostrar_box("exc",false,"Retiro no registrado","El retiro del estudiante no se pudo realizar: ".$error);
				echo mostrar_btn_imp_reg();
			} // fin de si no era error 1062
			} //fin else consulta retiro
} // fin de si no es empty el post
} // fin funcion
?>
</html>