<<<<<<< HEAD
<?php 
require_once('autoload.php');
require_once('connect.php');
if ($_SERVER['REQUEST_METHOD'] ==='POST'){
	$user_id = $_POST['userid'];
	$id = $_POST['id'];
	
	$blockfriendRequest = new notificationobj();
	$blockfriendRequest->setNotificationId($id);
	$blockfriendRequest->setConn(new database_query($pdo,'notifications'));
	$result = $blockfriendRequest->block();
		if($result){
			echo 'done';
		}
}
=======
<?php 
require_once('autoload.php');
require_once('connect.php');
if ($_SERVER['REQUEST_METHOD'] ==='POST'){
	$user_id = $_POST['userid'];
	$id = $_POST['id'];
	
	$blockfriendRequest = new notificationobj();
	$blockfriendRequest->setNotificationId($id);
	$blockfriendRequest->setConn(new database_query($pdo,'notifications'));
	$result = $blockfriendRequest->block();
		if($result){
			echo 'done';
		}
}
>>>>>>> origin/master
?>