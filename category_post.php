  <!-- Start of Header -->
  
  <?php include_once "includes/header.inc.php"?>
                <!-- End of Header -->

                <!-- Start of Search Wrapper -->
                <?php include_once "includes/searchwrapper.inc.php"?>
                
                <!-- End of Search Wrapper -->
                <!-- Start of Page Container -->
                <form  id = "ParentForm" name ="ParentForm" method ="POST" Action ="#">
                <input type="hidden" id="hdnFormAction" name="hdnFormAction" value=""/>
                                <input type="hidden" id="hdnArgs" name="hdnArgs" value=""/>
                <div class="page-container">
                        <div  id ="dvContainer" name ="dvContainer" class="container">
                                <div class="row">
                                   
                                   <?php
                                       include_once "db/connect.php";
                                      //var_dump($_POST) ;
                                        //echo  $_POST['hdnFormAction'];
                                        
                                      if  (isset($_POST['hdnFormAction']) )
                                      {
                                       
                                          $args = $_POST['hdnArgs'];
                                           redirectPage($_POST['hdnFormAction'], $args)     ;
                                         // include_once $_POST['hdnFormAction']  ;
                                      }
                                      else {
                                        include_once "category_home.php" ;
                                            
                                   ?>
                                     
                                      <?php } ?>
                                        <!-- end of page content -->


                                        <!-- start of sidebar -->
                                                      
                                         <!-- End of sidebar -->
                                </div>
                        </div>
                </div>
                </form>
                <!-- End of Page Container -->
                 <!-- Start of Footer -->
                 <?php include_once "includes/footer.inc.php"?>

<!-- End of Footer -->

<?php 
 
function formPost_Delete($post_id)
{
  echo $post_id;
	$db_conn = dbconnect(DBHOST, DBDB, DBUSER, DBPW);

	$qry_post = "UPDATE post_master SET post_active = 'D' WHERE post_master_id =".$post_id.";" ;
	$rs = $db_conn->query($qry_post);
        // showQueryErrors($db_conn,$qry_post);
	
	dbdisconnect($db_conn);
	return $rs;

}

function formPost_Archive($post_id)
{
	$db_conn = dbconnect(DBHOST, DBDB, DBUSER, DBPW);

	$qry_post = "UPDATE post_master SET post_active = 'A' WHERE post_master_id =".$post_id.";" ;
	$rs = $db_conn->query($qry_post);
        // showQueryErrors($db_conn,$qry_post);
	
	dbdisconnect($db_conn);
	return $rs;

}

    
   function  redirectPage($new_page, $args)     
   {
           //echo 'test from redirect';
        switch ($new_page) {
                case "post_all.php":
                    switch ($args){
                            case 'btnViewAll' :
                                 loadPage($new_page,'');
                                 $_SESSION['user_type']  ='mbr';
                                 if ($_SESSION['user_type'] =='mbr') { 
                                    formPostAdd('','','');
                                 }
                                 break;
                           
                            case 'btn_new_post' :
                                 loadPage($new_page,'');
                                 formPostAdd('','','');
                                 break;

                           case 'btn_post_save' :
                                 $category_id =1;
                                 loadPage($new_page,'');
                                 formPostAdd($category_id,$_POST['txtheading'], $_POST['txtContents']);
                               // formPostAdd($category_id,'','');
                                 formPostSave($category_id );
                                 echo '<script type="text/javascript">', 'document.getElementById("hdnArgs").value = "btnViewAll" ;',     '</script>';
                                 echo '<script type="text/javascript">', 'document.getElementById("hdnFormAction").value ="post_all.php" ;',     '</script>';
                                 echo '<script type="text/javascript">', 'document.ParentForm.submit();',     '</script>';
                                 
                                 break;
                              //delete button postback   
                            case fnmatch('D*',$args): 
                              echo "D";
                              formPost_Delete(ltrim($args,'D'));
                              loadPage($new_page,'');
                                 formPostAdd('','','');
                                 break;

                                  //Archive button postback   
                            case fnmatch('A*',$args): 
                            echo "A";
                            formPost_Archive(ltrim($args,'A'));
                            loadPage($new_page,'');
                               formPostAdd('','','');
                               break;
                            // when passing with id 
                            default:
                            loadPage($new_page, $args);  

                    }
                   break; 
                case "post_master.php":
                      loadPage($new_page, $args); 
                    break;
                case "category_home.php":
                      loadPage($new_page, $args); 
                    break;
                case "green":
                    echo "Your favorite color is green!";
                    break;
                default:
                    echo "Your favorite color is neither red, blue, nor green!";
            }
     
   }

  function   loadPage($new_page, $args)
       {
              // echo 'test load page';
        include_once $new_page ;
       }

       ?>

<?php 
       function formPostAdd($category_id ,$heading ,$contents)
{      
	?>
        
	<div  width="100%" height="100%"  >
	 <h3> New Post Entry Page </h3>
	
	 <br>
				
	 <label for="heading">Heading</label>  
		<input type="text" size="200"  id ="txtheading" name="txtheading" value= "<?php echo  $heading ?>"></input>
		<br>
				 <br>  

				 <label for="txtContents">Content</label>
		<textarea id="txtContents" name="txtContents" rows="7" cols="250" maxlength="65530"  width ="100%"><?php echo  $contents ?></textarea>
		
				 		
				 
				 <br>
				 
				 <input type="submit" id ="btn_post_save" name ="btn_post_save"  onclick ="currentPage(this,'post_all.php');"  value="Save" />
				 <input type="submit" name ="Cancel" value="Cancel"/>
				 <br>
			</div>
	 
	<?php
    
}
?> 
<script language ="Javascript" type ="text/javascript">
 function clearform()
 {
          
        document.getElementById("hdnArgs").value = 'btnViewAll' ;
                                   document.getElementById("hdnFormAction").value ='post_all.php' ;
                            
                                  // alert(document.getElementById("hdnFormAction").value);
                                   document.ParentForm.submit();
 }
</script>