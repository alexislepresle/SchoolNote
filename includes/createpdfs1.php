<?php
header( 'content-type: text/html; charset=utf-8' );
require('fpdf.php');
$dsn = 'mysql:host=localhost;dbname=agile2_bd;charset=UTF8';
try {
 
    $pdo = new PDO($dsn, 'agile2' , 'iesh1Dah6Iet8rai');
    
    }
    catch (PDOException $exception) {
     exit('Erreur de connexion à la base de données');
     
    }
    $query = $pdo->query("SELECT COUNT(*) AS NUMBERABS, CURRENT_DATE, substr(LASTNAMESTUDENT,1,15) AS LASTNAMESTUDENT,substr(FIRSTNAMESTUDENT,1,10) AS FIRSTNAMESTUDENT,N_STUDENT,TPSTUDENT,CODEUE FROM ABSENCE join STUDENT USING (N_STUDENT) JOIN MODULE USING (N_MODULE) join UE USING (N_UE) WHERE STATUSABSENCE=0 AND CODEUE=1.1 OR CODEUE=1.2 group by LASTNAMESTUDENT, FIRSTNAMESTUDENT, N_STUDENT, TPSTUDENT, CODEUE");
    $query2=$pdo->query("SELECT N_STUDENT,CODEUE,COUNT(*) AS NUMBERABS FROM ABSENCE JOIN MODULE USING(N_MODULE) JOIN UE USING (N_UE) GROUP BY N_STUDENT,CODEUE");
    $resultat = $query->fetchAll();
    $resultat2=$query2->fetchAll();
    class PDF extends FPDF
    {
    // En-tête
    function Header()
    {
        // Logo
        $this->Image('logo.png',10,6,30);
        // Police Arial gras 15
        $this->SetFont('Arial','B',15);
        // Décalage à droite
        $this->Cell(80);
    }
    
    // Pied de page
    function Footer()
    {
        // Positionnement à 1,5 cm du bas
        $this->SetY(-15);
        // Police Arial italique 8
        $this->SetFont('Arial','I',8);
        // Numéro de page
        $this->Cell(0,10,'Caen University : Computer Science Department                                    Generated from SchoolNote',0,0);
        
        $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
    }
    } 

$pdf=new PDF('P','mm','A4');
$pdf->AliasNbPages();
$pdf->addPage();
$pdf->SetFont('Arial','B',14);
$pdf->Cell(40,10,'Absences S1',1,0,'C');
// Saut de ligne
 $pdf->Ln(20);
$pdf->Ln();
$pdf->Ln();
$pdf->Cell(25,5,'Etupass');
$pdf->Cell(70,5,'Last name');
$pdf->Cell(40,5,'First name');
$pdf->Cell(10,5,'UE');
$pdf->Cell(10,5,'TP');
$pdf->Cell(20,5,'Nb Abs');
$pdf->Ln();
foreach($resultat as $value){
	$pdf->SetFont('Arial','',12);
    $pdf->Cell(25,5,$value['N_STUDENT'],1);
    $pdf->Cell(70,5,$value['LASTNAMESTUDENT'],1);
    $pdf->Cell(40,5,$value['FIRSTNAMESTUDENT'],1);
    $pdf->Cell(10,5,$value['CODEUE'],1);
    $pdf->Cell(10,5,$value['TPSTUDENT'],1);
    $pdf->Cell(20,5,$value['NUMBERABS'],1);
    
	$pdf->Ln();
    //$pdf->Cell(30,5,$value['LASTNAMESTUDENT'],1,0]);
    //$pdf->Cell(30,5,$value['FIRSTNAMESTUDENT'],1,0]);
}
$pdf->Output("Unjustified_AbsencesS1.pdf",'I');
?>