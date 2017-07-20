<?php
/**
 * Created by PhpStorm.
 * User: ardi
 * Date: 11/06/17
 * Time: 9:31
 */
include(dirname(__FILE__) . '/../libs/database.php');

if($_GET['mod'] == 'saldovalas'){
    $cari = $db->prepare("SELECT count(jenis_valas) FROM SALDOVALAS WHERE jenisvalas=:jenisnya AND tgl=:tglnya");
    $cari->bindParam(":jenisnya", $_POST['jenis_valas']);
    $cari->bindParam(":tglnya", $_POST['tgl_valas']);
    $cari->execute();
    if($cari->fetchColumn() == 1){
        $sql = $db->prepare("UPDATE SALDOVALAS SET valas=:valasnya, rupiah=:rupiahnya WHERE jenisvalas=:jenisvalasnya AND tgl=:tglnya");
        $sql->bindParam(":valasnya", $_POST['saldo_valas']);
        $sql->bindParam(":rupiahnya", $_POST['saldo_rupiah']);
        $sql->bindParam(":jenisvalasnya", $_POST['jenis_valas']);
        $sql->bindParam(":tglnya", $_POST['tgl_valas']);
    }else{
        $sql = $db->prepare("INSERT INTO SALDOVALAS VALUES (:u1, :u2, :u3, :u4)");
        $sql->bindParam(":u3", $_POST['saldo_valas']);
        $sql->bindParam(":u4", $_POST['saldo_rupiah']);
        $sql->bindParam(":u1", $_POST['jenis_valas']);
        $sql->bindParam(":u2", $_POST['tgl_valas']);
    }
    $sql->execute();

    echo "InsertOK";
}
elseif($_GET['mod'] == 'saldoharian'){
    $cari = $db->prepare("SELECT count(tgl) FROM saldoharian WHERE tgl=:tglnya");
    $cari->bindParam(":tglnya", $_POST['tgl']);
    $cari->execute();
    if($cari->fetchColumn() == 1){
        $sql = $db->prepare("UPDATE saldoharian SET saldo=:u1, titipan_awal=:u2 WHERE tgl=:u3");
        $sql->bindParam(":u1", $_POST['saldo']);
        $sql->bindParam(":u2", $_POST['titipan_awal']);
        $sql->bindParam(":u3", $_POST['tgl']);
        $sql->execute();
    }else{
        $sql = $db->prepare("INSERT INTO saldoharian VALUES (:u3,:u1,:u2)");
        $sql->bindParam(":u1", $_POST['saldo']);
        $sql->bindParam(":u2", $_POST['titipan_awal']);
        $sql->bindParam(":u3", $_POST['tgl']);
        $sql->execute();
    }
    echo "InsertOK";
}