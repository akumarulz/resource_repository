
<?php
require_once('connect.php');
require_once('autoload.php');
require_once('cleantext.php');

if (strtoupper($_SERVER['REQUEST_METHOD']) ==='POST'){
	$found = null;
	$checked = null;
	$user_id = cleantext($_POST['user_id']); // who the friend request is going to
	$visitor = cleantext($_POST['visitor']); // who the request is coming from
	
	$notification = new database_query($pdo,'notifications');
	$friends = new database_query($pdo,'friends');

	//check if user has made a previous request
	$ck = new notificationobj();
	$ck->setConn($notification);
	$ck->setReciever($user_id);
	$ck->setSenderId($visitor);
	$ck->setNotification('Friend request');
	//check for previous notifiation
	$found = $ck->checkforfriendsNotification();
		if(!$found){
			//check if already friends
				$fri = new friendsobj();
				$fri->setConn($friends);
				$fri->setRecieverid($user_id);
				$fri->setFromid($visitor);
				$found = $fri->checkforfriends();
				if($found){
					echo 'friends';
				}
		}else{
			echo 'true';
		}
}


?>