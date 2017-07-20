<?php
/**
 * Created by PhpStorm.
 * User: ardi
 * Date: 08/06/17
 * Time: 22:26
 */
$n=0;
include(dirname(__FILE__) . '/../libs/database.php');
include(dirname(__FILE__) . '/../libs/formattanggal.php');

//kemarin
$yester = date('d-m-Y', strtotime($_POST['tgl'].'-1 days'));

$sql0 = $db->prepare("SELECT * FROM saldovalas WHERE tgl=:u1");
$sql0->bindParam(":u1", $yester);
$sql0->execute();
$data0 = $sql->fetchAll();
//$sql0 = $db->query("SELECT JENISVALAS FROM nota n, transaksi t WHERE n.nonota=t.nonota and t.tgl_transaksi='".$_POST['tgl']."' GROUP BY JENISVALAS");
?>
<table class="table table-hover" id="cekLaporanStokHarian">
    <thead>
    <tr>
        <th rowspan="2">No</th>
        <th rowspan="2">VLS</th>
        <!-- awal -->
        <th rowspan="2">VLS Awal</th>
        <th rowspan="2">RP Awal</th>
        <!-- Beli -->
        <th colspan="3" class="text-center">Pembelian</th>
        <!-- Jual -->
        <th colspan="3" class="text-center">Penjualan</th>
        <!-- akhir -->
        <th rowspan="2">VLS Akhir</th>
        <th rowspan="2">Kurs</th>
        <th rowspan="2">RP Akhir</th>
    </tr>
    <tr>
        <th>Beli</th>
        <th>Kurs</th>
        <th>Rupiah</th>

        <th>Jual</th>
        <th>Kurs</th>
        <th>Rupiah</th>
    </tr>
    </thead>
    <tbody>

<?php
$saldoawal = 0;
$pembelianrp = 0;
$penjualanrp = 0;
$saldoakhir = 0;

$valasnyabro = array();
$saldovalasharini = array();
$saldorupiahhariini = array();

foreach($data0 as $dd0){ $n++;
    //push array
    array_push($valasnyabro, $dd0['JENISVALAS']);

    //query beli
    $sql1 = $db->prepare("SELECT SUM(jumlah) as belitotal, SUM(nilai) as belirupiah
                       FROM nota n, transaksi t
                       WHERE t.nonota=n.nonota and
                             t.jenis='B' and
                             n.JENISVALAS=:u1 and
                             t.tgltransaksi=:u2
                     ");
    $sql1->bindParam(":u1", $dd0['JENISVALAS']);
    $sql1->bindParam(":u2", $_POST['tgl']);
    $sql1->execute();
    $data1 = $sql1->fetchAll();

    //query jual
    $sql2 = $db->query("SELECT SUM(jumlah) as jualtotal, SUM(nilai) as jualrupiah
                       FROM nota n, transaksi t
                       WHERE t.nonota=n.nonota and
                             t.jenis='J' and
                             n.JENISVALAS=:u1 and
                             t.tgltransaksi=:u2
                     ");
    $sql2->bindParam(":u1", $dd0['JENISVALAS']);
    $sql2->bindParam(":u2", $_POST['tgl']);
    $sql2->execute();
    $data2 = $sql2->fetchAll();
?>
        <tr class='text-left'>
            <td><?php echo $n;?></td>
            <td><?php echo strtoupper($dd0['JENISVALAS']);?></td>

            <!-- awal -->
            <td><?php echo number_format($dd0['SALDO'],2,',','.');?></td>
            <?php $saldoawal = $saldoawal + $dd0['RUPIAH']; ?>
            <td><?php echo number_format($dd0['RUPIAH'],2,',','.');?></td>

            <!-- Beli -->
<!--            --><?php //$beli = array(); $belijson = '{"'.strtoupper($dd0['JENISVALAS']).'":'; ?>
            <?php $beli = ''; $belijson = ''; ?>
            <?php foreach($data1 as $dd1){
                $beli[] = $dd1; $belijson .= json_encode($beli);?>
                <td><?php echo number_format($dd1['BELITOTAL'],2,',','.');?></td>
                <td><?php echo number_format($dd1['BELIRUPIAH']/$dd1['BELITOTAL'],2,',','.');?></td>
                <td><?php echo number_format($dd1['BELIRUPIAH'],2,',','.');?></td>
<!--            --><?php //} $belijson .= '}'; ?>
            <?php } ?>

            <!-- Jual -->
<!--            --><?php //$jual = array(); $jualjson = '{"'.strtoupper($dd0['JENISVALAS']).'":';?>
            <?php $jual = ''; $jualjson = '';?>
            <?php foreach($data2 as $dd2){
                $jual[] = $dd2; $jualjson .= json_encode($jual);?>
                <td><?php echo number_format($dd2['JUALTOTAL'],2,',','.');?></td>
                <td><?php echo number_format($dd2['JUALRUPIAH']/$dd2['JUALTOTAL'],2,',','.');?></td>
                <td><?php echo number_format($dd2['JUALLRUPIAH'],2,',','.');;?></td>
<!--            --><?php //} $jualjson .= '}';?>
            <?php } ?>

            <!-- akhir -->
            <?php
            $belidecode = json_decode($belijson, true);
            $pembelianrp = $pembelianrp + $belidecode[0]['BELIRUPIAH'];
            ?>
            <?php
            $jualdecode = json_decode($jualjson, true);
            $penjualanrp = $penjualanrp + $jualdecode[0]['JUALRUPIAH'];
            ?>
            <?php
            //push valas dan rupiah
            array_push($saldovalasharini, $belidecode[0]['BELITOTAL'] - $jualdecode[0]['JUALTOTAL']);
            array_push($saldorupiahhariini, $belidecode[0]['BELIRUPIAH'] - $jualdecode[0]['JUALRUPIAH']);

            $totallsaldovalas = $dd0['VALAS'] + $belidecode[0]['BELITOTAL'] - $jualdecode[0]['JUALTOTAL'];
            $totallsaldorupiah= $dd0['RUPIAH'] + $belidecode[0]['BELIRUPIAH'] - $jualdecode[0]['JUALRUPIAH'];
            ?>
            <td><?php echo number_format($totallsaldovalas,2,',','.');?></td>
            <td>
                <?php
                    echo number_format($totallsaldorupiah/$totallsaldovalas,2,',','.');
                ?>
            </td>
            <td><?php echo number_format($totallsaldorupiah,2,',','.');?></td>
        </tr>
<?php } ?>
    </tbody>
</table>
<p class="col-sm-3">Jumlah Saldo Awal Rupiah <br> <?php echo formatRP($saldoawal);?></p>
<p class="col-sm-3">Jumlah Pembelian Valas Total Rupiah <br> <?php echo formatRP($pembelianrp);?></p>
<p class="col-sm-3">Jumlah Penjualan Valas Total Rupiah <br> <?php echo formatRP($penjualanrp);?></p>
<?php $saldoakhir = $saldoawal + $pembelianrp - $penjualanrp;?>
<p class="col-sm-3">Jumlah Saldo Akhir Rupiah <br> <?php echo formatRP($saldoakhir);?></p>
<form action="print/printstokharian.php" method="get" target="_blank">
    <input type="hidden" value="<?php echo $_POST['tgl'];?>" name="tglsekarang"/>
    <input type="submit" class="btn btn-success" name="ptintstokharian" value="Print Stok Harian"/>
</form>