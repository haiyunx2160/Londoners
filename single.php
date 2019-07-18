

        

                <!-- Start of Header -->
              <?php require_once "includes/header.inc.php"?>
                <!-- End of Header -->

                <!-- Start of Search Wrapper -->
               <?php include_once "includes/searchwrapper.inc.php"?>
                <!-- End of Search Wrapper -->

                <?php



                                 if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['new_thread'])){


                                                   if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !==  true)
                                                   {
                                                          
                                                 

                                                        }     
                                                         else{
                                                                  echo "hello2";
                                                          }          
                                 }
?>
                        

                <!-- Start of Page Container -->
                <?php include_once "post_master.php"?>
                <!-- End of Page Container -->

                <!-- Start of Footer -->
               <?php include_once "includes/footer.inc.php"?>
                <!-- End of Footer -->

