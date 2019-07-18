<?php 
    // Initialize the session
    
     include_once "includes/header.inc.php";

  
    //conn file
    include_once "db/connect.php";
    $db_conn = dbconnect(DBHOST, DBDB, DBUSER, DBPW);
    //update member's profile
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["update_profile"])) {
        $sql3 = "UPDATE member_profile SET first_name = ?, last_name = ?, email = ?, address = ?, city = ?, province_id = ?, country_id = ? WHERE user_id = ?";

        if($stmt3 = $db_conn->prepare($sql3)){
            // Bind variables to the prepared statement as parameters
            $stmt3->bind_param("sssssiii", $param_firstname, $param_lastname, $param_email, $param_address, $param_city, $param_province, $param_country, $param_user);
            
            // Set parameters
            $param_firstname = $_POST['first_name'];
            $param_lastname = $_POST['last_name'];
            $param_email = $_POST["email"];
            $param_address = $_POST["address"];
            $param_city = $_POST["city"];
            $param_province = $_POST["province"];
            $param_country = $_POST["country"];
            $param_user = 1;
            
            // Attempt to execute the prepared statement
            if($stmt3->execute()){
                // Store result
                //$stmt->store_result();
                if(!$stmt3->error){       
                    echo "The user's profile has been updated.";
                } else {
                    echo "We could not update the profile for the specified member";
                }
            } else {
                
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            $stmt3->close();
        }
    //update avatar picture
    } else if (isset($_POST["save_avatar"])){
        $target_dir = "profile/user_pics/";
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);

        if($check !== false) {
            //save with a random number and the user's id
            $new_file_name = uniqid() .  $_SESSION["userid"] . "." . $imageFileType;

            //save url to the database
            $sql = "UPDATE member_profile SET avatar_url = ? WHERE user_id = ?";

            if($stmt = $db_conn->prepare($sql)){
                // Bind variables to the prepared statement as parameters
                $stmt->bind_param("si", $param_avatar_url, $param_user);
                
                // Set parameters
                $param_avatar_url = $new_file_name;
                $param_user = $_SESSION["userid"];
                
                // Attempt to execute the prepared statement
                if($stmt->execute()){
                    if($stmt->error){       
                        echo "We could update the url into the database";
                    }
                } else {
                    echo "Oops! Something went wrong. Please try again later.";
                }

                // Close statement
                $stmt->close();
            }

            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], "profile/user_pics/" . $new_file_name)) {
                echo "The user's avatar has been updated.";
            } else {
                echo "Sorry, something happened and was not possible to upload the image selected.";
            }
        } else {
            echo "The file selected is not a image.";
            $uploadOk = 0;
        }
    }
?>
 
            <!-- Start of Header -->
            <link rel ="stylesheet" href="profile/css/style.min.css" defer async>
      <style type="text/css">.jqstooltip { position: absolute;left: 0px;top: 0px;visibility: hidden;background: rgb(0, 0, 0) transparent;background-color: rgba(0,0,0,0.6);filter:progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000000, endColorstr=#99000000);-ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000000, endColorstr=#99000000)";color: white;font: 10px arial, san serif;text-align: left;white-space: nowrap;padding: 5px;border: 1px solid white;z-index: 10000;}.jqsfield { color: white;font: 10px arial, san serif;text-align: left;}</style>     
                <!-- End of Header -->
        
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper" style="display: block; margin-left: 0px !important;">
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <!-- Row -->
                <div class="row">
                    <!-- Column -->
                    <div class="col-lg-4 col-xlg-3 col-md-5">
                        <div class="card">
                            <div class="card-body">
                                <?php 
                                //this section of php code loads the left side profile information
                                $sql = "SELECT first_name, last_name, email, city, address, province_id, country_id, avatar_url FROM member_profile WHERE user_id = ?";
                
                                if($stmt = $db_conn->prepare($sql)){
                                    // Bind variables to the prepared statement as parameters
                                    $stmt->bind_param("i", $param_userid);
                                    
                                    // Set parameters
                                    $param_userid = $_SESSION["userid"];
                                    
                                    // Attempt to execute the prepared statement
                                    if($stmt->execute()){
                                        // Store result
                                        $stmt->store_result();
                
                                        if($stmt->num_rows == 1){       
                                            //results
                                            $stmt->bind_result($first_name, $last_name, $email, $city, $address, $province_id, $country_id, $avatar_url);
                                            
                                            if($stmt->fetch()){
                                                $_SESSION['first_name'] = $first_name;
                                                $_SESSION['last_name'] = $last_name;
                                                $_SESSION["email"] = $email;
                                                $_SESSION["city"] = $city;
                                                $_SESSION["address"] = $address;
                                                $_SESSION["province_id"] = $province_id;
                                                $_SESSION["country_id"] = $country_id;
                                                $_SESSION["avatar_url"] = $avatar_url;
                                            }   
                                        } else {
                                            echo "We could not find a profile for the specified member";
                                        }
                                    } else {
                                        echo "Oops! Something went wrong. Please try again later.";
                                    }
                
                                    // Close statement
                                    $stmt->close();
                                }

                                //this section of php code counts the number of posts and likes
                                $sql = "SELECT COUNT(post_master.category_id) AS total_posts FROM post_master INNER JOIN category_master ON post_master.category_id  = category_master.category_id WHERE member_id = ?";
                
                                if($stmt = $db_conn->prepare($sql)){
                                    // Bind variables to the prepared statement as parameters
                                    $stmt->bind_param("i", $param_username);
                                    
                                    // Set parametersss
                                    $param_username = $_SESSION["userid"];
                                    
                                    // Attempt to execute the prepared statement
                                    if($stmt->execute()){
                                        // Store result
                                        $stmt->store_result();
                
                                        if($stmt->num_rows == 1){       
                                            //results
                                            $stmt->bind_result($total_posts);
                                            
                                            if($stmt->fetch()){
                                                $_SESSION['total_posts'] = $total_posts;
                                            }   
                                        } else {
                                            echo "We could not find a profile for the specified member";
                                        }
                                    } else {
                                        echo "Oops! Something went wrong. Please try again later.";
                                    }
                
                                    // Close statement
                                    $stmt->close();
                                }
        
                                ?>
                                <center class="m-t-30"> <img src="profile/user_pics/<?php echo $_SESSION["avatar_url"] ?>" class="rounded-circle" width="100" style="max-height: 100px;">
                                <form method="post" enctype="multipart/form-data" accept="image/png, image/jpeg">
                                    <input type="file" name="fileToUpload" id="fileToUpload" >
                                    <input type="submit" value="Save" name="save_avatar">
                                </form>
                                    <h4 class="card-title m-t-10"><?php echo strtoupper($_SESSION['first_name']." ".$_SESSION['last_name']) ?></h4>
                                    <!-- <h6 class="card-subtitle">Accoubts Manager Amix corp</h6> -->
                                    <div class="row text-center justify-content-md-center">
                                        <div class="col-4"><a href="javascript:void(0)" class="link"><font class="font-medium"><?php echo $_SESSION['total_posts']; ?> posts</font></a></div>
                                        <div class="col-4"><a href="javascript:void(0)" class="link"><font class="font-medium"> 0 likes</font></a></div>
                                    </div>
                                </center>
                            </div>
                            <div>
                                <hr> </div>
                            <div class="card-body"> <small class="text-muted">Email address </small>
                                <h6><?php echo $_SESSION["email"]; ?></h6> <small class="text-muted p-t-30 db">City</small>
                                <h6><?php echo $_SESSION["city"]; ?></h6> <small class="text-muted p-t-30 db">Address</small>
                                <h6><?php echo $_SESSION["address"]; ?></h6>
                              
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                    <div class="col-lg-8 col-xlg-9 col-md-7">
                        <div class="card">
                            <!-- Tabs -->
                            <ul class="nav nav-pills custom-pills" id="pills-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="pills-timeline-tab" data-toggle="pill" href="#current-month" role="tab" aria-controls="pills-timeline" aria-selected="true">Timeline</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="pills-setting-tab" data-toggle="pill" href="#previous-month" role="tab" aria-controls="pills-setting" aria-selected="false">Setting</a>
                                </li>
                            </ul>
                            <!-- Tabs -->
                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade active show" id="current-month" role="tabpanel" aria-labelledby="pills-timeline-tab" style="opacity: 1 !important ;">
                                    <div class="card-body">
                                        <div class="profiletimeline m-t-0">

                                            <?php 
                                            
                                            //this section of php code gets all the post that the user made and counts its comments and likes
                                            //$sql = "SELECT COUNT(post_master.category_id) AS total_posts FROM post_master INNER JOIN category_master ON post_master.category_id  = category_master.category_id WHERE member_id = ?";
                                            $sql = "SELECT post_master_id, post_heading, post_date FROM post_master WHERE member_id = ? ";
                                            if($stmt = $db_conn->prepare($sql)){
                                                // Bind variables to the prepared statement as parameters
                                                $stmt->bind_param("i", $param_username);
                                                
                                                // Set parameters
                                                $param_username = $_SESSION["userid"];
                                                
                                                // Attempt to execute the prepared statement
                                                if($stmt->execute()){
                                                    // Store result
                                                    $stmt->store_result();
                            
                                                    if($stmt->num_rows > 0){       
                                                        //results
                                                        $stmt->bind_result($post_master_id, $post_heading, $post_date);
                                                        while($stmt->fetch()){
                                                            //--------------------------------------------
                                                            //now counting the number of comments and likes for the post
                                                            $sql2 = "SELECT COUNT(post_thread_id) AS total_comments FROM post_threads WHERE post_master_id = ?";
                                                            //--------------------------------------------

                                                            if($stmt2 = $db_conn->prepare($sql2)){
                                                                // Bind variables to the prepared statement as parameters
                                                                $stmt2->bind_param("i", $param_post);
                                                                
                                                                // Set parameters
                                                                $param_post = $post_master_id;
                                                                
                                                                // Attempt to execute the prepared statement
                                                                if($stmt2->execute()){
                                                                    // Store result
                                                                    $stmt2->store_result();
                                            
                                                                    if($stmt2->num_rows > 0){       
                                                                        //results
                                                                        $stmt2->bind_result($total_comments);
                                                                        
                                                                        if($stmt2->fetch()){
                                                                            echo "<div class='sl-item'>
                                                                             <div class='sl-left'> <img src='profile/user_pics/".$_SESSION['avatar_url']."' alt='user' class='rounded-circle'> </div>
                                                                                <div class='sl-right'>
                                                                                    <div> <a href='javascript:void(0)' class='link'>". $_SESSION['first_name'] . "</a> <span class='sl-date'>" . $post_date . "</span>
                                                                                        <div class='m-t-20 row'>
                                                                                                <div class='col-md-9 col-xs-12'>
                                                                                                <blockquote class='m-t-10'><a href='../thread_comments/thread.php?id=" . $post_master_id . "'>" . $post_heading  . "</a></blockquote></div>
                                                                                        </div>
                                                                                        <div class='like-comm m-t-20'> " . $total_comments . " Comments 0 Likes 
                                                                                        </div> 
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <hr>";
                                                                        }   
                                                                    }
                                                                } else {
                                                                    echo "Oops! Something went wrong. Please try again later.";
                                                                }
                                            
                                                                // Close statement
                                                                $stmt2->close();
                                                            }
                                                        }   
                                                    } else {
                                                        echo "This member did not participate in any post yet.";
                                                    }
                                                } else {
                                                    echo "Oops! Something went wrong. Please try again later.";
                                                }
                            
                                                // Close statement
                                                $stmt->close();
                                            }
                                            ?>                                          
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="tab-pane fade" id="previous-month" role="tabpanel" aria-labelledby="pills-setting-tab" style="opacity: 1 !important ;">
                                    <div class="card-body">
                                        <form class="form-horizontal form-material" method="post">
                                            <div class="form-group">
                                                <label class="col-md-12">First Name</label>
                                                <div class="col-md-12">
                                                    <input type="text" placeholder="" class="form-control form-control-line" name="first_name" value="<?php echo $_SESSION['first_name'] ?>">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="example-email" class="col-md-12">Last Name</label>
                                                <div class="col-md-12">
                                                    <input type="text" placeholder="" class="form-control form-control-line" name="last_name" value="<?php echo $_SESSION['last_name'] ?>">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-12">Address</label>
                                                <div class="col-md-12">
                                                    <input type="text" class="form-control form-control-line" name="address" value="<?php echo $_SESSION['address'] ?>">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-12">City</label>
                                                <div class="col-md-12">
                                                    <input type="text" placeholder="" class="form-control form-control-line" name="city" value="<?php echo $_SESSION['city'] ?>">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-12">Email</label>
                                                <div class="col-md-12">
                                                    <input type="text" placeholder="" class="form-control form-control-line" name="email" value="<?php echo $_SESSION['email'] ?>">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-12">Select Province</label>
                                                <div class="col-sm-12">
                                                    <select class="form-control form-control-line" name="province">
                                                        <?php
                                                        $sql = "SELECT province_id, name FROM province";
                                                        if($stmt = $db_conn->prepare($sql)){
                                                            // Attempt to execute the prepared statement
                                                            if($stmt->execute()){
                                                                // Store result
                                                                $stmt->store_result();

                                                                if($stmt->num_rows > 0){ 
                                                                    $stmt->bind_result($pronvince_id, $name);
                                                                    while($stmt->fetch()){
                                                                        if($_SESSION["province_id"] == $pronvince_id){
                                                                            echo "<option selected='selected' value='" . $pronvince_id . "'>" . $name . "</option>";
                                                                        } else {
                                                                            echo "<option value='" . $pronvince_id . "'>" . $name . "</option>";
                                                                        }
                                                                    }      
                                                                }
                                                            } else {
                                                                echo "Oops! Something went wrong. Please try again later.";
                                                            }

                                                            // Close statement
                                                            $stmt->close();
                                                        }                                                        
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-12">Select Country</label>
                                                <div class="col-sm-12">
                                                    <select class="form-control form-control-line" name="country">
                                                    <?php
                                                        $sql = "SELECT country_id, name FROM country";
                                                        if($stmt = $db_conn->prepare($sql)){
                                                            // Attempt to execute the prepared statement
                                                            if($stmt->execute()){
                                                                // Store result
                                                                $stmt->store_result();

                                                                if($stmt->num_rows > 0){ 
                                                                    $stmt->bind_result($country_id, $name);
                                                                    while($stmt->fetch()){
                                                                        if($_SESSION["province_id"] == $country_id){
                                                                            echo "<option selected='selected' value='" . $country_id . "'>" . $name . "</option>";
                                                                        } else {
                                                                            echo "<option value='" . $country_id . "'>" . $name . "</option>";
                                                                        }
                                                                    }      
                                                                }
                                                            } else {
                                                                echo "Oops! Something went wrong. Please try again later.";
                                                            }

                                                            // Close statement
                                                            $stmt->close();
                                                        }                                                        
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <button class="btn btn-success" name="update_profile">Update Profile</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                </div>
                <!-- Row -->
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Right sidebar -->
                <!-- ============================================================== -->
                <!-- .right-sidebar -->
                <!-- ============================================================== -->
                <!-- End Right sidebar -->
                <!-- ============================================================== -->
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            
                <!-- Start of Footer -->
               
           
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <?php include_once "includes/footer.inc.php"?>

    
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
       
    
    
    <!-- Bootstrap tether Core JavaScript -->
    <script src="profile/js/popper.min.js" defer></script>
   
    <!-- apps -->
    <script src="profile/js/app.min.js" defer></script>
    <script src="profile/js/app.init.js" defer></script>
    <script src="profile/js/app-style-switcher.js" defer></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="profile/js/perfect-scrollbar.jquery.min.js" defer></script>
    <script src="profile/js/sparkline.js" defer></script>
    <!--Wave Effects -->
    <script src="profile/js/waves.js" defer></script>
    <!--Menu sidebar -->
    <script src="profile/js/sidebarmenu.js" defer></script>
    <!--Custom JavaScript -->
     <script src="profile/js/custom.min.js" defer></script>  



