<?php
/**
 * Created by PhpStorm.
 * User: ardi
 * Date: 08/06/17
 * Time: 2:52
 */
$n=1;
$sql = $db->prepare("SELECT * FROM pegawai");
$sql->execute();
$data = $sql->fetchAll();
?>
<div class="text-center">
    <h3>Master Karyawan</h3>
    <a href="#" class="btn btn-primary">Tambah Karyawan</a>
</div>
<br/>
<table class="table table-hover dataTable">
    <thead>
    <tr>
        <th>No</th>
        <th>Nama Lengkap</th>
        <th>ID Pegawai</th>
        <th>Username</th>
        <th>Alamat Lengkap</th>
        <th>Password</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($data as $dd): ?>
        <tr>
            <th scope="row"><?php echo $n;?></th>
            <td><a href="#"><?php echo $dd['NAMA'];?></a></td>
            <td><?php echo $dd['IDPEG'];?></td>
            <td><?php echo $dd['USERNAMA'];?></td>
            <td><?php echo $dd['ALAMAT'];?></td>
            <td><?php echo $dd['PASSWORD'];?>****</td>
            <td>[<a href="#">edit</a>] [<a href="?mod=karyawan&aksi=hapus&id=<?php echo $dd['id'];?>">hapus</a>]</td>
        </tr>
        <?php $n++; endforeach; ?>
    </tbody>
</table>