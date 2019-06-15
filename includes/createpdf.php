<?php
header( 'content-type: text/html; charset=utf-8' );
require('fpdf_merge.php');
require_once('createpdfs1.php');
require_once('createpdfs2.php');
require_once('createpdfs3.php');
require_once('createpdfs4.php');


$pdf=new FPDF_Merge();
$pdf->add('createpdfs1.php');
$pdf->AddPage(); 
$pdf->add('createpdfs2.php');
//$pdf->add('createpdfs3.php');
//$pdf->add('createpdfs4.php');
//$pdf->output("Unjustified Absences",'I');
?>