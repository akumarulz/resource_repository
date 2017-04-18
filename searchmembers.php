<?php

$is_admin = $_SESSION['is_admin'];
$user_id = $_SESSION['user_id'];
//search connection for users
$var2 = new database_query($pdo,'users');
$query =null;

$pageCtrl = null;


$blocked_member = new notificationobj();
$blocked_member->setConn(new database_query($pdo,'notifications'));
$blocked_member ->setReciever($user_id);
$blocked_member->setNotification('Friend request');
$blockedRequests = $blocked_member->findBlockedMembers();

if(strtoupper($_SERVER['REQUEST_METHOD']) === 'GET' && isset($_GET['search'])) {
	//var_dump($_GET);
	require_once('cleantext.php');
		
	$query = "SELECT * FROM users ";
	$blockedrequests1 = (isset($_GET['search']['blockedrequests'])) ? 'JOIN notifications ON users.user_id = notifications.from_user_id ' : '';

	$blockedusers = (isset($_GET['search']['blocked'])=='1') ? ' JOIN blocked_users_table on users.user_id = blocked_users_table.user_id ' : '';
	$firstname = (trim($_GET['search']['firstname']) !='') ? 'WHERE first_name LIKE \'%'.cleantext($_GET['search']['firstname']).'%\'' : 'WHERE first_name LIKE \'%\' ';
	$surname = (trim($_GET['search']['surname']) !='') ? 'AND surname LIKE \'%'.cleantext($_GET['search']['surname']).'%\'' : 'AND surname LIKE \'%\' ';
	$school = (trim($_GET['search']['school']) !='') ? 'AND school_name LIKE \'%'.cleantext($_GET['search']['school']).'%\'' : 'AND school_name LIKE \'%\' ';
	$location = (trim($_GET['search']['location']) !='') ? 'AND location LIKE \'%'.cleantext($_GET['search']['location']).'%\'' : 'AND location LIKE \'%\' ';
	$blockedrequests2 = (isset($_GET['search']['blockedrequests'])) ? ' AND notifications.notification = "Friend request" AND notifications.accept = 2 AND reciever_id ='.$user_id:'';
	$order = ($_GET['search']['asc'] == '') ? ' ORDER BY surname DESC' : ' ORDER BY surname ASC' ;
		
	$query = $query.$blockedusers.$blockedrequests1.$firstname.$surname.$school.$location.$blockedrequests2.$order;
	
	$topicRS = $pdo->query($query);
	$result = $topicRS->fetchall(PDO::FETCH_ASSOC);
	
}

if($query == null){
	$query = "SELECT * FROM users ORDER BY surname DESC";
}

$stmt = $pdo->query($query);
$num = $stmt->rowCount();


$itemsPerPage =(isset($_GET['search']['numResult'])) ? $_GET['search']['numResult'] : 5;

$lastPage = ceil($num/$itemsPerPage);

if($lastPage < 1){
	$lastPage = 1;
}

$currentPage = 1;

if(isset($_GET['current'])) {
	$currentPage = preg_replace('#[^0-9]#','',$_GET['current']);
}

if($currentPage < 1){
	$currentPage = 1;
}elseif ($currentPage > $lastPage){
	$currentPage = $lastPage;
}

$limit = ' LIMIT '.($currentPage -1) * $itemsPerPage.','.$itemsPerPage;

$data = $pdo->query($query.$limit);

$got = $data->fetchall(PDO::FETCH_ASSOC);
unset($_GET['page']);
unset($_GET['current']);
if($lastPage !=1){
	if($currentPage > 1){
		$previous = $currentPage - 1;
		$pageCtrl.= '<a href="'.$_SERVER['PHP_SELF'].'&page=searchmembers&current='.$previous.'&'.http_build_query($_GET).'" >Previous</a> &nbsp; &nbsp; ';
		
		for($i = $currentPage - 4; $i < $currentPage; $i++){
			if($i > 0){
						$pageCtrl.= '<a href="'.$_SERVER['PHP_SELF'].'&page=searchmembers&current='.$i.'&'.http_build_query($_GET).'" >'.$i.'</a> &nbsp; ';

			}
		}
	}	

	$pageCtrl.=''.$currentPage.' &nbsp; ';

	for($i = $currentPage + 1; $i <= $lastPage; $i++){
		$pageCtrl.='<a href ="'.$_SERVER['PHP_SELF'].'&page=searchmembers&current='.$i.'&'.http_build_query($_GET).'" >'.$i.'</a> &nbsp; ';
		if($i >= $currentPage +4){
			break;
		}
	}
	
	if ($currentPage != $lastPage){
		$next = $currentPage+1;
				$pageCtrl.= '<a href="'.$_SERVER['PHP_SELF'].'&page=searchmembers&current='.$next.'&'.http_build_query($_GET).'" >Next</a> &nbsp; &nbsp; ';

	}

}

//search connection for counter
$dbconn = new database_join_queries($pdo);
$criteria = (isset($_GET)) ? $_GET : null ;

$templateVars = [
'user_id'=> $user_id,
'blockedRequests'=>$blockedRequests,
'criteria'=> $criteria,
'pageCtrl'=>$pageCtrl,
'members'=>$got,
'is_admin'=>$is_admin
];
$title = 'Search Members';
$content = loadTemplate('searchmembers_template.php', $templateVars);

?>