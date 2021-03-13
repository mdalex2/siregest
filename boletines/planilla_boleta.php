<?php 
session_cache_limiter('nocache,private'); //evita mensaje de sesion expirada al presionar atras en el navegador

require_once("../funciones/conexion.php");
require_once("../funciones/funcionesPHP.php");
require_once("../funciones/encriptado.php");
include_once("../funciones/errores_genericos.php");
require_once("../funciones/img.thumbail.rezise.php");
//require_once("../funciones/fechas_func.php");
//include_once("../funciones/mostrar_iconos_comandos.php");
session_start();
?>
<!doctype html>
<html>
<head>
<meta charset="<?php if (isset($_SESSION['juego_caracteres'])){ echo $_SESSION['juego_caracteres'];} else echo "utf-8";//esta variable se declara en modulo verificar login?>">
<title>Bolet&iacute;n informativo</title>
<style type="text/css">
.margenes td{
padding-left: 3px;
padding-right: 3px;
}
.titulo {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
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
<button type="button" name="imprimir" id="imprimir" value="Imprimir" onClick="imprimir();"><img src="../images/icons_menu/x32/printer2_x32.png" width="24" height="24" align="absmiddle">&nbsp;Imprimir</button>
&nbsp;
<?php 
 if (isset($_REQUEST["tipo"]) && $_REQUEST["tipo"]=="seccion"){
?>
<button type="button" name="cerrar" id="cerrar" value="Imprimir" onClick="window.close();"><img src="../images/sistema/close_windows.png" width="24" height="24" align="absmiddle">&nbsp;Cerrar</button>
<?php
 } else {
?>
<button type="button" name="cerrar" id="cerrar" value="Imprimir" onClick="parent.$.fancybox.close();"><img src="../images/sistema/close_windows.png" width="24" height="24" align="absmiddle">&nbsp;Cerrar</button>
<?php 
 }
?>
</td>
    <td width="30%" align="center"></td>
  </tr>
  
</table>
<?php
if (!empty($_REQUEST["tipo"])){
	//session_start();
	include_once("../funciones/funcionesPHP.php");
	$cod_anno_esc=$_REQUEST["txt_anno_esc_ocu"];
	$cod_dea=$_REQUEST["txt_cod_dea_ocu"];
	$cod_grado=$_REQUEST["txt_gra_ocu"];
	if ($_REQUEST["tipo"]=="seccion"){
		$id_alumno_post=$_POST["txt_id_alum"];
		$arr_chk_id_alum=$_POST["chk_id_alum"];	
		}
	else {
		$id_alumno_post[]=$_REQUEST["id_alum"];
		$arr_chk_id_alum[]="on";	}


for($i=0; $i < sizeof($arr_chk_id_alum); $i++){
	if(!isset($arr_chk_id_alum[$i])){ 	
		$arr_chk_id_alum[$i]='off';}
	if($arr_chk_id_alum[$i]=='on'){	
	$id_per_alumno=$id_alumno_post[$i];
?>
<table width="100%" border="0">
  <tr>
    <td><img src="../images/sistema/barra_me3.png" width="100%"></td>
    <td><img src="../images/sistema/corazon_vzlano_peq.png" width="79" height="74"></td>
  </tr>
  <tr>
    <?php
	$con_plantel=ejecuta_sql("SELECT den_plantel,
	terr_poblados.poblado,
	terr_estados.estado_ter
	FROM (instituciones 
	INNER JOIN terr_poblados ON terr_poblados.id_poblado=instituciones.id_poblado
	INNER JOIN terr_estados ON terr_estados.cod_estado_ter=terr_poblados. 	cod_estado_ter
	) WHERE cod_plantel='$cod_dea'",false);
	if ($con_plantel){
		$fil_plantel=mysql_fetch_array($con_plantel);
		$nombre_plantel=$fil_plantel["den_plantel"];
		$edo_plantel=$fil_plantel["estado_ter"];
		$poblado_plantel=$fil_plantel["poblado"];
	}
	?>
    <td colspan="2" align="center" style="text-align: left"><strong><?php echo $nombre_plantel.". &nbsp; - &nbsp;";
    ?></strong><span style="text-align: left"></span><span style="text-align: center"></span><span style="text-align: left"></span>&nbsp; <strong>CODIGO DEA: </strong><?php echo $cod_dea;?></td>
  </tr>
  <tr>
    <td colspan="2" align="center" style="text-align: left"><?php echo $edo_plantel." - ".$poblado_plantel;?></td>
  </tr>
  <tr>
    <td colspan="2" align="center"><span colspan="2" style="font-size:16px; margin:0PX;" class="titulo">BOLETIN INFORMATIVO</span></td>
  </tr>
</table>
<?php
$sql_datos_per="SELECT datos_per.*,tip_doc_per.tipo_doc_abr,tip_doc_per.tipo_doc,terr_nacionalidad.nacionalidad,terr_nacionalidad.pais,terr_estados.estado_ter FROM (datos_per
INNER JOIN tip_doc_per ON tip_doc_per.cod_tip_doc_per=datos_per.cod_tip_doc_per
INNER JOIN terr_nacionalidad ON terr_nacionalidad. 	cod_nac=datos_per.cod_nac
INNER JOIN terr_estados ON terr_estados.cod_estado_ter=datos_per.cod_estado_ter
) WHERE id_personal='$id_per_alumno'";
$cons_dat_per=ejecuta_sql($sql_datos_per,false);
if ($cons_dat_per){
	$datos_per=mysql_fetch_array($cons_dat_per);
?>
<p class="titulo">IDENTIFICACI&Oacute;N DEL ESTUDIANTE:</p>
<table width="100%" border="1" cellpadding="0" cellspacing="1" bordercolor="#000000" style="border-collapse: collapse;font-weight: normal; text-transform:uppercase;" class="margenes">
  <tr>
    <td><strong><?php echo $datos_per["tipo_doc"];?>: <?php echo $datos_per["tipo_doc_abr"]."-".number_format($datos_per["num_identificacion"], 0, ",", ".");?></strong></td>
    <td width="30"><strong>SEXO:</strong></td>
    <td><strong>F: </strong><?php if ($datos_per["sexo"]=="F"){ echo "(X)";}?></td>
    <td><strong>M: </strong> <?php if ($datos_per["sexo"]=="M"){ echo "(X)";}?></td>
    <td><strong>EDAD: </strong><?php 
		$fecha_nac=date("d-m-Y",strtotime($datos_per["fecha_nac"]));
		echo calcular_edad($fecha_nac); 
		?> A&Ntilde;OS</td>
    
    <td rowspan="5" align="center" width="80"><div id="foto" name="foto" style="height:100px; width:80px; ">
      <?php 
//$ruta_foto="";
  $ruta_foto=$_SESSION["carp_per_fotos"].$id_per_alumno."/".$datos_per["foto_perfil"];
	if (file_exists($ruta_foto) && $datos_per["foto_perfil"]!=''){
		echo "<img src='$ruta_foto' width='80px' height='100px'>";}
	else {
		echo "<img src='../images/sistema/no-pict.jpg' width='80' height='100'>";}
?>
    </div></td>
  </tr>
  <tr>
    <td colspan="5"><strong>APELLIDOS: </strong><?php echo $datos_per["apellidos"];?> &nbsp;<strong>NOMBRES: </strong><?php echo $datos_per["nombres"];?></td>
  </tr>
  <tr>
    <td colspan="3"><strong>FECHA DE NACIMIENTO: </strong><?php echo strtoupper(formato_fecha("L",$datos_per["fecha_nac"]));?></td>
    <td colspan="2"><strong>LUGAR DE NACIMIENTO: </strong><?php echo $datos_per["estado_ter"]." / ".$datos_per["lugar_nac"];?></td>
</tr>
  <tr>
    <td colspan="3"><strong>NACIONALIDAD: </strong><?php echo $datos_per["nacionalidad"];?></td>
    <td colspan="2"><strong>PAIS: </strong><?php echo $datos_per["pais"];?></td>
  </tr>
  <tr>
    <?php
		$direccion="NO REGISTRADA EN SISTEMA";
$consulta_dir="Select direcc_personas.*,tip_direcc.tipo_direcc,terr_estados.estado_ter,terr_municipios.municipio,terr_parroquias.parroquia,terr_poblados.poblado,direcc_personas.fecha_g,datos_per.nombres,datos_per.apellidos from (direcc_personas
INNER JOIN tip_direcc ON direcc_personas.cod_tip_dir=tip_direcc.cod_tip_dir 
INNER JOIN terr_estados ON direcc_personas.cod_estado_ter=terr_estados.cod_estado_ter 
INNER JOIN terr_municipios ON direcc_personas.cod_municipio=terr_municipios.id_municipio 
INNER JOIN terr_parroquias ON direcc_personas.cod_parroquia=terr_parroquias.id_parroquia 
INNER JOIN terr_poblados ON direcc_personas.cod_poblado=terr_poblados.id_poblado 
inner join datos_per on datos_per.id_personal=direcc_personas.guardado_por
) where direcc_personas.id_personal='$id_per_alumno' LIMIT 1";
$consulta_dir=ejecuta_sql($consulta_dir,false);
if ($consulta_dir){
	while ($fila=mysql_fetch_array($consulta_dir)){
		$direccion=trans_texto("ESTADO ".$fila["estado_ter"]." / MUNICIPIO ".$fila["municipio"]." / PAROQUIA ".$fila["parroquia"]." / POBLADO-SECTOR ".$fila["poblado"]." / ".$fila["direccion"],"MA");
	}
}
	?>
    <td colspan="5"><strong>DIRECCI&Oacute;N DE HABITACI&Oacute;N: </strong> <?PHP echo $direccion; ?></td>
  </tr>
  <tr>
    <td colspan="3"><strong>A&Ntilde;O ESCOLAR:</strong>&nbsp;<?PHP 
			echo $cod_anno_esc;
			$cons_dias_habils=ejecuta_sql("SELECT dias_habiles,porcen_inas_aplazado FROM anno_esc_me WHERE cod_anno_esc='$cod_anno_esc'",false);
			if ($cons_dias_habils){
				$fila_dia_hab=mysql_fetch_array($cons_dias_habils);
				$tot_dia_hab=$fila_dia_hab["dias_habiles"];
				$porcen_inas_aplazado=$fila_dia_hab["porcen_inas_aplazado"];
			} else {
				$tot_dia_hab=0;
				$porcen_inas_aplazado=0;
			}
		?>
	</td>
    <?php 
			$cons_grado=ejecuta_sql("SELECT  	grado_letras FROM grados_esc WHERE cod_grado='$cod_grado'",false);
			if ($cons_grado){
				$fila_grados=mysql_fetch_array($cons_grado);
				$grado_letras=$fila_grados["grado_letras"];
			} else {
				$grado_letras="NO ENCONTRADO";
			}
		?>
    <td colspan="2"><strong>GRADO O A&Ntilde;O:&nbsp;</strong><?php echo $grado_letras;?></td>
		<?php 
		$sql_secc="SELECT  	alum_insc_notas.id_seccion,inst_secciones.seccion_corto FROM  (alum_insc_notas
			INNER JOIN inst_secciones ON inst_secciones.id_seccion=alum_insc_notas.id_seccion) WHERE alum_insc_notas.cod_plantel_proc='$cod_dea' AND alum_insc_notas.id_personal='$id_per_alumno' AND alum_insc_notas.cod_anno_esc='$cod_anno_esc' AND alum_insc_notas.cod_grado='$cod_grado' LIMIT 1";
			
			$cons_secc=ejecuta_sql($sql_secc,false);
			if ($cons_secc){
				$fila_secc=mysql_fetch_array($cons_secc);
				$secc_abr=$fila_secc["seccion_corto"];
			} else {
				$secc_abr="NO ENCONTRADO";
			}
		?>    
    <td><strong>SECCI&Oacute;N</strong>: &nbsp;<?php echo $secc_abr;?></td>
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
		WHERE alum_repr.id_alumno='$id_per_alumno'
		ORDER BY datos_per.nombres,datos_per.apellidos asc LIMIT 1
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

<table width="100%" border="1" cellpadding="0" cellspacing="1" bordercolor="#000000" style="border-collapse: collapse; font-weight: normal; " class="margenes">
<tr>
	<td width="50%"><strong>APELLIDOS Y NOMBRES: </strong><?php echo $fil_dat_repres["apellidos"]." ".$fil_dat_repres["nombres"];?></td>
	<td width="25%"><strong>PARENTESCO: </strong><?php echo $fil_dat_repres["parentesco"];?></td>
	<td width="25%"><strong>C&Eacute;DULA DE IDENTIDAD: </strong><?php echo $fil_dat_repres["tipo_doc_abr"]."-".number_format($fil_dat_repres["num_identificacion"], 0, ",", ".");?></td>
 </tr>
</table>
<?php
		echo "<br>";
		} //fin while
	} //FIN DE SI HUBO CONSULTA REPRESENTANTE
?>

<?php
//INICIO CONSULTA CALIFICACIONES

		$sql_asig="SELECT 
		asig_prog.des_mat_prog,asig_prog.tip_asig,
		asig_prog.mat_prog_cor,
		n1,n2,n3,
		i1,i2,i3,
		rev 
		FROM (alum_insc_notas 
		INNER JOIN asig_prog ON asig_prog.cod_asig_prog=alum_insc_notas.cod_asig_prog
		) WHERE 
		 	id_personal='$id_per_alumno' AND 
			cod_anno_esc='$cod_anno_esc' AND 
			cod_grado='$cod_grado' AND 
			asig_prog.tip_asig='AS' AND
			mat_pend=false ORDER BY 
			asig_prog.orden ASC
		";
		$consulta_asig=ejecuta_sql($sql_asig,false);
		if ($consulta_asig){
			
	?>
<table width="100%" border="1" cellpadding="0" cellspacing="1" bordercolor="#000000" style="border-collapse: collapse;" class="margenes">
<tr>
	<td width="30%" rowspan="2" class="titulo">ASIGNATURAS</td>
	<td width="15%" colspan="2" style="text-align: center"><strong>1 er Lapso</strong></td>
	<td width="15%" colspan="2" style="text-align: center"><strong>2do Lapso</strong></td>
	<td width="15%" colspan="2" style="text-align: center"><strong>3cer Lapso</strong></td>
	<td width="5%" style="text-align: center"><strong>DEF.</strong></td>
	<td width="5%" style="text-align: center"> <strong>REV.</strong></td>
	<td width="15%" colspan="2" style="text-align: center"><strong>Inasist</strong>.</td>
	</tr>
<tr>
  <td  width="5%" style="text-align: center"><strong>Cal</strong></td>
  <td width="5%" style="text-align: center"><strong>Inas</strong></td>
  <td width="5%" style="text-align: center"><strong>Cal</strong></td>
  <td width="5%"  style="text-align: center"><strong>Inas</strong></td>
  <td width="5%"  style="text-align: center"><strong>Cal</strong></td>
  <td width="5%"  style="text-align: center"><strong>Inas</strong></td>
  <td width="5%"  style="text-align: center"><strong>Cal</strong></td>
  <td width="5%"  style="text-align: center">&nbsp;</td>
  <td width="5%" style="text-align: center"><strong>Acum</strong></td>
  <td width="5%"  style="text-align: center"><strong><?php echo $porcen_inas_aplazado;?></strong>&#37</td>
</tr>
<?PHP
$arr_pro_L1="";
$arr_pro_L2="";
$arr_pro_L3="";
$arr_pro_i1="";
$arr_pro_i2="";
$arr_pro_i3="";
$arr_pro_def="";
$arr_pro_ti="";
while ($fil_notas=mysql_fetch_array($consulta_asig)){
			$asignatura=$fil_notas["des_mat_prog"];
			$asignatura_abr=$fil_notas["mat_prog_cor"];
			//nota lapso 01
			switch ($fil_notas["n1"]){
				case 0:
					$L1="-";
					break;
				case 1:
					$L1="I";
					$arr_pro_L1[].=$fil_notas["n1"];
					break;					
				default:
					$L1=pon_cero_izq($fil_notas["n1"],2);
					$arr_pro_L1[].=$fil_notas["n1"];
					break;
			}
			//nota lapso 02
			switch ($fil_notas["n2"]){
				case 0:
					$L2="-";
					break;
				case 1:
					$L2="I";
					$arr_pro_L2[].=$fil_notas["n2"];
					break;					
				default:
					$L2=pon_cero_izq($fil_notas["n2"],2);
					$arr_pro_L2[].=$fil_notas["n2"];
					break;
			}	
			//nota lapso 03
			switch ($fil_notas["n3"]){
				case 0:
					$L3="-";
					break;
				case 1:
					$L3="I";
					$arr_pro_L3[].=$fil_notas["n3"];
					break;					
				default:
					$L3=pon_cero_izq($fil_notas["n3"],2);
					$arr_pro_L3[].=$fil_notas["n3"];
					break;
			}	
			//inasistencias lapso 01
			switch ($fil_notas["i1"]){
				case 0:
					$i1="-";
					break;
				default:
					$i1=pon_cero_izq($fil_notas["i1"],2);
					$arr_pro_i1[].=$fil_notas["i1"];
					break;
			}
			//inasistencias lapso 02
			switch ($fil_notas["i2"]){
				case 0:
					$i2="-";
					break;
				default:
					$i2=pon_cero_izq($fil_notas["i2"],2);
					$arr_pro_i2[].=$fil_notas["i2"];
					break;
			}
			//inasistencias lapso 03
			switch ($fil_notas["i3"]){
				case 0:
					$i3="-";
					break;
				default:
					$i3=pon_cero_izq($fil_notas["i3"],2);
					$arr_pro_i3[].=$fil_notas["i3"];
					break;
			}	
			//TOTAL DE INASISTENCIAS:
			$tot_inas=$i1+$i2+$i3;
			if ($tot_inas>0){	
			$arr_pro_ti[].=$tot_inas;	}
			//$i1=pon_cero_izq($fil_notas["i1"],2);
			//$i2=pon_cero_izq($fil_notas["i2"],2);
			//$i3=pon_cero_izq($fil_notas["i3"],2);
			if ($fil_notas["rev"]>0){
				$rev=pon_cero_izq($fil_notas["rev"],2);}
			else {
				$rev="-";
			}
			unset($arr_notas);
			$arr_notas="";
			if ((int)$fil_notas["n1"]>0){
				$arr_notas[].=$fil_notas["n1"];
			}
			if ((int)$fil_notas["n2"]>0){
				$arr_notas[].=$fil_notas["n2"];
			}		
			if ((int)$fil_notas["n3"]>0){
				$arr_notas[].=$fil_notas["n3"];
			}	
			$definitiva=pon_cero_izq(round(promedio($arr_notas)),2);
			switch ($definitiva){
				case 0:
					$definitiva="-";
					break;
				case 1:
					$definitiva="I";
					$arr_pro_def[].=$definitiva;
					break;
				default:
					$definitiva=$definitiva;
					if (($L1>0 || $L1=="I" ) && ($L2>0 || $L2=="I" ) && ($L3>0 || $L3=="I" )) {$arr_pro_def[].=$definitiva;}
					
					break;
			}
			//calculo de % de 25 porciento
			if ($tot_inas>0 && $tot_dia_hab>0)
				$porc_inas=round($tot_inas*100/$tot_dia_hab)."&#37";
			else
				$porc_inas="-";
?>
<tr>
  <td ><?PHP echo $asignatura." - ".$asignatura_abr;?></td>
  <td style="text-align: center"><?php echo $L1?></td>
  <td style="text-align: center"><?php echo $i1?></td>
  <td style="text-align: center"><?php echo $L2?></td>
  <td style="text-align: center"><?php echo $i2?></td>
  <td style="text-align: center"><?php echo $L3?></td>
  <td style="text-align: center"><?php echo $i3?></td>
  <td style="text-align: center"><?php if (($L1>0 || $L1=="I" ) && ($L2>0 || $L2=="I" ) && ($L3>0 || $L3=="I" )) {echo $definitiva;} else {echo "-";}?></td>
  <td style="text-align: center"><?php echo $rev;?></td>
  <td style="text-align: center"><?php if ($tot_inas>0)echo $tot_inas; else echo "-";?></td>
  <td style="text-align: center"><?php echo $porc_inas;?></td>
</tr>
<?PHP
} // FIN WHILE
?>
<tr>
  <td align="right">Promedios / Totales</td>
  <td align="center"><?php echo pon_cero_izq(round(promedio($arr_pro_L1)),2); ?></td>
  <td align="center"><?php echo pon_cero_izq(round(promedio($arr_pro_i1)),2); ?></td>
  <td align="center"><?php echo pon_cero_izq(round(promedio($arr_pro_L2)),2); ?></td>
  <td align="center"><?php echo pon_cero_izq(round(promedio($arr_pro_i2)),2); ?></td>
  <td align="center"><?php echo pon_cero_izq(round(promedio($arr_pro_L3)),2); ?></td>
  <td align="center"><?php echo pon_cero_izq(round(promedio($arr_pro_i3)),2); ?></td>
  <td align="center"><?php if (promedio($arr_pro_def)>0){ echo pon_cero_izq(round(promedio($arr_pro_def)),2);} else echo "-";?></td>
  <td align="center"></td>
  <td align="center"><?php echo pon_cero_izq(round(promedio($arr_pro_ti)),2); ?></td>
  <td></td>
</tr>
</table>
<?php
		echo "<br>";
	} //FIN DE SI HUBO CONSULTA ASIGNATURAS
?>

<?php
//INICIO CONSULTA CALIFICACIONES DE PROGRAMAS

		$sql_asig="SELECT 
		asig_prog.des_mat_prog,asig_prog.tip_asig,
		asig_prog.mat_prog_cor,
		n1,n2,n3,
		i1,i2,i3,
		rev 
		FROM (alum_insc_notas 
		INNER JOIN asig_prog ON asig_prog.cod_asig_prog=alum_insc_notas.cod_asig_prog
		) WHERE 
		 	id_personal='$id_per_alumno' AND 
			cod_anno_esc='$cod_anno_esc' AND 
			mat_pend=true ORDER BY 
			asig_prog.orden ASC
		";
		$consulta_asig=ejecuta_sql($sql_asig,false);
		if ($consulta_asig){
			
	?>
<table width="100%" border="1" cellpadding="0" cellspacing="1" bordercolor="#000000" style="border-collapse: collapse;" class="margenes">
<tr>
	<td width="30%" rowspan="2" class="titulo">MATERIA(S) PENDIENTE(S)</td>
	<td width="15%" colspan="2" style="text-align: center"><strong>1er Lapso</strong></td>
	<td width="15%" colspan="2" style="text-align: center"><strong>2do Lapso</strong></td>
	<td width="15%" colspan="2" style="text-align: center"><strong>3cer Lapso</strong></td>
	<td width="5%" style="text-align: center"><strong>DEF.</strong></td>
	<td width="5%" style="text-align: center"> <strong>REV.</strong></td>
	<td width="15%" colspan="2" style="text-align: center"><strong>Inasist</strong>.</td>
	</tr>
<tr>
  <td  width="5%" style="text-align: center"><strong>Cal</strong></td>
  <td width="5%" style="text-align: center"><strong>Inas</strong></td>
  <td width="5%" style="text-align: center"><strong>Cal</strong></td>
  <td width="5%"  style="text-align: center"><strong>Inas</strong></td>
  <td width="5%"  style="text-align: center"><strong>Cal</strong></td>
  <td width="5%"  style="text-align: center"><strong>Inas</strong></td>
  <td width="5%"  style="text-align: center"><strong>Cal</strong></td>
  <td width="5%"  style="text-align: center">&nbsp;</td>
  <td width="5%" style="text-align: center"><strong>Acum</strong></td>
  <td width="5%"  style="text-align: center"><strong><?php echo $porcen_inas_aplazado;?></strong>&#37</td>
</tr>
<?PHP
$arr_pro_L1="";
$arr_pro_L2="";
$arr_pro_L3="";
$arr_pro_i1="";
$arr_pro_i2="";
$arr_pro_i3="";
$arr_pro_def="";
$arr_pro_ti="";
while ($fil_notas=mysql_fetch_array($consulta_asig)){
			$asignatura=$fil_notas["des_mat_prog"];
			$asignatura_abr=$fil_notas["mat_prog_cor"];
			//nota lapso 01
			switch ($fil_notas["n1"]){
				case 0:
					$L1="-";
					break;
				case 1:
					$L1="I";
					$arr_pro_L1[].=$fil_notas["n1"];
					break;					
				default:
					$L1=pon_cero_izq($fil_notas["n1"],2);
					$arr_pro_L1[].=$fil_notas["n1"];
					break;
			}
			//nota lapso 02
			switch ($fil_notas["n2"]){
				case 0:
					$L2="-";
					break;
				case 1:
					$L2="I";
					$arr_pro_L2[].=$fil_notas["n2"];
					break;					
				default:
					$L2=pon_cero_izq($fil_notas["n2"],2);
					$arr_pro_L2[].=$fil_notas["n2"];
					break;
			}	
			//nota lapso 03
			switch ($fil_notas["n3"]){
				case 0:
					$L3="-";
					break;
				case 1:
					$L3="I";
					$arr_pro_L3[].=$fil_notas["n3"];
					break;					
				default:
					$L3=pon_cero_izq($fil_notas["n3"],2);
					$arr_pro_L3[].=$fil_notas["n3"];
					break;
			}	
			//inasistencias lapso 01
			switch ($fil_notas["i1"]){
				case 0:
					$i1="-";
					break;
				default:
					$i1=pon_cero_izq($fil_notas["i1"],2);
					$arr_pro_i1[].=$fil_notas["i1"];
					break;
			}
			//inasistencias lapso 02
			switch ($fil_notas["i2"]){
				case 0:
					$i2="-";
					break;
				default:
					$i2=pon_cero_izq($fil_notas["i2"],2);
					$arr_pro_i2[].=$fil_notas["i2"];
					break;
			}
			//inasistencias lapso 03
			switch ($fil_notas["i3"]){
				case 0:
					$i3="-";
					break;
				default:
					$i3=pon_cero_izq($fil_notas["i3"],2);
					$arr_pro_i3[].=$fil_notas["i3"];
					break;
			}	
			//TOTAL DE INASISTENCIAS:
			$tot_inas=$i1+$i2+$i3;
			if ($tot_inas>0){	
			$arr_pro_ti[].=$tot_inas;	}
			//$i1=pon_cero_izq($fil_notas["i1"],2);
			//$i2=pon_cero_izq($fil_notas["i2"],2);
			//$i3=pon_cero_izq($fil_notas["i3"],2);
			if ($fil_notas["rev"]>0){
				$rev=pon_cero_izq($fil_notas["rev"],2);}
			else {
				$rev="-";
			}
			unset($arr_notas);
			$arr_notas="";
			if ((int)$fil_notas["n1"]>0){
				$arr_notas[].=$fil_notas["n1"];
			}
			if ((int)$fil_notas["n2"]>0){
				$arr_notas[].=$fil_notas["n2"];
			}		
			if ((int)$fil_notas["n3"]>0){
				$arr_notas[].=$fil_notas["n3"];
			}	
			$definitiva=pon_cero_izq(round(promedio($arr_notas)),2);
			switch ($definitiva){
				case 0:
					$definitiva="-";
					break;
				case 1:
					$definitiva="I";
					$arr_pro_def[].=$definitiva;
					break;
				default:
					$definitiva=$definitiva;
					if (($L1>0 || $L1=="I" ) && ($L2>0 || $L2=="I" ) && ($L3>0 || $L3=="I" )) {$arr_pro_def[].=$definitiva;}
					
					break;
			}
			//calculo de % de 25 porciento
			if ($tot_inas>0 && $tot_dia_hab>0)
				$porc_inas=round($tot_inas*100/$tot_dia_hab)."&#37";
			else
				$porc_inas="-";
?>
<tr>
  <td ><?PHP echo $asignatura." - ".$asignatura_abr;?></td>
  <td style="text-align: center"><?php echo $L1?></td>
  <td style="text-align: center"><?php echo $i1?></td>
  <td style="text-align: center"><?php echo $L2?></td>
  <td style="text-align: center"><?php echo $i2?></td>
  <td style="text-align: center"><?php echo $L3?></td>
  <td style="text-align: center"><?php echo $i3?></td>
  <td style="text-align: center"><?php if (($L1>0 || $L1=="I" ) && ($L2>0 || $L2=="I" ) && ($L3>0 || $L3=="I" )) {echo $definitiva;} else {echo "-";}?></td>
  <td style="text-align: center"><?php echo $rev;?></td>
  <td style="text-align: center"><?php if ($tot_inas>0)echo $tot_inas; else echo "-";?></td>
  <td style="text-align: center"><?php echo $porc_inas;?></td>
</tr>
<?PHP
} // FIN WHILE
?>
<tr>
  <td align="right">Promedios / Totales</td>
  <td align="center"><?php echo pon_cero_izq(round(promedio($arr_pro_L1)),2); ?></td>
  <td align="center"><?php echo pon_cero_izq(round(promedio($arr_pro_i1)),2); ?></td>
  <td align="center"><?php echo pon_cero_izq(round(promedio($arr_pro_L2)),2); ?></td>
  <td align="center"><?php echo pon_cero_izq(round(promedio($arr_pro_i2)),2); ?></td>
  <td align="center"><?php echo pon_cero_izq(round(promedio($arr_pro_L3)),2); ?></td>
  <td align="center"><?php echo pon_cero_izq(round(promedio($arr_pro_i3)),2); ?></td>
  <td align="center"><?php if (promedio($arr_pro_def)>0){ echo pon_cero_izq(round(promedio($arr_pro_def)),2);} else echo "-";?></td>
  <td align="center"></td>
  <td align="center"><?php echo pon_cero_izq(round(promedio($arr_pro_ti)),2); ?></td>
  <td></td>
</tr>
</table>
<?php
		echo "<br>";
	} //FIN DE SI HUBO CONSULTA MATERIA PENDIENTE
?>


<?php
//INICIO CONSULTA CALIFICACIONES DE PROGRAMAS

		$sql_asig="SELECT 
		asig_prog.des_mat_prog,asig_prog.tip_asig,
		asig_prog.mat_prog_cor,
		n1,n2,n3,
		i1,i2,i3,
		rev 
		FROM (alum_insc_notas 
		INNER JOIN asig_prog ON asig_prog.cod_asig_prog=alum_insc_notas.cod_asig_prog
		) WHERE 
		 	id_personal='$id_per_alumno' AND 
			cod_anno_esc='$cod_anno_esc' AND 
			cod_grado='$cod_grado' AND 
			asig_prog.tip_asig='PR' ORDER BY 
			asig_prog.orden ASC
		";
		$consulta_asig=ejecuta_sql($sql_asig,false);
		if ($consulta_asig){
			
	?>
<table width="100%" border="1" cellpadding="0" cellspacing="1" bordercolor="#000000" style="border-collapse: collapse;" class="margenes">
<tr>
	<td width="30%" rowspan="2" class="titulo">PROGRAMAS</td>
	<td width="15%" colspan="2" style="text-align: center"><strong>1er Lapso</strong></td>
	<td width="15%" colspan="2" style="text-align: center"><strong>2do Lapso</strong></td>
	<td width="15%" colspan="2" style="text-align: center"><strong>3cer Lapso</strong></td>
	<td width="5%" style="text-align: center"><strong>DEF.</strong></td>
	<td width="5%" style="text-align: center"> <strong>REV.</strong></td>
	<td width="15%" colspan="2" style="text-align: center"><strong>Inasist</strong>.</td>
	</tr>
<tr>
  <td  width="5%" style="text-align: center"><strong>Cal</strong></td>
  <td width="5%" style="text-align: center"><strong>Inas</strong></td>
  <td width="5%" style="text-align: center"><strong>Cal</strong></td>
  <td width="5%"  style="text-align: center"><strong>Inas</strong></td>
  <td width="5%"  style="text-align: center"><strong>Cal</strong></td>
  <td width="5%"  style="text-align: center"><strong>Inas</strong></td>
  <td width="5%"  style="text-align: center"><strong>Cal</strong></td>
  <td width="5%"  style="text-align: center">&nbsp;</td>
  <td width="5%" style="text-align: center"><strong>Acum</strong></td>
  <td width="5%"  style="text-align: center"><strong><?php echo $porcen_inas_aplazado;?></strong>&#37</td>
</tr>
<?PHP
$arr_pro_L1="";
$arr_pro_L2="";
$arr_pro_L3="";
$arr_pro_i1="";
$arr_pro_i2="";
$arr_pro_i3="";
$arr_pro_def="";
$arr_pro_ti="";
while ($fil_notas=mysql_fetch_array($consulta_asig)){
			$asignatura=$fil_notas["des_mat_prog"];
			$asignatura_abr=$fil_notas["mat_prog_cor"];
			//nota lapso 01
			switch ($fil_notas["n1"]){
				case 0:
					$L1="-";
					break;
				case 1:
					$L1="I";
					$arr_pro_L1[].=$fil_notas["n1"];
					break;					
				default:
					$L1=pon_cero_izq($fil_notas["n1"],2);
					$arr_pro_L1[].=$fil_notas["n1"];
					break;
			}
			//nota lapso 02
			switch ($fil_notas["n2"]){
				case 0:
					$L2="-";
					break;
				case 1:
					$L2="I";
					$arr_pro_L2[].=$fil_notas["n2"];
					break;					
				default:
					$L2=pon_cero_izq($fil_notas["n2"],2);
					$arr_pro_L2[].=$fil_notas["n2"];
					break;
			}	
			//nota lapso 03
			switch ($fil_notas["n3"]){
				case 0:
					$L3="-";
					break;
				case 1:
					$L3="I";
					$arr_pro_L3[].=$fil_notas["n3"];
					break;					
				default:
					$L3=pon_cero_izq($fil_notas["n3"],2);
					$arr_pro_L3[].=$fil_notas["n3"];
					break;
			}	
			//inasistencias lapso 01
			switch ($fil_notas["i1"]){
				case 0:
					$i1="-";
					break;
				default:
					$i1=pon_cero_izq($fil_notas["i1"],2);
					$arr_pro_i1[].=$fil_notas["i1"];
					break;
			}
			//inasistencias lapso 02
			switch ($fil_notas["i2"]){
				case 0:
					$i2="-";
					break;
				default:
					$i2=pon_cero_izq($fil_notas["i2"],2);
					$arr_pro_i2[].=$fil_notas["i2"];
					break;
			}
			//inasistencias lapso 03
			switch ($fil_notas["i3"]){
				case 0:
					$i3="-";
					break;
				default:
					$i3=pon_cero_izq($fil_notas["i3"],2);
					$arr_pro_i3[].=$fil_notas["i3"];
					break;
			}	
			//TOTAL DE INASISTENCIAS:
			$tot_inas=$i1+$i2+$i3;
			if ($tot_inas>0){	
			$arr_pro_ti[].=$tot_inas;	}
			//$i1=pon_cero_izq($fil_notas["i1"],2);
			//$i2=pon_cero_izq($fil_notas["i2"],2);
			//$i3=pon_cero_izq($fil_notas["i3"],2);
			if ($fil_notas["rev"]>0){
				$rev=pon_cero_izq($fil_notas["rev"],2);}
			else {
				$rev="-";
			}
			unset($arr_notas);
			$arr_notas="";
			if ((int)$fil_notas["n1"]>0){
				$arr_notas[].=$fil_notas["n1"];
			}
			if ((int)$fil_notas["n2"]>0){
				$arr_notas[].=$fil_notas["n2"];
			}		
			if ((int)$fil_notas["n3"]>0){
				$arr_notas[].=$fil_notas["n3"];
			}	
			$definitiva=pon_cero_izq(round(promedio($arr_notas)),2);
			switch ($definitiva){
				case 0:
					$definitiva="-";
					break;
				case 1:
					$definitiva="I";
					$arr_pro_def[].=$definitiva;
					break;
				default:
					$definitiva=$definitiva;
					if (($L1>0 || $L1=="I" ) && ($L2>0 || $L2=="I" ) && ($L3>0 || $L3=="I" )) {$arr_pro_def[].=$definitiva;}
					
					break;
			}
			//calculo de % de 25 porciento
			if ($tot_inas>0 && $tot_dia_hab>0)
				$porc_inas=round($tot_inas*100/$tot_dia_hab)."&#37";
			else
				$porc_inas="-";
?>
<tr>
  <td ><?PHP echo $asignatura." - ".$asignatura_abr;?></td>
  <td style="text-align: center"><?php echo $L1?></td>
  <td style="text-align: center"><?php echo $i1?></td>
  <td style="text-align: center"><?php echo $L2?></td>
  <td style="text-align: center"><?php echo $i2?></td>
  <td style="text-align: center"><?php echo $L3?></td>
  <td style="text-align: center"><?php echo $i3?></td>
  <td style="text-align: center"><?php if (($L1>0 || $L1=="I" ) && ($L2>0 || $L2=="I" ) && ($L3>0 || $L3=="I" )) {echo $definitiva;} else {echo "-";}?></td>
  <td style="text-align: center"><?php echo $rev;?></td>
  <td style="text-align: center"><?php if ($tot_inas>0)echo $tot_inas; else echo "-";?></td>
  <td style="text-align: center"><?php echo $porc_inas;?></td>
</tr>
<?PHP
} // FIN WHILE
?>
<tr>
  <td align="right">Promedios / Totales</td>
  <td align="center"><?php echo pon_cero_izq(round(promedio($arr_pro_L1)),2); ?></td>
  <td align="center"><?php echo pon_cero_izq(round(promedio($arr_pro_i1)),2); ?></td>
  <td align="center"><?php echo pon_cero_izq(round(promedio($arr_pro_L2)),2); ?></td>
  <td align="center"><?php echo pon_cero_izq(round(promedio($arr_pro_i2)),2); ?></td>
  <td align="center"><?php echo pon_cero_izq(round(promedio($arr_pro_L3)),2); ?></td>
  <td align="center"><?php echo pon_cero_izq(round(promedio($arr_pro_i3)),2); ?></td>
  <td align="center"><?php if (promedio($arr_pro_def)>0){ echo pon_cero_izq(round(promedio($arr_pro_def)),2);} else echo "-";?></td>
  <td align="center"></td>
  <td align="center"><?php echo pon_cero_izq(round(promedio($arr_pro_ti)),2); ?></td>
  <td></td>
</tr>
</table>
<?php
		echo "<br>";
	} //FIN DE SI HUBO CONSULTA PROGRAMAS
?>

<span>Observacciones</span>
<table width="100%" border="1" cellpadding="0" cellspacing="1" bordercolor="#000000" style="border-collapse: collapse; font-weight: normal; height:40px;" class="margenes">
<tr>
	<td>&nbsp;</td>
	</tr>
</table>
<span>Validaci&oacute;n de la instituci&oacute;n</span>
<table width="100%" border="1" cellpadding="0" cellspacing="1" bordercolor="#000000" style="border-collapse: collapse; font-weight: normal; height:60px;" class="margenes">
<tr>
	<td width="35%"><h6>Sello</h6>
	<h6>IMPRESO EL <?PHP echo date("d-m-Y")." POR: ".$_SESSION["nombre_usuario"];?></h6></td>
  <td width="15%">&nbsp;</td>
  <td width="35%"><h6>Firmas autorizadas</h6></td>
  <td width="15%">&nbsp;</td>
	</tr>
</table>
<?php
}
// si llego al final de cada alumno pongo un salto pagina
if ($i<sizeof($arr_chk_id_alum)-1 and $i!=0){
	?>
	<h6 class="SaltoDePagina"></h6>
<?php
} // fin si ens menor que el size para el salto de pagina
} // fin each para mostrar tooodas las boletas
} // fin se si se recibio el id_alumno y el id_a&Ntilde;o escolar
else {
	echo "<h2 align=\"center\">No se recibieron los datos para generar la planilla de inscripci&oacute;n</h2>";
}
?>
</body>
</html>