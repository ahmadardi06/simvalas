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
        $this->Image('logons1.png',22,14,25);
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
        $this->Cell(205,0,'',1,1,'C');
        $this->Ln(5);
    }

    function BasicTable($header)
    {
        // Header
        $w = array(12, 17, 22, 16, 15, 21, 15, 15, 20, 17, 14, 20);
        for($i=0;$i<count($header);$i++)
            $this->Cell($w[$i],6,$header[$i],1,0,'C');
        $this->Ln(3);
    }
}

$yester = date('Y-m-d', strtotime($_GET['tglsekarang'].'-1 days'));
$pemb   = $db->query("SELECT jenis FROM transaksi WHERE jenis='B' AND tgl_transaksi='".$_GET['tglsekarang']."'")->num_rows;
$penj   = $db->query("SELECT jenis FROM transaksi WHERE jenis='J' AND tgl_transaksi='".$_GET['tglsekarang']."'")->num_rows;

$minB = $db->query("SELECT MIN(nonota) as minb FROM transaksi WHERE tgl_transaksi='".$_GET['tglsekarang']."' AND jenis='B'")->fetch_array();
$maxB = $db->query("SELECT MAX(nonota) as maxb FROM transaksi WHERE tgl_transaksi='".$_GET['tglsekarang']."' AND jenis='B'")->fetch_array();

$minJ = $db->query("SELECT MIN(nonota) as minj FROM transaksi WHERE tgl_transaksi='".$_GET['tglsekarang']."' AND jenis='J'")->fetch_array();
$maxJ = $db->query("SELECT MAX(nonota) as maxj FROM transaksi WHERE tgl_transaksi='".$_GET['tglsekarang']."' AND jenis='J'")->fetch_array();

$pdf = new PDF();
$pdf->SetTitle('Print Laporan Stok Harian');
$pdf->SetTopMargin(15);
$pdf->SetLeftMargin(3);
$pdf->SetRightMargin(3);
$pdf->AddPage();

$pdf->Ln(2);
$pdf->SetFont('Times','BU',12);
$pdf->Cell(205,0,'LAPORAN STOK HARIAN ',0,1,'C');
$pdf->SetFont('Times','',12);

$pdf->Ln(5);
$pdf->Cell(0,0,tglIndo($_GET['tglsekarang']),0,1,'C');

//$pdf->Ln(5);
//$pdf->Cell(60,0, 'Nota Pembelian : '.$pemb.' Transaksi',0,1,'C');
//$pdf->Cell(80);
//$pdf->Cell(155,0, 'Nota Penjualan : '.$penj.' Transaksi',0,1,'C');

$pdf->Ln(5);
$pdf->Cell(70,0, 'Nota Pembelian : '.$minB['minb'].' s/d '.$maxB['maxb'],0,1,'C');
$pdf->Cell(90);
$pdf->Cell(155,0, 'Nota Penjualan : '.$minJ['minj'].' s/d '.$maxJ['maxj'],0,1,'C');

$pdf->Ln(5);
$pdf->SetFont('Times','',9);
$header = array('VLS', ' Saldo Awal', 'Saldo Rp', 'PEMB', 'Kurs', 'Rp', 'PENJ', 'Kurs', 'Rp', 'Saldo Akhir', 'Kurs Rata', 'Saldo Rp');
$pdf->BasicTable($header);

//isi baris sendiri
$pdf->SetFont('Times','',9);
$sql0 = $db->query("SELECT * FROM allsaldo WHERE tgl='".$yester."'");

$valasnyabro        = array();
$saldovalasbro      = array();
$saldorupiahbro     = array();

while($dd0 = $sql0->fetch_array())
{
    array_push($valasnyabro, $dd0['jenis_valas']);

    $pdf->Ln(3);
    $pdf->Cell(12, 5, $dd0['jenis_valas'],1,0,'C');
	if($dd0['jenis_valas'] == 'DINAR'){
		$dinarnya = number_format($dd0['saldo_valas'],2,',','.');
	}else{
		$dinarnya = number_format($dd0['saldo_valas'],0,',','.');
	}
    $pdf->Cell(17, 5, $dinarnya,1,0,'R');
    $saldoawal = $saldoawal + $dd0['saldo_rupiah'];
    if($dd0['saldo_rupiah'] < 0) {
        $pdf->SetTextColor(255, 0, 0);
    }
    $pdf->Cell(22, 5, number_format($dd0['saldo_rupiah'],0,',','.'),1,0,'R');
    $pdf->SetTextColor(0, 0, 0);

    $sql1 = $db->query("SELECT SUM(jumlah) as belitotal, SUM(nilai) as belirupiah
                       FROM nota n, transaksi t
                       WHERE t.nonota=n.nonota and
                             t.jenis='B' and
                             n.jenis_valas='".$dd0['jenis_valas']."' and
                             t.tgl_transaksi='".$_GET['tglsekarang']."'
                     ");

    //query jual
    $sql2 = $db->query("SELECT SUM(jumlah) as jualtotal, SUM(nilai) as jualrupiah
                       FROM nota n, transaksi t
                       WHERE t.nonota=n.nonota and
                             t.jenis='J' and
                             n.jenis_valas='".$dd0['jenis_valas']."' and
                             t.tgl_transaksi='".$_GET['tglsekarang']."'
                     ");

    $beli = ''; $belijson = '';
    while($dd1 = $sql1->fetch_array())
    {
        $beli[] = $dd1; $belijson .= json_encode($beli);
        $pdf->Cell(16, 5, printKosongRP(number_format($dd1['belitotal'],0,',','.')),1,0,'R');
        $pdf->Cell(15, 5, printKosongRP(number_format($dd1['belirupiah']/$dd1['belitotal'],2,',','.')),1,0,'R');
        $pdf->Cell(21, 5, printKosongRP(number_format($dd1['belirupiah'],0,',','.')),1,0,'R');
    }

    $jual = ''; $jualjson = '';
    while($dd2 = $sql2->fetch_array())
    {
        $jual[] = $dd2; $jualjson .= json_encode($jual);
        $pdf->Cell(15, 5, printKosongRP(number_format($dd2['jualtotal'],0,',','.')),1,0,'R');
        $pdf->Cell(15, 5, printKosongRP(number_format($dd2['jualrupiah']/$dd2['jualtotal'],2,',','.')),1,0,'R');
        $pdf->Cell(20, 5, printKosongRP(number_format($dd2['jualrupiah'],0,',','.')),1,0,'R');
    }

    $belidecode = json_decode($belijson, true);
    $pembelianrp = $pembelianrp + $belidecode[0]['belirupiah'];

    $jualdecode = json_decode($jualjson, true);
    $penjualanrp = $penjualanrp + $jualdecode[0]['jualrupiah'];

    array_push($saldovalasbro, $dd0['saldo_valas'] + $belidecode[0]['belitotal'] - $jualdecode[0]['jualtotal']);
    array_push($saldorupiahbro, $dd0['saldo_rupiah'] + $belidecode[0]['belirupiah'] - $jualdecode[0]['jualrupiah']);

    $totallsaldovalas = $dd0['saldo_valas'] + $belidecode[0]['belitotal'] - $jualdecode[0]['jualtotal'];
    $totallsaldorupiah= $dd0['saldo_rupiah'] + $belidecode[0]['belirupiah'] - $jualdecode[0]['jualrupiah'];
	if($dd0['jenis_valas'] == 'DINAR'){
		$dinarnyavalas = number_format($totallsaldovalas,2,',','.');
	}else{
		$dinarnyavalas = number_format($totallsaldovalas,0,',','.');
	}
    $pdf->Cell(17, 5, $dinarnyavalas,1,0,'R');
    $pdf->Cell(14, 5, number_format($totallsaldorupiah/$totallsaldovalas,2,',','.'),1,0,'R');
    if($totallsaldorupiah < 0) {
        $pdf->SetTextColor(255, 0, 0);
    }
    $pdf->Cell(20, 5, number_format($totallsaldorupiah,0,',','.'),1,0,'R');
    $pdf->SetTextColor(0, 0, 0);

    $pdf->Ln(2);
}
$saldoakhir = $saldoawal + $pembelianrp - $penjualanrp;

$pdf->Ln(6);
$pdf->SetFont('Times','',10);

$pdf->Cell(0,0,'Jumlah Rupiah ',0,1,'L');
$pdf->Cell(22);
$pdf->Cell(0,0,' : '.number_format($saldoawal,0,',','.'),0,1,'L');

$pdf->Cell(52);
$pdf->Cell(0,0,'Jumlah Rupiah',0,1,'L');
$pdf->Cell(74);
$pdf->Cell(0,0,' : '.number_format($pembelianrp,0,',','.'),0,1,'L');

$pdf->Cell(105);
$pdf->Cell(0,0,'Jumlah Rupiah',0,1,'L');
$pdf->Cell(130);
$pdf->Cell(0,0,' : '.number_format($penjualanrp,0,',','.'),0,1,'L');

$pdf->Cell(155);
$pdf->Cell(0,0,'Jumlah Rupiah',0,1,'L');
$pdf->Cell(177);
$pdf->Cell(0,0,' : '.number_format($saldoakhir,0,',','.'),0,1,'L');

$pdf->Ln(8);
$pdf->SetFont('Times','',10);

$carisaldonya = $db->query("SELECT * FROM saldoharian WHERE tgl='".$yester."'")->fetch_array();
$ambiltitipbon = $db->query("SELECT * FROM titipbon WHERE tgl='".$_GET['tglsekarang']."'")->fetch_array();

$pdf->Cell(0,0,'Saldo ',0,1,'L');
$pdf->Cell(30);
$pdf->Cell(0,0,' : Rp '.number_format($carisaldonya['saldo'],0,',','.'),0,1,'L');

$pdf->Cell(90);
$pdf->Cell(0,0,'Pembukuan',0,1,'L');
$pdf->Cell(120);
$pdf->Cell(0,0,' : ',0,1,'L');

$pdf->Ln(4);
$pdf->Cell(0,0,'Titipan Awal',0,1,'L');
$pdf->Cell(30);
$pdf->Cell(0,0,' : Rp '.number_format($carisaldonya['titipan_awal'],0,',','.'),0,1,'L');

$pdf->Cell(90);
$pdf->Cell(0,0,'Stok Valas',0,1,'L');
$pdf->Cell(120);
$pdf->Cell(0,0,' : ',0,1,'L');

$pdf->Ln(4);
$pdf->Cell(0,0,'Penjualan',0,1,'L');
$pdf->Cell(30);
$pdf->Cell(0,0,' : Rp '.number_format($penjualanrp,0,',','.'),0,1,'L');

$pdf->Cell(90);
$pdf->Cell(0,0,'Saksi Control',0,1,'L');
$pdf->Cell(120);
$pdf->Cell(0,0,' : ',0,1,'L');

$pdf->Ln(4);
$pdf->Cell(0,0,'Pembelian',0,1,'L');
$pdf->Cell(30);
$pdf->Cell(0,0,' : Rp '.number_format($pembelianrp,0,',','.'),0,1,'L');

$hitungkasnya = $carisaldonya['saldo'] + $penjualanrp + $ambiltitipbon['bon'] - $pembelianrp - $ambiltitipbon['titip'];

$pdf->Ln(4);
$pdf->Cell(0,0,'Kas',0,1,'L');
$pdf->Cell(30);
$pdf->Cell(0,0,' : Rp '.number_format($hitungkasnya,0,',','.'),0,1,'L');

$hitungtitipakhir = $carisaldonya['titipan_awal'] + $ambiltitipbon['titip'] - $ambiltitipbon['bon'];

$pdf->Ln(4);
$pdf->Cell(0,0,'Titipan Akhir',0,1,'L');
$pdf->Cell(30);
$pdf->Cell(0,0,' : Rp '.number_format($hitungtitipakhir,0,',','.'),0,1,'L');

//insert ke titipan selanjutnya
$carisaldoharian = $db->query("SELECT * FROM saldoharian WHERE tgl='".$_GET['tglsekarang']."'")->num_rows;
if($carisaldoharian == 1){
    $db->query("UPDATE saldoharian SET saldo='".$hitungkasnya."', titipan_awal='".$hitungtitipakhir."' WHERE tgl='".$_GET['tglsekarang']."'");
}else{
    $db->query("INSERT INTO saldoharian VALUES ('','".$_GET['tglsekarang']."','".$hitungkasnya."','".$hitungtitipakhir."')");
}

$carisalll = $db->query("SELECT * FROM allsaldo WHERE tgl='".$_GET['tglsekarang']."'")->num_rows;
if($carisalll == count($valasnyabro)){
    for($i=0; $i<count($valasnyabro); $i++){
        $db->query("UPDATE allsaldo SET
                    saldo_valas='".$saldovalasbro[$i]."',
                    saldo_rupiah='".$saldorupiahbro[$i]."'
                    WHERE tgl='".$_GET['tglsekarang']."' AND
                    jenis_valas='".$valasnyabro[$i]."'");
    }
}
else{
    for($i=0; $i<count($valasnyabro); $i++){
        $db->query("INSERT INTO allsaldo VALUES (NULL, '".$_GET['tglsekarang']."','".$valasnyabro[$i]."','".$saldovalasbro[$i]."','".$saldorupiahbro[$i]."')");
    }
}

$pdf->Ln(4);
$pdf->Cell(0,0,'Kasir ',0,1,'L');
$pdf->Cell(30);
$pdf->Cell(0,0,' : ',0,1,'L');

$pdf->Ln(10);
$pdf->Cell(0,0,'BON',0,1,'L');
$pdf->Cell(30);
$pdf->Cell(0,0,' : Rp '.number_format($ambiltitipbon['bon'],0,',','.'),0,1,'L');

$pdf->Ln(4);
$pdf->Cell(0,0,'TITIP ',0,1,'L');
$pdf->Cell(30);
$pdf->Cell(0,0,' : Rp '.number_format($ambiltitipbon['titip'],0,',','.'),0,1,'L');

$pdf->Output('','LaporanHarian'.date('dFY').'.pdf');
?>