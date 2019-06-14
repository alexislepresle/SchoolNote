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
    $query = $pdo->query("SELECT COUNT(*) AS NUMBERABS, CURRENT_DATE, substr(LASTNAMESTUDENT,1,15) AS LASTNAMESTUDENT,substr(FIRSTNAMESTUDENT,1,10) AS FIRSTNAMESTUDENT,STUDENT.N_STUDENT,TPSTUDENT,CODEUE FROM ABSENCE join STUDENT USING (N_STUDENT) JOIN MODULE USING (N_MODULE) join UE USING (N_UE) WHERE STATUSABSENCE=1;");
    $query2=$pdo->query("SELECT N_STUDENT,CODEUE,COUNT(*) AS NUMBERABS FROM ABSENCE JOIN MODULE USING(N_MODULE) JOIN UE USING (N_UE) GROUP BY N_STUDENT,CODEUE");
    $resultat = $query->fetchAll();
    $resultat2=$query2->fetchAll();


$pdf=new FPDF('P','mm','A4');
$pdf->addPage();
$pdf->Image('logo.png',10,6,30);
    // Police Arial gras 15
    $pdf->SetFont('Arial','B',15);
    // Décalage à droite
    $pdf->Cell(80);
    // Titre
    $pdf->Cell(40,10,'Absences',1,0,'C');
    // Saut de ligne
    $pdf->Ln(20);
$pdf->SetFont('Arial','B',14);
$pdf->Ln();
$pdf->Ln();
$pdf->Cell(25,5,'Etupass');
$pdf->Cell(50,5,'Last name');
$pdf->Cell(50,5,'First name');
$pdf->Cell(10,5,'UE');
$pdf->Cell(10,5,'TP');
$pdf->Cell(50,5,'Number of absences');
$pdf->Ln();
foreach($resultat as $value){
	$pdf->SetFont('Arial','',12);
    $pdf->Cell(25,5,$value['N_STUDENT'],1);
    $pdf->Cell(50,5,$value['LASTNAMESTUDENT'],1);
    $pdf->Cell(50,5,$value['FIRSTNAMESTUDENT'],1);
    $pdf->Cell(10,5,$value['CODEUE'],1);
    $pdf->Cell(10,5,$value['TPSTUDENT'],1);
    $pdf->Cell(10,5,$value['NUMBERABS'],1);
    
	$pdf->Ln();
    //$pdf->Cell(30,5,$value['LASTNAMESTUDENT'],1,0]);
    //$pdf->Cell(30,5,$value['FIRSTNAMESTUDENT'],1,0]);
}
	$pdf->Ln();
	$pdf->Ln();
	$pdf->Ln();
	$pdf->MultiCell(150,5,'Created on '.$value['CURRENT_DATE'],1);
$pdf->Output("Unjustified Absences",'I');
?>