<?php
//search connection for users
$var2 = new database_query($pdo,'users');
$query = null;

$pageCtrl = null;

if(strtoupper($_SERVER['REQUEST_METHOD']) === 'GET' && isset($_GET['search'])) {

	require_once('cleantext.php');
	$valid = false;

	function check($str){
		$flag = false;
		if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$str)){
			$flag = true;
		}
		return $flag;
	}

	if(check($_GET['search']['to_date']) == true && check($_GET['search']['from_date']) == true){
		$valid = true;
	}
	
	if($_GET['search']['user_search'] == ''){
		$_GET['search']['user_id'] = '';
	}

	$query = "SELECT * FROM forum_topics ";
	$topic = (trim($_GET['search']['title']) !='') ? 'WHERE topic_title LIKE \'%'.cleantext($_GET['search']['title']).'%\'' : 'WHERE topic_title LIKE \'%\' ';
	$category = (trim($_GET['search']['category']) !='') ? ' AND category = \''.$_GET['search']['category'].'\'' : '';
	$usertopic = ($_GET['search']['user_id']!= '') ? ' AND user_id = '.$_GET['search']['user_id'] : ''; 
	//keep quotes of date search will not work
	$date = ($valid == true) ? ' AND DATE(`date`) >= \''.cleantext($_GET['search']['from_date']).'\' AND  DATE(`date`) <= \''.cleantext($_GET['search']['to_date']).'\'' : ''; 
	$no_archived = ' AND blocked_users != \'ARCHIVED\' ';
	$order = (isset($_GET['search']['asc']) == '') ? ' ORDER BY DATE DESC' : ' ORDER BY DATE ASC' ;
	$query = $query.$topic.$category.$usertopic.$date.$no_archived.$order;
	
	$topicRS = $pdo->query($query);
	$result = $topicRS->fetchall(PDO::FETCH_ASSOC);
	
}

if($query == null){
	$query = 'SELECT * FROM forum_topics WHERE blocked_users != \'ARCHIVED\' ORDER BY date DESC';
}

$stmt = $pdo->query($query);
$num = $stmt->rowCount();

$itemsPerPage = (isset($_GET['search']['numResult'])) ? $_GET['search']['numResult'] : 5;

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
		$pageCtrl.= '<a href="'.$_SERVER['PHP_SELF'].'?page=forums&current='.$previous.'&'.http_build_query($_GET).'" >Previous</a> &nbsp; &nbsp; ';
		
		for($i = $currentPage - 4; $i < $currentPage; $i++){
			if($i > 0){
						$pageCtrl.= '<a href="'.$_SERVER['PHP_SELF'].'?page=forums&current='.$i.'&'.http_build_query($_GET).'" >'.$i.'</a> &nbsp; ';

			}
		}
	}	

	$pageCtrl.=''.$currentPage.' &nbsp; ';

	for($i = $currentPage + 1; $i <= $lastPage; $i++){
		$pageCtrl.='<a href ="'.$_SERVER['PHP_SELF'].'?page=forums&current='.$i.'&'.http_build_query($_GET).'" >'.$i.'</a> &nbsp; ';
		if($i >= $currentPage +4){
			break;
		}
	}
	
	if ($currentPage != $lastPage){
		$next = $currentPage+1;
				$pageCtrl.= '<a href="'.$_SERVER['PHP_SELF'].'?page=forums&current='.$next.'&'.http_build_query($_GET).'" >Next</a> &nbsp; &nbsp; ';

	}

}

//search connection for counter
$dbconn = new database_join_queries($pdo);
$criteria = (isset($_GET)) ? $_GET : null ;

$templateVars = [
'query'=>$query,
'criteria'=> $criteria,
'topics'=>$got,
'dbconn'=>$dbconn,
'users'=>$var2,
'pageCtrl'=>$pageCtrl
];
$title = 'Forum search';
$content = loadTemplate('forum_search_template.php', $templateVars);


?>