<?php
class commentsobj{
private $conn;
private $comment=[];
private $is_admin;
private $user_id;
private $tableconn;
private $column;
private $id;

	public function __construct($in_id,$in_column,$in_comment,$in_conn,$in_is_admin,$in_userid,$in_tableconn){
		$this->comment[] = $in_comment;
		$this->conn = $in_conn;
		$this->is_admin=$in_is_admin;
		$this->user_id = $in_userid;
		$this->column = $in_column;
		$this->tableconn = $in_tableconn;
		$this->id = $in_id;
	}

public function getHTML(){
	
		
			$array=['user_id'=>$this->comment[0]['user_id']];
			$var = $this->conn->selectcol($array);
			$result ='<li>';
				$result = $result.'<p class="resourceCommentUser"><b>'.ucfirst(strtolower($var[0]['first_name'])).' '.ucfirst(strtolower($var[0]['surname'])).'</b><br> '.date( 'H:i jS M Y',strtotime($this->comment[0]['date'])).'</p>';
								
				$result = $result.'<p class="comment">'.$this->comment[0]['comment'].'</p>';
				$result = $result.'<p><button class="commentreplybtn" value="'.$this->comment[0]['comment_id'].'A" id="'.$this->comment[0]['comment_id'].'" >Reply</button></p>';
				
			//find comments
			$find_replies = ['comment_reply_id' =>$this->comment[0]['comment_id']];
			$replies = $this->tableconn->selectcol($find_replies);
			if($replies){
				//var_dump($found);
				$result = $result.'<button class="showreplies" id="'.$this->comment[0]['comment_id'].'R" value="'.$this->comment[0]['comment_id'].'B" >Replies</button>';
			}
				
					
				if($this->user_id == $var[0]['user_id'] || $this->is_admin == 'Y'){
					$result = $result.'<form id="form1" class="commentManagementform" action="commentsManagement.php" method="POST">';
					$result = $result.'<input type="hidden" name="comment[comment_id]" value="'.$this->comment[0]['comment_id'].'"  />';
					$result = $result.'<input type="hidden" name="comment[user_id]" value="'.$this->user_id .'"  />';
					$result = $result.'<input type="hidden" name="comment[column]" value="'.$this->column.'" />';
					$result = $result.'<input type="hidden" name="comment[id]" value="'.$this->id.'" />';
					$result = $result.'<input type="submit" value="Delete" /></form>';
				}
					
				
				$col = ($this->column =='resource_id') ? 'resource_id' : 'topic_id' ;
				$result = $result.'<div id="'.$this->comment[0]['comment_id'].'A" class="commentreply" >';
						$result = $result.'<h5>Reply to comment</h5>';
						$result = $result.'<form id="form2" class="commentManagementform" action="new_discussion_comment_func.php" method="POST">';
						$result = $result.'<input type="hidden" name="comment[comment_reply_id]" value="'.$this->comment[0]['comment_id'].'" />';
						$result = $result.'<input type="hidden" name="comment[user_id]" value="'.$this->user_id .'"  />';
						$result = $result.'<input type="hidden" name="comment['.$col.']" value="'.$this->id.'" />';
						
						$result = $result.'<textarea cols="60" rows="3" name="comment[comment]"></textarea>';
						$result = $result.'<input type="submit" value="reply" name="comment[reply]"/></form>';
											
			$result = $result.'</div>';
			
			
			if($replies){
				
				$result = $result.'<ul id="'.$this->comment[0]['comment_id'].'B" class="commentreplies">';
					foreach($replies as $found){
						$inner = ['user_id' => $found['user_id']];
						$getinner = $this->conn->selectcol($inner);
						
						$result = $result.'<li>';						
							$result = $result.'<p class="resourceCommentUserreplies" ><b>'.ucfirst(strtolower($getinner[0]['first_name'])).' '.ucfirst(strtolower($getinner[0]['surname'])).' </b><br>'.date( 'H:i jS M Y',strtotime($found['date'])).'</p>';
							$result = $result.'<p class="commentrepliescomment" >'.$found['comment'].'</p>';
							
							//delete reply 
								if($this->user_id == $getinner[0]['user_id'] || $this->is_admin == 'Y'){
									$result = $result.'<form id="form1" class="commentManagementform" action="commentsManagement.php" method="POST">';
									$result = $result.'<input type="hidden" name="comment[comment_id]" value="'.$found['comment_id'].'"  />';
									$result = $result.'<input type="hidden" name="comment[user_id]" value="'.$this->user_id .'"  />';
									$result = $result.'<input type="hidden" name="comment[column]" value="'.$this->column.'" />';
									$result = $result.'<input type="hidden" name="comment[id]" value="'.$this->id.'" />';
									$result = $result.'<input type="submit" value="Delete" /></form>';
								}
						$result = $result.'</li>';
					}
				$result = $result.'</ul>';
			}
			
	$result = $result.'</li>';

	$str = $this->comment[0]['comment_id'].'R';
	
	$result = $result.'<script> 
		$("#"+'.$this->comment[0]['comment_id'].').click(function(){
		var v = $(this).val(); 
		$("#"+v).toggle();
		});
			
			
			 
			</script>';
		
	return $result;
}
}

?>