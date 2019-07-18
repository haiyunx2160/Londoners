<?php
session_start();
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

$pst_id=$_POST['post_id'];

if(isset($_SESSION["loggedin"]) && isset($_SESSION["userid"]) ){

        $mem_id=$_SESSION["userid"];
    $db_conn = dbconnect(DBHOST, DBDB, DBUSER, DBPW);

    $qry_check_memID="SELECT member_id FROM post_likes WHERE member_id=$mem_id AND post_master_id = $pst_id";

    $res = mysqli_query($db_conn, $qry_check_memID);

    $row=mysqli_fetch_assoc($res);

    if($row) {

        $qry_count = "SELECT post_master_id FROM post_likes where post_master_id =$pst_id";

        $result=$db_conn->query($qry_count);

        $likeNum = mysqli_num_rows($result);

        echo $likeNum;

        exit;

    }else{

        $qry_add_like= "INSERT INTO post_likes (post_master_id, member_id) VALUES ('$pst_id', '$mem_id')";

        if ($db_conn->query($qry_add_like) === TRUE) {

            $qry_count = "SELECT post_master_id FROM post_likes where post_master_id =$pst_id";

            $result=$db_conn->query($qry_count);

            $likeNum = mysqli_num_rows($result);

            echo $likeNum;

        exit;
        } else {
            echo "Error: " . $qry_add_like . "<br>" . $db_conn->error;
        }

    }
}
else{
    echo "Login";
}

?>

