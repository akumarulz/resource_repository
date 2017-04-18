
<?php
require_once('connect.php');
require_once('autoload.php');
require_once('cleantext.php');

if ($_SERVER['REQUEST_METHOD'] ==='POST'){
	
	$me = cleantext($_POST['userid']);
	$them = cleantext($_POST['friendID']);
	$notificationId = cleantext($_POST['id']);
	
	
	$newfriend = new friendsobj();
	$newfriend->setRecieverid($me);
	$newfriend->setFromid($them);
	$newfriend->setConn(new database_query($pdo,'friends'));
	$result = $newfriend->save();
		if($result){
			$removeNotification = new notificationobj();
			$removeNotification->setNotificationId($notificationId);
			$removeNotification->setConn(new database_query($pdo,'notifications'));
			$esult = $removeNotification->RemoveNotification();
			if($result){
				echo 'done';
			}
		}	
}


?>