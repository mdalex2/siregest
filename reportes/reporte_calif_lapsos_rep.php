<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO9959-1" />
<title>Resumen de calificaciones</title>
<style type="text/css">


#cabecera, #menu, #lateral, #comentarios {
  display: none !important;
}
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
.SaltoDePagina
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
<script language="JavaScript">
//cerrar todas las ventanas. Script por tunait!
//http://javascript.tunait.com/
//tunait@yahoo.com
var cont = 0
function abreVentana(pagina)
{
cont++
eval('ventana'+ cont + "=window.open(pagina,'ventana'+cont,'')")
}

function cerrar()
{
for(m=1;m<=cont;m++)
	{
	if(eval('ventana' + m))
		{
		eval('ventana' + m + ".close()")
		}
	}
cont=0
}
</script>
</head>

<body style="font-family: Arial, Helvetica, sans-serif; font-size: 11px;">
<table width="100%" border="0">
  <tr>
    <td><img src="../images/sistema/barra_me3.png" width="100%"/></td>
    <td><img src="../images/sistema/corazon_vzlano_peq.png" width="79" height="74" /></td>
  </tr>
  <tr>
    <td colspan="2" align="center"><span colspan="2" style="font-size:16px" class="titulo">RESUMEN DE CALIFICACION DE LOS ESTUDIANTES POR LAPSOS</span></td>
  </tr>
</table>

<?php
session_start();
include_once("../funciones/funcionesPHP.php");
		if (!empty($_POST["cmb_secc"])){
			$id_seccion=$_POST["cmb_secc"];
			$cod_asig=$_POST["cmb_asig"];
			$cod_grado=$_POST["cmb_gra"];
			$cod_anno_esc=$_POST["cmb_anno_esc"];
			$cod_plantel=$_POST["cmb_plan"];
			
		}
		$consulta_secc=ejecuta_sql("select  inst_secciones.cod_plantel,inst_secciones.id_plan_nivel_est,inst_secciones.cod_mencion_educ,inst_secciones.cod_grado,inst_secciones.id_sector_educ,id_seccion,seccion_largo,seccion_corto,inst_secciones.fecha_g,grados_esc.grado_letras,inst_secciones.visible,menc_edu.mencion,plan_est_tip.nivel_plan_est,sectores_educ.sector_educ,instituciones.den_plantel from (inst_secciones 
		INNER JOIN grados_esc on grados_esc.cod_grado=inst_secciones.cod_grado
		INNER JOIN menc_edu ON menc_edu.cod_mencion_educ=inst_secciones.cod_mencion_educ
				INNER JOIN plan_est_tip ON plan_est_tip.id_plan_nivel_est=inst_secciones.id_plan_nivel_est
		INNER JOIN sectores_educ ON sectores_educ.id_sector_educ=inst_secciones.id_sector_educ
		INNER JOIN instituciones ON instituciones.cod_plantel=inst_secciones.cod_plantel

		) where inst_secciones.id_seccion='$id_seccion' LIMIT 1",true);
		if ($consulta_secc){
			$filas_secc=mysql_fetch_array($consulta_secc)
			
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
  <tr>
    <td colspan="2"><div class="ctrlHolder" style="margin:0px;">
     <p class="formHint" style="margin:0px;">ASIGNATURA:</p>
    <label><b><?php if (!empty($_POST["txt_nom_asig"])) echo $_POST["txt_nom_asig"]; else echo "NO DEFINIDA";;?></b></label>
    <br></div></td>
    <td colspan="2"><div class="ctrlHolder" style="margin:0px;">
    <?php
		$sql_bus_docent="SELECT datos_per.nombres,datos_per.apellidos FROM ( asi_doc_sec 
		INNER JOIN datos_per ON datos_per.id_personal=asi_doc_sec.id_profesor
		) WHERE	cod_anno_esc='$cod_anno_esc' AND  	id_seccion='$id_seccion' AND cod_asig_prog='$cod_asig'";
		$consult_docent=ejecuta_sql($sql_bus_docent,false);
		$docente="";
		if ($consult_docent){
			$fila_docente=mysql_fetch_array($consult_docent);
			$docente=$fila_docente["nombres"]." ".$fila_docente["apellidos"];
		}
		?>
      <p class="formHint" style="margin:0px;">DOCENTE:        </p>
      <label><b><?php echo $docente;?></b></label>
      <br></div></td>
    </tr>
</table>
<P class="titulo" align="center">ESTUDIANTES INSCRITOS EN LA SECCI&Oacute;N</P>
<!-- FIN FIELD DE RESUMEN DE ECNCABEZADO DE ASIGNATURA - SECCION -->
<table id="tabla_alumnos" class="margenes mouse_hover" width="100%" border="1" cellpadding="0" cellspacing="1" bordercolor="#000000" style="border-collapse: collapse;font-weight: normal; text-transform:uppercase;">
	<thead>
  <tr>
    <th width="...">N&deg;</th>
    <th width="...">N&deg; C&Eacute;DULA</th>
    <th width="...">APELLIDOS Y NOMBRES</th>
    <th title="Calificaci&oacute;n del primer lapso" width="...">LAP.1</th>
    <th width="..." title="Calificaci&oacute;n del segundo lapso">LAP.2</th>
    <th width="..." title="Calificaci&oacute;n del tercer lapso">LAP.3</th>
    <th width="..." title="N&deg; de inasistencias en el primero lapso">DEF.</th>
    <th width="..." title="N&deg; de inasistencias en el primero lapso">INA.1</th>
    <th width="..." title="N&deg; de inasistencias en el segundo lapso">INA.2</th>
    <th width="..." title="N&deg; de inasistencias en el tercer lapso">INA.3</th>
    <th width="..." title="Calificaci&oacute;n de revisi&oacute;n">REV.</th>
    <th  width="..."title="Tipo de evaluaci&oacute;n">TIP. EVA.</th>
  </tr>    
  </thead>
<tbody>
<?php
$sql_alumnos="SELECT 
alum_insc_notas.id_personal,
n1,n2,n3,i1,i2,i3,rev,
alum_insc_notas.id_tip_eval,tip_eval_calif.tipo_evaluacion,
tip_doc_per.tipo_doc,
tip_doc_per.tipo_doc_abr,
tip_doc_per.poner_num,
tip_doc_per.separador,
tip_doc_per.num_con_punto,
datos_per.num_identificacion,datos_per.nombres,datos_per.apellidos 
FROM (alum_insc_notas 
INNER JOIN datos_per ON datos_per.id_personal=alum_insc_notas.id_personal
INNER JOIN tip_doc_per ON tip_doc_per.cod_tip_doc_per=datos_per.cod_tip_doc_per
INNER JOIN tip_eval_calif ON tip_eval_calif.id_tip_eval=alum_insc_notas.id_tip_eval
)
WHERE alum_insc_notas.cod_anno_esc='$cod_anno_esc' AND alum_insc_notas.id_seccion='$id_seccion' AND alum_insc_notas.cod_asig_prog='$cod_asig'
ORDER BY datos_per.apellidos,datos_per.nombres ASC";
$cons_alumnos=ejecuta_sql($sql_alumnos,true);
$i=0;
if ($cons_alumnos){
	while ($fila_alum=mysql_fetch_array($cons_alumnos)){
		$i++;
		$id_alumno=$fila_alum["id_personal"];
		$num_id_per=$fila_alum["num_identificacion"];
		$tipo_doc_abr=$fila_alum["tipo_doc_abr"];
		$poner_num=$fila_alum["poner_num"];
		$separador=$fila_alum["separador"];
		$num_con_punto=$fila_alum["num_con_punto"];
		$apellidos_nombres=$fila_alum["apellidos"]." ".$fila_alum["nombres"];
		//calificaciones de lapsos BD
		$l1_bd=$fila_alum["n1"];
		$l2_bd=$fila_alum["n2"];
		$l3_bd=$fila_alum["n3"];
		$cr_bd=$fila_alum["rev"]; //calificacion revision
		
		//inasistencias BD
		$i1_bd=$fila_alum["i1"];
		$i2_bd=$fila_alum["i2"];
		$i3_bd=$fila_alum["i3"];	
		
		$cod_tip_eva_bd=$fila_alum["id_tip_eval"];
		$tip_eval=$fila_alum["tipo_evaluacion"];
?>
<tr>
  <td align="center"><?php echo $i;?></td>
  <td><?php echo formatear_id_personal($num_id_per,$tipo_doc_abr,$poner_num,$separador,$num_con_punto); ?></td>
  <td><?php echo $apellidos_nombres;?></td>
  <td align="center"><?php echo $l1_bd;?></td>
  <td align="center"><?php echo $l2_bd;?></td>
  <td align="center"><?php echo $l3_bd;?></td>
  <td align="center"><?php echo round(($l1_bd+$l2_bd+$l3_bd)/3);?></td>
  <td align="center"><?php echo $i1_bd;?></td>
  <td align="center" style="margin:0px;"><?php echo $i2_bd;?></td>
  <td align="center"><?php echo $i3_bd;?></td>
  <td align="center"><?php if ($cr_bd>0) echo $cr_bd; else echo "-";?></td>
  <td align="center"><?php echo $tip_eval;?></td>
</tr>
<?php
	} //fin while
} //fin if consulta alumnos
?>
</tbody>
</table>
<?php
		} // fin de si hubo consulta de seccion
?>


<br /><br /><br /><br />
<table width="100%" border="0" align="center">
<tr>
    <td width="30%" align="center" style="border-top:1px solid black;">RECIBIDO CONTROL ESTUDIO</td>
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
<button type="button" name="cerrar" id="cerrar" value="Imprimir" onclick="window.close();"><img src="../images/sistema/close_windows.png" width="32" height="32" align="absmiddle" />&nbsp;Cerrar</button>
</td>
    <td width="30%" align="center" style="border-top:1px solid black;">FIRMA DEL DOCENTE </td>
  </tr>
  <tr>
    <td align="center" ><p class="formHint" style="margin:0px;">NOMBRE:</p></td>
    <td>&nbsp;</td>
    <td align="center" >&nbsp;</td>
  </tr>
  
</table>
</body>
</html>