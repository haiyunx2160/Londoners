
<?php
/**
 * Created by PhpStorm.
 * User: Pedro 
 * Date: 18/02/2019
 * Time: 22:14
 */

define("DBHOST", "localhost");
define("DBDB",   "Londoners");
define("DBUSER", "londoners");
define("DBPW", "London123!");

function dbconnect($host, $db, $user, $pw){
	
$db_conn = new mysqli($host, $user, $pw, $db);
	if ($db_conn->connect_errno) {
   	 die ("Could not connect to database server".$db_host."\n Error: "
			.$db_conn->connect_errno 
			."\n Report: ".$db_conn->connect_error."\n");
	}
	return $db_conn;
}

function dbdisconnect($db_conn){
	$db_conn->close();
}
?>