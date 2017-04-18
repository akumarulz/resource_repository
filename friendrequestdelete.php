<<<<<<< HEAD
<?php
require_once('autoload.php');
require_once('connect.php');
if ($_SERVER['REQUEST_METHOD'] ==='POST'){
	$user_id = $_POST['userid'];
	$id = $_POST['id'];
	
	$deleteFriendResuest = new notificationobj();
	$deleteFriendResuest->setNotificationId($id);
	$deleteFriendResuest->setConn(new database_query($pdo,'notifications'));
	$result = $deleteFriendResuest->RemoveNotification();
		if($result){
			echo'done';
		}
}

?>