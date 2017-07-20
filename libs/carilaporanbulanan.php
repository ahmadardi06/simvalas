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

$blnnya = $_POST['thn']."-".$_POST['bln'];
$yester = date('Y-m-d', strtotime(date('Y-m-d').'-1 days'));

$sql0 = $db->query("SELECT * FROM allsaldo WHERE tgl='".$yester."'");

?>
<table class="table table-hover">
    <thead>
    <tr>
        <th class="text-center">No</th>
        <th class="text-center">VALAS</th>
        <th class="text-center">PEMBELIAN</th>
        <th class="text-center">KURS RATA</th>
        <th class="text-center">RUPIAH</th>
        <th class="text-center">PENJUALAN</th>
        <th class="text-center">KURS RATA</th>
        <th class="text-center">RUPIAH</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $pembelianrp = 0;
    $penjualanrp = 0;
    while($dd0 = $sql0->fetch_array()){ $n++;

        $sql1 = $db->query("SELECT SUM(jumlah) as belitotal, SUM(nilai) as belirupiah
                       FROM nota n, transaksi t
                       WHERE t.nonota=n.nonota and
                             t.jenis='B' and
                             n.jenis_valas='".$dd0['jenis_valas']."' and
                             t.tgl_transaksi LIKE '".$blnnya."%'
                     ");

        //query jual
        $sql2 = $db->query("SELECT SUM(jumlah) as jualtotal, SUM(nilai) as jualrupiah
                       FROM nota n, transaksi t
                       WHERE t.nonota=n.nonota and
                             t.jenis='J' and
                             n.jenis_valas='".$dd0['jenis_valas']."' and
                             t.tgl_transaksi LIKE '".$blnnya."%'
                     ");
    ?>
    <tr>
        <td><?php echo $n;?></td>
        <td><?php echo $dd0['jenis_valas'];?></td>

        <?php $beli = ''; $belijson = ''; ?>
        <?php while($dd1 = $sql1->fetch_array()){
            $beli[] = $dd1; $belijson .= json_encode($beli);?>
            <td><?php echo number_format($dd1['belitotal'],2,',','.');?></td>
            <td><?php echo number_format($dd1['belirupiah']/$dd1['belitotal'],2,',','.');?></td>
            <td><?php echo number_format($dd1['belirupiah'],2,',','.');?></td>
            <!--            --><?php //} $belijson .= '}'; ?>
        <?php } ?>

        <?php $jual = ''; $jualjson = '';?>
        <?php while($dd2 = $sql2->fetch_array()){
            $jual[] = $dd2; $jualjson .= json_encode($jual);?>
            <td><?php echo number_format($dd2['jualtotal'],2,',','.');?></td>
            <td><?php echo number_format($dd2['jualrupiah']/$dd2['jualtotal'],2,',','.');?></td>
            <td><?php echo number_format($dd2['jualrupiah'],2,',','.');?></td>
            <!--            --><?php //} $jualjson .= '}';?>
        <?php } ?>

        <?php
        $belidecode = json_decode($belijson, true);
        $pembelianrp = $pembelianrp + $belidecode[0]['belirupiah'];
        ?>
        <?php
        $jualdecode = json_decode($jualjson, true);
        $penjualanrp = $penjualanrp + $jualdecode[0]['jualrupiah'];
        ?>

    </tr>
    <?php } ?>
    </tbody>
</table>
<p class="col-sm-6">Jumlah Saldo Awal Rupiah <br> <?php echo formatRP($pembelianrp, true);?></p>
<p class="col-sm-6">Jumlah Saldo AKhir Rupiah <br> <?php echo formatRP($penjualanrp, true);?></p>

<form action="print/laporanbulanan.php" method="get" target="_blank">
    <input type="hidden" value="<?php echo $blnnya;?>" name="bulantahun"/>
    <input type="submit" class="btn btn-success" name="ptintlaporanbulanan" value="Print Laporan Bulanan"/>
</form>