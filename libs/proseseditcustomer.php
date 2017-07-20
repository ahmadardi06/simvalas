<?php
/**
 * Created by PhpStorm.
 * User: ardi
 * Date: 08/06/17
 * Time: 22:26
 */
include(dirname(__FILE__) . '/../libs/database.php');
$sql = $db->query("UPDATE customer SET ktp='".$_POST['ktp']."', nama='".$_POST['nama']."',
                    alamat='".$_POST['alamat']."', telepon='".$_POST['telepon']."' WHERE id='".$_POST['idcustomer']."'");
if($sql){
    echo "EditOK";
}else{
    echo "EditFAIL";
}