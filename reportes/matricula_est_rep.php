<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php session_start();echo $_SESSION['juego_caracteres'];//esta variable se declara en modulo verificar login?>"/>
    <?PHP
    $format_utf8=false;
		if (!empty($_POST["chk_des"])){
			$format_utf8=true;
			
    header("Pragma: public"); // required
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Cache-Control: private",false); // required for certain browsers
    header("Content-Type: application/msword; charset=utf-8");
    header("Content-Disposition: attachment; filename=\""."matricula.doc"."\"; charset=utf-8;" );
    //header("Content-Transfer-Encoding: binary");
	
		}
		
    ?>
<title>Reporte de matr&iacute;cula estudiantil</title>
<style type="text/css">
.margenes td{
padding-left: 3px;
padding-right: 3px;
}
.titulo {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 15px;
	text-transform: uppercase;
	font-weight: bold;
	margin-bottom: 2px;
	text-align: left;
}
.SaltoDePagina {
PAGE-BREAK-AFTER: always
}
.cursiva {
	font-style: italic;
	font-weight: bold;
}
.cursiva {
	font-style: italic;
}
</style>
</head>

<body style="font-family: Arial, Helvetica, sans-serif; font-size: 11px;">

<?php
function encabezado_pag(){
	
	?>
<table width="100%" border="0">
  <tr>
    <td><img src="../images/sistema/barra_me3.png" width="100%"/></td>
    <td><img src="../images/sistema/corazon_vzlano_peq.png" width="79" height="74" /></td>
  </tr>
</table>
<?php
}
?>
<?php
if (empty($_POST["chk_des"])){
?>
<table id="tb" width="100%" border="0" align="center">
  <tr>
    <td width="30%"></td>
    <td width="40%" align="center">
<script type="text/javascript">
function imprimir()
	{
		//var Obj = document.getElementById("imprimir");
		//var Obj1 = document.getElementById("cerrar");
		var Obj2 = document.getElementById("tb");
		Obj2.style.display='none';
		 window.print();
		Obj2.style.display = 'table';
	}
</script>
<button type="button" name="imprimir" id="imprimir" value="Imprimir" onclick="imprimir();"><img src="../images/icons_menu/x32/printer2_x32.png" width="24" height="24" align="absmiddle" />&nbsp;Imprimir</button>
&nbsp;
<button type="button" name="cerrar" id="cerrar" value="Imprimir" onclick="window.close();"><img src="../images/sistema/close_windows.png" width="24" height="24" align="absmiddle" />&nbsp;Cerrar</button>
</td>
    <td width="30%" align="center"></td>
  </tr>
  
</table>
<?php
}
?>
<body style="font-family: Arial, Helvetica, sans-serif; font-size: 11px;">
<?php

include_once("../funciones/funcionesPHP.php");
if (empty($_POST["cmb_anno_esc"]) || empty($_POST["cmb_plan"])){
	echo "<br><h1 align=\"center\">No se recibieron los datos a mostrar</h1>";
} else {
	//$id_seccion=$_POST["cmb_secc"];
	//$cod_asig=$_POST["cmb_asig"];
	//$cod_grado=$_POST["cmb_gra"];
	$cod_anno_esc=$_POST["cmb_anno_esc"];
	$cod_plantel=$_POST["cmb_plan"];
		$fecha_desde=date("d-m-Y",strtotime($_POST["fecha_desde"]));
		$fecha_hasta=date("d-m-Y",strtotime($_POST["fecha_hasta"]));
	
	//obtengo los datos del plantel
	$con_plantel=ejecuta_sql("SELECT instituciones.den_plantel,instituciones.email,terr_poblados.poblado,terr_municipios.municipio,terr_estados.estado_ter,terr_parroquias.parroquia,tip_ins.tip_ins,sectores_educ.sector_educ FROM (instituciones 
	INNER JOIN terr_poblados ON instituciones.id_poblado=terr_poblados.id_poblado
	INNER JOIN terr_estados ON terr_poblados.cod_estado_ter=terr_estados.cod_estado_ter
	INNER JOIN terr_municipios ON 	terr_municipios.cod_municipio=terr_poblados.cod_municipio and terr_municipios.cod_estado_ter=terr_estados.cod_estado_ter
	INNER JOIN terr_parroquias ON terr_parroquias.cod_parroquia=terr_poblados.cod_parroquia AND terr_parroquias.cod_estado_ter=terr_estados.cod_estado_ter AND terr_municipios.id_municipio=terr_parroquias.id_municipio 
	INNER JOIN tip_ins ON tip_ins.id_tip_ins=instituciones.id_tip_ins
	INNER JOIN sectores_educ on sectores_educ.id_sector_educ=instituciones.id_sector_educ
) 
	WHERE 
	cod_plantel='$cod_plantel'",false);
	if ($con_plantel){
		$fil_plantel=mysql_fetch_array($con_plantel);
		/*if($format_utf8==false) {
			$nombre_plantel=strtoupper($fil_plantel["den_plantel"]);
			$edo_plantel=strtoupper($fil_plantel["estado_ter"]);
			$poblado_plantel=strtoupper($fil_plantel["poblado"]);
			$parroquia=strtoupper($fil_plantel["parroquia"]);
			$municipio=strtoupper($fil_plantel["municipio"]);
			$tip_ins=strtoupper($fil_plantel["tip_ins"]);
			$sector_educ=strtoupper($fil_plantel["sector_educ"]);
			$email=$fil_plantel["email"];	
			/*		
		} else {
		*/
		$nombre_plantel=trans_texto($fil_plantel["den_plantel"],"MA");
			$edo_plantel=trans_texto($fil_plantel["estado_ter"],"MA");
			$poblado_plantel=trans_texto($fil_plantel["poblado"],"MA");
			$parroquia=trans_texto($fil_plantel["parroquia"],"MA");
			$municipio=trans_texto($fil_plantel["municipio"],"MA");
			$tip_ins=trans_texto($fil_plantel["tip_ins"],"MA");
			$sector_educ=trans_texto($fil_plantel["sector_educ"],"MA");
			$email=($fil_plantel["email"]);			
			//}
		if (empty($_POST["chk_des"])){echo encabezado_pag();}
		
?>
<table width="100%" border="0">
  <tr>
    <td colspan="3" align="left"><span class="titulo">RESUMEN ESTADISTICO MENSUAL</span></td>
    <td scope="col" align="left"><strong><span class="titulo">A&Ntilde;O ESCOLAR:<?php echo $cod_anno_esc;?></span></strong></td>
  </tr>
  <tr>
    <td scope="col"><strong>PLANTEL: </strong><?php echo $nombre_plantel;?></td>
    <td colspan="2" scope="col"><strong>C&Oacute;DIGO ESTADISTICO:</strong> 141013</td>
    <td scope="col"><strong>C&Oacute;DIGO DEA:</strong> <?php echo $cod_plantel;?></td>
  </tr>
  <tr>
    <td scope="col"><strong>DEPENDENCIA:</strong> <?php echo $tip_ins;?></td>
    <td scope="col"><strong>TURNO:</strong></td>
    <td scope="col"><strong>TELEFONO:</strong></td>
    <td scope="col"><strong>E-MAIL:</strong> <?php echo $email;?></td>
  </tr>
  <tr>
    <td scope="col"><strong>UBICACION:</strong> <?php echo $sector_educ;?></td>
    <td colspan="2" scope="col"><strong>PARROQUIA:</strong> <?php $parroquia;?></td>
    <td scope="col"><strong>MUNICIPIO:</strong> <?php echo $municipio;?></td>
  </tr>
  <tr>
    <td colspan="2" scope="col"><strong>RESUMEN DESDE: </strong> <?php echo $fecha_desde;?> <strong>HASTA: </strong> <?php echo $fecha_hasta;?></td>
    <td scope="col" align="left"><strong>DIAS HABILES LABORADOS:</strong>	</td>
    <td scope="col"><strong>DIAS LABORADOS CON ESTUDIANTES:</strong> </td>
  </tr>
</table>

<?php
	} // FIN DE SI HUBO CONSULTA DE PLANTEL
?>
<center><span class="titulo">MATRICULA GENERAL DEL SUBSISTEMA EDUCATIVO</span></center>
<table width="100%" border="1" cellpadding="0" cellspacing="1" bordercolor="#000000" style="border-collapse: collapse;font-weight: normal; text-transform:uppercase;" class="margenes">
  <tr>
    <td rowspan="2" scope="col"><strong>A&Ntilde;O/GRADO</strong></td>
    <td colspan="3" scope="col" align="center"><strong>MATRICULA INICIAL</strong></td>
    <td colspan="3" scope="col" align="center"><strong>INGRESO (RANGO)</strong></td>
    <td colspan="3" scope="col" align="center"><strong>EGRESOS (RANGO)</strong></td>
    <td colspan="3" scope="col" align="center"><strong>MATRICULA ACTUAL</strong></td>
    <td width="10%" rowspan="2" align="center" scope="col"><strong>N&deg; DE SECCIONES</strong></td>
  </tr>
  <tr>
    <td align="center" style="text-align: center" scope="col" width="5%"><strong>V</strong></td>
    <td align="center" style="text-align: center" scope="col"  width="5%"><strong>H</strong></td>
    <td align="center" style="text-align: center" scope="col"  width="10%"><strong>TOTAL</strong></td>
    <td style="text-align: center" scope="col"  width="5%"><strong>V</strong></td>
    <td style="text-align: center" scope="col"  width="5%"><strong>H</strong></td>
    <td style="text-align: center" scope="col" width="10%"><strong>TOTAL</strong></td>
    <td style="text-align: center" scope="col"  width="5%"><strong>V</strong></td>
    <td style="text-align: center" scope="col"  width="5%"><strong>H</strong></td>
    <td style="text-align: center" scope="col" width="10%"><strong>TOTAL</strong></td>
    <td style="text-align: center" scope="col"  width="5%"><strong>V</strong></td>
    <td style="text-align: center" scope="col"  width="5%"><strong>H</strong></td>
    <td style="text-align: center" scope="col" width="10%"><strong>TOTAL</strong></td>
  </tr>
  <?php
	$sql_grados="SELECT DISTINCT alum_insc_notas.cod_grado,grados_esc.grado_corto,grados_esc.grado_letras FROM (
	alum_insc_notas 
	INNER JOIN grados_esc ON grados_esc.cod_grado=alum_insc_notas.cod_grado
	) WHERE 
	alum_insc_notas.cod_plantel_proc='$cod_plantel'
	AND alum_insc_notas.cod_anno_esc='$cod_anno_esc'
	ORDER BY grados_esc.orden ASC";
	$cons_grados=ejecuta_sql($sql_grados,false);
	if ($cons_grados) {
	
	while ($fil_grados=mysql_fetch_array($cons_grados)){
		$cod_grado=$fil_grados["cod_grado"];
		$grado_corto=($fil_grados["grado_corto"]);
		$grado_letras=($fil_grados["grado_letras"]);
		$fecha_desde=date("d-m-Y",strtotime($_POST["fecha_desde"]));
		$fecha_hasta=date("d-m-Y",strtotime($_POST["fecha_hasta"]));
		$arraymat=obten_matr_inic_ingr($cod_plantel,$cod_anno_esc,$cod_grado,$fecha_desde,$fecha_hasta);
		$arraysecc=obten_num_secc($cod_plantel,$cod_anno_esc,$cod_grado);
		
		$arrayegre=obten_egresos($cod_plantel,$cod_anno_esc,$cod_grado,$fecha_desde,$fecha_hasta);
	?>
  <tr>
    <td scope="col"><?php echo $grado_letras;?></td>
    <td align="center" style="text-align: center" scope="col"><?php echo pon_cero_izq($arraymat["MIV"],2);?></td>
    <td align="center" style="text-align: center" scope="col"><?php echo pon_cero_izq($arraymat["MIH"],2);?></td>
    <td align="center" style="text-align: center" scope="col"><?php echo pon_cero_izq($arraymat["MIT"],2);?></td>
    <td style="text-align: center" scope="col"><?php echo pon_cero_izq($arraymat["MINV"],2);?></td>
    <td style="text-align: center" scope="col"><?php echo pon_cero_izq($arraymat["MINH"],2);?></td>
    <td style="text-align: center" scope="col"><?php echo pon_cero_izq($arraymat["MINT"],2);?></td>
    <td style="text-align: center" scope="col"><?php echo pon_cero_izq($arrayegre["EFV"],2);?></td>
    <td style="text-align: center" scope="col"><?php echo pon_cero_izq($arrayegre["EFH"],2);?></td>
    <td style="text-align: center" scope="col"><?php echo pon_cero_izq($arrayegre["EFT"],2);?></td>
    <td style="text-align: center" scope="col"><?php echo pon_cero_izq($arraymat["MIV"]-$arrayegre["ETV"],2);?></td>
    <td style="text-align: center" scope="col"><?php echo pon_cero_izq($arraymat["MIH"]-$arrayegre["ETH"],2);?></td>
    <td style="text-align: center" scope="col"><?php echo pon_cero_izq($arraymat["MIT"]-$arrayegre["ETT"],2);?></td>
    <td style="text-align: center" scope="col"><?php 
		echo pon_cero_izq($arraysecc["total"],2).": (";
		$limite=$arraysecc["total"];
		//echo "cant: $limite";
		for($i=0;$i<=$limite;$i++){
  	//mas sentencias...
		echo $arraysecc["letras"][$i];
		if ($i<$limite-1 and $limite!=1){
				echo ",";
		}
		}
		echo ")";
		?></td>
  </tr>
  <?PHP
}//fin while grados
} // fin de si hubo consulta de grado
	?>
</table>
<?php
// ----- BUSCO DATOS DE DIRECTOR(A) ----
	$id_director=$_POST["cmb_director"];
	$sql_director="SELECT datos_per.nombres,
	datos_per.apellidos,sexo,
	tip_doc_per.tipo_doc,
	tip_doc_per.tipo_doc_abr,
	tip_doc_per.poner_num,
	tip_doc_per.separador,
	tip_doc_per.num_con_punto,
	datos_per.num_identificacion
	FROM (datos_per
	INNER JOIN tip_doc_per ON tip_doc_per.cod_tip_doc_per=datos_per.cod_tip_doc_per
) 
	WHERE 
	id_personal='$id_director' LIMIT 1";
	$cons_director=ejecuta_sql($sql_director,false);
	if ($cons_director){
		$fila_direct=mysql_fetch_array($cons_director);
		$num_id_per=$fila_direct["num_identificacion"];
		$tipo_doc_abr=$fila_direct["tipo_doc_abr"];
		$poner_num=$fila_direct["poner_num"];
		$separador=$fila_direct["separador"];
		$num_con_punto=$fila_direct["num_con_punto"];

		$nombre_director=(ucwords(strtolower($fila_direct["nombres"])));
		$apellido_director=(ucwords(strtolower($fila_direct["apellidos"])));
		if ($fila_direct["sexo"]=="M"){ 
			$genero_direct=" Director ";
		} else {
			$genero_direct=" Directora ";
		}
	}
?>
<?php	
} // fin de si se recibió el año escolar y plantel
?>
<BR /><BR /><BR />
<table width="100%" border="0">
  <tr>
    <th scope="col" width="30%" align="left">IMPRESO POR: <?php 
		date_default_timezone_set("America/Caracas");
		echo ($_SESSION["nombre_usuario"]);
		echo " / ".date("d-m-Y h:m a");
		
		?></th>
    <th scope="col" >&nbsp;</th>
    <th scope="col" width="30%" style="border-top:1px solid black;"><?php 
		echo strtoupper($nombre_director." ".$apellido_director)."<br>";
		echo formatear_id_personal($num_id_per,$tipo_doc_abr,$poner_num,$separador,$num_con_punto)."<br>";
		echo strtoupper($genero_direct);
		?></th>
  </tr>
</table>
</body>
<?php
// esta funcion obtiene la cantidad de alumnos
// ingresados y matricula inicial
function obten_matr_inic_ingr($cod_plantel,$cod_anno_esc,$cod_grado,$fecha_desde,$fecha_hasta){
	$arr_matricula="";
	$arr_matricula["MIV"]=0;
	$arr_matricula["MIH"]=0;
	$arr_matricula["MIT"]=0;
	$arr_matricula["MINV"]=0;
	$arr_matricula["MINH"]=0;
	$arr_matricula["MINT"]=0;
	$sql_matric="SELECT DISTINCT alum_insc_notas.id_personal,fecha_inscrip,datos_per.sexo,datos_per.fecha_nac FROM (
	alum_insc_notas 
	INNER JOIN datos_per ON datos_per.id_personal=alum_insc_notas.id_personal
	) WHERE 
	alum_insc_notas.cod_plantel_proc='$cod_plantel'
	AND alum_insc_notas.cod_anno_esc='$cod_anno_esc'
	AND alum_insc_notas.cod_grado='$cod_grado' 
	ORDER BY fecha_nac ASC";
	$cons_matric=ejecuta_sql($sql_matric,false);
	if ($cons_matric) {
	while ($fil_matr=mysql_fetch_array($cons_matric)){
		$fecha_ing=date("d-m-Y",strtotime($fil_matr["fecha_inscrip"]));
		$fecha_nac=date("d-m-Y",strtotime($fil_matr["fecha_nac"]));
		//calculo matricula inicial
		$sexo=$fil_matr["sexo"];
		if (strtoupper($sexo)=="M"){
			$arr_matricula["MIV"]++;
		} else {
			$arr_matricula["MIH"]++;
		}
		$arr_matricula["MIT"]=$arr_matricula["MIV"]+$arr_matricula["MIH"];
		//VERIFICO SI HUBO INGRESOS EN LAS FECHAS SELECCIONADAS Y CALCULO ESOS TOTALES
		if ($fecha_ing>=$fecha_desde AND $fecha_ing<=$fecha_hasta){
		if (strtoupper($sexo)=="M"){
			$arr_matricula["MINV"]++;
		} else {
			$arr_matricula["MINH"]++;
		} // fin else sexo F
		$arr_matricula["MINT"]=$arr_matricula["MINV"]+$arr_matricula["MINH"];
		} // fin if fecha ingreso esta dentro del rango consultado
		
		//calculo cuantos alumnos por edad
		
	} // fin while
	} // fin si consulta matricula
	return $arr_matricula;
} // fin funcion
?>

<?php
// ESTA FUNCION OBTIENE EL NUMERO TOTAL DE SECCIONES
function obten_num_secc($cod_plantel,$cod_anno_esc,$cod_grado){
	$arr_secc="";
	$arr_secc["total"]=0;
	$arr_secc["letras"]="";
	$sql_secc="SELECT DISTINCT alum_insc_notas.id_seccion,inst_secciones.seccion_corto  FROM (
	alum_insc_notas 
	INNER JOIN inst_secciones ON inst_secciones.id_seccion=alum_insc_notas.id_seccion
	) WHERE 
	alum_insc_notas.cod_plantel_proc='$cod_plantel'
	AND alum_insc_notas.cod_anno_esc='$cod_anno_esc'
	AND alum_insc_notas.cod_grado='$cod_grado' 
	ORDER BY inst_secciones.seccion_corto ASC";
	$cons_secc=ejecuta_sql($sql_secc,true);
	if ($cons_secc) {
	while ($fil_secc=mysql_fetch_array($cons_secc)){
		//calculo cuantos alumnos por edad
		$arr_secc["total"]++;
		$arr_secc["letras"].=$fil_secc["seccion_corto"];
		
	} // fin while
	} // fin si consulta matricula
	return $arr_secc;	
}
?>
<?php
function obten_egresos($cod_plantel,$cod_anno_esc,$cod_grado,$fecha_desde,$fecha_hasta){
	// esta funcion obtiene la cantifad de alumnos
   // ingresados y matricula inicial
	$arr_egresos="";
	$arr_egresos["EFV"]=0;
	$arr_egresos["EFH"]=0;
	$arr_egresos["EFT"]=0;
	$arr_egresos["ETV"]=0;
	$arr_egresos["ETH"]=0;
	$arr_egresos["ETT"]=0;
	$sql_egre="SELECT DISTINCT alumn_retiros.id_personal,fecha_ret,inst_secciones.cod_grado,datos_per.sexo FROM (
	alumn_retiros 
	INNER JOIN datos_per ON datos_per.id_personal=alumn_retiros.id_personal
	INNER JOIN inst_secciones ON inst_secciones.id_seccion=alumn_retiros.id_seccion
	) WHERE 
	alumn_retiros.cod_plantel='$cod_plantel'
	AND alumn_retiros.cod_anno_esc='$cod_anno_esc' 
	ORDER BY fecha_ret ASC";
	$cons_egre=ejecuta_sql($sql_egre,false);
	if ($cons_egre) {
	while ($fil_egre=mysql_fetch_array($cons_egre)){
		$fecha_egre=date("d-m-Y",strtotime($fil_egre["fecha_ret"]));
		//calculo matricula inicial
		$sexo=$fil_egre["sexo"];
		$cod_grado_egre=$fil_egre["cod_grado"];
		if ($cod_grado==$cod_grado_egre){
		if (strtoupper($sexo)=="F"){
			$arr_egresos["ETH"]++;
		} else {
			$arr_egresos["ETV"]++;
		}
		$arr_egresos["ETT"]=$arr_egresos["ETV"]+$arr_egresos["ETH"];
		//VERIFICO SI HUBO INGRESOS EN LAS FECHAS SELECCIONADAS Y CALCULO ESOS TOTALES
		if ($fecha_egre>=$fecha_desde AND $fecha_egre<=$fecha_hasta){
		if (strtoupper($sexo)=="F"){
			$arr_egresos["EFH"]++;
		} else {
			$arr_egresos["EFV"]++;
		} // fin else sexo F
		$arr_egresos["EFT"]=$arr_egresos["EFV"]+$arr_egresos["EFH"];
		} // fin if fecha ingreso esta dentro del rango consultado
		} // fin de si el grado es el mismo que estoy consultando fuera de la funcion
		//calculo cuantos alumnos por edad
		
	} // fin while
	} // fin si consulta matricula
	return $arr_egresos;
} // fin funcion
?>
</html>

