<?php
/**
 * Created by PhpStorm.
 * User: ardi
 * Date: 10/06/17
 * Time: 17:19
 */
ob_clean();
require(dirname(__FILE__).'/../../libs/database.php');
require(dirname(__FILE__).'/../../libs/fpdf/fpdf.php');
require(dirname(__FILE__).'/../../libs/formattanggal.php');
class PDF extends FPDF{
    function Header(){
        $this->Image('logons1.png',25,4,15);
        $this->SetFont('times','B',10);
        $this->Cell(46);
        $this->Cell(48,0,'PT. NOOR SEMANGAT',0,1,'C');
        $this->Ln(3);

        $this->SetFont('times','B',8);
        $this->Cell(46);
        $this->Cell(48,0,'KEGIATAN USAHA PENUKARAN VALUTA ASING',0,1,'C');
        $this->Ln(3);

        $this->SetFont('times','',6);
        $this->Cell(46);
        $this->Cell(48,0,'Jalan Panggung No. 40 Telp. 031-3523266 - 3523537 Surabaya',0,1,'C');
        $this->Ln(3);

        $this->Cell(46);
        $this->SetFont('times','B',7);
        $this->Cell(48,0,'IZIN BANK INDONESIA : 5/10/KEP.PBI/SB/2003',0,1,'C');
        $this->Ln(3);
        $this->Cell(135,0,'',1,1,'C');
        $this->Ln(2);
    }
}

$nonota = $_GET['nonota'];
$transa1 = $db->prepare("SELECT * FROM transaksi WHERE nonota=:NOTANYA");
$transa1->bindParam(":NOTANYA", $nonota);
$transa1->execute();
$transa = $transa1->fetch();


$amnota1 = $db->prepare("SELECT * FROM DTRANSAKSI WHERE nonota=:NOTANYA");
$amnota1->bindParam(":NOTANYA", $nonota);
$amnota1->execute();
$amnota = $amnota1->fetchAll();

$custom1 = $db->prepare("SELECT * FROM customer WHERE ktp=:NOTANYA");
$custom1->bindParam(":NOTANYA", $transa['KTP']);
$custom1->execute();
$custom = $custom1->fetch();


$pdf = new PDF('P','mm','a6');
$pdf->SetTopMargin(7);
$pdf->SetLeftMargin(7);
$pdf->SetAutoPageBreak(true, 5);
$pdf->SetTitle('Print Nota Transaksi');
$pdf->AddPage();

$pdf->SetFont('times','',8);

if($transa['JENIS'] == 'J'){$cc = 'Penjualan'; $cc2 = 'PEMBELI'; }  else {$cc = 'Pembelian'; $cc2 ='PENJUAL';}

$pdf->Cell(130,3,'Nota '.$cc." ".$transa['NONOTA'],0,0,'R');
$pdf->Ln(3);

$pdf->Cell(10);
$pdf->Cell(0,0,'KTP/SIM/Passport',0,1,'L');
$pdf->Cell(35);
$pdf->Cell(0,0,' : '.$custom['KTP'],0,0,'L');
$pdf->Ln(3);

$pdf->Cell(10);
$pdf->Cell(0,0,'Nama Lengkap',0,1,'L');
$pdf->Cell(35);
$pdf->Cell(0,0,' : '.ucwords($custom['NAMA']),0,0,'L');
$pdf->Ln(3);

$pdf->Cell(10);
$pdf->Cell(0,0,'Alamat Lengkap',0,1,'L');
$pdf->Cell(35);
$pdf->Cell(0,0,' : '.$custom['ALAMAT'],0,0,'L');
$pdf->Ln(3);

$pdf->Cell(10);
$pdf->Cell(0,0,'Nomor Telepon',0,1,'L');
$pdf->Cell(35);
$pdf->Cell(0,0,' : '.$custom['TELEPON'],0,0,'L');
$pdf->Ln(3);

$pdf->SetFont('times','B',8);
$pdf->Cell(7);
$head = array('No','Valas','Jumlah','Kurs','Rupiah');
$widt = array(10, 20, 35, 20, 35);
for($i=0;$i<count($head);$i++)
    $pdf->Cell($widt[$i],4,$head[$i],1,0,'C');
$pdf->Ln(4);

$pdf->SetFont('times','',8);
$n0 = 0; $totaltrans = 0;
foreach($amnota as $dd){ $n0++;
    $pdf->Cell(7);
    $pdf->Cell(10,4,$n0,1,0,'C');
    $pdf->Cell(20,4,strtoupper($dd['JENISVALAS']),1,0,'C');
    $pdf->Cell(35,4,formatRP($dd['JUMLAH']),1,0,'C');
    $pdf->Cell(20,4,formatRP($dd['KURS']),1,0,'C');
    $pdf->Cell(35,4,formatRP($dd['NILAI']),1,0,'C');
    $pdf->Ln(4);
    $totaltrans += $dd['NILAI'];
}

$pdf->Ln(2);
$pdf->Cell(10);
$pdf->Cell(50,4,'Surabaya, '.tglIndo($transa['TGLTRANSAKSI']),0,0,'L');
$pdf->Cell(25);
$pdf->Cell(50,4,'Jumlah Total : '.formatRP($totaltrans, true),0,0,'L');

$pdf->Ln(20);
$pdf->Cell(10);
$pdf->Cell(50,4,$cc2,0,0,'L');
$pdf->Cell(25);
$pdf->Cell(50,4,'PT. NOOR SEMANGAT',0,0,'L');

$pdf->Output('','NotaTransaksi'.$nonota.'-'.date('dFY').'.pdf');
?>