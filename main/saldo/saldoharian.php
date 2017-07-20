<?php
/**
 * Created by PhpStorm.
 * User: ardi
 * Date: 08/06/17
 * Time: 2:52
 */
$n=1;
$sql = $db->prepare("SELECT * FROM saldoharian");
$sql->execute();
$data = $sql->fetchAll();
?>
<div class="text-center">
    <h3>Master Saldo Titipan</h3>
    <a href="javascript:;" class="btn btn-primary" id="btnTambahSaldoHarian">Setting Saldo Titipan</a>
</div>
<br/>

<table class="table table-hover dataTable">
    <thead>
    <tr>
        <th>No</th>
        <th>Tanggal</th>
        <th>Saldo</th>
        <th>Titipan Awal</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($data as $dd): ?>
        <tr>
            <th scope="row"><?php echo $n;?></th>
            <td><a href="#"><?php echo tglIndo($dd['TGL']);?></a></td>
            <td><?php echo formatRP($dd['SALDO']);?></td>
            <td><?php echo formatRP($dd['TITIPAN_AWAL']);?></td>
            <td>[<a href="?mod=saldoharian&aksi=hapus&id=<?php echo $dd['TGL'];?>">hapus</a>]</td>
        </tr>
        <?php $n++; endforeach; ?>
    </tbody>
</table>