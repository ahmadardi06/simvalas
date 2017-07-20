<?php
/**
 * Created by PhpStorm.
 * User: ardi
 * Date: 08/06/17
 * Time: 23:51
 */
ini_set('display_errors', 1);
session_start();
include(dirname(__FILE__).'/../../libs/database.php');
$dtuser = $db->prepare("SELECT * FROM pegawai WHERE idpeg=:usernya");
$dtuser->bindParam(":usernya", $_SESSION['iduser']);
$dtuser->execute();
if(isset($_GET['prosesTransaksi'])){
    //insert on table customer
    if(empty($_GET['idcustomer'])){
        $oncustomer = $db->prepare("INSERT INTO customer VALUES (:c1, :c2, :c3, :c4)");
        $oncustomer->bindParam(":c1", $_GET['ktp']);
        $oncustomer->bindParam(":c2", $_GET['nama']);
        $oncustomer->bindParam(":c3", $_GET['alamat']);
        $oncustomer->bindParam(":c4", $_GET['telepon']);
        $oncustomer->execute();
    }

    //insert on table transaksi
    $t4 = 0; $t5 = 'B';
    $ontrans    = $db->prepare("INSERT INTO transaksi VALUES (:t1, :t2, :t3, :t4, :t5)");
    $ontrans->bindParam(":t1", $_GET['nonota']);
    $ontrans->bindParam(":t2", $_GET['tgl_transaksi']);
    $ontrans->bindParam(":t3", $_GET['ktp']);
    $ontrans->bindParam(":t4", $t4);
    $ontrans->bindParam(":t5", $t5);
    $ontrans->execute();

    //insert on table nota
    $jmltotal = 0;
    for($i=0; $i<count($_GET['itung']); $i++){
        $onnota = $db->prepare("INSERT INTO DTRANSAKSI VALUES (:n1, :n2, :n3, :n4, :n5)");
        $onnota->bindParam(":n1", $_GET['nonota']);
        $onnota->bindParam(":n2", $_GET['jenis'.$i]);
        $onnota->bindParam(":n3", $_GET['jumlah'.$i]);
        $onnota->bindParam(":n4", $_GET['kurs'.$i]);
        $onnota->bindParam(":n5", $_GET['nilai'.$i]);
        $onnota->execute();
        $jmltotal = $jmltotal+$_GET['nilai'.$i];
    }

    //update on table transaksi
    $uptrans = $db->prepare("UPDATE transaksi SET total=:upt1 WHERE nonota=:upt2");
    $uptrans->bindParam(":upt1", $jmltotal);
    $uptrans->bindParam(":upt2", $_GET['nonota']);
    $uptrans->execute();

//    if($ontrans->execute() && $uptrans->execute()){
//        echo '  <div class="alert alert-success">
//                            <strong>Success!</strong> Proses Transaksi Berhasil Dilakukan.
//                        </div>';
        header("location: ../index.php?mod=pembelian&print=".$_GET['nonota']);
//    }else{
//        echo '  <div class="alert alert-danger">
//                            <strong>Failed!</strong> Proses Transaksi Gagal Dilakukan.
//                        </div>';
//    }
}