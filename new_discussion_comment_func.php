<<<<<<< HEAD
<?php
require_once('connect.php');
require_once('autoload.php');
require_once('commentobj.php');
require_once('session.php');
$id = (isset($_POST['comment']['resource_id'])) ? $_POST['comment']['resource_id'] : $_POST['comment']['topic_id'] ;
$type = (isset($_POST['comment']['resource_id'])) ? 'resource_id': 'topic_id' ;
$user_id = $_SESSION['user_id'];
//$user_id = $_POST['comment']['user_id'];
$var = new database_query($pdo,'discussion');

$result = null;
if(strtoupper($_SERVER['REQUEST_METHOD']) === 'POST') {

		try{
			$comment = new commentobj();
			$comment->setUserid($user_id);
			$comment->setComment($_POST['comment']['comment']);
			$comment->setConnection($var);

			if(isset($_POST['comment']['comment_reply_id'])){
					$comment->setReply($_POST['comment']['comment_reply_id']);
				}

			if(isset($_POST['comment']['resource_id'])){
							
				$comment->setResourceid($id);
				$result = $comment->saveRcomment();
			}else{
				
				$comment->setTopicid($id);
				$result = $comment->saveTcomment();
			}
			
			
		}catch(Exception $e){
				$error = $e->getMessage();
		}

if($result){
	//echo 'comment saved

			//array to return
			$send = [
			'id'=>$id,
			'user_id'=>$user_id,
			'column'=>$type
			];
			
			echo json_encode($send);	
	
		}else{
			echo 'error';
			}
}


=======
<?php
require_once('connect.php');
require_once('autoload.php');
require_once('commentobj.php');
require_once('session.php');
$id = (isset($_POST['comment']['resource_id'])) ? $_POST['comment']['resource_id'] : $_POST['comment']['topic_id'] ;
$type = (isset($_POST['comment']['resource_id'])) ? 'resource_id': 'topic_id' ;
$user_id = $_SESSION['user_id'];
//$user_id = $_POST['comment']['user_id'];
$var = new database_query($pdo,'discussion');

$result = null;
if(strtoupper($_SERVER['REQUEST_METHOD']) === 'POST') {

		try{
			$comment = new commentobj();
			$comment->setUserid($user_id);
			$comment->setComment($_POST['comment']['comment']);
			$comment->setConnection($var);

			if(isset($_POST['comment']['comment_reply_id'])){
					$comment->setReply($_POST['comment']['comment_reply_id']);
				}

			if(isset($_POST['comment']['resource_id'])){
							
				$comment->setResourceid($id);
				$result = $comment->saveRcomment();
			}else{
				
				$comment->setTopicid($id);
				$result = $comment->saveTcomment();
			}
			
			
		}catch(Exception $e){
				$error = $e->getMessage();
		}

if($result){
	//echo 'comment saved

			//array to return
			$send = [
			'id'=>$id,
			'user_id'=>$user_id,
			'column'=>$type
			];
			
			echo json_encode($send);	
	
		}else{
			echo 'error';
			}
}


>>>>>>> origin/master
?>