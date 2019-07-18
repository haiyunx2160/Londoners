<?php
 


 include_once "db/connect.php";
 $dbconn = dbconnect(DBHOST, DBDB, DBUSER, DBPW);
// error_reporting(E_ALL); 
// ini_set('display_errors', TRUE); 
// // Initialize the session
 session_start();
 
// // Check if the user is already logged in, if yes then redirect him to welcome page
 if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
  header("location: index .php");
     
 }else{
//  // Include config file

 
// // Define variables and initialize with empty values

 $username = $password = "";
 $username_err = $password_err = "";
 
// // Processing form data when form is submitted
 if($_SERVER["REQUEST_METHOD"] == "POST"){
  

$arr['posts']=[];




    //  //Check if username is empty
    if(empty(trim($_POST["UserName"]))){
        
        $username_err = "Please Enter Username.";
        echo $username_err;
        exit;
    } else{
        $username = trim($_POST["UserName"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please Enter your Password.";
        echo $password_err;
        exit;
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
         
        // Prepare a select statement
        $sql = "SELECT  user.user_id, user.user_name, USER.password,USER.user_type,member_profile.active
                FROM user
                INNER JOIN member_profile ON member_profile.user_id = user.user_id WHERE user.user_name= ?";
        
        if($stmt = $dbconn->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $param_username);
            
            // Set parameters
            $param_username = $username;
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Store result
                $stmt->store_result();
                
                // Check if username exists, if yes then verify password
                if($stmt->num_rows == 1){                    
                    // Bind result variables
                    
                    $stmt->bind_result($id, $username, $hashed_password,$usertype,$active);
                    if($stmt->fetch()){
                        if(password_verify($password, $hashed_password)){
                            if($usertype==1){
                            if($active==="I"){

                                    $status="This account is blocked.";

                                echo $status;
                                exit;
                                   
                            }
                            else{
                            //       session_start();
                            
                            // // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["userid"] = $id;
                            $_SESSION["username"] = $username;                            
                            
                            $v="success";
                            // Redirect 0user to welcome page
                            echo $v;
                            exit;
                            
                            }
                            
                            }
                            else{
                                   session_start();
                            
                            // // Store data in session variables
                            $_SESSION["adminloggedin"] = true;
                            $_SESSION["adminid"] = $id;
                            $_SESSION["adminusername"] = $username;                            
                            
                            // Redirect user to welcome page
                            $v="success";
                             
                            echo $v;
                             exit;
                            
                            }
                            // Password is correct, so start a new session
                          
                        } else{
                            // Display an error message if password is not valid
                            $password_err = "The password you entered was not valid.";
                             echo $password_err;
                            exit;
                        }
                    }
                } else{
                    // Display an error message if username doesn't exist
                    $username_err = "No account found with that username.";
                    
                     array_push($arr['posts'], $username_err);
                        echo $username_err;
                        exit;
                     
                }
            } else{
                 array_push($arr['posts'], "OPSS");
                echo "OPSS";
                exit;
                 
            }
        }
        
        // Close statement
        $stmt->close();
    }
    
    // Close connection
    $dbconn->close();
}
 }
?>