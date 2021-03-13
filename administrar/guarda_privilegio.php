<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Establecer privilegio</title>
</head>

<body>
<?php
	echo strtoupper("<h2>Página que almacena los privilegios</h2>");
	//echo $_POST["tot_reg"];
if(!empty($_POST['txt_id_grupo'])){
$error=false;
include_once("../funciones/conexion.php");
$conex=conectarse();
mysql_query("BEGIN",$conex);

$id_func=$_POST["txt_id_func"];
    for($j = 0; $j < count($_POST['txt_id_grupo']); $j++){
        //$sql = "INSERT INTO tbl_quiera_asistir_a (id_evento) VALUES (". $_POST['eleccion'][$j] .")";
				$id_gru_usu=$_POST['txt_id_grupo'][$j];
				$id_privileg=$id_func.$id_gru_usu;
				if (!empty($_POST['mostrar'.$id_gru_usu])){
					$mostrar=1;
				} else {
					$mostrar=0;
				}
				if (!empty($_POST['crear'.$id_gru_usu])){
					$crear=1;
				} else {
					$crear=0;
				}
				if (!empty($_POST['editar'.$id_gru_usu])){
					$editar=1;
				} else {
					$editar=0;
				}
				if (!empty($_POST['eliminar'.$id_gru_usu])){
					$eliminar=1;
				} else {
					$eliminar=0;
				}		
				if (!empty($_POST['imprimir'.$id_gru_usu])){
					$imprimir=1;
				} else {
					$imprimir=0;
				}	
				if (!empty($_POST['exportar'.$id_gru_usu])){
					$exportar=1;
				} else {
					$exportar=0;
				}
				if (!empty($_POST['otro'.$id_gru_usu])){
					$otro=1;
				} else {
					$otro=0;
				}	
				/*												
        echo " - mostrar: ".$_POST["txt_id_grupo"][$j]." mostrar: ".$mostrar;//completar el codigo grabar en la bd Mysql
				echo " - crear:    - ".$crear;
				echo " - editar:   - ".$editar;
				echo " - eliminar: - ".$eliminar;				
				echo " - imprimir: - ".$imprimir;
				echo " - exportar: - ".$exportar;				
				echo " - otro:     - ".$otro;
				echo "<br />";
				*/
				//comienzo la transancción
				//elimino todos los privilegios del grupo usuario viejo
				$sql_elim="delete from sis_priv_grup where id_func='".$id_func."' and id_grupo='".$id_gru_usu."'";
				//echo $sql_elim."<br>";
				$resultado=mysql_query($sql_elim,$conex);
				if (!$resultado) {
					$error=true;
					$msg_error[]=mysql_error();
				}
				
				$sql_guardar="insert into sis_priv_grup (id_privilegio,id_func,id_grupo,mostrar,crear,editar,eliminar,imprimir,exportar,otro) values 
				('$id_privileg','$id_func','$id_gru_usu',$mostrar,$crear,$editar,$eliminar,$imprimir,$exportar,$otro)";
				if (!mysql_query($sql_guardar,$conex)) {
					$error=true;
					$msg_error[]=mysql_error();
				}
				
    }
}
if($error==true) {
mysql_query("ROLLBACK",$conex);
echo "No se establecieron los privilegios de acceso:<pre>";
print_r($msg_error);
echo "</pre>";

} else {
mysql_query("COMMIT",$conex);
echo "Los privilegios se establecieron con &eacute;xito";
}
?>

</body>
</html>