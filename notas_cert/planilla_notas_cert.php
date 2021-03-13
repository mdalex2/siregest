<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Planilla de inscripci&oacute;n</title>
<style type="text/css">
.margenes td{
padding-left: 3px;
padding-right: 3px;
}
.titulo {
	font-family:Arial, Helvetica, sans-serif;
	font-size:14px;
	text-transform:uppercase;
	font-weight:bold;
	margin-bottom:2px;
}
<STYLE>
H6.SaltoDePagina
{
PAGE-BREAK-AFTER: always
}
.cursiva {
	font-style: italic;
	font-weight: bold;
}
.cursiva {
	font-style: italic;
}
</STYLE>
</style>
</head>

<body style="font-family: Arial, Helvetica, sans-serif; font-size: 11px;">
<?php
if (!empty($_GET["id_alum"]) && !empty($_GET["cod_anno_esc"]) && !empty($_GET["cod_dea"])){
	session_start();
	include_once("../funciones/funcionesPHP.php");
	$id_alum=$_GET["id_alum"];
	$cod_anno_esc=$_GET["cod_anno_esc"];
	$cod_dea=$_GET["cod_dea"];
?>
<table width="100%" border="0">
  <tr>
    <td><img src="../images/sistema/barra_me3.png" width="100%"/></td>
    <td><img src="../images/sistema/corazon_vzlano_peq.png" width="79" height="74" /></td>
  </tr>
  <tr>
  <?php
	$con_plantel=ejecuta_sql("SELECT den_plantel FROM instituciones WHERE cod_plantel='$cod_dea'",false);
	if ($con_plantel){
		$fil_plantel=mysql_fetch_array($con_plantel);
		$nombre_plantel=$fil_plantel["den_plantel"];
	}
	?>
    <td align="center" class="titulo"><strong><?php echo $nombre_plantel;
    ?></strong></td>
    <td align="center"><strong>CODIGO DEA: </strong><?php echo $cod_dea;?></td>
  </tr>
  <tr>
    <td align="center"><span colspan="2" style="font-size:16px" class="titulo">PLANILLA DE INSCRIPCI&Oacute;N</span></td>
    <td align="center"><strong>A&Ntilde;O ESCOLAR: </strong><?php echo $cod_anno_esc;?></td>
  </tr>
</table>
<?php
$sql_datos_per="SELECT datos_per.*,tip_doc_per.tipo_doc_abr,tip_doc_per.tipo_doc,terr_nacionalidad.nacionalidad,terr_nacionalidad.pais FROM (datos_per
INNER JOIN tip_doc_per ON tip_doc_per.cod_tip_doc_per=datos_per.cod_tip_doc_per
INNER JOIN terr_nacionalidad ON terr_nacionalidad. 	cod_nac=datos_per.cod_nac
) WHERE id_personal='$id_alum'";
$cons_dat_per=ejecuta_sql($sql_datos_per,false);
if ($cons_dat_per){
	$datos_per=mysql_fetch_array($cons_dat_per);
?>
<p class="titulo">DATOS PERSONALES DEL ESTUDIANTE:</p>
<table width="100%" border="1" cellpadding="0" cellspacing="1" bordercolor="#000000" style="border-collapse: collapse;font-weight: normal; text-transform:uppercase;height: 30px;" class="margenes">
  <tr>
    <td><strong><?php echo $datos_per["tipo_doc"];?>: <?php echo $datos_per["tipo_doc_abr"]."-".number_format($datos_per["num_identificacion"], 0, ",", ".");?></strong></td>
    <td width="30px"><strong>SEXO:</strong></td>
    <td><strong>F: </strong><?php if ($datos_per["sexo"]=="F"){ echo "(X)";}?></td>
    <td><strong>M: </strong> <?php if ($datos_per["sexo"]=="M"){ echo "(X)";}?></td>
    <td><strong>EDAD: </strong><?php 
		$fecha_nac=date("d-m-Y",strtotime($datos_per["fecha_nac"]));
		echo calcular_edad($fecha_nac); 
		?> A&Ntilde;OS</td>
    
    <td rowspan="6" align="center" width="120px"><div id="foto" name="foto" style="height:150px; width:120px; ">
      <?php 
//$ruta_foto="";
  $ruta_foto=$_SESSION["carp_per_fotos"].$id_alum."/".$datos_per["foto_perfil"];
	if (file_exists($ruta_foto) && $datos_per["foto_perfil"]!=''){
		echo "<img src='$ruta_foto' width='120px' height='150px'>";}
	else {
		echo "<img src='../images/sistema/no-pict.jpg' width='120' height='150'>";}
?>
    </div></td>
  </tr>
  <tr>
    <td colspan="5"><strong>APELLIDOS: </strong><?php echo $datos_per["apellidos"];?> &nbsp;<strong>NOMBRES: </strong><?php echo $datos_per["nombres"];?></td>
  </tr>
  <tr>
    <td colspan="3"><strong>FECHA DE NACIMIENTO: </strong><?php echo strtoupper(formato_fecha("L",$datos_per["fecha_nac"]));?></td>
    <td colspan="2"><strong>LUGAR DE NACIMIENTO: </strong><?php echo $datos_per["lugar_nac"];?></td>
</tr>
  <tr>
    <td colspan="3"><strong>NACIONALIDAD: </strong><?php echo $datos_per["nacionalidad"];?></td>
    <td colspan="2"><strong>PAIS: </strong><?php echo $datos_per["pais"];?></td>
  </tr>
  <tr>
    <td colspan="5"><strong>DIRECCI&Oacute;N DE HABITACI&Oacute;N:</strong></td>
    </tr>
</table>
<p>
  <?php
} //fin de si hubo consulta de datos personales
else { echo "<h2>No se pudo encontrar los datos del alumno<h2>";}
?>
</p>
<p>
</p>
<p class="titulo">DATOS DEL REPRESENTANTE, MADRE, PADRE O FAMILIAR&nbsp;</p>
  <?php
	  //$represent_asig=false;
		$sql_repres="SELECT alum_repr.id_representante,alum_repr.id_alumno,datos_per.nombres,datos_per.apellidos,datos_per.num_identificacion,tip_doc_per.tipo_doc_abr,parentescos.parentesco,representante,tip_ocup.ocup_profesion,edo_civil.edo_civil FROM (alum_repr 
		INNER JOIN datos_per ON datos_per.id_personal=alum_repr.id_representante
		INNER JOIN tip_doc_per ON tip_doc_per.cod_tip_doc_per=datos_per.cod_tip_doc_per
		INNER JOIN parentescos ON parentescos.id_parentesco=alum_repr.id_parentesco
		INNER JOIN tip_ocup ON tip_ocup.cod_tip_ocup=datos_per.cod_tip_ocup
		INNER JOIN edo_civil ON edo_civil.id_edo_civ =datos_per.id_edo_civ
		)
		WHERE alum_repr.id_alumno='$id_alum'
		ORDER BY datos_per.nombres,datos_per.apellidos asc
		";
		$consulta_repres=ejecuta_sql($sql_repres,false);
		if ($consulta_repres){
		while ($fil_dat_repres=mysql_fetch_array($consulta_repres)){
			$id_representante=$fil_dat_repres["id_representante"];
			if ($fil_dat_repres["representante"]==true){
				$representante_principal=" (REPRESENTANTE).";
				$nombre_repres_princ=$fil_dat_repres["nombres"]." ".$fil_dat_repres["apellidos"];
				} 
				else {
					$representante_principal="";
					$nombre_repres_princ="";
					}
	?>

<table width="100%" border="1" cellpadding="0" cellspacing="1" bordercolor="#000000" style="height: 30px;border-collapse: collapse; font-weight: normal; " class="margenes">
<tr>
	<td width="50%"><strong>C&Eacute;DULA DE IDENTIDAD: </strong><?php echo $fil_dat_repres["tipo_doc_abr"]."-".number_format($fil_dat_repres["num_identificacion"], 0, ",", ".");?></td>
	<td width="25%"><strong>EDO. CIVIL: </strong><?php echo $fil_dat_repres["edo_civil"];?></td>
	<td width="25%"><strong>PARENTESCO CON EL ALUMNO: </strong><?php echo $fil_dat_repres["parentesco"];?></td>
 </tr>
<tr>
  <td><strong>APELLIDOS Y NOMBRES: </strong><?php echo $fil_dat_repres["apellidos"]." ".$fil_dat_repres["nombres"];?></td>
  <td colspan="2">
  <strong>TEL&Eacute;FONO(S):</strong>
<?php
		$sql_telf_repre="SELECT num_telf,tip_telf.tipo_telefono FROM (telf_pers
		INNER JOIN tip_telf ON tip_telf.cod_tip_telf=telf_pers.cod_tip_telf
		)
		WHERE id_personal='$id_representante'";
		$cons_telf_repre=ejecuta_sql($sql_telf_repre,false);
		if ($cons_telf_repre){
			while ($fil_telf_repre=mysql_fetch_array($cons_telf_repre)){
				echo $fil_telf_repre["tipo_telefono"].": ".$fil_telf_repre["num_telf"]."  /  ";
			}
		}
	?>  </td>
</tr>
<tr>
  <td><strong>PROFESI&Oacute;N: </strong><?php echo $fil_dat_repres["ocup_profesion"];?></td>
  <td colspan="2"><strong>EMAIL(S): </strong><?php
		$sql_email_repre="SELECT email FROM emails_pers
		WHERE id_personal='$id_representante'";
		$cons_email_repre=ejecuta_sql($sql_email_repre,false);
		if ($cons_email_repre){
			while ($fil_email_repre=mysql_fetch_array($cons_email_repre)){
				echo $fil_email_repre["email"]."  -  ";
			}
		}
	?></td>
</tr>
</table>
<?php
		echo "<br>";
		} //fin while
	} //FIN DE SI HUBO CONSULTA REPRESENTANTE
?>
<p class="titulo">ASIGNATURAS / PROGRAMAS INSCRITOS(AS):</p>
<table width="100%" border="1" cellpadding="0" cellspacing="1" bordercolor="#000000" style="border-collapse: collapse; height: 30px; font-weight: normal; " class="margenes">
<thead>
<tr>
  <th><strong>ASIGNATURA / PROGRAMA:</strong></th>
	<th><strong>GRADO O A&Ntilde;O</strong></th>
	<th><strong>SECCI&Oacute;N:</strong></th>
	<th>ESCOLARIDAD</th>
 </tr>
 </thead>
<?php
$sql_asig_insc="SELECT asig_prog.des_mat_prog,asig_prog.mat_prog_cor, 	grados_esc.grado_letras,inst_secciones.seccion_largo,mat_pend,escolaridad.escolaridad FROM (alum_insc_notas
INNER JOIN asig_prog ON asig_prog.cod_asig_prog=alum_insc_notas.cod_asig_prog
INNER JOIN inst_secciones ON inst_secciones.id_seccion =alum_insc_notas.id_seccion
INNER JOIN grados_esc ON grados_esc.cod_grado=inst_secciones.cod_grado
INNER JOIN escolaridad ON escolaridad.id_escolaridad =alum_insc_notas.id_escolaridad
) WHERE  	alum_insc_notas.id_personal='$id_alum' AND cod_anno_esc='$cod_anno_esc' ORDER BY grados_esc.orden,asig_prog.des_mat_prog ASC ";
$cons_asi_ins=ejecuta_sql($sql_asig_insc,false);
if ($cons_asi_ins){
	while ($fil_asi_ins=mysql_fetch_array($cons_asi_ins)){
		if ($fil_asi_ins["mat_pend"]==true) {$pendiente=" (ASIGNATURA PENDIENTE)";} else {$pendiente="";}
?>
<tr>
  <td><?php echo $fil_asi_ins["mat_prog_cor"]."-".$fil_asi_ins["des_mat_prog"].$pendiente;?></td>
  <td><?php echo $fil_asi_ins["grado_letras"]?></td>
  <td><?php echo $fil_asi_ins["seccion_largo"]?></td>
  <td><?php echo $fil_asi_ins["escolaridad"]?></td>
</tr>
<?php
	}// fin while
} // fin de si hubo consulta de asignaturas inscritas
?>
</table>
<p class="titulo">DOCUMENTOS CONSIGNADOS:</p>
<table width="100%" border="1" cellpadding="0" cellspacing="1" bordercolor="#000000" style="height: 30px;border-collapse: collapse;font-weight: normal; " class="margenes">
<thead>
<tr>
	<th><strong>DOCUMENTO</strong></th>
	<th><strong>OBERVACIONES</strong></th>
 </tr>
 </thead>
<?php
$sql_doc_consig="SELECT tip_recaudos.descrip_recaudo,alum_insc_recaud.observaciones FROM (alum_insc_recaud
INNER JOIN tip_recaudos ON tip_recaudos.id_tip_recaudo=alum_insc_recaud.id_tip_recaudo
) WHERE alum_insc_recaud.id_personal='$id_alum' AND cod_anno_esc='$cod_anno_esc'";
$cons_doc_consig=ejecuta_sql($sql_doc_consig,false);
if ($cons_doc_consig){
while ($fil_doc_con=mysql_fetch_array($cons_doc_consig)){
?>
<tr>
  <td><?php echo $fil_doc_con["descrip_recaudo"];?></td>
  <td><?php echo $fil_doc_con["observaciones"];?></td>
</tr>
<?php
} //fin while
} //fin de si hubo consulta
?>
</table>
<p align="justify" de>
Mi representado ha sido inscrito en una instituci&oacute;n, cuyos principios y valores yo comparto por lo cual estoy en la disposici&oacute;n de que participe en las actividades programadas; asi mismo, estoy consciente de mi participaci&oacute;n y la de mi familia en la buena marcha de la instituci&oacute;n por ello me comprometo a asistir a las reuniones, actividades de formaci&oacute;n y encuentros planificados durante el a&ntilde;o escolar igualmente a prestar mi colaboraci&oacute;n para el desarrollo de las actividades de clase y mantener una comunicaci&oacute;n fluida con los docentes (respetando el horario de la instituci&oacute;n sin obstaculizar la marcha de las actividades diarias). <span class="cursiva">Hago constar que me comprometo a cumplir y hacer cumplir con mi representado, las leyes y reglamentos vigentes, as&iacute; como tambi&eacute;n, las disposiciones emanadas de la autoridad del plantel,</span> acatando las directrices del manual de convivencia interno, de acuerdo a la LOPNA, soy responsable de la asistencia de mi representado a clases y de conocer el desenvolvimiento acad&eacute;mico del estudiante, por lo cual me comprometo acudir al plantel a retirar los boletines informativos.<span class="cursiva"> De igual manera estoy en la disposici&oacute;n de colaborar con la instituci&oacute;n, acatando las decisiones que las autoridades tomen en concordancia con este compromiso espec&iacute;fico</span>.</p><BR /><BR />
<table width="100%" border="0" align="center">
<tr>
    <td width="30%" align="center" style="border-top:1px solid black;">FIRMA DEL REPRESENTANTE</td>
    <td width="40%" align="center">
<script type="text/javascript">
function imprimir()
	{
		var Obj = document.getElementById("imprimir");
		var Obj1 = document.getElementById("cerrar");
		Obj.style.visibility = 'hidden';
		Obj1.style.visibility = 'hidden';
		window.print();
		Obj.style.visibility = 'visible';
		Obj1.style.visibility = 'visible';
	}
</script>
<button type="button" name="imprimir" id="imprimir" value="Imprimir" onclick="imprimir();"><img src="../images/icons_menu/x32/printer2_x32.png" width="32" height="32" align="absmiddle" />&nbsp;Imprimir</button>
&nbsp;
<?php 
 if (isset($_REQUEST["tipo"]) && $_REQUEST["tipo"]=="window"){
?>
<button type="button" name="cerrar" id="cerrar" value="Imprimir" onclick="window.close();"><img src="../images/sistema/close_windows.png" width="24" height="24" align="absmiddle" />&nbsp;Cerrar</button>
<?php
 } else {
?>
<button type="button" name="cerrar" id="cerrar" value="Imprimir" onclick="parent.$.fancybox.close();"><img src="../images/sistema/close_windows.png" width="24" height="24" align="absmiddle" />&nbsp;Cerrar</button>
<?php 
 }
?>
</td>
    <td width="30%" align="center" style="border-top:1px solid black;">FIRMA DEL DOCENTE / FUNCIONARIO</td>
  </tr>
  <tr>
    <td align="center" ><?php if (!empty($nombre_repres_princ))echo $nombre_repres_princ; ?></td>
    <td>&nbsp;</td>
    <td align="center" ><?php echo $_SESSION['nombre_usuario'];?></td>
  </tr>
  
</table>
<p align="justify" de>&nbsp;</p>
<?php
} // fin se si se recibio el id_alumno y el id_a&Ntilde;o escolar
else {
	echo "<h2>No se recibieron los datos para general la planilla de inscripci&oacute;n</h2>";
}
?>
</body>
</html>