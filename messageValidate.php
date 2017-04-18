<?php

require_once('connect.php');
require_once('autoload.php');
if ($_SERVER['REQUEST_METHOD'] ==='POST' && ($_POST['message']['user_id'] != $_POST['message']['to_id'])){
//find reciever id

$var = new database_query($pdo,'messages');
$message_reciever = new database_query($pdo,'users');
$array1=['user_id'=>$_POST['message']['to_id']];
$found = $message_reciever->selectcol($array1);
$error = null;

	try{
		$message = new inboxitemobj();
		$message->setConn($var);
		if(is_numeric($_POST['message']['to_id'])){
		$message->setReciever($_POST['message']['to_id']);
		}else{
			throw new Exception("Error Sending message");
		}
		
		$message->setSender($_POST['message']['user_id']);
		$message->setTitle(substr($_POST['message']['title'],0,255));
		$message->setMessage($_POST['message']['message']);
		$result = $message->sendMessage();
		if(!$result){
			throw new Exception("Error Sending message");
		}

	}catch(exception $e){
		$error = $e->getMessage();
	}
	if($error != null){
		echo $error;
	}else{
		echo 'Sent';
	}
		
}else{
	echo 'Cannot message yourself';
}
?>