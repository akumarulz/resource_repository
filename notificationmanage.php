
<?php
if(strtoupper($_SERVER["REQUEST_METHOD"]) == "GET"){
		require_once('connect.php');
		require_once('autoload.php');

		$complete = '0';
		$notid = $_GET['notificationid'];
	
		$type = $_GET['type'];

			if($type !='message'){
				$var = new database_query($pdo,'notifications');
				$removeNotification = new notificationobj();
				$removeNotification->setConn($var);
				$removeNotification->setNotificationId($notid);
				$done = $removeNotification->RemoveNotification();

				if($done){
					$complete = '1';
				}
			}else{
				$var = new database_query($pdo,'messages');
				$setRead = new inboxitemobj();
				$setRead->setConn($var);
				$setRead->setMessageid($notid);
				$done = $setRead->setMessageRead();
				if($done){
					$complete = '1';
				}
			
	}
echo $complete;
}

?>