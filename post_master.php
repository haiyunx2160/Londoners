
<?php
 
 

    
      //print_r(comment_show(1));

     

      
    function comment_show($id){

			

        $db = new mysqli('localhost','londoners','London123!','Londoners');


        $query = "select member_profile.first_name,thread_comments.post_id,thread_comments.post_thread_id,thread_comments.comments,thread_comments.thread_created_date from member_profile INNER JOIN thread_comments
                                                ON thread_comments.member_id = member_profile.member_id WHERE thread_comments.post_thread_id = ".$id." AND thread_comments.post_id = 2 ORDER BY thread_comments.thread_comments_id desc;";


        if($db->query($query) == true){

         $rs = $db->query($query);
                 if($rs->num_rows > 0){
                         $comments = array();

                                while($row = $rs->fetch_assoc()){
                                         array_push($comments,$row);
                                }

                                  
      return $comments;
                 }else{
                         return;
                 }

         }
 }

    

 function new_comm($comments,$i,$posts){

	                          if(isset($comments)){
	                         	$count_comm = count($comments);
			                 	for($c = 0; $c < $count_comm; $c++){?>
						
                                                <ul class="children" id = "children<?php echo $i; ?>">

               <li class="comment byuser comment-author-saqib-sarwar bypostauthor odd alt depth-2" id="li-comment-3">
                       <article id="comment-3">

                <a href="#">
                        <img alt="" src="images/pp.png" class="avatar avatar-60 photo" height="60" width="60">
                </a>

                <div class="comment-meta">

                        <h5 class="author">
                                <cite class="fn"><?php echo $comments[$c]['first_name'] ?></cite>
                                <!-- - <a class="comment-reply-link" href="#">Reply</a>-->
                        </h5>

                        <p class="date">
                                <a href="#">
                                <time datetime="" ><?php
                                $date_r = date_create($comments[$c]['thread_created_date']);
                                echo date_format($date_r,"g:iA"); ?></time>
                                </a>
                        </p>

                </div><!-- end .comment-meta -->

                <div class="comment-body">
                       <?php echo $comments[$c]['comments'] ?>
                </div><!-- end of comment-body -->

        </article><!-- end of comment -->

</li>
</ul>

							<?php }?>
	                            <?php }
				     }
	


    $db = new mysqli('localhost','londoners','London123!','Londoners');

$id=$_GET['id'];
    $query = "select * from post_master where post_master_id =  $id;";
   
    if($db->query($query) == true){
    
     $rs = $db->query($query);
             if($rs->num_rows > 0){
                     $posts = ["No value"];
    
                            while($row = $rs->fetch_assoc()){
                             array_push($posts,$row);
                             //print_r($thread[0]);
                            }
    
             }
            }else{
                     echo "No Posts to display";
                     return;
    
         };

       
           
                    //new_comm($comments,1,$posts);


         // echo count($threads)-1;
         //print_r($posts);
         //print_r($threads);

  function save_thread($thread){
        $db1= new mysqli('localhost','londoners','London123!','Londoners');

        $qry = "insert into post_threads (post_master_id,member_id,previous_thread_id,thread_data) values (".$_GET['id'].",".$_SESSION['userid'].",1,'".mysqli_real_escape_string($db1,$thread)."');";


        if($db1->query($qry) !== true){
        //echo $_SESSION['id'];
        echo "<p style = 'color:red;'>Error in posting! Please try again.</p></br>";
                                                echo $db1->error;

        }else{
                
                ?>
                    <script>
                        alert("You Commented On This Post.");
                    </script>
                <?php
        }

  }


  if (isset($_POST['new_thread'])){
	$err_message = array();

	 $thread = trim($_POST['thread']);
	 if (empty($thread)){
		 echo $err_message = "<p style = 'color:red;'>Sorry, the thread cannot be empty</p></br>";
	 }else{
		 //$_SESSION['thread'] = $thread;

		 save_thread($thread);
                 display_data($posts);
	 }

}else{
	display_data($posts);
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////real page
?>
 <?php function display_data($posts){
          $db = new mysqli('localhost','londoners','London123!','Londoners');
$id=$_GET['id'];
          $query_thread = "select * from post_threads INNER JOIN member_profile on post_threads.member_id = member_profile.member_id where post_master_id = $id;";
   

         if($db->query($query_thread) == true){
    
                $rs = $db->query($query_thread);
                        if($rs->num_rows > 0){
                                $threads = ["No value"];
               
                                       while($row = $rs->fetch_assoc()){
                                        array_push($threads,$row);
                                        //print_r($thread[0]);
                                       }
               
                        }
                       }
         
         
         ?>


 
                        <div class="container">
                                <div class="row">

                                        <!-- start of page content -->
                                        <div class="span8 page-content">

                                                <ul class="breadcrumb">
                                                        <li><a href="#">Knowledge Base Theme</a><span class="divider">/</span></li>
                                                        <li><a href="#" title="View all posts in Server &amp; Database">Server &amp; Database</a> <span class="divider">/</span></li>
                                                        <li class="active">Your Website</li>
                                                </ul>

                                        

                                                <article class=" type-post format-standard hentry clearfix">

                                                        <h1 class="post-title"><a href="#"><?php echo $posts[1]['post_heading'] ?></a></h1>

                                                        <div class="post-meta clearfix">
                                                                <span class="date"><time datetime="" ><?php
                                $date_k = date_create($posts[1]['approved_date']);
                                echo date_format($date_k,"jS F Y"); ?></time></span>
                                                                <span class="category"><a href="#" title="View all posts in Server &amp; Database">Server &amp; Database</a></span>
                                                                <span class="comments"><a href="#" title="Comment on Integrating WordPress with Your Website"><?php if(!isset($threads)){echo 0;}else{ echo count($threads)-1;} ?> Comments</a></span>
                                                                <span class="like-count">66</span>
                                                        </div><!-- end of post meta -->

                                                         <p><?php echo $posts[1]['contents']; ?></p>
                                        
                                                        <!--<blockquote><p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat.</p></blockquote>-->


                                                </article>

                                                <div class="like-btn">

                                                        <form id="like-it-form" action="#" method="post">
                                                                <span class="like-it ">66</span>
                                                                <input type="hidden" name="post_id" value="99">
                                                                <input type="hidden" name="action" value="like_it">
                                                        </form>

                                                     <!--   <span class="tags">
                                                                <strong>Tags:&nbsp;&nbsp;</strong><a href="#" rel="tag">basic</a>, <a href="#" rel="tag">setting</a>, <a href="http://knowledgebase.inspirythemes.com/tag/website/" rel="tag">website</a>
                                                        </span>-->

                                                </div>

                                                <section id="comments">

                                                        <h3 id="comments-title">(<?php if(!isset($threads)){echo 0;}else{ echo count($threads)-1;} ?>) Comments</h3>


        

                                                        <?php for($i = 1; $i < @count($threads); $i++){ ?>

                                                                <?php if(!isset($threads)){
                                                                       break;
                                                               } ?>
                                                                <?php $comments = comment_show($i); ?>

                                                        <ol class="commentlist"  id = "comment<?php echo $i; ?>">

                                                                <li class="comment even thread-even depth-1" id="li-comment">
                                                                        <article id="article">

                                                                                <a href="#">
                                                                                        <img alt="" src="images/ppk.png" class="avatar avatar-60 photo" height="60" width="60">
                                                                                </a>

                                                                                <div class="comment-meta">

                                                                                        <h5 class="author">
                                                                                                <cite class="fn">
                                                                                                        <a href="#" rel="external nofollow" class="url"><?php echo $threads[$i]['first_name']."  ".$threads[$i]['last_name'] ?></a>
                                                                                                </cite>
                                                                                                - <a class="comment-reply-link"  href="#">Reply</a>
                                                                                        </h5>

                                                                                        <p class="date">
                                                                                                <a href="#">
                                                                                                        <time datetime="" ><?php
                                                                                                        $date = date_create($threads[$i]['thread_created_date']);
                                                                                                        echo date_format($date,"jS F Y"); ?></time>
                                                                                                </a>
                                                                                        </p>

                                                                                </div><!-- end .comment-meta -->

                                                                                <div class="comment-body">
                                                                                       <p><?php echo $threads[$i]['thread_data']; ?></p>
                                                                                </div><!-- end of comment-body -->

                                                                                <input type = 'button' style = 'margin-top:10px;margin-bottom:10px;' class = 'btn btn-primary' value = 'Reply' name = 'reply' id = 'reply<?php echo $i ?>'/>

                                                                                <form id = 'replyForm<?php echo $i ?>' method = 'post' style = 'display:none;'>
                                                             			     <textarea placeholder = 'Comment....'  id = 'threadArea<?php echo $i ?>' rows = '3' cols = '100' style = 'width:500px;' name='comment' class = ''></textarea></br></br>
                                                         			     <input style = '' type = 'submit' id = 'postReply<?php echo $i ?>' name = 'postReply<?php echo $i ?>' value = 'Post' class = 'btn btn-primary' />
			                                                     	</form>

                                                                        
   <script>

                                   //jQuery code to hide and show reply form
$("#reply<?php echo $i ?>").click(function(){
   if($("#replyForm<?php echo $i ?>").is(":visible")){
       $("#replyForm<?php echo $i ?>").hide(1000);
   }else{
       $("#replyForm<?php echo $i ?>").show(1000);
   }
})
                                         
//jQuery code for comment section ajax communication
                                   //reply form submit using aj
                                   
        $("#postReply<?php echo $i ?>").click(function(){
                var data = $("#replyForm<?php echo $i ?>").serializeArray();
                data[1] = {name: "thread", value: <?php echo $i; ?>};
                console.log(data);
                $.post("process_reply.php",data,function(res){
                console.log(res);
                });                                      
             })  

             //focus on reply

             function replyFocus(){
                     document.getElementById("threadArea<?php echo $i ?>").focus();
             }                                   

                                                         
</script>

                                                                        </article><!-- end of comment -->
                                                                           
                                                                           <?php new_comm($comments,$i,$posts) ;?>

                                                                </li>

                                                                        </article><!-- end of comment -->
                                                                </li>
                                                        </ol>
                                                        <?php } ?>
<!-- The form//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->

                                                        <div id="respond">

                                                                <h3>Join The Conversation</h3>

                                                                <div class="cancel-comment-reply">
                                                                        <a rel="nofollow" id="cancel-comment-reply-link" href="#" style="display:none;">Click here to cancel reply.</a>
                                                                </div>


                                                                <form method="post" id="commentform">


                                                                        <div>
                                                                                <label for="comment">Comment</label>
                                                                                <textarea class="span8" name="thread" id="comment" cols="58" rows="10"></textarea>
                                                                        </div>

                                                                        
                                                                        <div>
                                                                                <input class="btn" name="new_thread" type="submit" id="submit"  value="Submit Comment">
                                                                        </div>

                                                                </form>

                                                        </div>

                                                </section><!-- end of comments -->

                                        </div>
                                        <!-- end of page content -->
<!--//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->

                                        <!-- start of sidebar -->
                                        <aside class="span4 page-sidebar">

                                                <section class="widget">
                                                        <div class="support-widget">
                                                                <h3 class="title"><a href = 'contact.php'>Support</a></h3>
                                                                <p class="intro">Need more support? If you did not found an answer, contact us for further help.</p>
                                                        </div>
                                                </section>


                                                <section class="widget">
                                                        <h3 class="title">Featured Articles</h3>
                                                        <ul class="articles">
                                                                <li class="article-entry standard">
                                                                        <h4><a href="single.php">Integrating WordPress with Your Website</a></h4>
                                                                        <span class="article-meta">25 Feb, 2013 in <a href="#" title="View all posts in Server &amp; Database">Server &amp; Database</a></span>
                                                                        <span class="like-count">66</span>
                                                                </li>
                                                                <li class="article-entry standard">
                                                                        <h4><a href="single.php">WordPress Site Maintenance</a></h4>
                                                                        <span class="article-meta">24 Feb, 2013 in <a href="#" title="View all posts in Website Dev">Website Dev</a></span>
                                                                        <span class="like-count">15</span>
                                                                </li>
                                                                <li class="article-entry video">
                                                                        <h4><a href="single.php">Meta Tags in WordPress</a></h4>
                                                                        <span class="article-meta">23 Feb, 2013 in <a href="#" title="View all posts in Website Dev">Website Dev</a></span>
                                                                        <span class="like-count">8</span>
                                                                </li>
                                                                <li class="article-entry image">
                                                                        <h4><a href="single.php">WordPress in Your Language</a></h4>
                                                                        <span class="article-meta">22 Feb, 2013 in <a href="#" title="View all posts in Advanced Techniques">Advanced Techniques</a></span>
                                                                        <span class="like-count">6</span>
                                                                </li>
                                                        </ul>
                                                </section>



                                                <section class="widget"><h3 class="title">Categories</h3>
                                                        <ul>
                                                                <li><a href="#" title="Lorem ipsum dolor sit amet,">Advanced Techniques</a> </li>
                                                                <li><a href="#" title="Lorem ipsum dolor sit amet,">Designing in WordPress</a></li>
                                                                <li><a href="#" title="Lorem ipsum dolor sit amet,">Server &amp; Database</a></li>
                                                                <li><a href="#" title="Lorem ipsum dolor sit amet, ">Theme Development</a></li>
                                                                <li><a href="#" title="Lorem ipsum dolor sit amet,">Website Dev</a></li>
                                                                <li><a href="#" title="Lorem ipsum dolor sit amet,">WordPress for Beginners</a></li>
                                                                <li><a href="#" title="Lorem ipsum dolor sit amet, ">WordPress Plugins</a></li>
                                                        </ul>
                                                </section>
                                                <?php if(isset($threads) || $threads > 3){ ?>
                                                 <section class="widget">
                                                        <h3 class="title">Recent Comments</h3>
                                                        <ul id="recentcomments">
                                                           <?php for($n = 1; $n <3; $n++){ ?>
                                                                <li class="recentcomments"><a href="#" rel="external nofollow" class="url"><?php echo @$threads[$n]['first_name']." ". @$threads[$n]['last_name'] ;?></a>: <a href="#"><?php echo @$threads[$n]['thread_data'] ;?></a></li>
                                                            <?php } ?>
                                                        </ul>
                                                 </section>
                                                <?php } ?>

                                        </aside>
                                        <!-- end of sidebar -->
                                </div>
                        </div>
                </div>
                                <?php } ?>