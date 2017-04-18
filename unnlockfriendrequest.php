<?php
if(strtoupper($_SERVER['REQUEST_METHOD']) === 'GET') {
require_once('connect.php');
require_once('autoload.php');

$unblock = new notificationobj();
$unblock->setConn(new database_query($pdo,'notifications'));
$unblock->setNotificationId(($_GET['notificationid']));
$saved = $unblock->unblock();
	if($saved){
		echo '1';
	}
}

?>