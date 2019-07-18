              <!-- Start of Header -->
              <?php include_once "includes/header.inc.php"?>
                <!-- End of Header -->

                <!-- Start of Search Wrapper -->
                <?php include_once "includes/searchwrapper.inc.php"?>


                <!-- End of Search Wrapper -->

        <?php

                include_once "db/connect.php";

                function displaycategories1(){

                        

                        $db_conn = dbconnect(DBHOST, DBDB, DBUSER, DBPW);

                        $sql = "SELECT * FROM category_master";
                        

                        $result = $db_conn->query($sql);
                        
                        $output="";

                        $str = "<table><tr><th>Category Name</th><th>Topics</th><th>Posts</th><th>Last Post</th></tr>";

                        while($row = mysqli_fetch_array($result)){
                        
                        $cate_id = $row["category_id"];
                        $cate_name = $row['name'];
                        $cate_des =$row['description'];

                        $sql_topic_num = "SELECT * FROM post_master WHERE category_id=$cate_id";
                        $result_topic_num = $db_conn->query($sql_topic_num);

                        $topic_num= mysqli_num_rows($result_topic_num);

                        $sql_thread_num = "SELECT post_thread_id FROM post_threads pt INNER JOIN post_master pm ON pt.post_master_id = pm.post_master_id INNER JOIN category_master cm ON pm.category_id=cm.category_id WHERE cm.category_id =$cate_id";

                        $result_thread_num = $db_conn->query($sql_thread_num);
                        $thread_num= mysqli_num_rows($result_thread_num);

                        $sql_name_time = "SELECT u.user_name, pt.thread_created_date FROM post_threads pt INNER JOIN user u ON pt.member_id=u.user_id INNER JOIN post_master pm ON pt.post_master_id = pm.post_master_id INNER JOIN category_master cm ON pm.category_id=cm.category_id WHERE cm.category_id =$cate_id LIMIT 1";

                        $result_name_time=$db_conn->query($sql_name_time);
                        $row_name_time = mysqli_fetch_assoc($result_name_time);
                        $last_post_name= $row_name_time['user_name'];
                        $last_post_time= $row_name_time['thread_created_date'];

                        $str.="<tr><td><div class='article-entry standard'><h4><a href='category_post.php?categoryid=".$cate_id."'>". $cate_name."</a></h4><span class='article-meta'>".$cate_des."</span></div></td>
                        <td>".$topic_num."</td>
                        <td>".$thread_num."</td>
                        <td>by <span style='color:#d62d20'>".$last_post_name."</span> at <span style='color:#1e1f26'>".$last_post_time."</span></td>
                        </tr>";
                }
                        $str.="</table>";

                        echo $str;

                       


                $db_conn->close();
                
               }
        ?>

                 <!-- Start of Page Container -->
                 <div class="page-container">
                        <div class="container">
                                <div class="row">

                                        <!-- start of page content -->
                                        <div class="span8 page-content">

                                                <!-- Basic Home Page Template -->
                                                <div class="row separator">
                                                        <section class="span-cate articles-list">

                                                        <div class="cate-table">
                                                                <h2 class="cate-header">Categories</h2>
                                                                
                                                                 <!-- <ul class="articles"> -->
                                                                
                                                                <?php displaycategories1(); ?>
                                                                        
                                                                <!-- </ul> -->
                                                        </div>
                                                        </section>

                                                </div>
                                        </div>
                                        </div>  
                                        
                                        </div>       <!-- end of page content -->
                <!-- End of Page Container -->

                <!-- Start of Footer -->
                
                      <?php include_once "includes/footer.inc.php"?>
                <!-- End of Footer -->