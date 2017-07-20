<?php
/**
 * Created by PhpStorm.
 * User: ardi
 * Date: 08/06/17
 * Time: 2:52
 */
$n=1;
$sql = $db->prepare("SELECT n.*, t.tgltransaksi, t.jenis FROM dtransaksi n, transaksi t WHERE n.nonota=t.nonota");
$sql->execute();
$data = $sql->fetchAll();
$sukses = "<span class='label label-primary'>PEMBELIAN</span>";
$belump = "<span class='label label-success'>PENJUALAN</span>";
?>
<div class="text-center">
    <h3>Master Nota</h3>
    <a href="javascript:;" class="btn btn-primary" id="btnTambahNota">Tambah Nota</a>
</div>
<br/>
<table class="table table-hover dataTable">
    <thead>
    <tr>
        <th>No</th>
        <th>No Nota</th>
        <th>Transaksi</th>
        <th>Tanggal Transaksi</th>
        <th>Jenis Valas</th>
        <th>Jumlah</th>
        <th>Kurs</th>
        <th>Nilai</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($data as $dd): ?>
        <tr>
            <th scope="row"><?php echo $n;?></th>
            <td><a href="#"><?php echo $dd['NONOTA'];?></a></td>
            <td><?php echo ($dd['JENIS'] == 'B')? $sukses:$belump;?></td>
            <td><?php echo tglIndo($dd['TGLTRANSAKSI']);?></td>
            <td><?php echo strtoupper($dd['JENISVALAS']);?></td>
            <td><?php echo $dd['JUMLAH'];?></td>
            <td><?php echo formatRP($dd['KURS']);?></td>
            <td><?php echo formatRP($dd['NILAI']);?></td>
            <td>
                <?php $datanya = $dd['TGLTRANSAKSI'].'_'.$dd['JENISVALAS'].'_'.$dd['JUMLAH'].'_'.$dd['KURS'].'_'.$dd['NILAI'];?>
                [<a href="javascript:;" class="editNomorNota" datanya="<?php echo $datanya;?>">edit</a>]
                [<a href="?mod=nota&aksi=hapus&id=<?php echo $dd['NONOTA'];?>">hapus</a>]
            </td>
        </tr>
        <?php $n++; endforeach; ?>
    </tbody>
</table>