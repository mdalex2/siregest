<?php
session_start();
include_once("../funciones/funcionesPHP.php");
include_once("../funciones/conexion.php");
 if(!empty($_POST['campos'])) {
  $aLista=array_keys($_POST['campos']);
  $sql_query="DELETE FROM sis_funciones where id_func IN ('".implode("','",$aLista)."')";
	$conex=conectarse();
	$resultado=mysql_query($sql_query,$conex);
	if (!$resultado){
		$_SESSION["titulo_msg"]="INFORMACIÓN";
		$_SESSION["error"]=utf8_encode("Se produjo un evento al eliminar los registros. Información técnica:".mysql_error());
		header("location:../controlador/msgs_menu.php");
	} else {
		if (isset($_SESSION["array_permisos"])){
			$array_permisos=$_SESSION["array_permisos"]; //vuelvo a asignar la 		
			echo "
        <script language='JavaScript'>
        	alert('Los registros seleccionados se han eliminado de la base de datos');
					location.href='".$_SERVER['HTTP_REFERER']."';
        </script>"; 
			//header("location:".$_SERVER['HTTP_REFERER']);
			//mostrar_box("inf",false,"Eliminar multiples funciones","Se han eliminado las funciones con id numero: (".implode(',',$aLista).")");
			} else {
				header("location:../acceso_sis/menu_principal.php");
			}
			
			
			
	}
 }
 ?>
