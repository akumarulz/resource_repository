<?php
require_once('connect.php');
require_once('autoload.php');

if(strtoupper($_SERVER['REQUEST_METHOD']) === 'POST') {
	
	$error = null;
	$result = null;

	$user_id = $_POST['comment']['user_id'];

	$comment_id = $_POST['comment']['comment_id'];
	$column = $_POST['comment']['column'];
	$resource = $_POST['comment']['id'];
	
		$remove = new commentobj();
		$remove->setComment_id($comment_id);
		$remove->setConnection(new database_query($pdo,'discussion'));
		$result = $remove->removeComment();

if($result){
	$refreshArray = [
	'user_id'=> $user_id,
	'column'=>$column,
	'id'=>$resource
	];
	echo json_encode($refreshArray);
	
}else{	echo 'error';}
}
?>