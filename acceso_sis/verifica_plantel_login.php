<?php
function verifica_plantel(){
  if (isset($_SESSION['id_grupo_usuario']) && ($_SESSION['id_grupo_usuario']=="G0001")){
	header("Location:../acceso_sis/selecciona_plantel.php");
} else
	$sql_plantel="select usuario_plantel.cod_plantel,instituciones.den_plantel,instituciones.den_plantel_corta,instituciones.id_sector_educ from (usuario_plantel
	INNER JOIN instituciones ON usuario_plantel.cod_plantel=instituciones.cod_plantel) 
	 where id_personal='".$_SESSION['id_usuario']."'";
	$registros=ejecuta_sql($sql_plantel,true);
	if ($registros) {
		if (mysql_num_rows($registros)>1){
			header("location:../acceso_sis/selecciona_plantel.php");
			exit();
		} else {
			$array=mysql_fetch_array($registros);
			$_SESSION["cod_plantel_ses"]=trans_texto($array["cod_plantel"],"MA");
			$_SESSION["nom_plantel_ses"]=trans_texto($array["den_plantel"],"MA");
			$_SESSION["nom_plantel_corta_ses"]=trans_texto($array["den_plantel_corta"],"MA");
			$_SESSION["sess_id_sector_educ"]=$array["id_sector_educ"];
			return true;
		}
	} // fin si hay registros
	else {
		return false;
		}
}//fin de la funcion
?>