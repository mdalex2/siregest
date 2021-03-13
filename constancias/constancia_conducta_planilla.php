<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href="../images/sistema/siregest.ico" type="image/x-icon" rel="shortcut icon" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Constancia de estudio</title>
<style type="text/css">
.margenes td{
padding-left: 3px;
padding-right: 3px;
}
.titulo {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 20px;
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
<table id="tb" width="100%" border="0" align="center">
  <tr>
    <td width="30%" ></td>
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
<button type="button" name="cerrar" id="cerrar" value="Imprimir" onclick="parent.$.fancybox.close();"><img src="../images/sistema/close_windows.png" width="24" height="24" align="absmiddle" />&nbsp;Cerrar</button>
</td>
    <td width="30%" align="center"></td>
  </tr>
  
</table>
<?php
if (!empty($_REQUEST["id_per"]) && !empty($_REQUEST["cod_anno_esc"]) && !empty($_REQUEST["id_dir"]) && !empty($_REQUEST["cod_plan"]) && !empty($_REQUEST["id_secc"])){
	session_start();
	include_once("../funciones/funcionesPHP.php");
	$id_per_alumno=$_REQUEST["id_per"];
	$cod_anno_esc=$_REQUEST["cod_anno_esc"];
	$id_director=$_REQUEST["id_dir"];
	if (!empty($_REQUEST["vl"])){
		$valides=$_REQUEST["vl"];
	 } else {
		$valides=0;
		}
	$cod_plantel=$_REQUEST["cod_plan"];
	$id_seccion=$_REQUEST["id_secc"];
// ----- BUSCO DATOS DE DIRECTOR(A) ----
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
	$cons_director=ejecuta_sql($sql_director,true);
	if ($cons_director){
		$fila_direct=mysql_fetch_array($cons_director);
		$num_id_per=$fila_direct["num_identificacion"];
		$tipo_doc_abr=$fila_direct["tipo_doc_abr"];
		$poner_num=$fila_direct["poner_num"];
		$separador=$fila_direct["separador"];
		$num_con_punto=$fila_direct["num_con_punto"];

		$nombre_director=trans_texto($fila_direct["nombres"],"TI");
		$apellido_director=trans_texto($fila_direct["apellidos"],"TI");
		if ($fila_direct["sexo"]=="M"){ 
			$genero_direct=" Director ";
		} else {
			$genero_direct=" Directora ";
		}
	}
	
	
	
	// --- BUSCO DATOS DEL PLANTEL ----
	$sql_plantel="SELECT instituciones.den_plantel,terr_poblados.poblado,terr_municipios.municipio,terr_estados.estado_ter FROM (instituciones 
	INNER JOIN terr_poblados ON instituciones.id_poblado=terr_poblados.id_poblado
	INNER JOIN terr_estados ON terr_poblados.cod_estado_ter=terr_estados.cod_estado_ter
	INNER JOIN terr_municipios ON 	terr_municipios.cod_municipio=terr_poblados.cod_municipio and terr_municipios.cod_estado_ter=terr_estados.cod_estado_ter
) 
	WHERE 
	cod_plantel='$cod_plantel' LIMIT 1";
	$cons_plantel=ejecuta_sql($sql_plantel,true);
	if ($cons_plantel){
		$fila_plantel=mysql_fetch_array($cons_plantel);
		$nombre_plantel=trans_texto($fila_plantel["den_plantel"],"TI");
		$poblado=trans_texto($fila_plantel["poblado"],"TI");
		$municipio=trans_texto($fila_plantel["municipio"],"TI");
		$estado_terr=trans_texto($fila_plantel["estado_ter"],"TI");
		
	}
// ----- BUSCO DATOS DEL ALUMNO(A) ----
	$sql_alumno="SELECT 
	tip_doc_per.tipo_doc,
	tip_doc_per.tipo_doc_abr,
	tip_doc_per.poner_num,
	tip_doc_per.separador,
	tip_doc_per.num_con_punto,
	datos_per.num_identificacion,
	datos_per.nombres,
	datos_per.apellidos,sexo,
	fecha_nac,lugar_nac,
	terr_estados.estado_ter
	FROM (datos_per
	INNER JOIN tip_doc_per ON tip_doc_per.cod_tip_doc_per=datos_per.cod_tip_doc_per
	INNER JOIN terr_estados ON terr_estados.cod_estado_ter=datos_per.cod_estado_ter
) 
	WHERE 
	id_personal='$id_per_alumno' LIMIT 1";
	$cons_alumnos=ejecuta_sql($sql_alumno,true);
	if ($cons_alumnos){
		$fila_alum=mysql_fetch_array($cons_alumnos);
		$num_id_per=$fila_alum["num_identificacion"];
		$tipo_doc_abr=$fila_alum["tipo_doc_abr"];
		$poner_num=$fila_alum["poner_num"];
		$separador=$fila_alum["separador"];
		$num_con_punto=$fila_alum["num_con_punto"];

		$nombre_alumno=trans_texto($fila_alum["nombres"],"TI");
		$apellido_alumno=trans_texto($fila_alum["apellidos"],"TI");
		if ($fila_alum["sexo"]=="M"){ 
			$genero_alum=" el ";
			$nacidoa=" nacido ";
			$inscritoa=" inscrito ";
		} else {
			$genero_alum=" la ";
			$nacidoa=" nacida ";
			$inscritoa=" inscrita ";
		}
		$fecha_nac_c=date("d-m-Y",strtotime($fila_alum["fecha_nac"]));
		$fecha_nac_larg=formato_fecha("L",$fecha_nac_c);
		$edad_alum=calcular_edad($fecha_nac_c);
		$lugar_nac_alum=trans_texto($fila_alum["lugar_nac"],"TI");
		$estado_nac_alum=trans_texto($fila_alum["estado_ter"],"TI");
		if ($estado_nac_alum=="Extranjero"){
			$estado_nac_alum="";
		} else {
			$estado_nac_alum=" Estado ".$estado_nac_alum;
		}
	}
	
	
// ----- BUSCO DATOS DE LA SECCION) ----
	$sql_seccion="SELECT 
	inst_secciones.seccion_largo,
	grados_esc.grado_letras
	FROM (inst_secciones
	INNER JOIN grados_esc ON grados_esc.cod_grado =inst_secciones.cod_grado
) 
	WHERE 
	inst_secciones.id_seccion='$id_seccion' LIMIT 1";
	$cons_seccion=ejecuta_sql($sql_seccion,true);
	if ($cons_seccion){
		$fila_secc=mysql_fetch_array($cons_seccion);
		$grado_anno=trans_texto($fila_secc["grado_letras"],"TI");
		$seccion=trans_texto($fila_secc["seccion_largo"],"TI");
	}
	
	//BUSCO EL REPRESENTANTE
			$sql_repres="SELECT 
		tip_doc_per.tipo_doc,
		tip_doc_per.tipo_doc_abr,
		tip_doc_per.poner_num,
		tip_doc_per.separador,
		tip_doc_per.num_con_punto,
		datos_per.num_identificacion,
		datos_per.nombres,
		datos_per.apellidos,sexo,
		parentescos.parentesco,
		alum_repr.representante FROM (alum_repr 
		INNER JOIN datos_per ON datos_per.id_personal=alum_repr.id_representante
		INNER JOIN tip_doc_per ON tip_doc_per.cod_tip_doc_per=datos_per.cod_tip_doc_per
		INNER JOIN parentescos ON parentescos.id_parentesco=alum_repr.id_parentesco
		)
		WHERE alum_repr.id_alumno='$id_per_alumno' AND alum_repr.representante=true 
		ORDER BY datos_per.nombres,datos_per.apellidos asc LIMIT 1
		";
		$consulta_repres=ejecuta_sql($sql_repres,false);
		if ($consulta_repres){
			$fila_repres=mysql_fetch_array($consulta_repres);
		$num_id_per=$fila_repres["num_identificacion"];
		$tipo_doc_abr=$fila_repres["tipo_doc_abr"];
		$poner_num=$fila_repres["poner_num"];
		$separador=$fila_repres["separador"];
		$num_con_punto=$fila_repres["num_con_punto"];
		$id_repre=formatear_id_personal($num_id_per,$tipo_doc_abr,$poner_num,$separador,$num_con_punto);
		$nombre_repres=trans_texto($fila_repres["nombres"],"TI");
		$apellido_repres=trans_texto($fila_repres["apellidos"],"TI");
		if ($fila_repres["sexo"]=="M"){ 
			$genero_repres=" ciudadano";
		} else {
			$genero_repres=" ciudadana";
		}
			

			
		}
?>

<table width="100%" border="0">
  <tr>
    <td><img src="../images/sistema/barra_me3.png" width="100%"/></td>
    <td><img src="../images/sistema/corazon_vzlano_peq.png" width="79" height="74" /></td>
  </tr>
</table>
<br /><br />
<center>
<span class="titulo" style="line-height: 300%;">CONSTANCIA DE CONDUCTA</span>
</center>
<p align="justify" style="font-size:16px;line-height: 200%;">
Quien suscribe, <?PHP echo $nombre_director." ".$apellido_director;?> titular de la c&eacute;dula de identidad N&deg; <?php echo formatear_id_personal($num_id_per,$tipo_doc_abr,$poner_num,$separador,$num_con_punto); ?>,<?php echo $genero_direct;?> de la <?php echo $nombre_plantel;?>, c&oacute;digo de Plantel <?php echo $cod_plantel;?>, que funciona en <?php echo $poblado?>, Municipio <?php echo $municipio;?> del Estado <?php echo $estado_terr;?>, por medio de la presente:
</p>
<center>
<span class="titulo">HACE CONSTAR</span>
</center>
<p align="justify" style="font-size:16px;line-height: 200%;">

Que <?php echo $genero_alum;?> estudiante <?php echo $nombre_alumno." ".$apellido_alumno;?>, titular de la c&eacute;dula de identidad N&deg; <?php echo formatear_id_personal($num_id_per,$tipo_doc_abr,$poner_num,$separador,$num_con_punto);?>, natural de <?php echo $lugar_nac_alum;?> <?php echo $estado_nac_alum;?>, <?php echo $nacidoa;?> el <?php echo $fecha_nac_larg;?> de <?php echo $edad_alum;?> a&ntilde;os de edad, est&aacute; <?php echo $inscritoa;?> en <?php echo $grado_anno." ".$seccion?>, para el per&iacute;odo escolar <?php echo $cod_anno_esc;?>, presentando hasta el momento 
<input type = "text" id = "txt1" style="width:auto; border:0; border:rgb(255,255,255); appearance:document; font-size:14px; text-align:center; font-weight:bold;" onkeyup = "expand()" value="BUENA CONDUCTA"  size="21" title="Clic para modificar"/>

<script type = "text/javascript">
var oldsize = 14;
function expand() {
var len = document.getElementById("txt1").value.length;
if (len >= oldsize) {
document.getElementById("txt1").size = len *1.3;
oldsize ++;
}
}
</script>
  &nbsp;durante la permanencia en el plantel.
</p>
<p align="justify" style="font-size:16px;line-height: 200%;">
Constancia que se expide a petici&oacute;n de su representante ante este plantel, <?php echo $genero_repres;?>, <?php echo $nombre_repres." ".$apellido_repres;?> titular de la c&eacute;dula de identidad N&deg; <?php echo $id_repre;?>, en <?php echo $poblado;?> a los <?php echo date("d")." d&iacute;as del mes de ".formato_fecha("MES",date("d-m-Y"))." de ".date("Y");?>.
</p><br /><br /><br />

<table width="100%" border="0" style="font-size:16px;">
  <tr>
    <th scope="col" width="30%">&nbsp;</th>
    <th scope="col" style="border-top:1px solid black;"><?php 
		echo strtoupper($nombre_director." ".$apellido_director)."<br>";
		echo formatear_id_personal($num_id_per,$tipo_doc_abr,$poner_num,$separador,$num_con_punto)."<br>";
		echo strtoupper($genero_direct);
		?></th>
    <th scope="col" width="30%">&nbsp;</th>
  </tr>
</table>
<?php
if ($valides>0){
	?>
<h4>V&aacute;lida por <?php echo $valides;?> meses.</h4>
<?php
}
?>
<h6 class="SaltoDePagina"></h6>
<?php
} // fin se si se recibio el id_alumno y el id_a&Ntilde;o escolar
else {
	echo "<h2 align='center'>No se recibieron los datos para generar la constancia de inscripci&oacute;n</h2>";
}
?>
</body>
</html>