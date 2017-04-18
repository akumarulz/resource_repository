<!--selected forum.php, newtopic.php-->
<h1>Forum</h1>
<div class="forum_main_div">
	<h2><?php echo wordwrap($topic[0]['topic_title'],30,"<br>\n",true); ?></h2>

	<h4><?php echo $topic[0]['category']; ?></h4>
	<span class="date-time"><?php echo date( 'H:i l jS M Y',strtotime($topic[0]['date'])); ?></span>
	
<p><?php echo  wordwrap($topic[0]['topic_description'],130,"<br>\n",true); ?></p>
<hr>
<?php 
		if($userid != $topic[0]['user_id'] || $is_admin == 'Y'){
			echo '<a href="makereport&source=forum&id='.$topic[0]['topic_id'].'" ><p>Report content</p></a>';
		}
	?>
<?php if($userid == $topic[0]['user_id']){
		echo '<form action="'.htmlspecialchars($_SERVER["PHP_SELF"].'&page=newtopic').'" action="GET">
		<input type="hidden" name=topic[id] value="'. $topic[0]['topic_id'].'" />
		<input type="submit" value="Edit" />
		</form>';
	}
	?>
</div>
<div class="resource_discussion">

<h4>Add Comment</h4>
<span id="output"></span>
<form id="resourceCommentForm" action="new_discussion_comment_func.php" method="POST">
		<textarea id="resourcetextarea" name="comment[comment]" rows="5" cols="80"></textarea><br>
		<input type="hidden" name="comment[topic_id]" value="<?php echo $topic[0]['topic_id'];?>"/>
		<input type="submit" value="Comment" />
	</form>
<h3>Comments</h3>


	<ul class="viewComments">
		<?php

		if(isset($comments)){
				foreach($comments as $comment){
					if($comment['comment_reply_id'] !=null){
							continue;
						}
					$var = new database_query($pdo,$tablename);
					$comment['comment_id'] = new commentsobj($id,$column,$comment,$conn,$is_admin,$userid,$var);
					echo $comment['comment_id'] -> getHTML();
				}
		}?>
	</ul>
	
</div>