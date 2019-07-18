<?php 
  include_once "db/connect.php";

  if ($args == '' ){
    
  $category_id = 1;

?>


<div class="container">
                                <div class="row">
                                <div class="span8 page-content">
                              

                                              
<?php
include_once "functions/functions.php";

  getAllPostsByCategoryID($category_id) ;

  ?>       
 
         
 </div>
 </div>
 </div>
 <?php
}   

  // get post deatis for the selecgted category
// function getAllPostsByCategoryID($category_id){
//     $db_conn = dbconnect(DBHOST, DBDB, DBUSER, DBPW);
	
// 	$qry_post = "select * from post_master  pm
// 				  left outer join member_profile mp
// 				  on pm.member_id =mp.member_id"				
//                 ." where pm.category_id =".$category_id." and pm.post_active <>'D' order by pm.post_date DESC";
                
//     $rs = $db_conn->query($qry_post);

//     while($row=mysqli_fetch_array($rs)){
        
            
//     $posth = $row["post_heading"];
//     $postdate = $row["post_date"];
//     $contents = $row["contents"];

   
               
//                $id =  $row['post_master_id'];



//         echo "<li class='article-entry standard'> <h4><a id =".$row['post_master_id']." href='single.php?id=".$id. "' >".$posth."</a></h4>".
//         "<span class='article-meta'>".$postdate."</span>".
//         "<p>".$contents ."</p>".
//         "<span class='like-count'>66</span>";
       
//         $_SESSION['userid'];
//         echo $row['member_id'];
//         //if ($_SESSION['member_id'] ==$row['member_id']) { ?>
						 
            
<!--            <a href = #dvContainer onclick ="currentPage(this,'post_all.php');" id = <--?php echo 'D'.$row['post_master_id'];?> name =  <--?php echo 'D'.$row['post_master_id'];?> >Delete </a> &nbsp;
                               
//             <a href = #dvContainer  onclick ="currentPage(this,'post_all.php');" id = <--?php echo 'A'.$row['post_master_id'];?> name =  <-?php echo 'A'.$row['post_master_id'];?> >Archive </a> </li>
//                                 <?php //}
    //}
   

    
    $_SESSION['user_type']  ='mbr';
   if ($_SESSION['user_type'] =='mbr') { 
   
   //echo "<h4><input type ='submit' id ='btn_new_post' name ='btn_new_post'  onclick =currentPage(this,'post_all.php'); value ='Write a new post'/> </h4>";
   //onclick =currentPage(this,'post_master.php');
    
   } 
   
   
       
   
   
   


     echo "<h4><input type ='submit' id ='btnBack' name ='btnBack'  onclick =currentPage(this,'category_home.php'); value ='Back'/> </h4>";
        // showQueryErrors($db_conn,$qry_post);
	
    $db_conn->close();
  
//}


?>

<?php 
function formPostSave($category_id ){
	
	$error_formAdd_msg = validate_formAdd_fields();
	if (count($error_formAdd_msg) > 0){
					display_error($error_formAdd_msg);
					// if error stay on page 2 with user data 
					//form_next($_POST['notes'], strtolower(pathinfo($_FILES['pic']['name'])));
					formPostAdd($category_id,$_POST['txtheading'], $_POST['txtContents']);
	}
	else{
			//if page 2 validation success , upload image and save data to db .
	save_data($category_id);
	// if save success  show summary page

	//formDisplayPosts($category_id);
//display_success();
	}
}


?>
<?php
function save_data($category_id){
    $_SESSION['id'] =1;
    
	$db_conn = dbconnect(DBHOST, DBDB, DBUSER, DBPW);
$qry = "INSERT INTO post_master (member_id,category_id , location_id,post_heading,contents,post_date, 
          approved_by,approved_date,post_active,post_inactive_date,post_viewer_action_id,comments) 
         values(".$_SESSION['id'].", '".$category_id."',1,'".$_POST['txtheading']."',
         '".$_POST['txtContents']."', current_timestamp,1,current_timestamp,'Y',current_timestamp,1,'test');";
	
//.$_SESSION['id']
//$db_conn->query($qry);
    
    if($db_conn->query($qry)!==true){
        echo $db_conn->error;
    }
    
//get PK from table
$post_id  = mysqli_insert_id($db_conn);   

return $post_id;

}
?>


<?php 
  // validate page 1
function validate_formAdd_fields(){
    $error_msg = array();
     echo "tst from validation";
    //Name validation
	if (!isset($_POST['txtheading'])){
		$error_msg[] = " Heading field not defined";
	} else if (isset($_POST['txtheading'])){
		$heading = trim($_POST['txtheading']);
		if (empty($heading)){
			$error_msg[] = "The  Heading field is empty";
		} else {
			if (strlen($heading) >  100){
				$error_msg[] = "The  heading field contains too many characters";
			}
		}
    }
    
    if (!isset($_POST['txtContents'])){
			$error_msg[] = " Notes field not defined";
		} else if (isset($_POST['txtContents'])){
			$txtContents = trim($_POST['txtContents']);
			if (empty($txtContents)){
				$error_msg[] = "The  Contents field is empty";
			} else {
				if (strlen($txtContents) >  65535){
					$error_msg[] = "The   Contents field contains too many characters";
				}
			}
			}
    
    
/*	if (count($error_msg) == 0){
       // if no error store session 
        store_form1_session( $name, $age);         
	} */
	return $error_msg;
} ?>

<?php function display_error($error_msg){
	echo "<p>\n";
	foreach($error_msg as $v){
		echo $v."<br>\n";
	}
	echo "</p>\n";
} ?>
