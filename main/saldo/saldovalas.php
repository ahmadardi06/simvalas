<?php
/**
 * Created by PhpStorm.
 * User: ardi
 * Date: 08/06/17
 * Time: 2:52
 */
$n=1;
$sql = $db->prepare("SELECT * FROM SALDOVALAS");
$sql->execute();
$data = $sql->fetchAll();
?>
<div class="text-center">
    <h3>Master Saldo Valas</h3>
    <a href="javascript:;" class="btn btn-primary" id="btnTambahSaldo">Setting Saldo Valas</a>
</div>
<br/>

<table class="table table-hover dataTable">
    <thead>
    <tr>
        <th>No</th>
        <th>Tanggal</th>
        <th>Jenis Valas</th>
        <th>Saldo Valas</th>
        <th>Saldo Rupiah</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($data as $dd): ?>
        <tr>
            <th scope="row"><?php echo $n;?></th>
            <td><a href="#"><?php echo tglIndo($dd['TGL']);?></a></td>
            <td><?php echo $dd['JENISVALAS'];?></td>
            <td><?php echo formatRP($dd['VALAS']);?></td>
            <td><?php echo formatRP($dd['RUPIAH']);?></td>
            <td>[<a href="?mod=saldovalas&aksi=hapus&id=<?php echo $dd['JENISVALAS'];?>&tgl=<?php echo $dd['TGL'];?>">hapus</a>]</td>
        </tr>
        <?php $n++; endforeach; ?>
    </tbody>
</table>