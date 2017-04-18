<<<<<<< HEAD
<?php
require_once('cleanInput_func.php');

if(isset($_GET['messageid'])){
	//clean input from get global
	$user_id = $_SESSION['user_id'];
	$cleantext = clean_input($_GET['messageid']);
	
	//user inbox number
	$allmessages = new database_query($pdo,'messages');
	
	//get the message the user has clicked on
	$array=['messageid'=>$cleantext,];
	$result = $allmessages->selectcol($array);
	
	//get sender details
	$senderDetails = new database_query($pdo,'users');
	$senderArray = ['user_id'=>$result[0]['sender_id']];
	$sender = $senderDetails->selectcol($senderArray);
	
	//mark message as read
		$array=['messageid'=>$cleantext,'mread'=>1];
		$allmessages->update($array,'messageid');
		
	//setup outputs
	$templateVars =[ 
	'message'=>$result[0],
	'sender'=>$sender[0],
	'user_id'=>$user_id
	];
	$title = 'messages';
	$content = loadTemplate('read_message_template.php', $templateVars);
}


=======
<?php
require_once('cleanInput_func.php');

if(isset($_GET['messageid'])){
	//clean input from get global
	$user_id = $_SESSION['user_id'];
	$cleantext = clean_input($_GET['messageid']);
	
	//user inbox number
	$allmessages = new database_query($pdo,'messages');
	
	//get the message the user has clicked on
	$array=['messageid'=>$cleantext,];
	$result = $allmessages->selectcol($array);
	
	//get sender details
	$senderDetails = new database_query($pdo,'users');
	$senderArray = ['user_id'=>$result[0]['sender_id']];
	$sender = $senderDetails->selectcol($senderArray);
	
	//mark message as read
		$array=['messageid'=>$cleantext,'mread'=>1];
		$allmessages->update($array,'messageid');
		
	//setup outputs
	$templateVars =[ 
	'message'=>$result[0],
	'sender'=>$sender[0],
	'user_id'=>$user_id
	];
	$title = 'messages';
	$content = loadTemplate('read_message_template.php', $templateVars);
}


>>>>>>> origin/master
?>