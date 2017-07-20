<?php
/**
 * Created by PhpStorm.
 * User: ardi
 * Date: 08/06/17
 * Time: 2:52
 */
$n=1;
$sql = $db->prepare("SELECT * FROM customer");
$sql->execute();
$data = $sql->fetchAll();
?>
<div class="text-center">
    <h3>Master Customer</h3>
<!--    <a href="#" class="btn btn-primary">Tambah Customer</a>-->
</div>
<br/>
<table class="table table-hover dataTable">
    <thead>
    <tr>
        <th>No</th>
        <th>KTP/SIM/Passport</th>
        <th>Nama Lengkap</th>
        <th>Alamat Lengkap</th>
        <th>Telepon (HP)</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($data as $dd): ?>
    <tr>
        <th scope="row"><?php echo $n;?></th>
        <td><a href="#"><?php echo $dd['KTP'];?></a></td>
        <td><?php echo $dd['NAMA'];?></td>
        <td><?php echo $dd['ALAMAT'];?></td>
        <td><?php echo $dd['TELEPON'];?></td>
        <td>
			<?php $datanya = $dd['KTP'].'_'.$dd['NAMA'].'_'.$dd['ALAMAT'].'_'.$dd['TELEPON'];?>
                [<a href="javascript:;" class="editCustomer" datanya="<?php echo $datanya;?>">edit</a>] 
			[<a href="?mod=customer&aksi=hapus&id=<?php echo $dd['KTP'];?>">hapus</a>]
        </td>
    </tr>
    <?php $n++; endforeach; ?>
    </tbody>
</table>