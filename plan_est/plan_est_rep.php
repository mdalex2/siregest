<?php
if (empty($_GET["id_pla"]) && empty($_GET["cod_sec"]) && empty($_GET["cod_men"]) && empty($_GET["cod_gra"])){
	echo '<p align="center"<br/><br/><h2>&diams;&nbsp;Plan de estudio no encontrado</h2></p>';
} else {
session_start();
$id_pla=$_GET["id_pla"];
$cod_sec=$_GET["cod_sec"];
$cod_men=$_GET["cod_men"];
$cod_gra=$_GET["cod_gra"];
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
	$this->Text(100,13,'LISTADO DE ASIGNACIÓN DE MATERIAS',0,'C', 0);
	$this->Text(100,18,'A PLAN DE ESTUDIO',0,'C', 0);
	$this->Ln(3); //DISACIA DE INICIO DEL REPORTE A LOS DETALLES ORIGINAL 15
}

function Footer()
{
	$this->SetY(-15);
	$this->SetFont('Arial','',8);
	date_default_timezone_set("America/Caracas");
	$fecha_impre=date("d-m-Y h:m a"); 
	$usuario=ucwords(strtolower($_SESSION["nombre_usuario"]));
	$this->Cell(100,10,'IMPRESO: '.utf8_decode($usuario).' '.utf8_decode($fecha_impre).' - Sistema de Registros Estudiantiles (SIREGEST)',0,0,'L');

}
//Tabla simple
}
	$pdf=new PDF('P','mm','Letter');
	$pdf->Open();
	$pdf->AddPage();
	$pdf->SetMargins(25,20,20);
	$pdf->Ln(14);
   
	$strConsultaH = "SELECT nivel_plan_est,sector_educ,cod_plan_nivel_me,mencion,grados_esc.grado_letras,asig_prog.mat_prog_cor,asig_prog.des_mat_prog, plan_est_conf.cod_asig_prog from (plan_est_conf
	inner join plan_est_tip on plan_est_tip.id_plan_nivel_est=plan_est_conf.id_plan_nivel_est 
	inner join sectores_educ on sectores_educ.id_sector_educ=plan_est_conf.id_sector_educ
	inner join menc_edu on menc_edu.cod_mencion_educ=plan_est_conf.cod_mencion_educ 
	inner join grados_esc on grados_esc.cod_grado=plan_est_conf.cod_grado   	
	inner join asig_prog on asig_prog.cod_asig_prog=plan_est_conf.cod_asig_prog
	) where plan_est_conf.id_plan_nivel_est='$id_pla' and plan_est_conf.cod_grado='$cod_gra' and plan_est_conf.cod_mencion_educ='$cod_men' and plan_est_conf.id_sector_educ='$cod_sec' order by plan_est_conf.orden asc LIMIT 0,1";
	
	$historialH =ejecuta_sql($strConsultaH,false);
	
	if ($historialH){
	$numfilasH = mysql_num_rows($historialH);
	$filaH = mysql_fetch_array($historialH);
	
		//celda(ancho,alto,salto de linea,border,alineacion,relleno)
		$TI1=("CÓDIGO ");
		$TME=("CÓDIGO ME: ");
    $pdf->SetFont('Arial','B',12);$pdf->Cell(8,6,"ID: ",0,0,'L');$pdf->SetFont('Arial','',12);$pdf->Cell(0,6,utf8_decode($id_pla),0,1,'L');
		$pdf->SetFont('Arial','B',12);$pdf->Cell(28,6,$TME,0,0,'L');$pdf->SetFont('Arial','',12);$pdf->Cell(0,6,utf8_decode($filaH["cod_plan_nivel_me"]),0,1,'L');
		$pdf->SetFont('Arial','B',12);$pdf->Cell(42,6,"PLAN DE ESTUDIO: ",0,0,'L');$pdf->SetFont('Arial','',12);$pdf->Cell(0,6,utf8_decode($filaH["nivel_plan_est"]),0,1,'L');
		$pdf->SetFont('Arial','B',12);$pdf->Cell(24,6,"SECTOR: ",0,0,'L');$pdf->SetFont('Arial','',12);$pdf->Cell(0,6,utf8_decode($filaH["sector_educ"]),0,1,'L');		
		$tit_men=("MENCIÓN: ");
		$pdf->SetFont('Arial','B',12);$pdf->Cell(24,6,$tit_men,0,0,'L');$pdf->SetFont('Arial','',12);$pdf->Cell(0,6,utf8_decode($filaH["mencion"]),0,1,'L');
		$tit_gra=("GRADO O AÑO: ");
				$pdf->SetFont('Arial','B',12);$pdf->Cell(35,6,$tit_gra,0,0,'L');$pdf->SetFont('Arial','',12);$pdf->Cell(0,6,utf8_decode($filaH["grado_letras"]),0,1,'L');

	
	$pdf->Ln(12);
	
	$pdf->SetWidths(array(19, 150)); //indico longitud de columnas
	$pdf->SetFont('Arial','B',10);
	//$pdf->SetFillColor(85,107,47);
	$pdf->SetFillColor(85,127,170);
    $pdf->SetTextColor(255);

		for($i=0;$i<1;$i++)
			{
				$pdf->SetDrawColor(0,0,0);
				$pdf->SetLineWidth(.3);

				$pdf->Row(array($TI1, 'ASIGNATURAS'));
			}
	} //fin de si hubo consulta de los headers
	$strConsulta = "SELECT asig_prog.mat_prog_cor,asig_prog.des_mat_prog, plan_est_conf.cod_asig_prog from (plan_est_conf 
	inner join asig_prog on asig_prog.cod_asig_prog=plan_est_conf.cod_asig_prog
	) where plan_est_conf.id_plan_nivel_est='$id_pla' and plan_est_conf.cod_grado='$cod_gra' and plan_est_conf.cod_mencion_educ='$cod_men' and plan_est_conf.id_sector_educ='$cod_sec' order by plan_est_conf.orden asc";
	
	$historial =ejecuta_sql($strConsulta,true);
	if ($historial){
	$numfilas = mysql_num_rows($historial);
		//echo "<pre>".print_r($fila)."</pre>";
	for ($i=0; $i<$numfilas; $i++)
		{
			$fila = mysql_fetch_array($historial);
			$pdf->SetFont('Arial','',10);
			
			if($i%2 == 1)
			{
				$pdf->SetFillColor(255,255,255); // color linea
    		$pdf->SetTextColor(0); //color texto
				$pdf->SetDrawColor(0,0,0); //color linea
				$pdf->SetLineWidth(.3); //bordes
				
				$pdf->Row(array(utf8_decode($fila['mat_prog_cor']),utf8_decode($fila['des_mat_prog'])));
			}
			else
			{
					$pdf->SetFillColor(255,255,255);
    			$pdf->SetTextColor(0);
					$pdf->SetDrawColor(0,0,0);
					$pdf->SetLineWidth(.3);
					
				$pdf->Row(array(utf8_decode($fila['mat_prog_cor']), utf8_decode($fila['des_mat_prog'])));
			}
		}
		$pdf->Output();

//$pdf->Output('prueba.pdf','D');
} 
}

?>
