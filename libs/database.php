<?php
/**
 * Created by PhpStorm.
 * User: ardi
 * Date: 08/06/17
 * Time: 1:47
 */
 /**
$localhost  = "localhost";
$username   = "root";
$password   = "";
$dbname     = "dbvalas";

// create connection
$db = new mysqli($localhost, $username, $password, $dbname);

// check connection
if($db->connect_error) {
    die("connection failed : " . $db->connect_error);
}
*/

$user = "valas";
$pass = "valas";
$dbas = "
	(DESCRIPTION =
		(ADDRESS_LIST =
		  (ADDRESS = (PROTOCOL = TCP)(HOST = localhost)(PORT = 1521))
		)
		(CONNECT_DATA =
		  (SERVICE_NAME = orcl)
		)
	)";
	
try{
    $db = new PDO("oci:dbname=".$dbas,$user,$pass);
    //if($db) echo "Connected!.";
}catch(PDOException $e){
    echo ($e->getMessage());
}
?>
