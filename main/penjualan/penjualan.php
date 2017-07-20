<?php
/**
 * Created by PhpStorm.
 * User: ardi
 * Date: 08/06/17
 * Time: 4:53
 */
?>
<form action="penjualan/prosesTransaksi.php" method="get" autocomplete="off">
<div class="col-sm-8">
    <div class="panel panel-success">
        <div class="panel-heading">Penjualan</div>
        <div class="panel-body">
            <div class="text-right">
                <a href="javascript:;" class="btn btn-default " id="tambahBaris">Tambah Baris</a>
                <a href="javascript:;" class="btn btn-default" id="hapusBaris">Hapus Baris</a>
            </div>
            <table class="table" id="dtailtrans">
                <thead>
                <tr>
                    <th class="text-center">Jenis Valas</th>
                    <th class="text-center">Jumlah</th>
                    <th class="text-center">Kurs</th>
                    <th class="text-center">Nilai</th>
                </tr>
                </thead>

                <tbody>
                <tr>
                    <td>
                        <input type="hidden" name="itung[]" class="form-control"/>
                        <input autofocus list="macamvalas" type="text" name="jenis0" class="form-control input_capital"/>
                    </td>
                    <td><input type="text" name="jumlah0" class="form-control"/></td>
                    <td><input type="text" onchange="hitungNilai(this, 'jumlah0', 'nilai0');" name="kurs0" class="form-control"/></td>
                    <td><input type="text" name="nilai0" class="form-control"/></td>
                </tr>
                </tbody>
            </table>
            <?php if($_GET['print'] != null){ ?>
                <a href="print/notransaksi.php?nonota=<?php echo $_GET['print'];?>" target="_blank" class="btn btn-primary"><i class="glyphicon glyphicon-print"></i> Print Nota Transaksi</a>
            <?php } ?>
        </div>
    </div>
</div>
<div class="col-sm-4">
        <div class="panel panel-success">
            <div class="panel-heading">Informasi Customer</div>
            <div class="panel-body">
                <div class="form-group">
                    <label for="email">Nomor Nota:</label>
                    <input type="text" onchange="lihatNoNota(this);" name="nonota" class="form-control" id="nonota" />
                </div>
                <div class="form-group">
                    <label for="pwd">KTP/SIM/Passport:</label>
                    <input type="text" onchange="lihatKtp(this);" name="ktp" class="form-control" id="ktp">
                    <input type="hidden" id="idcustomer" name="idcustomer" />
                </div>
                <div class="form-group">
                    <label for="email">Nama Lengkap:</label>
                    <input type="text" name="nama" class="form-control" id="nama">
                </div>
                <div class="form-group">
                    <label for="email">Alamat:</label>
                    <textarea name="alamat" id="alamat" cols="30" rows="1" class="form-control"></textarea>
                </div>
                <div class="form-group">
                    <label for="email">Telepon:</label>
                    <input type="text" name="telepon" class="form-control" id="telepon">
                </div>
                <div class="form-group">
                    <label for="email">Tanggal:</label>
                    <input value="<?php echo date('d-m-Y');?>" type="text" name="tgl_transaksi" class="form-control datePicker">
                </div>
                <button type="submit" value="penjualan" name="prosesTransaksi" class="btn btn-lg btn-success btn-block">Proses Transaksi</button>
            </div>
        </div>
    </div>
</form>