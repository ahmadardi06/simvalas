<?php
/**
 * Created by PhpStorm.
 * User: ardi
 * Date: 08/06/17
 * Time: 22:26
 */
include(dirname(__FILE__) . '/../libs/database.php');
$sql = $db->query("UPDATE nota SET jenis_valas='".$_POST['jenis_valas']."', jumlah='".$_POST['jumlah']."',
                    kurs='".$_POST['kurs']."', nilai='".$_POST['nilai']."' WHERE id='".$_POST['idnota']."'");
if($sql){
    echo "EditOK";
}else{
    echo "EditFAIL";
}