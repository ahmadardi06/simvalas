<?php
/**
 * Created by PhpStorm.
 * User: ardi
 * Date: 08/06/17
 * Time: 22:26
 */
include(dirname(__FILE__) . '/../libs/database.php');
$sql = $db->prepare("SELECT COUNT(*) FROM customer WHERE ktp=:KTPNYA");
$sql->bindParam(":KTPNYA", $_POST['ktp']);
$sql->execute();
$jml = $sql->fetchColumn();

$sql1 = $db->prepare("SELECT * FROM customer WHERE ktp=:KTPNYA");
$sql1->bindParam(":KTPNYA", $_POST['ktp']);
$sql1->execute();
$ddd = $sql1->fetch();
echo $jml."_".$ddd['NAMA']."_".$ddd['TELEPON']."_".$ddd['ALAMAT']."_".$ddd['KTP'];