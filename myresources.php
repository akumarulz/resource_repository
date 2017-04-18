<?php
$userid = $_SESSION['user_id'];
require_once('cleantext.php');
//search connection for users
$var2 = new database_query($pdo,'users');
$getDetails = ['user_id'=>$userid];
$owner = $var2->selectcols($getDetails);

$query =null;

$pageCtrl = null;

if(strtoupper($_SERVER['REQUEST_METHOD']) === 'GET' && isset($_GET['search'])) {
//var_dump($_GET);
	$valid = false;
		
			//determin id the dates are set
			if($_GET['search']['from_date']!='' && $_GET['search']['to_date'] != ''){
				$valid=true;
			}
				
			//base query string 
		$query ='SELECT * FROM document_resources WHERE user_id = '.$userid.' '; 

		//if the search field is set include it as an 'and' to extend the query
		$title = ($_GET['search']['title'] !='' ) ? ' AND title LIKE \'%'.cleantext($_GET['search']['title']).'%\'' : ' AND title LIKE \'%\' ' ;
		$filetype = ($_GET['search']['type'] !='' ) ? ' AND file_type LIKE \'%'.cleantext($_GET['search']['type']).'%\' ': '';
		$category = ($_GET['resourcedoc']['subject'] !='' ) ? ' AND category_id = '.cleantext($_GET['resourcedoc']['subject']).' ' : '';
		$no_archived = ' AND blocked_users != \'ARCHIVED\' ';
		$date = ($valid == true) ? ' AND DATE(`date`) >= \''.cleantext($_GET['search']['from_date']).'\' AND DATE(`date`) <=\''.cleantext($_GET['search']['to_date']).'\' ': ''; 
		$asc = ($_GET['search']['asc'] =='' ) ? ' order by date desc':' order by date asc';

		//join queries together
		$query = $query.$title.$filetype.$category.$date.$no_archived.$asc;
		
		//echo $query;
		//run query
	
}

if($query == null){
	$query = 'SELECT * FROM document_resources WHERE user_id = '.$userid.' AND blocked_users != \'ARCHIVED\' ORDER BY DATE(`date`) DESC';
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
		$pageCtrl.= '<a href="'.$_SERVER['PHP_SELF'].'?page=myresources&current='.$previous.'&'.http_build_query($_GET).'" >Previous</a> &nbsp; &nbsp; ';
		
		for($i = $currentPage - 4; $i < $currentPage; $i++){
			if($i > 0){
						$pageCtrl.= '<a href="'.$_SERVER['PHP_SELF'].'?page=myresources&current='.$i.'&'.http_build_query($_GET).'" >'.$i.'</a> &nbsp; ';

			}
		}
	}	

	$pageCtrl.=''.$currentPage.' &nbsp; ';

	for($i = $currentPage + 1; $i <= $lastPage; $i++){
		$pageCtrl.='<a href ="'.$_SERVER['PHP_SELF'].'?page=myresources&current='.$i.'&'.http_build_query($_GET).'" >'.$i.'</a> &nbsp; ';
		if($i >= $currentPage +4){
			break;
		}
	}
	
	if ($currentPage != $lastPage){
		$next = $currentPage+1;
				$pageCtrl.= '<a href="'.$_SERVER['PHP_SELF'].'?page=myresources&current='.$next.'&'.http_build_query($_GET).'" >Next</a> &nbsp; &nbsp; ';

	}

}

//search connection for counter
$dbconn = new database_join_queries($pdo);
$criteria = (isset($_GET)) ? $_GET : null ;
$subjects = new database_query($pdo,'specialist_subjects');
$retrievedsubjects = $subjects->selectall();

$templateVars = [
'dbconn'=>$dbconn,
'subjects'=>$retrievedsubjects,
'search_criteria'=> $criteria,
'pageCtrl'=>$pageCtrl,
'resources'=>$got,
'owner'=>$owner
];
$title = 'My Resources';
$content = loadTemplate('myresources_template.php', $templateVars);

?>