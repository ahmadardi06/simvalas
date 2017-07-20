<?php
/**
 * Created by PhpStorm.
 * User: ardi
 * Date: 08/06/17
 * Time: 22:26
 */
include(dirname(__FILE__) . '/../libs/database.php');
$sql = $db->prepare("SELECT COUNT(*) FROM transaksi WHERE nonota=:NOTANYA");
$sql->bindParam(":NOTANYA", $_POST['nota']);
$sql->execute();
$jml = $sql->fetchColumn();
echo $jml;