<?php
$user = null;
$user_id = $_SESSION['user_id'];
$allusers = new database_query($pdo,'users');

if(isset($_GET['user_id'])){
	//retrieve name and id of user selected to send a message to. 
	$array = ['user_id'=>$_GET['user_id']] ;
	 $user = $allusers->selectcols($array);
}

//retrieve all messages for this member
$allmessages = new database_query($pdo,'messages');
$getMessages = ['reciever_id'=>$user_id];
$result = $allmessages->selectcol($getMessages);

	$templateVars =[ 
	'user_id'=>$_SESSION['user_id'],
	'inbox'=>$result,
	'findusers'=>$allusers,
	'user'=>$user
	];
	$title = 'send message Page';
	$content = loadTemplate('message_template.php', $templateVars);
?>