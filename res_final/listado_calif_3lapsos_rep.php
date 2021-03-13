<?php
header( 'Content-Type: text/html; charset=UTF-8' );
/** Error reporting */
//error_reporting(0);
session_start();
require_once("../funciones/funcionesPHP.php");
require_once("../funciones/conexion.php");


/** Include path **/
//ini_set('include_path', ini_get('include_path').';../class/php_excel/');

/** PHPExcel */

include '../class/php_excel/PHPExcel.php';

/** PHPExcel_Writer_Excel2007 */
//include '../class/php_excel/PHPExcel/Writer/Excel2007.php';

// Create new PHPExcel object
require_once '../class/php_excel/PHPExcel/IOFactory.php';
$objPHPExcel = PHPExcel_IOFactory::load("../plantillas/listado_calif_3lapsos.xls");
// Set properties
$objPHPExcel->getProperties()->setCreator("SIREGEST");
$objPHPExcel->getProperties()->setTitle("CALIFICACION TRES LAPSOS");
// RENOMBRO LA HOJA
$objPHPExcel->getActiveSheet()->setTitle('Calificaciones Tres Lapsos');
//AGREGO DATOS
$objPHPExcel->setActiveSheetIndex(0);
    $objPageSetup = new PHPExcel_Worksheet_PageSetup();
    $objPageSetup->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LEGAL);
		//SI ES VERITCAL:  PORTRAIT   HORIZONTAL:LANDSCAPE
    $objPageSetup->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
    $objPageSetup->setFitToWidth(1); //UNA PAGINA POR HOJA
		//$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToPage(true);
		//$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToWidth(0);
		//$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToHeight(1);    
    $objPHPExcel->getActiveSheet()->setPageSetup($objPageSetup);
$objPHPExcel->getActiveSheet()->SetCellValue('A1', $_SESSION["E1"]);	
$objPHPExcel->getActiveSheet()->SetCellValue('A2', $_SESSION["E2"]);
$usuario=strtoupper($_SESSION["nombre_usuario"]);
$fecha_actual=fecha_actual("mysql");  
$impreso_por=strtoupper("IMPRESO POR:".$usuario." - ".formato_fecha("LH",$fecha_actual));
//echo $fecha_imp;
//exit();
//$fecha_imp=strftime("%d/%b/%Y-%I:%M %p",date("d-m-Y H:i:s"));
$objPHPExcel->getActiveSheet()->SetCellValue('A59',$impreso_por);
// COLOCO NOMBRE DEL SISTEMA Y VERSION
$objPHPExcel->getActiveSheet()->SetCellValue('BA59',$_SESSION["app_nombre"]." - ".$_SESSION["app_version"]);

//CONFIGURO LAS POSICIONES DEL ENCABEZADO DE LA ASIGNATURA
$e_asig = array("O11", "S11", "W11", "AA11","AE11","AI11","AM11","AQ11","AU11","AY11","BC11","BG11","BK11","BO11","BS11");
//CONFIGURO LA COLUNA Y FILA DE LOS LAPSOS
$col_ced="B";
$col_alum="F";
$fil_alum=12;
$tot_ins_l1=0;$tot_ins_l2=0;$tot_ins_l3=0;$tot_ins_def=0;
$tot_np_l1=0;$tot_np_l2=0;$tot_np_l3=0;$tot_np_def=0;

//SE AGREGAN LOS DATOS
$id_seccion=$_POST["cmb_secc"];
$cod_anno_esc=$_POST["cmb_anno_esc"];
$sql_encabezado="SELECT instituciones.den_plantel,
inst_secciones.cod_plantel,
terr_poblados.poblado,
terr_municipios.municipio,
terr_estados.estado_ter,
grados_esc.grado_letras,
inst_secciones.seccion_largo,
plan_est_tip.cod_plan_nivel_me,
plan_est_tip.nivel_plan_est,
inst_secciones.id_plan_nivel_est,
inst_secciones.cod_grado,
inst_secciones.cod_mencion_educ,
menc_edu.mencion,
inst_secciones.id_sector_educ,
sectores_educ.sector_educ
FROM (inst_secciones 
INNER JOIN instituciones ON instituciones.cod_plantel=inst_secciones.cod_plantel 
INNER JOIN terr_poblados ON instituciones.id_poblado=terr_poblados.id_poblado 
INNER JOIN terr_estados ON terr_poblados.cod_estado_ter=terr_estados.cod_estado_ter 
INNER JOIN terr_municipios ON terr_municipios.cod_municipio=terr_poblados.cod_municipio and terr_municipios.cod_estado_ter=terr_estados.cod_estado_ter 
INNER JOIN grados_esc ON grados_esc.cod_grado=inst_secciones.cod_grado 
INNER JOIN plan_est_tip ON plan_est_tip.id_plan_nivel_est=inst_secciones.id_plan_nivel_est 
INNER JOIN menc_edu ON menc_edu.cod_mencion_educ=inst_secciones.cod_mencion_educ
INNER JOIN sectores_educ ON sectores_educ.id_sector_educ=inst_secciones.id_sector_educ 
) WHERE inst_secciones.id_seccion='$id_seccion'";
//Extraemos los registros de la base de datos mysql
//$server="mysql.hostinger.es";
$server=$_SESSION["host"];
$database=$_SESSION["bd"];
$dbuser=$_SESSION["usuario_bd"];
$dbpass=$_SESSION["password"];

$conexion=mysql_connect($server,$dbuser,$dbpass);
mysql_query("SET NAMES 'utf8'");
mysql_select_db($database,$conexion);
$cons_encabezado=mysql_query($sql_encabezado,$conexion);
mysql_query("SET NAMES 'utf8'");
if (!$cons_encabezado){
	die("<h2>No se han encontrado registros del plantel</h2>".mysql_error());
	} else {
	$fila_enc=mysql_fetch_array($cons_encabezado);
	$id_plan_nivel_est=$fila_enc["id_plan_nivel_est"];
	$cod_grado =$fila_enc["cod_grado"];
	$cod_mencion_educ=$fila_enc["cod_mencion_educ"];
	$id_sector_educ=$fila_enc["id_sector_educ"];
	$nombre_plantel=$fila_enc["den_plantel"];
	$cod_plantel=$fila_enc["cod_plantel"];
	$cod_plan_nivel_me=$fila_enc["cod_plan_nivel_me"];
	$plan_est=($fila_enc["nivel_plan_est"]);
	$sector_educ=($fila_enc["sector_educ"]);
	$localidad=trans_texto((("ESTADO: ".$fila_enc["estado_ter"]." / MUNICIPIO: ".$fila_enc["municipio"]." / POBLADO: ".$fila_enc["poblado"])),"MA");
	$grado_letras=($fila_enc["grado_letras"]);
	$seccion_largo=($fila_enc["seccion_largo"]);
	$mencion=($fila_enc["mencion"]);
	
	
	$objPHPExcel->getActiveSheet()->SetCellValue('A4',$nombre_plantel);
	$objPHPExcel->getActiveSheet()->SetCellValue('A5',"CÓDIGO: ".$cod_plantel);
	$objPHPExcel->getActiveSheet()->SetCellValue('A6',$localidad);
	$objPHPExcel->getActiveSheet()->SetCellValue('A8',$cod_anno_esc);
	$objPHPExcel->getActiveSheet()->SetCellValue('E8',$grado_letras);
	$objPHPExcel->getActiveSheet()->SetCellValue('M8',$seccion_largo);
	$objPHPExcel->getActiveSheet()->SetCellValue('U8',$mencion);	
	$objPHPExcel->getActiveSheet()->SetCellValue('AB8',$cod_plan_nivel_me);	
	$objPHPExcel->getActiveSheet()->SetCellValue('AE8',$plan_est." (".$sector_educ.")");	
	
// ----- obtengo los estudiantes de la seccion ---------
$sql_estudiantes="SELECT DISTINCT
	alum_insc_notas.id_personal,
 	datos_per.nombres,
	datos_per.apellidos,
	tip_doc_per.tipo_doc,
	tip_doc_per.tipo_doc_abr,
	tip_doc_per.poner_num,
	tip_doc_per.separador,
	tip_doc_per.num_con_punto,
	datos_per.num_identificacion,
	anno_esc_me.calif_min
	FROM (
	alum_insc_notas 
	INNER JOIN datos_per ON datos_per.id_personal=alum_insc_notas.id_personal
	INNER JOIN tip_doc_per ON tip_doc_per.cod_tip_doc_per=datos_per.cod_tip_doc_per
	INNER JOIN anno_esc_me ON anno_esc_me.cod_anno_esc=alum_insc_notas.cod_anno_esc
	) 
	WHERE alum_insc_notas.cod_anno_esc='$cod_anno_esc' AND id_seccion='$id_seccion' LIMIT 40";	
$cons_estud=mysql_query($sql_estudiantes,$conexion);
if (!$cons_estud){
	die("<h2>No se han encontrado registros del plantel</h2>".mysql_error());
	} else {
		while ($fil_estud=mysql_fetch_array($cons_estud)){
			$fil_alum++;
			$calif_min=$fil_estud["calif_min"];
			$id_personal=$fil_estud["id_personal"];
			$nombres=$fil_estud["nombres"];
			$apellidos=$fil_estud["apellidos"];
			$tipo_doc=$fil_estud["tipo_doc"];
			$tipo_doc_abr=$fil_estud["tipo_doc_abr"];
			$poner_num=$fil_estud["poner_num"];
			$separador=$fil_estud["separador"];
			$num_con_punto=$fil_estud["num_con_punto"];
			$num_identificacion=$fil_estud["num_identificacion"];
			$cedula=formatear_id_personal($num_identificacion,$tipo_doc_abr,$poner_num,$separador,$num_con_punto);
			//calculo total de inscritos 
			$tot_ins_l1++;
			$tot_ins_l2++;
			$tot_ins_l3++;
			//PONGO LA NOTA MINIMA APROBATORIA PARA CALUCULO
			$objPHPExcel->getActiveSheet()->SetCellValue("A56",$calif_min);	
			//comienzo a poner los datos del alumno
			$objPHPExcel->getActiveSheet()->SetCellValue($col_ced.$fil_alum,$cedula);	
			$objPHPExcel->getActiveSheet()->SetCellValue($col_alum.$fil_alum,$nombres." ".$apellidos);
			//BUSCO ASIGNATURAS DEL PLAN DE ESTUDIO 
			//PARA VERIFICAR SI EL ALUMNO TIENE NOTAS Y COLOCARLAR ALLI
			$sql_asignaturas="SELECT plan_est_conf.cod_asig_prog,asig_prog.des_mat_prog,asig_prog.mat_prog_med
  FROM (plan_est_conf
	INNER JOIN asig_prog ON asig_prog.cod_asig_prog=plan_est_conf.cod_asig_prog
	)
	WHERE id_plan_nivel_est='$id_plan_nivel_est' AND cod_grado='$cod_grado' AND cod_mencion_educ='$cod_mencion_educ' AND id_sector_educ='$id_sector_educ'
	ORDER BY asig_prog.orden ASC";
//configuro la letra donde comenzaran a pintarse las notas 
//en N 
$col_lap="N";
$cons_asig=mysql_query($sql_asignaturas,$conexion);
if (!$cons_asig){
	die("<h2>No se han encontrado las asignaturas</h2>".mysql_error());
	} else {
		$pos_fil_enc_asig=-1;		
		while ($fil_asig=mysql_fetch_array($cons_asig)){
$tot_apro_l1[]=0;$tot_apro_l2[]=0;$tot_apro_l3[]=0;$tot_apro_def[]=0;
$tot_apla_l1[]=0;$tot_apla_l2[]=0;$tot_apla_l3[]=0;$tot_apla_def[]=0;
			
			$cod_asig_prog=$fil_asig["cod_asig_prog"];
			$pos_fil_enc_asig++;
			$asig_abr=($fil_asig["mat_prog_med"]);
			$objPHPExcel->getActiveSheet()->SetCellValue($e_asig[$pos_fil_enc_asig],$asig_abr);
			
			//BUSCO NOTAS PARA CADA ASIGNATURA

			$fil_lap=$fil_alum;

			$sql_notas="SELECT n1,n2,n3 FROM alum_insc_notas WHERE cod_anno_esc='$cod_anno_esc' AND id_seccion='$id_seccion' AND id_personal='$id_personal' AND cod_asig_prog='$cod_asig_prog'";
		$cons_notas=mysql_query($sql_notas,$conexion);
		if (!$cons_notas){
			die("<h2>No se han encontrado registros de notas</h2>".mysql_error());
			} else {
				$col_lap++;
				//MUESTRO LAS NOTAS PARA CADA ASIG
				if (mysql_num_rows($cons_notas)>0){								
				$fil_notas=mysql_fetch_array($cons_notas);
				$l1=$fil_notas["n1"];
				$l2=$fil_notas["n2"];
				$l3=$fil_notas["n3"];
				switch ($l1){
					case 0:
						$l1="NR";
						break;
					case 1:
						$l1="I";
						$tot_np_l1++;
						break;
					default:
						$l1=pon_cero_izq($fil_notas["n1"],2);
						break;						
				}
				switch ($l2){
					case 0:
						$l2="NR";
						break;
					case 1:
						$l2="I";
						$tot_np_l2++;
						break;	
					default:
						$l2=pon_cero_izq($fil_notas["n2"],2);
						break;						
											
				}		
				switch ($l3){
					case 0:
						$l3="NR";
						break;
					case 1:
						$l3="I";
						$tot_np_l3++;
						break;
					default:
						$l3=pon_cero_izq($fil_notas["n3"],2);
						break;						
												
				}									
				$def=pon_cero_izq(round(($fil_notas["n1"]+$fil_notas["n2"]+$fil_notas["n3"])/3),2);
				$def_calc=pon_cero_izq(round(($fil_notas["n1"]+$fil_notas["n2"]+$fil_notas["n3"])/3),2);
				switch ($def){
					case 0:
						$def="NR";
						break;
					case 1:
						$def="I";
						$tot_np_def++;
						break;						
				}
				//CALCULO LOS TOTALES APROBADO Y APLAZADOS
				if ($fil_notas["n1"]>=$calif_min){
					$tot_apro_l1[$pos_fil_enc_asig]++;
				} else {
						$tot_apla_l1[$pos_fil_enc_asig]++;
				}
				if ($fil_notas["n2"]>=$calif_min){
					$tot_apro_l2[$pos_fil_enc_asig]++;
				} else {
						$tot_apla_l2[$pos_fil_enc_asig]++;
				}	
				if ($fil_notas["n3"]>=$calif_min){
					$tot_apro_l3[$pos_fil_enc_asig]++;
				} else {
						$tot_apla_l3[$pos_fil_enc_asig]++;
				}	
				if ($def_calc>=$calif_min){
					$tot_apro_def[$pos_fil_enc_asig]++;
				} else {
					$tot_apla_def[$pos_fil_enc_asig]++;
				}															
				//MUESTRO LAS NOTAS PARA CADA ASIG
				$objPHPExcel->getActiveSheet()->SetCellValue($col_lap.$fil_lap,$l1);	
				$objPHPExcel->getActiveSheet()->getStyle($col_lap.$fil_lap)->getNumberFormat()
->setFormatCode('00');  //formato numero con un cero antes ejm 08

				//muestro el totales lap1
				$objPHPExcel->getActiveSheet()->SetCellValue($col_lap."54",$tot_ins_l1);	
				$objPHPExcel->getActiveSheet()->SetCellValue($col_lap."55",$tot_np_l1);	
				$objPHPExcel->getActiveSheet()->SetCellValue($col_lap."56",$tot_apro_l1[$pos_fil_enc_asig]);
				$objPHPExcel->getActiveSheet()->SetCellValue($col_lap."57",$tot_apla_l1[$pos_fil_enc_asig]);				
				//-----------------------------------
				$col_lap++;
				$objPHPExcel->getActiveSheet()->SetCellValue($col_lap.$fil_lap,$l2);
				$objPHPExcel->getActiveSheet()->getStyle($col_lap.$fil_lap)->getNumberFormat()
->setFormatCode('00'); 

				$objPHPExcel->getActiveSheet()->SetCellValue($col_lap."54",$tot_ins_l2);		
				$objPHPExcel->getActiveSheet()->SetCellValue($col_lap."55",$tot_np_l2);
				$objPHPExcel->getActiveSheet()->SetCellValue($col_lap."56",$tot_apro_l2[$pos_fil_enc_asig]);
				$objPHPExcel->getActiveSheet()->SetCellValue($col_lap."57",$tot_apla_l2[$pos_fil_enc_asig]);				
				
				//---------------------------------				
				$col_lap++;
				$objPHPExcel->getActiveSheet()->SetCellValue($col_lap.$fil_lap,$l3);
				$objPHPExcel->getActiveSheet()->getStyle($col_lap.$fil_lap)->getNumberFormat()
->setFormatCode('00'); 
	
				$objPHPExcel->getActiveSheet()->SetCellValue($col_lap."54",$tot_ins_l3);	
				$objPHPExcel->getActiveSheet()->SetCellValue($col_lap."55",$tot_np_l3);	
				$objPHPExcel->getActiveSheet()->SetCellValue($col_lap."56",$tot_apro_l3[$pos_fil_enc_asig]);
				$objPHPExcel->getActiveSheet()->SetCellValue($col_lap."57",$tot_apla_l3[$pos_fil_enc_asig]);				
							
				//-----------------------------------
				$col_lap++;	
				$objPHPExcel->getActiveSheet()->SetCellValue($col_lap.$fil_lap,$def);	
				$objPHPExcel->getActiveSheet()->getStyle($col_lap.$fil_lap)->getNumberFormat()
->setFormatCode('00'); 

				$objPHPExcel->getActiveSheet()->SetCellValue($col_lap."54",$tot_ins_l3);	
				$objPHPExcel->getActiveSheet()->SetCellValue($col_lap."55",$tot_np_def);	
				$objPHPExcel->getActiveSheet()->SetCellValue($col_lap."56",$tot_apro_def[$pos_fil_enc_asig]);
				$objPHPExcel->getActiveSheet()->SetCellValue($col_lap."57",$tot_apla_def[$pos_fil_enc_asig]);				
							
				} //fin de si mysql nm rows>0 en notas
				else {
					//si no se eocnotro la materia inscrita es que no curso
				$objPHPExcel->getActiveSheet()->SetCellValue($col_lap.$fil_lap,"NC");					
				$col_lap++;
				$objPHPExcel->getActiveSheet()->SetCellValue($col_lap.$fil_lap,"NC");	
				$col_lap++;
				$objPHPExcel->getActiveSheet()->SetCellValue($col_lap.$fil_lap,"NC");	
				$col_lap++;	
				$objPHPExcel->getActiveSheet()->SetCellValue($col_lap.$fil_lap,"-");	
				
				} // FIN ELSE EN CASO Q NO HAYA MAS DE 1 REISTRO NOTAS
				
			} // fin else consulta de notas
			
			
			
		} // fin while asignaturas
	       }//fin else asignaturas
			
		} // FIN WHILE ESTUDIANTES
	} // FIN ELSE SI NO HUBO CONSULTA DE ESTUDIANTES
} // fin se si se consulto el encabezado y no hubo error


//muestro el encabezado


//------------ MUESTRO EL ARCHIVO -------
// Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
/*
header ("Expires: Thu, 27 Mar 1980 23:59:00 GMT"); //la pagina expira en una fecha pasada
header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); //ultima actualizacion ahora cuando la cargamos
header ("Cache-Control: no-cache, must-revalidate"); //no guardar en CACHE
header ("Pragma: no-cache"); 
//excel2003
header('Content-Type: application/vnd.ms-excel');
//excel 2007
//header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

header('Content-Disposition: attachment;filename="SIREGEST-Calificaciones_3lapsos.xls"');
header('Cache-Control: max-age=0');
*/

// PREPARO LA SEGURIDAD DE LA HOJA DE CALCULO
//alimentamos el generador de aleatorios
mt_srand (time());
//generamos un número aleatorio para la clave
$numero_aleatorio = mt_rand(0,99999999); 
$objPHPExcel->getSecurity()->setLockWindows(true);
$objPHPExcel->getSecurity()->setLockStructure(true);
$objPHPExcel->getSecurity()->setWorkbookPassword("$numero_aleatorio");
$objPHPExcel->getActiveSheet()->getProtection()->setPassword('$numero_aleatorio');
$objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);
$objPHPExcel->getActiveSheet()->getProtection()->setSort(true);
$objPHPExcel->getActiveSheet()->getProtection()->setInsertRows(true);
$objPHPExcel->getActiveSheet()->getProtection()->setFormatCells(true);
$objPHPExcel->setActiveSheetIndex(0);

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
if (!file_exists("../docs")){
		mkdir("../docs",0777);}
$nombre_archivo="../docs/".$_SESSION['id_usuario']."_lis_cal_3Lap.xls";
$objWriter->save($nombre_archivo);
header("location:$nombre_archivo");
exit();
// Echo done
?>