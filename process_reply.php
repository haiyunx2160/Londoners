<?php
 session_start();



$db1= new mysqli('localhost','londoners','London123!','Londoners');

$qry = "insert into thread_comments (post_id,post_thread_id,member_id,comments) values (2,".$_POST['thread'].",".$_SESSION['id'].",'".mysqli_real_escape_string($db1,$_POST['comment'])."');";


if($db1->query($qry) !== true){
    echo $db1->error;
}


?>