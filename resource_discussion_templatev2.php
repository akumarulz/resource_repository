<h1>Resource details</h1>
<div class="resource_div">
<div class="resource_details">
<?php

$fileext = pathinfo($resource[0]['filename']);
		$var = ($resource[0]['file_type'] == 'url') ?  $resource[0]['file_type']  :  $fileext['extension'] ;
			switch(strtolower($var)){
				case "url": echo '<img class="results_icon" src="images/htmls.png" alt="a url link"/>';break;
				case "txt": echo '<img class="results_icon" src="images/txts.png" alt="a text document"/>';break;
				case "avi": echo '<img class="results_icon" src="images/avi.png" alt="an avi file"/>';break;
				case "doc": echo '<img class="results_icon" src="images/docs.png" alt="a word document"/>';break;
				case "jpg": echo '<img class="results_icon" src="images/jpg.png" alt="an image file"/>';break;
				case "mp3": echo '<img class="results_icon" src="images/mp3.png" alt="an audio file"/>';break;
				case "mp4": echo '<img class="results_icon" src="images/mp4.png" alt="an audio or video file"/>';break;
				case "pdf": echo '<img class="results_icon" src="images/pdf.png" alt="a pdf document"/>';break;
				case "movs": echo '<img class="results_icon" src="images/movs.png" alt="a movie file"/>';break;
				case "png" : echo '<img class="results_icon" src="images/png.png" alt="an image file"/>';break;
				case "gif" : echo '<img class="results_icon" src="images/gif.png" alt="a gif image file"/>';break;
				default: echo'<img class="results_icon" src="images/docs.png" alt="a word document"/>';
				
			}
			
			$allID = explode(',',$resource[0]['rated_user_id']);
		
		if(in_array($user_id,$allID)){
			$class = 'jDisabled';
		}else{$class='';}
		?>
		<div class="rating <?php echo $class;?>" id="<?php echo $resource[0]['rating'].'_'.$resource[0]['resource_id'];?>"></div>
		
		<br><br><br><br><br><p><b><?php echo wordwrap($resource[0]['title'],30,"<br>\n",true); ?></b></p>
		<p><?php echo date( 'H:i l jS M Y',strtotime($resource[0]['date']))?></p>
		
		<?php if($resource[0]['file_size'] > 0){ 
		$size = round($resource[0]['file_size']/1048576,2);
		echo '<p> file size: '.$size.'MB</p>';}
			?>
			
		<p>File Type: <?php echo $var;?></p>
		<p>Favourited: <?php echo $resource[0]['favorited'];?></p>
		<p>Times Downloaded: <?php echo $resource[0]['downloaded']; ?></p>
		<?php 
			if($user_id != $resource[0]['resource_id'] || $is_admin =='Y'){
				echo '<a href="makereport&source=resource&id='.$resource[0]['resource_id'].'"><p>Report Content</p></a>';
			}
		echo '<button class="toggleRecommender" >Recommend</button>';
			if($resource[0]['url_address'] != '' || $resource[0]['url_address'] != null){
			echo '<a href="'.$resource[0]['url_address'].'" class="downloadCounter" id="'.$resource[0]['resource_id'].'-'.$user_id.'" target="_blank"><button class="url" >Go to Resource</button></a>';
			}else{
			echo '<form action = "downloaderv3.php" method = "post">
			<input type="hidden" name="user_id" value="'.$user_id.'" />
			<input type="hidden" name="file" value="'.$resource[0]['resource_id'].'"/>
			<input type="submit" value="Download" />
			</form>';
			}
			?>
</div>
<div class="resource_description">
	<h4>Description</h4>
	<p><?php echo $resource[0]['description']; ?></p>
					
			<?php
			
			if($user_id == $resource[0]['user_id']){
				if($resource[0]['url_address'] != null){
					//link to url upload form
					echo '<a href="'.htmlspecialchars($_SERVER["PHP_SELF"].'?page=linkresource_upload&resource_id='.$resource[0]['resource_id']).'"><button>Edit</button></a>';
					
					
				}else{
					//link to file upload form
					echo '<a href="'.htmlspecialchars($_SERVER["PHP_SELF"].'?page=upLoadResource&resource_id='.$resource[0]['resource_id']).'"><button>Edit</button></a>';
					
				}
			}
		?>
		
	</div><!--resource_description ends-->
	
	</div><!--resource_details ends-->
		<div class="recommend_div">
			<p>Please enter the email address of whom you would like to 
				recommend this resource to. <br>For multiple emails please seperate with a comma (one@email.com, two@email.com).</p>
		<form class="emailRecommendation" action="EmailRecommendation.php" method="GET">
			<input type="hidden" name="resourceTitle" value="<?php echo $resource[0]['title'];?>" />
			<input type ="hidden" name="user_id" value="<?php echo $user_id;?>" />
			<textarea id ="ta" cols="60" rows="2" name="emails"></textarea>
			<input type="submit" value="Send"/>
			</form>
			<br>
		</div>
	<div class="resource_discussion">

<h4>Add comments</h4>


		<span id="output"></span>
		<form id="resourceCommentForm" action="new_discussion_comment_func.php" method="POST">
				<textarea id="resourcetextarea" name="comment[comment]" rows="4" cols="80"></textarea><br>
				<input type="hidden" name="comment[user_id]" value="<?php echo $user_id;?>" />
				<input type="hidden" name="comment[resource_id]" value="<?php echo $resource[0]['resource_id'];?>" />
				
			<input type="submit" value="Comment" />
			</form>
			<h3>Comments</h3>
			<div class="resource_discussion_comments" >
				<ul class="viewComments">
					<?php if(sizeof($comments) > 0){
							foreach($comments as $comment){
								if($comment['comment_reply_id'] != null){
									continue;
								}
								$var = new database_query($pdo,'discussion');
								$comment['comment_id'] = new commentsobj($id,$column,$comment,$conn,$is_admin,$user_id,$var);
								echo $comment['comment_id'] -> getHTML();
							}
						}
					?>
				</ul>
			</div>
	</div>		