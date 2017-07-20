<?php
ini_set('display_errors', 1);
/**
 * Created by PhpStorm.
 * User: ardi
 * Date: 22/11/16
 * Time: 15:45
 */
ob_clean();
require(dirname(__FILE__).'/../../libs/database.php');
require(dirname(__FILE__).'/../../libs/fpdf/fpdf.php');
class PDF extends FPDF{
    function Header(){
        $this->Image('logo.png',15,6,25);
        $this->Ln(2);
        $this->SetFont('Arial','B',14);
        $this->Cell(85);
        $this->Cell(30,0,'PT. NOOR SEMANGAT',0,1,'C');
        $this->Ln(5);
        $this->SetFont('Arial','B',12);
        $this->Cell(85);
        $this->Cell(30,0,'PEDAGANG VALUTA ASING BERIZIN',0,1,'C');
        $this->Ln(5);
        $this->Cell(85);
        $this->Cell(30,0,'(Authorized Money Changer)',0,1,'C');
        $this->Ln(5);
        $this->SetFont('Arial','B',9);
        $this->Cell(85);
        $this->Cell(30,0,'Jalan Panggung 40 Surabaya - 60162 Telp. 031-3523266 - 3523537',0,1,'C');
        $this->Ln(5);
        $this->Cell(190,0,'',1,1,'C');
        $this->Ln(5);
    }

    function Footer(){
        $this->SetY(-12);
        $this->SetFont('Arial','I',8);
        $this->Cell(0,10,'Copyright by Ahmad Ardiansyah v1.0',0,0,'L');
    }

    function BasicTable($header)
    {
        // Header
        $w = array(10, 17, 17, 15, 15, 17, 15, 17, 17, 17, 15, 17);
        for($i=0;$i<count($header);$i++)
            $this->Cell($w[$i],6,$header[$i],1,0,'C');
        $this->Ln(3);
    }
}

$pdf = new PDF();
$pdf->SetTitle('Print ke PDF Formulir Nikah');
$pdf->AddPage();
$pdf->SetFont('Times','',9);

$pdf->Cell(140);
$pdf->Cell(50,0,'Kamis, 8 Juni 2007',0,1,'R');
$pdf->Ln(5);

$pdf->SetFont('Times','BU',12);
$pdf->Cell(190,0,'LAPORAN STOK HARIAN',0,1,'C');
$pdf->SetFont('Times','',12);
$pdf->Ln(10);

$pdf->SetFont('Times','',10);
$pdf->Cell(0,0,'Nota Pembelian : ',0,1,'L');
$pdf->Cell(65);
$pdf->Cell(50,0,'Nota Penjualan : ',0,1,'R');
$pdf->Ln(3);

$pdf->SetFont('Times','',8);
$header = array('VLS', ' Saldo Awal', 'Saldo Rp', 'PEMB', 'Kurs', 'Rp', 'PENJ', 'Kurs', 'Rp', 'Saldo Akhir', 'Kurs Rata', 'Saldo Rp');
$pdf->BasicTable($header);

//isi baris sendiri

$pdf->Ln(5);
$pdf->SetFont('Times','',10);

$pdf->Ln(5);
$pdf->Cell(0,0,'Saldo',0,1,'L');
$pdf->Cell(30);
$pdf->Cell(0,0,' : ',0,1,'L');

$pdf->Cell(90);
$pdf->Cell(0,0,'Pembukuan',0,1,'L');
$pdf->Cell(120);
$pdf->Cell(0,0,' : ',0,1,'L');

$pdf->Ln(4);
$pdf->Cell(0,0,'Titipan Awal',0,1,'L');
$pdf->Cell(30);
$pdf->Cell(0,0,' : ',0,1,'L');

$pdf->Cell(90);
$pdf->Cell(0,0,'Stok Valas',0,1,'L');
$pdf->Cell(120);
$pdf->Cell(0,0,' : ',0,1,'L');

$pdf->Ln(4);
$pdf->Cell(0,0,'Penjualan',0,1,'L');
$pdf->Cell(30);
$pdf->Cell(0,0,' : ',0,1,'L');

$pdf->Cell(90);
$pdf->Cell(0,0,'Saksi Control',0,1,'L');
$pdf->Cell(120);
$pdf->Cell(0,0,' : ',0,1,'L');

$pdf->Ln(4);
$pdf->Cell(0,0,'Pembelian',0,1,'L');
$pdf->Cell(30);
$pdf->Cell(0,0,' : ',0,1,'L');

$pdf->Ln(4);
$pdf->Cell(0,0,'Kas',0,1,'L');
$pdf->Cell(30);
$pdf->Cell(0,0,' : ',0,1,'L');

$pdf->Ln(4);
$pdf->Cell(0,0,'Titipan Akhir',0,1,'L');
$pdf->Cell(30);
$pdf->Cell(0,0,' : ',0,1,'L');

$pdf->Ln(4);
$pdf->Cell(0,0,'Kasir',0,1,'L');
$pdf->Cell(30);
$pdf->Cell(0,0,' : ',0,1,'L');

$pdf->Ln(10);
$pdf->Cell(0,0,'BON',0,1,'L');
$pdf->Cell(30);
$pdf->Cell(0,0,' : ',0,1,'L');

$pdf->Ln(4);
$pdf->Cell(0,0,'TITIP',0,1,'L');
$pdf->Cell(30);
$pdf->Cell(0,0,' : ',0,1,'L');

$pdf->Output('','LaporanHarian'.date('dFY').'.pdf');
?>
