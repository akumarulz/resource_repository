<<<<<<< HEAD
<?php
if(strtoupper($_SERVER['REQUEST_METHOD']) === 'GET') {
	require_once('connect.php');
	require_once('autoload.php');
//	$user_id = $_GET['user_id'];
	$inboxitem = $_GET['inboxitem'];

	$var = new database_query($pdo,'messages');
	$remove = new inboxitemobj();
	$remove->setMessageid($inboxitem);
	$remove->setConn($var);
	$result = $remove->removeMessage();
	if($result){
		echo '1';
	}else{
		echo '-1';
	}
}
=======
<?php
if(strtoupper($_SERVER['REQUEST_METHOD']) === 'GET') {
	require_once('connect.php');
	require_once('autoload.php');
//	$user_id = $_GET['user_id'];
	$inboxitem = $_GET['inboxitem'];

	$var = new database_query($pdo,'messages');
	$remove = new inboxitemobj();
	$remove->setMessageid($inboxitem);
	$remove->setConn($var);
	$result = $remove->removeMessage();
	if($result){
		echo '1';
	}else{
		echo '-1';
	}
}
>>>>>>> origin/master
?>