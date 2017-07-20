<?php
/**
 * Created by PhpStorm.
 * User: ardi
 * Date: 08/06/17
 * Time: 4:53
 */
$tglskrng = date("d-m-Y");
$jmlbeli = $db->prepare("SELECT COUNT(*) FROM TRANSAKSI WHERE JENIS='B' AND TGLTRANSAKSI=:tgltransaksi");
$jmlbeli->bindParam(":tgltransaksi", $tglskrng);
$jmlbeli->execute();

$jmljual = $db->prepare("SELECT COUNT(*) FROM TRANSAKSI WHERE JENIS='J' AND TGLTRANSAKSI=:tgltransaksi");
$jmljual->bindParam(":tgltransaksi", $tglskrng);
$jmljual->execute();

$jmltran = $db->prepare("SELECT COUNT(*) FROM TRANSAKSI WHERE TGLTRANSAKSI=:tgltransaksi");
$jmltran->bindParam(":tgltransaksi", $tglskrng);
$jmltran->execute();

$jmlcust = $db->prepare("SELECT COUNT(*) FROM customer");
$jmlcust->execute();
?>
<br/>
<div class="row text-center">
    <div class="col-lg-3">
        <img class="img-rounded" src="../img/beli.png" alt="Generic placeholder image" width="140" height="140">
        <h2>Pembelian</h2>
        <p>Total Pembelian Sekarang : <b><?php echo $jmlbeli->fetchColumn();?></b>.</p>
<!--        <p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>-->
    </div><!-- /.col-lg-4 -->
    <div class="col-lg-3">
        <img class="img-rounded" src="../img/jual.png" alt="Generic placeholder image" width="140" height="140">
        <h2>Penjualan</h2>
        <p>Total Penjualan Sekarang : <b><?php echo $jmljual->fetchColumn();?></b>.</p>
<!--        <p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>-->
    </div><!-- /.col-lg-4 -->
    <div class="col-lg-3">
        <img class="img-rounded" src="../img/transaksi2.png" alt="Generic placeholder image" width="140" height="140">
        <h2>Transaksi</h2>
        <p>Total Transaksi Sekarang : <b><?php echo $jmltran->fetchColumn();?></b>.</p>
<!--        <p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>-->
    </div><!-- /.col-lg-4 -->
    <div class="col-lg-3">
        <img class="img-rounded" src="../img/usercustom2.png" alt="Generic placeholder image" width="140" height="140">
        <h2>Customer</h2>
        <p>Total Semua Customer : <b><?php echo $jmlcust->fetchColumn();?></b>.</p>
        <!--        <p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>-->
    </div><!-- /.col-lg-4 -->
</div><!-- /.row -->

<?php
$tglsk = date("d-m-Y");
$sql1 = $db->prepare("SELECT t.*, c.* FROM transaksi t, customer c  WHERE t.ktp=c.ktp and t.tgltransaksi=:tgltransaksi and t.jenis='B'");
$sql1->bindParam(":tgltransaksi", $tglsk);
$sql1->execute();
$data1 = $sql1->fetchAll();

$sql2 = $db->prepare("SELECT t.*, c.* FROM transaksi t, customer c  WHERE t.ktp=c.ktp and t.tgltransaksi=:tgltransaksi and t.jenis='J'");
$sql2->bindParam(":tgltransaksi", $tglsk);
$sql2->execute();
$data2 = $sql2->fetchAll();

$totalbelisekarang = 0;
$totaljualsekarang = 0;
?>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-primary">
            <div class="panel-heading">Transaksi Pembelian</div>
            <div class="panel-body">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Nomor Nota</th>
                        <th>KTP/SIM/Passport</th>
                        <th>Nama Customer</th>
                        <th>Alamat Lengkap</th>
                        <th>Telepon</th>
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
                            <td><?php echo $dd1['KTP'];?></td>
                            <td><?php echo strtoupper($dd1['NAMA']);?></td>
                            <td><?php echo ucwords($dd1['ALAMAT']);?></td>
                            <td><?php echo $dd1['TELEPON'];?></td>
                            <td><?php echo formatRP($dd1['TOTAL'], TRUE);?></td>
                        </tr>
                        <?php $totalbelisekarang += $dd1['total'];?>
                    <?php } ?>
                    </tbody>
                </table>
                <p class="text-center">Total Pembelian : <b><?php echo formatRP($totalbelisekarang,true);?></b></p>
            </div>
        </div>
    </div>
	
    <div class="col-sm-12">
        <div class="panel panel-primary">
            <div class="panel-heading">Transaksi Penjualan</div>
            <div class="panel-body">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Nomor Nota</th>
                        <th>KTP/SIM/Passport</th>
                        <th>Nama Customer</th>
                        <th>Alamat Lengkap</th>
                        <th>Telepon</th>
                        <th>Total</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $n=0; foreach($data2 as $dd1){ $n++; ?>
                        <tr class='text-left'>
                            <td><?php echo $n;?></td>
                            <td>
                                <a href='javascript:;' onclick="detailTransaksiNota('<?php echo $dd1["NONOTA"];?>');">
                                    <?php echo $dd1['NONOTA'];?>
                                </a>
                            </td>
                            <td><?php echo $dd1['KTP'];?></td>
                            <td><?php echo strtoupper($dd1['NAMA']);?></td>
                            <td><?php echo ucwords($dd1['ALAMAT']);?></td>
                            <td><?php echo $dd1['TELEPON'];?></td>
                            <td><?php echo formatRP($dd1['TOTAL'], TRUE);?></td>
                        </tr>
                        <?php $totaljualsekarang += $dd1['total'];?>
                    <?php } ?>
                    </tbody>
                </table>
                <p class="text-center">Total Penjualan : <b><?php echo formatRP($totaljualsekarang,true);?></b></p>
            </div>
        </div>
    </div>
</div>