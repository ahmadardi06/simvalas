<?php
/**
 * Created by PhpStorm.
 * User: ardi
 * Date: 08/06/17
 * Time: 23:51
 */
include(dirname(__FILE__).'/../../libs/database.php');
if(isset($_GET['prosesTransaksi'])){
    //insert on table saldoharian
    $tgl = $_GET['tgl'];
    $bon = $_GET['bon'];
    $tit = $_GET['titip'];

    $cari = $db->query("SELECT * FROM titipbon WHERE tgl='".$tgl."'")->num_rows;
    if($cari == 1){
        $sql = $db->query("UPDATE titipbon SET bon='".$bon."', titip='".$tit."' WHERE tgl='".$tgl."'");
    }else{
        $sql = $db->query("INSERT INTO titipbon VALUES ('','".$tgl."','".$tit."','".$bon."')");
    }

    if($sql){
        header("location: ../index.php?mod=bontitip&act=OK");
    }

}
