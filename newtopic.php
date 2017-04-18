<?php

$is_admin = $_SESSION['is_admin'];
$user_id = $_SESSION['user_id'];
$date = date("Y-m-d h:i:s");
$error = null;
$dbconn = new database_query($pdo,'forum_topics');
$array=['date'=>$date];
$edit = null;
if(strtoupper($_SERVER['REQUEST_METHOD']) === 'GET' && isset($_GET['topic'])) {

	$search = ['topic_id'=>$_GET['topic']['id']];
	$found = $dbconn->selectcol($search);

	$edit = new topicobj($array);
	$edit->setTitle($found[0]['topic_title']);
	$edit->setCategory($found[0]['category']);
	$edit->setDesc($found[0]['topic_description']);
	$edit->setTopicId($found[0]['topic_id']);
	$date = $found[0]['date'];
}

if(isset($_POST['forum'])){

try{
	
		$newTopic = new topicobj($array);
			if($_POST['forum']['topic_id'] > 0){
				$newTopic->setTopicId($_POST['forum']['topic_id']);
			}
		$newTopic->setConn($dbconn);
		$newTopic->setUserId($user_id);
		$newTopic->setTitle($_POST['forum']['topic_title']);
		$newTopic->setDesc($_POST['forum']['topic_description']);
		$newTopic->setCategory($_POST['forum']['category']);

		if($_POST['forum']['topic_id'] > 0){
			$result = $newTopic->upDateTopic();
		}else{
			$result = $newTopic->save();
		}
		if(!$result){
			throw new Exception("Topic not saved, please try again");
		}
}catch(exception $e){
	$error = $e->getMessage();
}

	if($error != null){
		
		$templateVars =[
		'user_id'=>$user_id,
		'forum'=>$_POST['forum'],
		'Emessage'=>$error
		];
		$title = 'New Topic Page';
		$content = loadTemplate('new_topic_template.php', $templateVars);

	}elseif($result){
		//load topic page
		
		$array=['date'=>$date];

		if($_POST['forum']['topic_id'] > 0){
			$array = ['topic_id' => $_POST['forum']['topic_id']];
		}

		$results = $dbconn->selectcol($array);
		
		
		$users = new database_query($pdo,'users');
		//load topic page
		$templateVars =[
		'is_admin'=>$is_admin,
		'users'=>$users,
		'topic'=>$results,
		'userid'=>$user_id,
		];
		$title = 'Forum Page';
		$content = loadTemplate('forum_template.php', $templateVars);
			
	}

}else{
	$templateVars =['user_id'=>$user_id,'editTopic'=>$edit];
	$title = 'New Topic Page';
	$content = loadTemplate('new_topic_template.php', $templateVars);
}
?>