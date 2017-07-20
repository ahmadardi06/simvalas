<?php
/**
 * Created by PhpStorm.
 * User: ardi
 * Date: 10/06/17
 * Time: 0:13
 */
$n=0;
include(dirname(__FILE__) . '/../libs/database.php');
include(dirname(__FILE__) . '/../libs/formattanggal.php');
$sql = $db->prepare("SELECT * FROM DTRANSAKSI WHERE nonota=:u1");
$sql->bindParam(":u1", $_POST['nonota']);
$sql->execute();
$data = $sql->fetchAll();

$dtsql = $db->prepare("SELECT c.*, t.* FROM customer c, transaksi t WHERE t.nonota=:u1 AND t.ktp=c.ktp");
$dtsql->bindParam(":u1", $_POST['nonota']);
$dtsql->execute();
$data1 = $dtsql->fetch();
?>
<h3>Nomor Nota : <b><?php echo $_POST['nonota']; ?></b></h3>
<form target="_blank" action="../main/print/notransaksi.php" method="get">
    <input type="hidden" value="<?php echo $_POST['nonota'];?>" name="nonota" />
    <button class="btn btn-primary" type="submit" value="submit" name="submit">
        <i class="glyphicon glyphicon-print"></i> Print Nota Transaksi
    </button>
</form>
<br>
<p>KTP/SIM/Passport : <b><?php echo $data1['KTP'];?></b></p>
<p>Nama Lengkap &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <b><?php echo strtoupper($data1['NAMA']);?></b></p>
<p>Alamat Lengkap &nbsp;&nbsp;&nbsp;: <b><?php echo ucwords($data1['ALAMAT']);?></b></p>
<p>Nomor Telepon &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <b><?php echo $data1['TELEPON'];?></b></p>
<table class="table">
    <thead>
    <tr>
        <th>No</th>
        <th>Jenis</th>
        <th>Jumlah</th>
        <th>Kurs</th>
        <th>Nilai</th>
    </tr>
    </thead>
    <tbody>
    <?php
	$totalgrand = 0;
	foreach($data as $dd){ $n++; ?>
        <tr>
            <td><?php echo $n;?></td>
            <td><?php echo strtoupper($dd['JENISVALAS']);?></td>
            <td><?php echo formatRP($dd['JUMLAH']);?></td>
            <td><?php echo formatRP($dd['KURS']);?></td>
            <td><?php echo formatRP($dd['NILAI']);?></td>
        </tr>
		<?php $totalgrand += $dd['NILAI'];?>
    <?php } ?>
    </tbody>
</table>
<p class="text-center">Total Transaksi : <b><?php echo formatRP($totalgrand,true);?></b></p>