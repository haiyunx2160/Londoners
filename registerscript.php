<?php
require_once "db/connect.php";
$dbconn = dbconnect(DBHOST, DBDB, DBUSER, DBPW);
error_reporting(E_ALL); 
ini_set('display_errors', TRUE); 
// Include config file

 
// Define variables and initialize with empty values
$username = $password = $confirm_password = $firstname = $lastname =  $email= "";

$username_err = $password_err = $confirm_password_err = $firstname_err =$lastname_err =$address_err =$city_err =$email_err= "";
$newid="";

$error="";

print_r($_POST);
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
 // Validate password
    if(empty(trim($_POST["regpassword"]))){
        $error = "Please enter a password.";  
        echo $error;
        exit;

    } elseif(strlen(trim($_POST["regpassword"])) < 6){
        $error = "Password must have atleast 6 characters.";
        echo $error;
        exit;
        
    } else{
        $password = trim($_POST["regpassword"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $error = "Please enter confirm password.";     
        echo $error;
        exit;
        
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($error) && ($password != $confirm_password)){
            $error = "Password did not match.";
            echo $error;
        exit;
        
        }
    }
    //validate firstname 
    if(empty(trim($_POST["firstname"]))){
        $error = "Please enter first name.";     
        echo $error;
        exit;
        
    } else{
        $firstname = trim($_POST["firstname"]);
        
    }
    
    //validate lastname 
    if(empty(trim($_POST["lastname"]))){
        $error = "Please enter last name.";     
        echo $error;
        exit;
        
    } else{
        $lastname = trim($_POST["lastname"]);
        
    }

    //validate email
    if(empty(trim($_POST["email1"]))){
        $error = "Please enter email.";     
        echo $error;
        exit;
        
    } else{
        $email = trim($_POST["email1"]);
        
    }
    // Validate username
    if(empty(trim($_POST["regusername"]))){
        $error = "Please enter a username.";
    } else{
                
        //select statement
        $sql = "SELECT user_id FROM user WHERE user_name = ?";
        
        if($stmt = $dbconn->prepare($sql)){
           
            $stmt->bind_param("s", $param_username);
            
            
            $param_username = trim($_POST["regusername"]);
            
            //execute the prepared statement
            if($stmt->execute()){
                
                $stmt->store_result();
                
                if($stmt->num_rows == 1){
                    $error = "This username is already taken.";
                    echo $error;
                    exit;
                } else{
                    $username = trim($_POST["regusername"]);
                }
            } else{
                 $error="Oops! Something went wrong. Please try again later.";
                 echo $error;
                 exit;
            }
        }
         
        // Close statement
        $stmt->close();
    }
    
    
    // Check input errors before inserting in database
    if(empty($error)){
        
        // insert statement
        $sql = "INSERT INTO user (user_name, password,user_type,created_by) VALUES (?, ?, ?,?)";
        $sql1="INSERT INTO member_profile(first_name,last_name,user_id,email,created_by) VALUES(?, ?,?,?,?)";
        if($stmt = $dbconn->prepare($sql)){
           
            $stmt->bind_param("ssii", $param_username, $param_password,$param_user_type,$param_created_by);
           
           
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            $param_user_type=1;
            $param_created_by=1;
            
            //execute the prepared statement
            //$v = $stmt->execute();
            
            if($stmt->execute()){
                $sql3 = "SELECT user_id FROM user WHERE user_name = ?";
        
            if($stmt2 = $dbconn->prepare($sql3)){
            // Bind variables to the prepared statement as parameters
            $stmt2->bind_param("s", $param_username1);
            
            // Set parameters
            $param_username1 = $username;
            
            // Attempt to execute the prepared statement
            if($stmt2->execute()){
                    $stmt2->store_result();
                    if($stmt2->num_rows==1){

                    
                    // Bind result variables
                    $stmt2->bind_result($id);
                    if($stmt2->fetch()){
                        $newid=$id;
                        
                    }
                }
                
               
            }
        }
            }
            
            $stmt1 = $dbconn->prepare($sql1);
            $stmt1->bind_param("ssisi",$param_firstname,$param_lastname,$param_user_id,$param_email,$param_created_by);
           
            // Close connection
            $param_firstname=$firstname;
            $param_lastname=$lastname;
            
           
            $param_user_id = $newid;
            $param_email=$email;
            $param_created_by =1;
            
            $n = $stmt1->execute();
    
            // Close statement
            
            if($n ===true){
               
                // Redirect to same page
                $sucess="Registration SucessFul";
                echo $sucess;
                exit;
           
               
              
            } else{
             
                $register= "Something went wrong. Please try again later. ";
                echo $register;
                exit;
            }
             $stmt2->close();
            $stmt1->close();
            $stmt->close();
            
        }
         
        
       $dbconn->close();
    }
    
}
?>