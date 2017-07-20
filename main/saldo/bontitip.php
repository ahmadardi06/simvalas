<?php
/**
 * Created by PhpStorm.
 * User: ardi
 * Date: 08/06/17
 * Time: 4:53
 */
?>
<?php if($_GET['act'] == 'OK'){ ?>
    <div class="alert alert-success">
        <strong>Success!</strong> Setting BON atau TITIP.
    </div>
<?php } ?>
<form action="saldo/prosesBonTitip.php" method="get" autocomplete="off">

    <div class="col-sm-4">
        <div class="panel panel-primary">
            <div class="panel-heading">Masukkan Bon / Titip</div>
            <div class="panel-body">
                <div class="form-group">
                    <label for="email">Tanggal:</label>
                    <input value="<?php echo date('Y-m-d');?>" type="text" name="tgl" class="form-control datePicker">
                </div>
                <div class="form-group">
                    <label for="email">BON</label>
                    <input type="text" name="bon" class="form-control" id="bon">
                </div>
                <div class="form-group">
                    <label for="email">TITIP</label>
                    <input type="text" name="titip" class="form-control" id="titip">
                </div>
                <button type="submit" value="penjualan" name="prosesTransaksi" class="btn btn-lg btn-success btn-block">Proses Transaksi</button>
            </div>
        </div>
    </div>

    <div class="col-sm-8">
        <div class="panel panel-primary">
            <div class="panel-heading">Data Titip Bon</div>
            <div class="panel-body">
                <table class="table tabel-hover dataTable">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Titip</th>
                        <th>Bon</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $n=0;
                    $sql = $db->query("SELECT * FROM titipbon");
                    while($dd = $sql->fetch_array()){ $n++; ?>
                        <tr>
                            <td><?php echo $n;?></td>
                            <td><?php echo tglIndo($dd['tgl']);?></td>
                            <td><?php echo formatRP($dd['titip']);?></td>
                            <td><?php echo formatRP($dd['bon']);?></td>
                            <td>[<a href="#">hapus</a>]</td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</form>