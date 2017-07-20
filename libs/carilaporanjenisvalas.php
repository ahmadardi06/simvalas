<?php
/**
 * Created by PhpStorm.
 * User: ardi
 * Date: 08/06/17
 * Time: 22:26
 */
include(dirname(__FILE__) . '/../libs/database.php');
include(dirname(__FILE__) . '/../libs/formattanggal.php');
$jenis = $_POST['jns']; $tgl = $_POST['tgl'];
?>

<!-- Pembelian -->
<?php
$n=0;
$total=0;
$rupiah=0;
$sqlb = $db->prepare("SELECT n.jumlah, n.nilai, n.kurs, n.nonota
                   FROM transaksi t, dtransaksi n
                   WHERE t.nonota=n.nonota AND
                          n.jenisvalas=:u1 AND
                          t.tgltransaksi=:u2 AND
                          t.jenis='B'");
$sqlb->bindParam(":u1", $jenis);
$sqlb->bindParam(":u2", $tgl);
$sqlb->execute();
$data = $sqlb->fetchAll();
?>
<h4 class="text-center">Jenis Valas : <b><?php echo $jenis;?></b></h4>
<form action="print/perjenisvalas.php" target="_blank" method="get">
    <input type="hidden" name="jenis" value="<?php echo $jenis;?>"/>
    <input type="hidden" name="tgl" value="<?php echo $tgl;?>"/>
    <button name="submit" value="submit" class="btn btn-primary"><i class="glyphicon glyphicon-print"></i> Print Laporan Harian</button>
</form>
<div class="col-sm-6">
    <h4 class="text-center">Pembelian</h4>
    <table class="table table-hover">
        <thead>
        <tr>
            <th class="text-center">NO</th>
            <th class="text-center">NO NOTA</th>
            <th class="text-center">VALAS</th>
            <th class="text-center">RATE</th>
            <th class="text-center">RUPIAH</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($data as $dd){ $n++; ?>
            <tr>
                <td><?php echo $n;?></td>
                <td><?php echo $dd['NONOTA'];?></td>
                <td><?php echo formatRP($dd['JUMLAH']);?></td>
                <?php $total =  $total+$dd['JUMLAH']; $rupiah = $rupiah+$dd['NILAI'];?>
                <td><?php echo formatRP($dd['KURS']);?></td>
                <td><?php echo formatRP($dd['NILAI']);?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
    <h4 class="text-left">Total Valas : <?php echo formatRP($total);?></h4>
    <h4 class="text-left">Total Kurs &nbsp;: <?php echo formatRP($rupiah/$total);?></h4>
    <h4 class="text-left">Total Rupiah : <?php echo formatRP($rupiah);?></h4>
</div>

<!-- Penjualan -->
<?php
$n=0;
$total1=0;
$rupiah1=0;
$sqlb = $db->prepare("SELECT n.jumlah, n.nilai, n.kurs, n.nonota
                   FROM transaksi t, dtransaksi n
                   WHERE t.nonota=n.nonota AND
                          n.jenisvalas=:u1 AND
                          t.tgltransaksi=:u2 AND
                          t.jenis='J'");
$sqlb->bindParam(":u1", $jenis);
$sqlb->bindParam(":u2", $tgl);
$sqlb->execute();
$data = $sqlb->fetchAll();
?>
<div class="col-sm-6">
    <h4 class="text-center">Penjualan</h4>
    <table class="table table-hover">
        <thead>
        <tr>
            <th class="text-center">NO</th>
            <th class="text-center">NO NOTA</th>
            <th class="text-center">VALAS</th>
            <th class="text-center">RATE</th>
            <th class="text-center">RUPIAH</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($data as $dd){ $n++; ?>
            <tr>
                <td><?php echo $n;?></td>
                <td><?php echo $dd['NONOTA'];?></td>
                <td><?php echo formatRP($dd['JUMLAH']);?></td>
                <?php $total1 =  $total1+$dd['JUMLAH']; $rupiah1 = $rupiah1+$dd['NILAI'];?>
                <td><?php echo formatRP($dd['KURS']);?></td>
                <td><?php echo formatRP($dd['NILAI']);?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
    <h4 class="text-left">Total Valas : <?php echo formatRP($total1);?></h4>
    <h4 class="text-left">Total Kurs &nbsp;: <?php echo formatRP($rupiah1/$total1);?></h4>
    <h4 class="text-left">Total Rupiah : <?php echo formatRP($rupiah1);?></h4>
</div>