<?php
/**
 * Created by PhpStorm.
 * User: ardi
 * Date: 08/06/17
 * Time: 2:05
 */
session_start();
include_once("../libs/database.php");
include_once("../libs/formattanggal.php");
if(!empty($_SESSION['iduser'])){
$dtus = $db->prepare("SELECT * FROM PEGAWAI WHERE IDPEG=:idpegawai");
$dtus->bindParam(":idpegawai", $_SESSION['iduser']);
$dtus->execute();
$dtuser = $dtus->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="Aplikasi Sistem Keuangan">
    <meta name="author" content="Ahmad Ardiansyah">
    <link rel="icon" href="../img/logo.png">

    <title>Sistem Pelaporan Keuangan</title>

    <link rel="stylesheet" href="../css/jquery-ui.css">

    <!-- Bootstrap core CSS -->
    <link href="../css/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="../css/assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../css/navbar-fixed-top.css" rel="stylesheet">

    <!-- datatable css -->
    <link rel="stylesheet" href="../css/jquery.dataTables.min.css"/>

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../css/assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="../css/assets/js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>

<!-- Fixed navbar -->
<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="?mod=dashboard">Sistem Pelaporan</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li><a href="?mod=pembelian">Pembelian</a></li>
                <li><a href="?mod=penjualan">Penjualan</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        Laporan <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="?mod=laporanharian">Transaksi Harian</a></li>
                        <li><a href="?mod=laporanstokharian">Laporan Stok Harian</a></li>
<!--                        <li><a href="?mod=laporanbulanan">Laporan Omzet Bulanan</a></li>-->
                        <li><a href="?mod=jenisvalas">Laporan Jenis Valas</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        Master Data <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="?mod=saldovalas">Saldo Valas</a></li>
                        <li><a href="?mod=saldoharian">Saldo Titipan</a></li>
                        <li><a href="?mod=bontitip">Bon / Titip</a></li>
                        <li><a href="?mod=nota">No Nota</a></li>
                        <li><a href="?mod=transaksi">Transaksi</a></li>
                        <li><a href="?mod=customer">Customer</a></li>
                    </ul>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="javascript:;"><?php echo tglIndo(date('Y-m-d'), true);?></a></li>
                <li><a href="?mod=karyawan">Karyawan</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <?php echo $dtuser[0]['NAMA'];?> <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="?mod=logout" id="frmLogout">Logout Sistem</a></li>
                    </ul>
                </li>

            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>

<?php
if($_GET['mod'] == 'laporanstokharian'){ $clas = 'container-fluid'; } else { $clas = 'container'; }
?>

<div class="<?php echo $clas;?>">

    <?php
    if($_GET['mod'] == 'customer'){
        if($_GET['aksi'] == 'hapus'){
            $sql = $db->prepare("DELETE FROM customer WHERE KTP=:u1");
            $sql->bindParam(":u1", $_GET['id']);
            $sql->execute();
        }
        include('customer/customer.php');
    }
    elseif($_GET['mod'] == 'transaksi'){
        if($_GET['aksi'] == 'hapus'){
            $sql = $db->query("DELETE FROM transaksi WHERE nonota='".$_GET['id']."'");
        }
        include('transaksi/transaksi.php');
    }
    elseif($_GET['mod'] == 'nota'){
        if($_GET['aksi'] == 'hapus'){
            $sql = $db->query("DELETE FROM DTRANSAKSI WHERE nonota='".$_GET['id']."'");
        }
        include('nota/nota.php');
    }
    elseif($_GET['mod'] == 'karyawan'){
        if($_GET['aksi'] == 'hapus'){
            $sql = $db->query("DELETE FROM pegawai WHERE idpeg='".$_GET['id']."'");
        }
        include('karyawan/karyawan.php');
    }
    elseif($_GET['mod'] == 'saldovalas'){
        if($_GET['aksi'] == 'hapus'){
            $sql = $db->query("DELETE FROM saldovalas WHERE jenisvalas='".$_GET['id']."' AND tgl='".$_GET['tgl']."'");
        }
        include('saldo/saldovalas.php');
    }elseif($_GET['mod'] == 'saldoharian'){
        if($_GET['aksi'] == 'hapus'){
            $sql = $db->query("DELETE FROM saldoharian WHERE TGL='".$_GET['id']."'");
        }
        include('saldo/saldoharian.php');
    }elseif($_GET['mod'] == 'bontitip'){
        include('saldo/bontitip.php');
    }
    elseif($_GET['mod'] == 'laporanstokharian'){
        include('harian/stokharian.php');
    }
    elseif($_GET['mod'] == 'laporanharian'){
        include('harian/harian.php');
    }
    elseif($_GET['mod'] == 'laporanbulanan'){
        include('bulanan/bulanan.php');
    }
    elseif($_GET['mod'] == 'jenisvalas'){
        include('laporan/jenisvalas.php');
    }
    elseif($_GET['mod'] == 'logout'){
        include('logout.php');
    }
    elseif($_GET['mod'] == 'pembelian'){
        include('pembelian/pembelian.php');
    }
    elseif($_GET['mod'] == 'penjualan'){
        include('penjualan/penjualan.php');
    }
	elseif($_GET['mod'] == 'backup'){
        exec("c:/xampp/mysql/bin/mysqldump -uroot dbvalas4 > f:/valasbackup/dbvalas".date("Y-m-d").".sql");
		echo "<div class='text-center'><div class='alert alert-success'>Backup Database Success. Terimakasih !!!</div></div>";
    }
    else{
        include('dashboard/dashboard.php');
    } ?>

</div> <!-- /container -->

<?php include(dirname(__FILE__).'/../libs/modalpopup.php');?>
<datalist id="macamvalas">
<?php
$query = $db->prepare("SELECT JENISVALAS FROM SALDOVALAS GROUP BY JENISVALAS");
$query->execute();
$dd = $query->fetchAll();
foreach($dd as $data){ ?>
    <option value="<?php echo $data['JENISVALAS'];?>">
<?php } ?>
</datalist>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

<script src="//cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script>window.jQuery || document.write('<script src="../css/assets/js/vendor/jquery.min.js"><\/script>')</script>
<script src="../css/dist/js/bootstrap.min.js"></script>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="../css/assets/js/ie10-viewport-bug-workaround.js"></script>
<script src="../js/mainlokal.js"></script>
<script>

    $(function () {
        Date.prototype.yyyymmdd = function() {
            var mm = this.getMonth() + 1; // getMonth() is zero-based
            var dd = this.getDate() - 1;

            return [(dd>9 ? '' : '0') + dd, (mm>9 ? '' : '0') + mm, this.getFullYear()].join('-');
        };

        var date = new Date();

        $("#refreshHalamanLaporanHarian").hide();

        $(".dataTable").DataTable();

        $( ".datePicker" ).datepicker({
            dateFormat: 'dd-mm-yy',
            maxDate: '+0d'
        });

//        $("#printTransaksi").click(function () {
//            var nonota = $(this).attr('datanya');
//            alert(nonota);
//        });

        //belum fix
        $("#btnTambahNota").click(function () {
            var html = "<h3>Master Data Saldo</h3><br>" +
                "<form>" +
                "<div class='form-group'>"+
                "<label for='email'>Tanggal</label>"+
                "<input type='text' name='tgl_valas' class='form-control datePicker' id='tgl_valas' placeholder='yyyy-mm-dd' />"+
                "<label for='email'>Jenis Valas</label>"+
                "<input type='text' name='jenis_valas' class='form-control' id='jenis_valas' />"+
                "<label for='email'>Saldo Valas</label>"+
                "<input type='text' name='saldo_valas' class='form-control' id='saldo_valas' />"+
                "<label for='email'>Saldo Rupiah</label>"+
                "<input type='text' name='saldo_rupiah' class='form-control' id='saldo_rupiah' />"+
                "</div>"+
                "</form>";
            $("#modalMasterDataForm").html(html);
            $("#modalMasterData").modal('show');
            $("#btnAksiTambahMaster").click(function () {
                alert("Sorry, Under Construction !!!");
            })
        })

        $("#btnTambahSaldo").click(function () {
            var html = "<h3>Master Data Saldo</h3><br>" +
                "<form id='formMasterDataSaldo'>" +
                    "<div class='form-group'>"+
                    "<label for='email'>Tanggal</label>"+
                    "<input type='text' name='tgl_valas' class='form-control' value='"+date.yyyymmdd()+"' id='tgl_valas' placeholder='yyyy-mm-dd' />"+
                    "<label for='email'>Jenis Valas</label>"+
                    "<input type='text' list='macamvalas' name='jenis_valas' class='form-control' id='jenis_valas' />"+
                    "<label for='email'>Saldo Valas</label>"+
                    "<input type='text' name='saldo_valas' class='form-control' id='saldo_valas' />"+
                    "<label for='email'>Saldo Rupiah</label>"+
                    "<input type='text' name='saldo_rupiah' class='form-control' id='saldo_rupiah' />"+
                    "</div>"+
                "</form>";
            $("#modalMasterDataForm").html(html);
            $("#modalMasterData").modal('show');
            $("#btnAksiTambahMaster").click(function () {
                var datanya = $("#formMasterDataSaldo").serialize();
                $.ajax({
                    type: "POST",
                    data: datanya,
                    url: "../libs/tambahmasterdata.php?mod=saldovalas",
                    success: function(msg){
                        location.href='?mod=saldovalas&stat='+msg;
                    }
                })
            })
        });

        $("#btnTambahSaldoHarian").click(function () {
            var html = "" +
                "<form id='formMasterDataSaldoHarian'>" +
                "<div class='form-group'>"+
                "<label for='email'>Tanggal</label>"+
                "<input type='text' name='tgl' class='form-control' value='"+date.yyyymmdd()+"' id='tgl' placeholder='yyyy-mm-dd' />"+
                "<label for='email'>Saldo</label>"+
                "<input type='text' name='saldo' class='form-control' id='saldo' />"+
                "<label for='email'>Titipan Awal</label>"+
                "<input type='text' name='titipan_awal' class='form-control' id='titipan_awal' />"+
                "</div>"+
                "</form>";
            $("#modalMasterDataForm").html(html);
            $("#modalMasterData").modal('show');
            $("#btnAksiTambahMaster").click(function () {
                var datanya = $("#formMasterDataSaldoHarian").serialize();
                $.ajax({
                    type: "POST",
                    data: datanya,
                    url: "../libs/tambahmasterdata.php?mod=saldoharian",
                    success: function(msg){
                        location.href='?mod=saldoharian&stat='+msg;
                    }
                })
            })
        })

        $("#cariLaporanJenisValas").click(function () {
            var jns = $("#jenis_valas").val();
            var tgl = $("#tgl_valas").val();

            $.ajax({
                type: "POST",
                data: "jns="+jns+"&tgl="+tgl,
                url: "../libs/carilaporanjenisvalas.php",
                success: function (msg) {
                    $("#jenis_valas").attr("disabled","on");
                    $("#tgl_valas").attr("disabled","on");
                    $("#refreshHalamanLaporanHarian").show();
                    $("#cariLaporanJenisValas").hide();
                    $("#cekLaporanJenisValas").html(msg);
                }
            })
        })

        $("#cariLaporanBulanan").click(function () {
            var bulan = $("#bulan").val();
            var tahun = $("#tahun").val();

            $.ajax({
                type: "POST",
                data: "bln="+bulan+"&thn="+tahun,
                url: "../libs/carilaporanbulanan.php",
                success: function (msg) {
                    $("#bulan").attr("disabled","on");
                    $("#tahun").attr("disabled","on");
                    $("#refreshHalamanLaporanHarian").show();
                    $("#cariLaporanBulanan").hide();
                    $("#cekLaporanOmzetBulanan").html(msg);
                }
            })
        });
		
		$(".editCustomer").click(function (e) {
            e.preventDefault();

            var splitt = $(this).attr('datanya').split('_');
			var html = "<h3>Form Edit Customer</h3><br>" +
                "<form id='formEditCustomer'>" +
                "<div class='form-group'>"+
                "<label for='email'>KTP/SIM/Passport</label>" +
                "<input type='hidden' value='"+splitt[0]+"' name='idcustomer' />"+
                "<input value='"+splitt[1]+"' type='text' name='ktp' class='form-control' id='ktp' />"+
                "<label for='email'>Nama Customer</label>"+
                "<input value='"+splitt[2]+"' type='text' name='nama' class='form-control' id='nama' />"+
                "<label for='email'>Alamat Lengkap</label>"+
                "<textarea name='alamat' class='form-control' cols='30' rows='2' id='alamat'>"+splitt[3]+"</textarea>"+
                "<label for='email'>Telepon</label>"+
                "<input value='"+splitt[4]+"' type='text' name='telepon' class='form-control' id='telepon' />"+
                "</div>"+
                "</form>";
				
			$("#modalMasterDataForm").html(html);
			$("#modalMasterData").modal('show');
			$("#btnAksiTambahMaster").click(function () {
				var datanya = $("#formEditCustomer").serialize();
				$.ajax({
					type: "POST",
					data: datanya,
					url: "../libs/proseseditcustomer.php",
					success: function(psn){
						location.href='?mod=customer&stat='+psn;
					}
				})
			})
		});

        $(".editNomorNota").click(function (e) {
            e.preventDefault();

            var splitt = $(this).attr('datanya').split('_');

            var html = "<h3>Form Edit Nota</h3><br>" +
                "<form id='formEditNota'>" +
                "<div class='form-group'>"+
                "<label for='email'>Jenis Valas</label>" +
                "<input type='hidden' value='"+splitt[0]+"' name='idnota' />"+
                "<input value='"+splitt[1]+"' type='text' list='macamvalas' name='jenis_valas' class='form-control' id='jenis_valas' />"+
                "<label for='email'>Jumlah</label>"+
                "<input value='"+splitt[2]+"' type='text' name='jumlah' class='form-control' id='jumlah' />"+
                "<label for='email'>Kurs</label>"+
                "<input value='"+splitt[3]+"' type='text' name='kurs' class='form-control' id='kurs' />"+
                "<label for='email'>Nilai</label>"+
                "<input value='"+splitt[4]+"' type='text' name='nilai' class='form-control' id='nilai' />"+
                "</div>"+
                "</form>";
            $("#modalMasterDataForm").html(html);
            $("#modalMasterData").modal('show');
            $("#btnAksiTambahMaster").click(function () {
                var datanya = $("#formEditNota").serialize();
                $.ajax({
                    type: "POST",
                    data: datanya,
                    url: "../libs/proseseditnota.php",
                    success: function(psn){
                        location.href='?mod=nota&stat='+psn;
                    }
                })
            })
        });

        $("#cariLaporanHarian").click(function () {
            var tgl = $("#tglStartHarian").val();

            $.ajax({
                type: "POST",
                data: "tgl="+tgl,
                url: "../libs/caritransaksi.php",
                success: function(msg){
                    $("#tglStartHarian").attr("disabled","on");
                    $("#refreshHalamanLaporanHarian").show();
                    $("#cariLaporanHarian").hide();
                    $("#cekLaporanHarian").html(msg);
                }
            })
        });

        $("#cariLaporanStokHarian").click(function () {
            var tgl = $("#tglStokHarian").val();

            $.ajax({
                type: "POST",
                data: "tgl="+tgl,
                url: "../libs/caristokharian.php",
                success: function(msg){
                    $("#tglStokHarian").attr("disabled","on");
                    $("#refreshHalamanLaporanHarian").show();
                    $("#cariLaporanStokHarian").hide();
                    $("#cekLaporanStokHarian").html(msg);
                }
            })
        });

        var i = 0;
        $("#tambahBaris").click(function () {
            i = i+1;
            var jenis = 'jenis'+i;  var jumlah = 'jumlah'+i;
            var kurs = 'kurs'+i;    var nilai = 'nilai'+i;
            var html = '<tr>'+
                '<input type="hidden" name="itung[]" />'+
                '<td><input type="text" list="macamvalas" name="'+jenis+'" class="form-control input_capital"/></td>'+
                '<td><input type="text" name="'+jumlah+'" class="form-control"/></td>'+
                '<td><input type="text" onchange=\'hitungNilai(this, "'+jumlah+'", "'+nilai+'");\' name="'+kurs+'" class="form-control"/></td>'+
                '<td><input type="text" name="'+nilai+'" class="form-control"/></td>'+
                '</tr>';
            $("#dtailtrans > tbody:last-child").append(html);
        });

        $("#hapusBaris").click(function () {
            $("#dtailtrans > tbody > tr:last").remove();
        });

        $('.input_capital').on('input', function(evt) {
            $(this).val(function (_, val) {
                return val.toUpperCase();
            });
        });
    });
</script>
</body>
</html>

<?php }else{
    include("../libs/error.php");
}