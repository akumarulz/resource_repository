<?php
require_once('connect.php');
require_once('autoload.php');
if(strtoupper($_SERVER['REQUEST_METHOD']) === 'POST') {

	
	$users = new database_query($pdo,'users');
	$user_id=$_POST['user_id'];
	$column = ($_POST['column'] == 'resource_id') ? 'resource_id' : 'forum_id';
	$id = $_POST['id'];

	$findis_admin =['user_id'=>$user_id];
	$result = $users->selectcols($findis_admin);
		$is_admin = $result['is_admin'];
	
	
	$getComments = new database_query($pdo,'discussion');
	
	$comments = $getComments ->getComments($column, $id);
	
	
		echo '<script >
		$(".showreplies").click(function(event){
			var select = $(this);
			var id = select.attr("value");
			$("#"+id).toggle();
			});
		$(".commentManagementform").submit(function(event){
		event.stopPropagation();
			event.preventDefault();
		$.post($(this).attr("action"),
		$(this).serializeArray(),
		function(info){
			
			var result = JSON.parse(info);
			$(".viewComments").load("refreshComments.php",{user_id:result.user_id,column:result.column,id:result.id});
		});
	});
		</script>';
		 if(isset($comments)){
			// echo '<ul class="viewComments">';

				foreach($comments as $comment){
					if($comment['comment_reply_id'] > 0){
							continue;
						}
					$comment['comment_id'] = new commentsobj($id,$column,$comment,$users,$is_admin,$user_id,$getComments);
					echo $comment['comment_id'] -> getHTML();
				}
				//echo'</ul>';
			}		
}

?>