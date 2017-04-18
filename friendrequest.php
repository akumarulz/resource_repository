<<<<<<< HEAD
<?php
//linked with friendcheck....try to make a function
require_once('connect.php');
require_once('autoload.php');
require_once('cleantext.php');
//require_once('friendcheck.php');
if ($_SERVER['REQUEST_METHOD'] ==='POST'){
	
	//$ids[0] is the visitor to the profile and requesting friends with $ids[1] profile owner
		
	if(isset($_POST['request']['user_id'])){
		$ids = null;
		$ids = explode('-',$_POST['request']['user_id']);
		$requester = cleantext($ids[0]);
		$potential = cleantext($ids[1]);
		
		
		$notification = new database_query($pdo,'notifications');
		$friends = new database_query($pdo,'friends');
		
	$ck = new notificationobj();
	$ck->setConn($notification);
	$ck->setReciever($potential);
	$ck->setSenderId($requester);
	$ck->setNotification('Friend request');
	//check for previous notifiation
	$found = $ck->checkforfriendsNotification();
		if(!$found){
			//check if already friends
				$fri = new friendsobj();
				$fri->setConn($friends);
				$fri->setRecieverid($potential);
				$fri->setFromid($requester);
				$found = $fri->checkforfriends();
				if(!$found){
					//make a new request
					$found = $ck->saveFriendRequestNotification();
				}
		}
		
			if($found){
				echo 'requested';
			}
			
		}else{
			echo 'error';
		}
	}

=======
<?php
//linked with friendcheck....try to make a function
require_once('connect.php');
require_once('autoload.php');
require_once('cleantext.php');
//require_once('friendcheck.php');
if ($_SERVER['REQUEST_METHOD'] ==='POST'){
	
	//$ids[0] is the visitor to the profile and requesting friends with $ids[1] profile owner
		
	if(isset($_POST['request']['user_id'])){
		$ids = null;
		$ids = explode('-',$_POST['request']['user_id']);
		$requester = cleantext($ids[0]);
		$potential = cleantext($ids[1]);
		
		
		$notification = new database_query($pdo,'notifications');
		$friends = new database_query($pdo,'friends');
		
	$ck = new notificationobj();
	$ck->setConn($notification);
	$ck->setReciever($potential);
	$ck->setSenderId($requester);
	$ck->setNotification('Friend request');
	//check for previous notifiation
	$found = $ck->checkforfriendsNotification();
		if(!$found){
			//check if already friends
				$fri = new friendsobj();
				$fri->setConn($friends);
				$fri->setRecieverid($potential);
				$fri->setFromid($requester);
				$found = $fri->checkforfriends();
				if(!$found){
					//make a new request
					$found = $ck->saveFriendRequestNotification();
				}
		}
		
			if($found){
				echo 'requested';
			}
			
		}else{
			echo 'error';
		}
	}

>>>>>>> origin/master
?>