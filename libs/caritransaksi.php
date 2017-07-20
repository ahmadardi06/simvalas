<?php
/**
 * Created by PhpStorm.
 * User: ardi
 * Date: 08/06/17
 * Time: 22:26
 */
include(dirname(__FILE__) . '/../libs/database.php');
include(dirname(__FILE__) . '/../libs/formattanggal.php');
$sql1 = $db->prepare("SELECT t.*, c.nama FROM transaksi t, customer c  WHERE t.ktp=c.ktp and t.tgltransaksi=:u1 and t.jenis='B'");
$sql1->bindParam(":u1",$_POST['tgl']);
$sql1->execute();
$data1 = $sql1->fetchAll();

$sql2 = $db->prepare("SELECT t.*, c.nama FROM transaksi t, customer c  WHERE t.ktp=c.ktp and t.tgltransaksi=:u1 and t.jenis='J'");
$sql2->bindParam(":u1",$_POST['tgl']);
$sql2->execute();
$data2 = $sql2->fetchAll();
?>
<h3>Tanggal : <b><?php echo $_POST['tgl'];?></b></h3>
<div class="col-sm-6">
    <h3>Pembelian</h3>
    <table class="table table-hover">
        <thead>
        <tr>
            <th>No</th>
            <th>Nomor Nota</th>
            <th>Nama Customer</th>
            <th>Total</th>
        </tr>
        </thead>
        <tbody>
        <?php $n=0; foreach($data1 as $dd1){ $n++; ?>
            <tr class='text-left'>
                <td><?php echo $n;?></td>
                <td>
                    <a href='javascript:;' onclick="detailTransaksiNota('<?php echo $dd1["NONOTA"];?>');">
                        <?php echo $dd1['NONOTA'];?>
                    </a>
                </td>
                <td><?php echo strtoupper($dd1['NAMA']);?></td>
                <td><?php echo formatRP($dd1['TOTAL']);?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
<div class="col-sm-6">
    <h3>Penjualan</h3>
    <table class="table table-hover">
        <thead>
        <tr>
            <th>No</th>
            <th>Nomor Nota</th>
            <th>Nama Customer</th>
            <th>Total</th>
        </tr>
        </thead>
        <tbody>
        <?php $n=0; foreach($data2 as $dd2){ $n++; ?>
            <tr class='text-left'>
                <td><?php echo $n;?></td>
                <td>
                    <a href='javascript:;' onclick="detailTransaksiNota('<?php echo $dd2["NONOTA"];?>');">
                        <?php echo $dd2['NONOTA'];?>
                    </a>
                </td>
                <td><?php echo strtoupper($dd2['NAMA']);?></td>
                <td><?php echo formatRP($dd2['TOTAL']);?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>