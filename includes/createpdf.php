<?php
require('fpdf.php');
$dsn = 'mysql:host=localhost;dbname=agile2_bd;charset=UTF8';
try {
 
    $pdo = new PDO($dsn, 'agile2' , 'iesh1Dah6Iet8rai');
    
    }
    catch (PDOException $exception) {
     exit('Erreur de connexion à la base de données');
     
    }
    $query = $pdo->query("SELECT SYSDATE(), substr(LASTNAMESTUDENT,1,15) AS LASTNAMESTUDENT,substr(FIRSTNAMESTUDENT,1,10) AS FIRSTNAMESTUDENT,STUDENT.N_STUDENT,TPSTUDENT,CODEUE FROM ABSENCE join STUDENT USING (N_STUDENT) JOIN MODULE USING (N_MODULE) join UE USING (N_UE) WHERE STATUSABSENCE=1;");
    //$query2=$pdo->query("SELECT LASTNAmE STUDENT,FIRSTNAME STUDENT,N_STUDENTCOUNT(*) FROM ABSENCE GROUP")
    $resultat = $query->fetchAll();


$pdf=new FPDF('P','mm','A4');
$pdf->addPage();
$pdf->SetFont('Arial','B',14);
$pdf->Cell(30,5,'Absences',0,0,'C');
$pdf->Ln();
$pdf->Ln();
$pdf->Cell(25,5,'Etupass');
$pdf->Cell(50,5,'Nom');
$pdf->Cell(50,5,'Prenom');
$pdf->Cell(10,5,'UE');
$pdf->Cell(10,5,'TP');
$pdf->Ln();
foreach($resultat as $value){
	$pdf->SetFont('Arial','',12);
    $pdf->Cell(25,5,$value['N_STUDENT'],1);
    $pdf->Cell(50,5,$value['LASTNAMESTUDENT'],1);
    $pdf->Cell(50,5,$value['FIRSTNAMESTUDENT'],1);
    $pdf->Cell(10,5,$value['CODEUE'],1);
	$pdf->Cell(10,5,$value['TPSTUDENT'],1);
	$pdf->Ln();
    //$pdf->Cell(30,5,$value['LASTNAMESTUDENT'],1,0]);
    //$pdf->Cell(30,5,$value['FIRSTNAMESTUDENT'],1,0]);
}
	$pdf->Ln();
	$pdf->Ln();
	$pdf->Ln();
	$pdf->MultiCell(150,5,$value['SYSDATE()'],1);
$pdf->Output();
?>