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
        $this->Image('logons1.png',20,14,25);
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

    function BasicTable()
    {
        // Header
        $header = array('VALAS','PEMBELIAN','KURS RATA','RUPIAH','PENJUALAN','KURS RATA','RUPIAH');
        // 80 = 25,20,35
        $w = array(20, 25, 25, 35, 25, 25, 35);
        for($i=0;$i<count($header);$i++)
            $this->Cell($w[$i],6,$header[$i],1,0,'C');
        $this->Ln(1);
    }
}

$yester = date('Y-m-d', strtotime(date('Y-m-d').'-1 days'));
$bulanapa = array('JANUARI','FEBRUARI','MARET','APRIL','MEI','JUNI','AGUSTUS','SEPTEMBER','OKTOBER','NOVEMBER','DESEMBER');
$ambilbulan = explode('-',$_GET['bulantahun']);
$bln = (int)$ambilbulan[1];

$pdf = new PDF();
$pdf->SetTitle('Print Laporan Stok Harian');
$pdf->SetTopMargin(15);
$pdf->AddPage();
$pdf->SetFont('Times','',9);

$pdf->Ln(5);
$pdf->SetFont('Times','BU',12);
$pdf->Cell(190,0,'LAPORAN TOTAL OMZET AKHIR BULAN',0,1,'C');
$pdf->SetFont('Times','',12);

$pdf->Ln(6);
$pdf->Cell(0,0,"Periode Bulan ".$bulanapa[$bln-1]." Tahun ".$ambilbulan[0],0,1,'C');

$pdf->Ln(5);
$pdf->SetFont('Times','B',10);
$pdf->BasicTable();

$pdf->SetFont('Times','',10);
//isi baris sendiri
$pembelianrp = 0;
$penjualanrp = 0;
$sql0 = $db->query("SELECT * FROM allsaldo WHERE tgl='".$yester."'");
while($dd0 = $sql0->fetch_array()) {

    $pdf->Ln(5);
    $pdf->Cell(20, 5, $dd0['jenis_valas'],1,0,'C');

    $sql1 = $db->query("SELECT SUM(jumlah) as belitotal, SUM(nilai) as belirupiah
                       FROM nota n, transaksi t
                       WHERE t.nonota=n.nonota and
                             t.jenis='B' and
                             n.jenis_valas='" . $dd0['jenis_valas'] . "' and
                             t.tgl_transaksi LIKE '" . $blnnya . "%'
                     ");

    //query jual
    $sql2 = $db->query("SELECT SUM(jumlah) as jualtotal, SUM(nilai) as jualrupiah
                       FROM nota n, transaksi t
                       WHERE t.nonota=n.nonota and
                             t.jenis='J' and
                             n.jenis_valas='" . $dd0['jenis_valas'] . "' and
                             t.tgl_transaksi LIKE '" . $blnnya . "%'
                     ");

    $beli = ''; $belijson = '';
    while($dd1 = $sql1->fetch_array()){
        $beli[] = $dd1; $belijson .= json_encode($beli);
        $pdf->Cell(25, 5, formatRP($dd1['belitotal']),1,0,'R');
        $pdf->Cell(25, 5, formatRP($dd1['belirupiah']/$dd1['belitotal']),1,0,'R');
        $pdf->Cell(35, 5, formatRP($dd1['belirupiah']),1,0,'R');
    }

    $jual = ''; $jualjson = '';
    while($dd2 = $sql2->fetch_array()){
        $jual[] = $dd2; $jualjson .= json_encode($jual);
        $pdf->Cell(25, 5, formatRP($dd2['jualtotal']),1,0,'R');
        $pdf->Cell(25, 5, formatRP($dd2['jualrupiah']/$dd2['jualtotal']),1,0,'R');
        $pdf->Cell(35, 5, formatRP($dd2['jualrupiah']),1,0,'R');
    }

    $belidecode = json_decode($belijson, true);
    $pembelianrp = $pembelianrp + $belidecode[0]['belirupiah'];
    $jualdecode = json_decode($jualjson, true);
    $penjualanrp = $penjualanrp + $jualdecode[0]['jualrupiah'];
}

$pdf->Ln(10);
$pdf->SetFont('Times','',10);

$pdf->Cell(0,0,'Jumlah Pembelian Rupiah',0,1,'L');
$pdf->Cell(40);
$pdf->Cell(0,0,' : '.formatRP($pembelianrp, true),0,1,'L');

$pdf->Cell(105);
$pdf->Cell(0,0,'Jumlah Penjualan Rupiah',0,1,'L');
$pdf->Cell(145);
$pdf->Cell(0,0,' : '.formatRP($penjualanrp, true),0,1,'L');
$pdf->Ln(6);


$pdf->Output('','LaporanBulanan'.date('dFY').'.pdf');
?>