<?php
/**
 * Created by PhpStorm.
 * User: ardi
 * Date: 08/06/17
 * Time: 2:05
 */
session_start();
include_once("../libs/database.php");
if(!empty($_SESSION['iduser'])){
$dtuser = $db->query("SELECT * FROM karyawan WHERE id='".$_SESSION['iduser']."'")->fetch_array(); ?>


<?php
}else{
    include("../libs/error.php");
}
