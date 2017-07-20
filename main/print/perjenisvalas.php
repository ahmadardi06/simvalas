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
        $this->Image('logons1.png',30,14,25);
        $this->Ln(2);
        $this->SetFont('times','B',17);
        $this->Cell(85);
        $this->Cell(30,0,'PT. NOOR SEMANGAT',0,1,'C');
        $this->Ln(5);
        $this->SetFont('times','B',12);
        $this->Cell(85);
        $this->Cell(30,0,'KEGIATAN USAHA PENUKARAN VALUTA ASING',0,1,'C');
        $this->Ln(4);
        $this->SetFont('Arial','',9);
        $this->Cell(85);
        $this->Cell(30,0,'Jalan Panggung No. 40 Telp. 031-3523266 - 3523537',0,1,'C');
        $this->Ln(4);
        $this->SetFont('times','',9);
        $this->Cell(85);
        $this->Cell(30,0,'SURABAYA - 60162 - INDONESIA',0,1,'C');
        $this->Ln(4);
        $this->Cell(85);
        $this->SetFont('times','B',9);
        $this->Cell(30,0,'IZIN BANK INDONESIA : 5/10/KEP.PBI/SB/2003',0,1,'C');
        $this->Ln(5);
        $this->Cell(190,0,'',1,1,'C');
        $this->Ln(5);
    }
}

$pdf = new PDF('P','mm','legal');
$pdf->SetTitle('Print Per Jenis Valas');
$pdf->SetAutoPageBreak(true, 73);
$pdf->SetTopMargin(13);
$pdf->AddPage();

$pdf->SetFont('times','B',12);
$pdf->Cell(0,3,$_GET['jenis'],0,1,'C');
$pdf->Ln(1);
$pdf->SetFont('times','',10);
$pdf->Cell(0,3,tglIndo($_GET['tgl']),0,1,'C');

$pdf->Cell(28);
$pdf->SetFont('times','B',11);
$pdf->Cell(0,3,'Pembelian',0,1,'L');
$pdf->Ln(1);
$pdf->SetFont('times','',11);
$pdf->Cell(28);
$head = array('No','No Nota', 'Valas','Rate','Rupiah');
$widt = array(10, 25, 40, 30, 40);
for($i=0;$i<count($head);$i++)
    $pdf->Cell($widt[$i],5,$head[$i],1,0,'C');
$pdf->Ln(5);

$sqlb = $db->query("SELECT n.jumlah, n.nilai, n.kurs, n.nonota
                   FROM transaksi t, nota n
                   WHERE t.nonota=n.nonota AND
                          n.jenis_valas='".$_GET['jenis']."' AND
                          t.tgl_transaksi='".$_GET['tgl']."' AND
                          t.jenis='B'");
$n=0; $totalrpbeli = 0; $totalvalasbeli = 0;
while($ddb = $sqlb->fetch_array()){ $n++;
    $pdf->Cell(28);
    $pdf->Cell(10,5,$n,1,0,'C');
    $pdf->Cell(25,5,$ddb['nonota'],1,0,'C');
    $pdf->Cell(40,5,formatRP($ddb['jumlah']),1,0,'C');
    $pdf->Cell(30,5,formatRP($ddb['kurs']),1,0,'C');
    $pdf->Cell(40,5,formatRP($ddb['nilai']),1,0,'C');
    $pdf->Ln(5);
    $totalrpbeli += $ddb['nilai'];
    $totalvalasbeli += $ddb['jumlah'];
}

$pdf->Ln(5);
$pdf->Cell(30);
$pdf->Cell(0,0,'Total Pembelian Valas',0,1,'L');
$pdf->Cell(73);
$pdf->Cell(30,0,' : '.formatRP($totalvalasbeli),0,0,'L');
$pdf->Ln(4);

$pdf->Cell(30);
$pdf->Cell(0,0,'Rate Rata-rata',0,1,'L');
$pdf->Cell(73);
$pdf->Cell(30,0,' : '.formatRP($totalrpbeli/$totalvalasbeli),0,0,'L');
$pdf->Ln(4);

$pdf->Cell(30);
$pdf->Cell(0,0,'Total Pembelian Rupiah',0,1,'L');
$pdf->Cell(73);
$pdf->Cell(30,0,' : '.formatRP($totalrpbeli),0,0,'L');

$pdf->Ln(7);

$pdf->Cell(28);
$pdf->SetFont('times','B',11);
$pdf->Cell(0,3,'Penjualan',0,1,'L');
$pdf->Ln(1);
$pdf->SetFont('times','',11);
$pdf->Cell(28);
$head = array('No','No Nota', 'Valas','Rate','Rupiah');
$widt = array(10, 25, 40, 30, 40);
for($i=0;$i<count($head);$i++)
    $pdf->Cell($widt[$i],5,$head[$i],1,0,'C');
$pdf->Ln(5);

$sqlj = $db->query("SELECT n.jumlah, n.nilai, n.kurs, n.nonota
                   FROM transaksi t, nota n
                   WHERE t.nonota=n.nonota AND
                          n.jenis_valas='".$_GET['jenis']."' AND
                          t.tgl_transaksi='".$_GET['tgl']."' AND
                          t.jenis='J'");
$n=0; $totalrpjual = 0; $totalvalasjual = 0;
while($ddj = $sqlj->fetch_array()){ $n++;
    $pdf->Cell(28);
    $pdf->Cell(10,5,$n,1,0,'C');
    $pdf->Cell(25,5,$ddj['nonota'],1,0,'C');
    $pdf->Cell(40,5,formatRP($ddj['jumlah']),1,0,'C');
    $pdf->Cell(30,5,formatRP($ddj['kurs']),1,0,'C');
    $pdf->Cell(40,5,formatRP($ddj['nilai']),1,0,'C');
    $pdf->Ln(5);
    $totalrpjual += $ddj['nilai'];
    $totalvalasjual += $ddj['jumlah'];
}
$pdf->Ln(5);
$pdf->Cell(30);
$pdf->Cell(0,0,'Total Penjualan Valas',0,1,'L');
$pdf->Cell(73);
$pdf->Cell(30,0,' : '.formatRP($totalvalasjual),0,0,'L');
$pdf->Ln(4);

$pdf->Cell(30);
$pdf->Cell(0,0,'Rate Rata-rata',0,1,'L');
$pdf->Cell(73);
$pdf->Cell(30,0,' : '.formatRP($totalrpjual/$totalvalasjual),0,0,'L');
$pdf->Ln(4);

$pdf->Cell(30);
$pdf->Cell(0,0,'Total Penjualan Rupiah',0,1,'L');
$pdf->Cell(73);
$pdf->Cell(30,0,' : '.formatRP($totalrpjual),0,0,'L');
$pdf->Ln(4);

$pdf->Output('','LaporanPerJenisValas'.date('dFY').'.pdf');
?>