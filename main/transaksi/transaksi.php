<?php
/**
 * Created by PhpStorm.
 * User: ardi
 * Date: 08/06/17
 * Time: 2:52
 */
$n=1;
$sql = $db->prepare("SELECT t.*, cu.nama FROM transaksi t, customer cu WHERE t.ktp=cu.ktp");
$sql->execute();
$data = $sql->fetchAll();
$sukses = "<span class='label label-primary'>PEMBELIAN</span>";
$belump = "<span class='label label-success'>PENJUALAN</span>";
?>
<div class="text-center">
    <h3>Master Transaksi</h3>
<!--    <a href="#" class="btn btn-primary">Tambah Transaksi</a>-->
</div>
<br/>

<table class="table table-hover dataTable">
    <thead>
    <tr>
        <th>No</th>
        <th>No Nota</th>
        <th>KTP/SIM/Passport</th>
        <th>Nama Lengkap</th>
        <th>Tanggal Transaksi</th>
        <th>Total</th>
        <th>Jenis</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($data as $dd): ?>
        <tr>
            <th scope="row"><?php echo $n;?></th>
            <td><a href="#"><?php echo $dd['NONOTA'];?></a></td>
            <td><?php echo $dd['KTP'];?></td>
            <td><?php echo $dd['NAMA'];?></td>
            <td><?php echo tglIndo($dd['TGLTRANSAKSI']);?></td>
            <td><?php echo formatRP($dd['TOTAL']);?></td>
            <td><?php echo ($dd['JENIS'] == 'B')? $sukses:$belump;?></td>
            <td>[<a href="?mod=transaksi&aksi=hapus&id=<?php echo $dd['NONOTA'];?>">hapus</a>]</td>
        </tr>
        <?php $n++; endforeach; ?>
    </tbody>
</table>