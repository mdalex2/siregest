<?php
if (empty($_GET["id_secc"]) && empty($_GET["cod_anno_esc"])){
	echo '<p align="center"<br/><br/><h2>&diams;&nbsp;No se han efectuado asignaciones de docentes a la secci&oacute;n seleccionada</h2></p>';
} else {
session_start();
$cod_sec=$_GET["id_secc"];
$cod_anno_esc=$_GET["cod_anno_esc"];
include_once('../funciones/conexion.php');
include_once('../funciones/funcionesPHP.php');
require_once('../class/fpdf/fpdf.php');
class PDF extends FPDF
{
var $widths;
var $aligns;

function SetWidths($w)
{
	//Set the array of column widths
	$this->widths=$w;
}

function SetAligns($a)
{
	//Set the array of column alignments
	$this->aligns=$a;
}

function Row($data)
{
	//Calculate the height of the row
	$nb=0;
	for($i=0;$i<count($data);$i++)
		$nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
	$h=5*$nb;
	//Issue a page break first if needed
	$this->CheckPageBreak($h);
	//Draw the cells of the row
	for($i=0;$i<count($data);$i++)
	{
		$w=$this->widths[$i];
		$a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
		//Save the current position
		$x=$this->GetX();
		$y=$this->GetY();
		//Draw the border
		
		$this->Rect($x,$y,$w,$h);

		$this->MultiCell($w,5,$data[$i],0,$a,'true');
		//Put the position to the right of the cell
		$this->SetXY($x+$w,$y);
	}
	//Go to the next line
	$this->Ln($h);
}

function CheckPageBreak($h)
{
	//If the height h would cause an overflow, add a new page immediately
	if($this->GetY()+$h>$this->PageBreakTrigger)
		$this->AddPage($this->CurOrientation);
}

function NbLines($w,$txt)
{
	//Computes the number of lines a MultiCell of width w will take
	$cw=&$this->CurrentFont['cw'];
	if($w==0)
		$w=$this->w-$this->rMargin-$this->x;
	$wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
	$s=str_replace("\r",'',$txt);
	$nb=strlen($s);
	if($nb>0 and $s[$nb-1]=="\n")
		$nb--;
	$sep=-1;
	$i=0;
	$j=0;
	$l=0;
	$nl=1;
	while($i<$nb)
	{
		$c=$s[$i];
		if($c=="\n")
		{
			$i++;
			$sep=-1;
			$j=$i;
			$l=0;
			$nl++;
			continue;
		}
		if($c==' ')
			$sep=$i;
		$l+=$cw[$c];
		if($l>$wmax)
		{
			if($sep==-1)
			{
				if($i==$j)
					$i++;
			}
			else
				$i=$sep+1;
			$sep=-1;
			$j=$i;
			$l=0;
			$nl++;
		}
		else
			$i++;
	}
	return $nl;
}

function Header()
{
	$this->Image('../images/sistema/logo_reporte.jpg',25 ,10,70,8,'JPG');
	$this->SetDrawColor(212,31,0);
	$this->SetLineWidth(.3);//Ancho de linea
  $this->Line(25,21,190,21);//Dibuja una linea (parametros)

	$this->SetFont('Arial','',8);
	//$this->Text(25,23,'Sistema de Registros Estudiantiles (Siregest) ',0,'R', 0);
	$this->Ln();
	$this->SetFont('Arial','B',13);
	$this->SetTextColor(15);
	$this->Text(100,13,'LISTADO DE ASIGNACIÓN DE DOCENTE',0,'C', 0);
	$this->Text(100,18,'SECCIÓN - CATEDRA',0,'C', 0);
	$this->Ln(3); //DISACIA DE INICIO DEL REPORTE A LOS DETALLES ORIGINAL 15
}

function Footer()
{
	$this->SetY(-15);
	$this->SetFont('Arial','',8);
	date_default_timezone_set("America/Caracas");
	$fecha_impre=date("d-m-Y h:m a"); 
	$usuario=utf8_decode(ucwords(strtolower($_SESSION["nombre_usuario"])));
	$this->Cell(100,10,'IMPRESO: '.$usuario.' '.$fecha_impre.' - Sistema de Registros Estudiantiles (Siregest)',0,0,'L');

}
//Tabla simple
}
	$strConsulta_encabeza = "select asig_prog.mat_prog_cor,asig_prog.des_mat_prog,datos_per.nombres,datos_per.apellidos,
	inst_secciones.cod_grado,grados_esc.grado_letras,inst_secciones.seccion_corto,
	 plan_est_tip.nivel_plan_est,instituciones.den_plantel_corta
	 from (asi_doc_sec 
		INNER JOIN datos_per on datos_per.id_personal=asi_doc_sec.id_profesor 
		INNER JOIN asig_prog on asig_prog.cod_asig_prog=asi_doc_sec.cod_asig_prog 
		INNER JOIN inst_secciones ON inst_secciones.id_seccion=asi_doc_sec.id_seccion 
		INNER JOIN grados_esc ON grados_esc.cod_grado=inst_secciones.cod_grado
		INNER JOIN plan_est_tip ON plan_est_tip.id_plan_nivel_est=inst_secciones.id_plan_nivel_est
		INNER JOIN instituciones ON instituciones.cod_plantel=inst_secciones.cod_plantel
		) where asi_doc_sec.id_seccion='$cod_sec' AND asi_doc_sec.cod_anno_esc='$cod_anno_esc' LIMIT 1";
	$strConsulta = "select asig_prog.mat_prog_cor,asig_prog.des_mat_prog,datos_per.nombres,datos_per.apellidos,
	inst_secciones.cod_grado,grados_esc.grado_letras,inst_secciones.seccion_corto,
	 plan_est_tip.nivel_plan_est
	 from (asi_doc_sec 
		INNER JOIN datos_per on datos_per.id_personal=asi_doc_sec.id_profesor 
		INNER JOIN asig_prog on asig_prog.cod_asig_prog=asi_doc_sec.cod_asig_prog 
		INNER JOIN inst_secciones ON inst_secciones.id_seccion=asi_doc_sec.id_seccion 
		INNER JOIN grados_esc ON grados_esc.cod_grado=inst_secciones.cod_grado
		inner JOIN plan_est_tip ON plan_est_tip.id_plan_nivel_est=inst_secciones.id_plan_nivel_est
		) where asi_doc_sec.id_seccion='$cod_sec' AND asi_doc_sec.cod_anno_esc='$cod_anno_esc'";
	
	$historial =ejecuta_sql($strConsulta,false);
	$registros_encabezando=ejecuta_sql($strConsulta_encabeza,true);
	if ($historial){
	$fila_header=mysql_fetch_array($registros_encabezando);	
	$pdf=new PDF('P','mm','Letter');
	$pdf->Open();
	$pdf->AddPage();
	$pdf->SetMargins(25,20,20);
	$pdf->Ln(14);
   
		//celda(ancho,alto,salto de linea,border,alineacion,relleno)
		$pdf->SetFont('Arial','B',12);$pdf->Cell(23,6,"PLANTEL: ",0,0,'L');$pdf->SetFont('Arial','',12);$pdf->Cell(30,6,utf8_decode($fila_header["den_plantel_corta"]),0,1,'L');
		$tit_secc="ANO ESCOLAR: ";
    $pdf->SetFont('Arial','B',12);$pdf->Cell(35,6,$tit_secc,0,0,'L');$pdf->SetFont('Arial','',12);$pdf->Cell(30,6,utf8_decode($cod_anno_esc)." (".utf8_decode($fila_header["nivel_plan_est"]).")",0,1,'L');
		$tit_ano_gra=("GRADO O ANO DE INSTRUCCIÓN: ");
		$pdf->SetFont('Arial','B',12);$pdf->Cell(73,6,$tit_ano_gra,0,0,'L');$pdf->SetFont('Arial','',12);$pdf->Cell(0,6,utf8_decode($fila_header["grado_letras"]),0,1,'L');
		$pdf->SetFont('Arial','B',12);$pdf->Cell(22,6,"SECCIÓN: ",0,0,'L');$pdf->SetFont('Arial','',12);$pdf->Cell(0,6,utf8_decode($fila_header["seccion_corto"]),0,1,'L');


	
	$pdf->Ln(12);
	
	$pdf->SetWidths(array(19, 75,75)); //indico longitud de columnas
	$pdf->SetFont('Arial','B',10);
	//$pdf->SetFillColor(85,107,47);
	$pdf->SetFillColor(85,127,170,85);
    $pdf->SetTextColor(255);

		for($i=0;$i<1;$i++)
			{
				$pdf->SetDrawColor(0,0,0);
				$pdf->SetLineWidth(.3);

				$pdf->Row(array('ABREV.', 'ASIGNATURAS','DOCENTE'));
			}
		
		
		
		
	$numfilas = mysql_num_rows($historial);
		//echo "<pre>".print_r($fila)."</pre>";
	for ($i=0; $i<$numfilas; $i++)
		{
			$fila = mysql_fetch_array($historial);
			$pdf->SetFont('Arial','',10);
			
					$pdf->SetFillColor(255,255,255);
    			$pdf->SetTextColor(0);
					$pdf->SetDrawColor(0,0,0);
					$pdf->SetLineWidth(.3);
					
				$pdf->Row(array(utf8_decode($fila['mat_prog_cor']), utf8_decode($fila['des_mat_prog']),utf8_decode($fila['nombres']." ".$fila['apellidos'])));
		}
		$pdf->Output();

//$pdf->Output('prueba.pdf','D');
} 
}

?>
