<?php
 include_once "db/connect.php";

function displaycategories(){
  $db_conn = dbconnect(DBHOST, DBDB, DBUSER, DBPW);
  $sql = "SELECT * FROM category_master";

$result = $db_conn->query($sql);
$output="";
while($row = mysqli_fetch_array($result)){
  
  $cate_id = $row["category_id"];
  $cate_name = $row['name'];

echo "<li><a href='category_post.php' title='Lorem ipsum dolor sit amet'>". $cate_name."</a></li>";

    
}
$db_conn->close();
     
}

function uen($string){
  return rawurlencode($string);
}




function hotposts(){
    $db_conn = dbconnect(DBHOST, DBDB, DBUSER, DBPW);
	
	$qry_post = "select * from post_master  pm
				  left outer join member_profile mp 
				  on pm.member_id =mp.member_id"				
                ." where pm.category_id ='1' order by pm.post_date DESC";
                
    $rs = $db_conn->query($qry_post);
    
    while($row=mysqli_fetch_array($rs)){
      
    $postid=$row['post_master_id'];        
    $posth = $row["post_heading"];
    $postdate = $row["post_date"];

      
    $postid_url=$postid;
     // $likeNum=gethotposlikes($postid);

        echo "<li class='article-entry standard'> <h4><a href='single.php?id=".$postid_url."'>".$posth."</a></h4>".
        "<span class='article-meta'>".$postdate." in <a href='#' title='View all posts in Advanced Techniques'>".$posth."</a>".
        "</span>".
        //"<span class='like-count'>".$likeNum."</span>".
       
        "</li>";
    }
   

    $db_conn->close();
}


function recentposts(){
    $db_conn = dbconnect(DBHOST, DBDB, DBUSER, DBPW);
	
	$qry_post = "select * from post_master  pm
				  left outer join member_profile mp 
				  on pm.member_id =mp.member_id"				
                ." where pm.category_id ='1' order by pm.post_date DESC";
                
    $rs = $db_conn->query($qry_post);
    
    while($row=mysqli_fetch_array($rs)){
      
    $postid=$row['post_master_id'];        
    $posth = $row["post_heading"];
    $postdate = $row["post_date"];

    $postid_url=urlencode($postid);

        echo "<li class='article-entry standard'> <h4><a href='single.php?id=".$postid_url."'>".$posth."</a></h4>".
        "<span class='article-meta'>".$postdate." in <a href='#' title='View all posts in Advanced Techniques'>".$posth."</a>".
         "</span>".
        "<span class='like-count'>66</span></li>";
    }
   
        // showQueryErrors($db_conn,$qry_post);
	
    $db_conn->close();
}

function post_data($postid){

  
    $db_conn = dbconnect(DBHOST, DBDB, DBUSER, DBPW);
    $post_query="select * from post_master where post_master_id=".$postid."";
    $post_rs=$db_conn->query($post_query);
    
   $row=mysqli_fetch_array($post_rs);

    echo "<li><a href='index.php'>The Londoners</a><span class='divider'>/</span></li>".
    "<li><a href='category_post.php?categoryid=".$row['category_id']."' title='View all posts in Server &amp; Database'>Server &amp; Database</a> <span class='divider'>/</span></li>".
    "<li class='active'>".$row['post_heading']."</li>";


    
echo "<h1 class='post-title'><a href=''>".$row['post_heading']."</a></h1>".

    "<div class='post-meta clearfix'>".
    "<span class='date'>25 Feb, 2013</span>".
    "<span class='category'><a href='#' title='View all posts in Server &amp; Database'>Server &amp; Database</a></span>".
    "<span class='comments'><a href='#' title='Comment on Integrating WordPress with Your Website'>3 Comments</a></span>".
    "<span class='like-count'>66</span>".
    "</div>".
    "<p>".$row['contents']."</p>";
    

}

function getpostlikes($postid){

    $db_conn = dbconnect(DBHOST, DBDB, DBUSER, DBPW);
    $qry_count = "SELECT post_master_id FROM post_likes where post_master_id =$postid";
    $result=$db_conn->query($qry_count);
    $likeNum = mysqli_num_rows($result);
    

    echo "<span class='like-it'>".$likeNum."</span>".
    "<input type='hidden' name='post_id' value='".$postid."'>";
    
   
    
}

function gethotposlikes($postid){
  $db_conn = dbconnect(DBHOST, DBDB, DBUSER, DBPW);
  $qry_count = "SELECT post_master_id FROM post_likes where post_master_id =$postid";
  $result=$db_conn->query($qry_count);
  $likeNum = mysqli_num_rows($result);
  return $likeNum;
}


function loginmodals(){

    $str ="<div class='modal fade' id='exampleModal' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
  <div class='modal-dialog' role='document'>
    <div class='modal-content'>
      <div class='modal-header'>
      <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
          <span aria-hidden='true'>&#10060;</span>
        </button>
     
        <h5 class='modal-title' id='exampleModalLabel'>Login</h5>
      
      </div>
      <div class='modal-body'>
        <form id='loginform' method='post'>
        <center>
          <div class='form-group'>
           
            <label for='recipient-name' class='col-form-label'>UserName <input type='text' class='form-control' name='UserName' id='UserName' value='' required></label>
           
            <div  id='invalidUserName'></div>
          </div>
          <div class='form-group'>
            <label for='message-text' class='col-form-label'>Password <input type='password' class='form-control' name='password' id='password'  required value=''></label>
           
          </div>
          <div  id='invalidPassword'></div>
          </center>
        </form>

      </div>
      <div class='modal-footer'>
        <button type='submit' class='btn btn-primary' id='button1'>Login</button>
        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
        
      </div>
    </div>
  </div>
</div>";
return $str;
}

function regmodals(){
    $reg1="<div class='modal fade' id='exampleModal1'  tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
  <div class='modal-dialog' role='document'>
    <div class='modal-content'>
      <div class='modal-header'>
      <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
      <span aria-hidden='true'>&#10060;</span>
    </button>
        <h5 class='modal-title' id='exampleModalLabel'>Login</h5>
        
      </div>
      <div class='modal-body'>
        <form id='regform' method='post'>
        <div class='form-group'>
        <label for='recipient-name' class='col-form-label'>UserName <input type='text' id='regusername' name='regusername' class='form-control' required> </label>
        
        <span class='help-block'></span>
    </div>   
    <div class='form-group'>
    <label for='recipient-name' class='col-form-label'>First Name <input type='text' id='firstname' name='firstname' class='form-control'> </label>
        
        <span class='help-block'></span>
    </div> 
    <div class='form-group'>
        <label>Last Name <input type='text' id='lastname' name='lastname' class='form-control'></label>
        
        <span class='help-block'></span>
    </div>
    
    <div class='form-group'>
        <label>Email ID   <input type='email' id='email' name='email1' class='form-control'></label>
      
        <span class='help-block'></span>
    </div>   
    <div class='form-group'>
        <label>Password <input type='password' id='regpassword' name='regpassword' class='form-control'></label>
        
        <span class='help-block'></span>
    </div>
    <div class='form-group'>
        <label>Confirm Password <input type='password' id='confirm_password' name='confirm_password' class='form-control'></label>
        
        <span class='help-block'></span>
    </div>
  
        </form>
      </div>
      <div class='modal-footer'>
      <p>Already a member <a id='reglogin' >click here!</a> to Login</p>
        <button type='submit' class='btn btn-primary' id='regbutton'>Register</button>
        <input type='reset' class='btn btn-default' value='Reset'>
        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
        
      </div>
    </div>
  </div>
</div>";
return $reg1;
}

function getPostsByCategoryID($category_id){
  $db_conn = dbconnect(DBHOST, DBDB, DBUSER, DBPW);

	$qry_post = "select * from post_master  pm
				  left outer join member_profile mp 
				  on pm.member_id =mp.member_id"				
                ." where pm.category_id =$category_id order by pm.post_date DESC";
                
    $rs = $db_conn->query($qry_post);
    
    while($row=mysqli_fetch_array($rs)){
      
    $postid=$row['post_master_id'];        
    $posth = $row["post_heading"];
    $postdate = $row["post_date"];

    $page="postmaster.php";

        echo "<li class='article-entry standard'> <h4><a href='single.php?id=".$postid."'>".$posth."</a></h4>".
        "<span class='article-meta'>".$postdate." in <a href='#' title='View all posts in Advanced Techniques'>".$posth."</a>".
        "</span>".
        "<span class='like-count'>66</span></li>";
    }
   
   echo "<h4><a class='readmore-link' id='btnViewAll' name ='btnViewAll' onclick =currentPage(this,'post_all.php');>View All</a></h4>";
   //echo "<h4><input type ='submit' id ='btnViewAll' name ='btnViewAll'  onclick =currentPage(this,'post_all.php'); value ='View All'/> </h4>";
      // showQueryErrors($db_conn,$qry_post);

  $db_conn->close();

}




/*GET ALL POST BY CATEGORY ID*/
function getAllPostsByCategoryID($category_id)
{

  echo " <ul class='breadcrumb'>".
  "<li><a href='index.php'>The Londoners</a><span class='divider'>/</span></li>".
  "<li><a href='categories.php?category_id=".$category_id."' title='View all posts in Server &amp; Database'>Server &amp; Database</a> <span class='divider'>/</span></li>".
 
"</ul>";

  
    $db_conn = dbconnect(DBHOST, DBDB, DBUSER, DBPW);
    
	$qry_post = "select * from post_master"		
                ." where category_id =".$category_id." and post_active <>'D' order by post_date DESC";
                
    $rs = $db_conn->query($qry_post);

    while($row=mysqli_fetch_array($rs))
    {
        
          
  



    echo "<article class=' type-post  format-standard hentry clearfix'>".

   " <header class='clearfix'>".

           " <h3 class='post-title'>".
                   " <a href='single.php?id=".$row["post_master_id"]."'>".$row["post_heading"]."</a>".
           " </h3>".

           " <div class='post-meta clearfix'>".
                   " <span class='date'>".$row["post_date"]."</span>".
                  " <span class='category'><a href='category_post?id=".$category_id."' title='View all posts in Server &amp; Database'></a></span>".
                   " <span class='comments'>3 Comments</span>".
                  
            "</div>".

    "</header>".

   " <p> ".substr($row['contents'], 0,50) .". . . <a class='readmore-link' href='single.php?id=".$row['post_master_id']."'>Read more</a></p>".

"</article>";
}

}
?>
                              
    

































<!-- <script Language ="Javascript" type ="text/javascript">
 function currentPage(ctl,new_page){
   
     document.getElementById("hdnArgs").value = ctl.id ;
     document.getElementById("hdnFormAction").value =new_page ;

    // alert(document.getElementById("hdnFormAction").value);
     document.ParentForm.submit();

     
 }
</script> -->

