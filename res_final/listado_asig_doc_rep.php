<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php if (isset($_SESSION['juego_caracteres'])){ echo $_SESSION['juego_caracteres'];} else echo "utf-8";//esta variable se declara en modulo verificar login?>" />
<title>Listado de asignaci&oacute;n de docentes</title>
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
function esPar($numero){
   $resto = $numero%2;
   if (($resto==0) && ($numero!=0)) {
        return true;
   } else {
        return false;
	 }
}
?>
<?php
function encabezado_pag(){
	
	?>
<table width="100%" border="0">
  <tr>
    <td><img src="../images/sistema/barra_me3.png" width="100%"/></td>
    <td><img src="../images/sistema/corazon_vzlano_peq.png" width="79" height="74" /></td>
  </tr>
  <tr>
    <td colspan="2" align="center"><span colspan="2" style="font-size:16px" class="titulo">LISTADO DE ASIGNACION DE DOCENTES</span></td>
  </tr>
</table>
<?php
}
?>
<?php
function obten_docente($cod_anno_esc,$cod_asig,$id_seccion){
$sql_docente="SELECT 
	datos_per.nombres,
	datos_per.apellidos,
	doc_guia.nombres as nombre_guia,
	doc_guia.apellidos as apellido_guia,	
	tip_doc_per.tipo_doc,
	tip_doc_per.tipo_doc_abr,
	tip_doc_per.poner_num,
	tip_doc_per.separador,
	tip_doc_per.num_con_punto,
	datos_per.num_identificacion FROM (asi_doc_sec
	INNER JOIN datos_per ON datos_per.id_personal=asi_doc_sec.id_profesor
	INNER JOIN datos_per AS doc_guia ON doc_guia.id_personal=asi_doc_sec.id_docente_guia
	
	INNER JOIN tip_doc_per ON tip_doc_per.cod_tip_doc_per=datos_per.cod_tip_doc_per
	) WHERE cod_anno_esc='$cod_anno_esc' AND id_seccion='$id_seccion' AND cod_asig_prog='$cod_asig' LIMIT 1";
$datos_docente="";
$cons_docent=ejecuta_sql($sql_docente,false);
if ($cons_docent){
	$fila_doc=mysql_fetch_array($cons_docent);
	$nombres=$fila_doc["nombres"];
	$apellidos=$fila_doc["apellidos"];
	$tipo_doc=$fila_doc["tipo_doc"];
	$tipo_doc_abr=$fila_doc["tipo_doc_abr"];
	$poner_num=$fila_doc["poner_num"];
	$separador=$fila_doc["separador"];
	$num_con_punto=$fila_doc["num_con_punto"];
	$num_identificacion=$fila_doc["num_identificacion"];
	
	$cedula=formatear_id_personal($num_identificacion,$tipo_doc_abr,$poner_num,$separador,$num_con_punto);
	$nombres_apellido=$nombres." ".$apellidos;
	$datos_docente["docente"]=$cedula."  &nbsp;".$nombres_apellido;
	$datos_docente["guia"]=$fila_doc["nombre_guia"]." ".$fila_doc["apellido_guia"];
	return $datos_docente;
} else {
	$datos_docente["docente"]="SIN ASIGNACI&Oacute;N";
	$datos_docente["guia"]="SIN ASIGNACI&Oacute;N";
	return $datos_docente;
} // fin esle si consulta docente
} //fin funcion
?>
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
<button type="button" name="cerrar" id="cerrar" value="Imprimir" onclick="window.close();"><img src="../images/sistema/close_windows.png" width="24" height="24" align="absmiddle" />&nbsp;Cerrar</button>
</td>
    <td width="30%" align="center"></td>
  </tr>
  
</table>

<body style="font-family: Arial, Helvetica, sans-serif; font-size: 11px;">
<?php
session_start();

include_once("../funciones/funcionesPHP.php");
		if (!empty($_POST["cmb_anno_esc"])){
			//$id_seccion=$_POST["cmb_secc"];
			//$cod_asig=$_POST["cmb_asig"];
			//$cod_grado=$_POST["cmb_gra"];
			$cod_anno_esc=$_POST["cmb_anno_esc"];
			$cod_plantel=$_POST["cmb_plan"];
			
		}
		if (!empty($_POST["cmb_gra"])){
			$filt_grad=" AND inst_secciones.cod_grado='".$_POST["cmb_gra"]."'";
		} else {
			$filt_grad="";
		}
		if (!empty($_POST["cmb_secc"])){
			$filt_secc=" AND inst_secciones.id_seccion='".$_POST["cmb_secc"]."'";
		} else {
			$filt_secc="";
		}		
		$cont_registros=-1;
		$consulta_secc=ejecuta_sql("select  inst_secciones.cod_plantel,inst_secciones.id_plan_nivel_est,inst_secciones.cod_mencion_educ,inst_secciones.cod_grado,inst_secciones.id_sector_educ,id_seccion,seccion_largo,seccion_corto,inst_secciones.fecha_g,grados_esc.grado_letras,inst_secciones.visible,menc_edu.mencion,plan_est_tip.nivel_plan_est,sectores_educ.sector_educ,instituciones.den_plantel from (inst_secciones 
		INNER JOIN grados_esc on grados_esc.cod_grado=inst_secciones.cod_grado
		INNER JOIN menc_edu ON menc_edu.cod_mencion_educ=inst_secciones.cod_mencion_educ
				INNER JOIN plan_est_tip ON plan_est_tip.id_plan_nivel_est=inst_secciones.id_plan_nivel_est
		INNER JOIN sectores_educ ON sectores_educ.id_sector_educ=inst_secciones.id_sector_educ
		INNER JOIN instituciones ON instituciones.cod_plantel=inst_secciones.cod_plantel

		) WHERE inst_secciones.cod_plantel='$cod_plantel' and inst_secciones.visible=true $filt_grad $filt_secc ORDER BY grados_esc.orden ASC",true);
		if ($consulta_secc){
		while ($filas_secc=mysql_fetch_array($consulta_secc)){
			$cont_registros++;
			$id_seccion=$filas_secc["id_seccion"];
			
?>
<?php
if (esPar($cont_registros)){
	echo "<br><br>".$_SESSION["app_nombre"]."-".$_SESSION["app_version"]."IMPRESO: ".$_SESSION["nombre_usuario"]." FECHA: ".date("d-m-Y h:m a");
	echo "<span class=\"SaltoDePagina\"></span>";
	echo encabezado_pag();
}
if ($cont_registros==0){
	echo encabezado_pag();
}
?>

<table class="margenes" width="100%" border="1" cellpadding="0" cellspacing="1" bordercolor="#000000" style="border-collapse: collapse;font-weight: normal; text-transform:uppercase;height: 30px;">
  <tr>
    <td colspan="3"><div class="ctrlHolder" style="margin:0px;">
     <p class="formHint" style="margin:0px;">Plantel:</p>
    <label><b><?php echo $filas_secc["den_plantel"]." (".$filas_secc["sector_educ"].")";?></b></label>
    <br>
   
  </div>
  </td>
    <td><div class="ctrlHolder" style="margin:0px;">
     <p class="formHint" style="margin:0px;">Menci&oacute;n:</p>
    <label><b><?php echo $filas_secc["mencion"];?></b></label>
    <br></div></td>
  </tr>
  <tr>
    <td><div class="ctrlHolder">
      <p class="formHint" style="margin:0px;">Periodo escolar:      </p>
      <label><b><?php echo $_POST["cmb_anno_esc"];?></b></label>
      <br />
    </div></td>
    <td><div class="ctrlHolder">
      <p class="formHint" style="margin:0px;">A&ntilde;o o grado:</p>
      <label><b><?php echo $filas_secc["grado_letras"];?></b></label>
      <br />
    </div></td>
    <td><div class="ctrlHolder">
     <p class="formHint" style="margin:0px;">Secci&Oacute;n:</p>
     <label><b><?php echo $filas_secc["seccion_largo"];?></b></label>
    <br></div></td>
    <td>
<div class="ctrlHolder" style="margin:0px;">
     <p class="formHint" style="margin:0px;">Plan de estudio:</p>
    <label><b><?php echo $filas_secc["nivel_plan_est"];?></b></label>
    <br>
   
  </div>    
    </td>
  </tr>
</table>
<p class="titulo" align="center">ASIGNATURAS - DOCENTE</p>
<?php

$sql_obten_config_plan_estud="select 
 id_plan_nivel_est,cod_mencion_educ,id_sector_educ,cod_grado
 FROM inst_secciones
 WHERE id_seccion='$id_seccion' LIMIT 1
";

if ($consulta=ejecuta_sql($sql_obten_config_plan_estud,true)){
	$reg_plan_est=mysql_fetch_array($consulta);
	$id_plan_nivel_es=$reg_plan_est["id_plan_nivel_est"];
	$cod_mencion_educ=$reg_plan_est["cod_mencion_educ"];
	$id_sector_educ=$reg_plan_est["id_sector_educ"];
	$cod_grado=$reg_plan_est["cod_grado"];
	/*
	echo $id_secc_post."<br>";
	echo $id_plan_nivel_es."<br>";
	echo $cod_mencion_educ."<br>";
	echo $id_sector_educ."<br>";
	echo $cod_grado."<br>";
	*/
	//----------------------------------
	$sql_asignaturas="SELECT plan_est_conf.cod_asig_prog,asig_prog.des_mat_prog,asig_prog.mat_prog_cor
  FROM (plan_est_conf
	INNER JOIN asig_prog ON asig_prog.cod_asig_prog=plan_est_conf.cod_asig_prog
	)
	WHERE id_plan_nivel_est='$id_plan_nivel_es' AND cod_grado='$cod_grado' AND cod_mencion_educ='$cod_mencion_educ' AND id_sector_educ='$id_sector_educ'
	ORDER BY asig_prog.orden ASC";
 $consul_asig=ejecuta_sql($sql_asignaturas,true);
 if ($consul_asig){

?>

<table id="tabla_asig" class="letra_16 mouse_hover" style="font-size:12px; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif;" cellpadding="0" cellspacing="1" bordercolor="#000000" width="100%">
<thead> 
<tr>
  <th width="10px" align="left" style="border-bottom:1px solid rgb(42,63,85);">N&deg;</th>
<th title="Abreviatura de la asignatura" align="left" width="60px" style="border-bottom:1px solid rgb(42,63,85);"> ABREV.</th>
<th width="250px" align="left" style="border-bottom:1px solid rgb(42,63,85);">ASIGNATURA</th>
<th width="250px" style="border-bottom:1px solid rgb(42,63,85);" align="left">N&deg; DE C&Eacute;DULA / DOCENTE</th>
</tr>
</thead>
<?php
$i=0;
$prof_guia="SIN ASIGNACI&Oacute;N";
	while ($fila=mysql_fetch_array($consul_asig)){
		$i++;
		$cod_asig=$fila["cod_asig_prog"];
?>
<tr >
  <td><?php echo $i;?></td>
  <td><label for="chk_cod_asig[<?php echo $i;?>]"><?php echo $fila["mat_prog_cor"]; ?></label></td>
  <td><?php echo $fila["des_mat_prog"];?></td>
  <td><?php 
			$array_docente=obten_docente($cod_anno_esc,$cod_asig,$id_seccion);
			
	echo  $array_docente["docente"];?></td>
  </tr>
<?php
	if ($array_docente["guia"]!="SIN ASIGNACI&Oacute;N"){$prof_guia=$array_docente["guia"];}
	} // fin while
?>
</table>
<table width="100%">
<tr><td style="border-bottom:1px solid rgb(42,63,85);"><h2><?php echo "DOCENTE GU&Iacute;A DE LA SECCI&Oacute;N: ".$prof_guia;?></h2></td></tr>
</table>

<br /><br />
<?php
} // fin si hay consulta de asig
} // fin de si se encontro la configuracion del plan de estudio a traves de la seccion
?>

<?php
		} // fin while secciones
		} // fin de si hubo consulta de seccion
?>

</body>
</html>