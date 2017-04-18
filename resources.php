<<<<<<< HEAD
<?php

require_once('cleantext.php');


$fd = new database_query($pdo,'users');
$pageCtrl = null;
$query = null;
//quick search criteria
$quick_search = (isset($_POST['search']['title']) != "") ? "%".$_POST['search']['title']."%" : "%" ;

if($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['search'])){
			
			$valid = false;
		
			//determin id the dates are set
			if($_GET['search']['from_date']!='' && $_GET['search']['to_date'] != ''){
				$valid=true;
			}
				
			//base query string 
		$query ='SELECT * FROM document_resources'; 

		//if the search field is set include it as an 'and' to extend the query
		$title = ($_GET['search']['title'] !='' ) ? ' WHERE title LIKE \'%'.cleantext($_GET['search']['title']).'%\'' : ' WHERE title LIKE \'%\' ' ;
		$filetype = ($_GET['search']['type'] !='' ) ? ' AND file_type LIKE \'%'.cleantext($_GET['search']['type']).'%\' ': '';
		$category = ($_GET['resourcedoc']['subject'] !='' ) ? ' AND category_id = '.cleantext($_GET['resourcedoc']['subject']).' ' : '';
		$user = ($_GET['search']['user_id'] !='' ) ? ' AND user_id = '.$_GET['search']['user_id'].'' : '';
		
		$date = ($valid == true) ? ' AND DATE(`date`) >= \''.cleantext($_GET['search']['from_date']).'\' AND DATE(`date`) <=\''.cleantext($_GET['search']['to_date']).'\' ': ''; 
		$no_archived = 'AND blocked_users != \'ARCHIVED\' ';
		$asc = ($_GET['search']['asc'] =='' ) ? ' ORDER BY DATE(`date`) DESC':' ORDER BY DATE(`date`) ASC';

		//join queries together
		$query = $query.$title.$filetype.$category.$user.$date.$no_archived.$asc;
		
		//echo $query;
		//run query
	}

//get the list of stored subject areas
$subjects = new database_query($pdo,'specialist_subjects');
$retrievedsubjects = $subjects->selectall();

if($query == null){
	$query = 'SELECT * FROM document_resources WHERE blocked_users != \'ARCHIVED\' AND title LIKE \''.$quick_search.'\' ORDER BY date DESC';
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
		$pageCtrl.= '<a href="'.$_SERVER['PHP_SELF'].'?page=resources&current='.$previous.'&'.http_build_query($_GET).'" >Previous</a> &nbsp; &nbsp; ';
		
		for($i = $currentPage - 4; $i < $currentPage; $i++){
			if($i > 0){
						$pageCtrl.= '<a href="'.$_SERVER['PHP_SELF'].'?page=resources&current='.$i.'&'.http_build_query($_GET).'" >'.$i.'</a> &nbsp; ';

			}
		}
	}	

	$pageCtrl.=''.$currentPage.' &nbsp; ';

	for($i = $currentPage + 1; $i <= $lastPage; $i++){
		$pageCtrl.='<a href ="'.$_SERVER['PHP_SELF'].'?page=resources&current='.$i.'&'.http_build_query($_GET).'" >'.$i.'</a> &nbsp; ';
		if($i >= $currentPage +4){
			break;
		}
	}
	
	if ($currentPage != $lastPage){
		$next = $currentPage+1;
				$pageCtrl.= '<a href="'.$_SERVER['PHP_SELF'].'?page=resources&current='.$next.'&'.http_build_query($_GET).'" >Next</a> &nbsp; &nbsp; ';

	}

}

$criteria = (isset($_GET['search']))? $_GET : null ;
$var = new database_join_queries($pdo);
$templateVars = [
'dbconn'=>$var,
'search_criteria'=>$criteria,
'subjects' => $retrievedsubjects,
'docs'=> $got,
'connect' => $fd,
'userID'=>$_SESSION['user_id'],
'pageCtrl'=>$pageCtrl
];

$title = 'Resources Page';
$content = loadTemplate('resource_template.php', $templateVars);

=======
<?php

require_once('cleantext.php');


$fd = new database_query($pdo,'users');
$pageCtrl = null;
$query = null;
//quick search criteria
$quick_search = (isset($_POST['search']['title']) != "") ? "%".$_POST['search']['title']."%" : "%" ;

if($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['search'])){
			
			$valid = false;
		
			//determin id the dates are set
			if($_GET['search']['from_date']!='' && $_GET['search']['to_date'] != ''){
				$valid=true;
			}
				
			//base query string 
		$query ='SELECT * FROM document_resources'; 

		//if the search field is set include it as an 'and' to extend the query
		$title = ($_GET['search']['title'] !='' ) ? ' WHERE title LIKE \'%'.cleantext($_GET['search']['title']).'%\'' : ' WHERE title LIKE \'%\' ' ;
		$filetype = ($_GET['search']['type'] !='' ) ? ' AND file_type LIKE \'%'.cleantext($_GET['search']['type']).'%\' ': '';
		$category = ($_GET['resourcedoc']['subject'] !='' ) ? ' AND category_id = '.cleantext($_GET['resourcedoc']['subject']).' ' : '';
		$user = ($_GET['search']['user_id'] !='' ) ? ' AND user_id = '.$_GET['search']['user_id'].'' : '';
		
		$date = ($valid == true) ? ' AND DATE(`date`) >= \''.cleantext($_GET['search']['from_date']).'\' AND DATE(`date`) <=\''.cleantext($_GET['search']['to_date']).'\' ': ''; 
		$no_archived = 'AND blocked_users != \'ARCHIVED\' ';
		$asc = ($_GET['search']['asc'] =='' ) ? ' ORDER BY DATE(`date`) DESC':' ORDER BY DATE(`date`) ASC';

		//join queries together
		$query = $query.$title.$filetype.$category.$user.$date.$no_archived.$asc;
		
		//echo $query;
		//run query
	}

//get the list of stored subject areas
$subjects = new database_query($pdo,'specialist_subjects');
$retrievedsubjects = $subjects->selectall();

if($query == null){
	$query = 'SELECT * FROM document_resources WHERE blocked_users != \'ARCHIVED\' AND title LIKE \''.$quick_search.'\' ORDER BY date DESC';
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
		$pageCtrl.= '<a href="'.$_SERVER['PHP_SELF'].'?page=resources&current='.$previous.'&'.http_build_query($_GET).'" >Previous</a> &nbsp; &nbsp; ';
		
		for($i = $currentPage - 4; $i < $currentPage; $i++){
			if($i > 0){
						$pageCtrl.= '<a href="'.$_SERVER['PHP_SELF'].'?page=resources&current='.$i.'&'.http_build_query($_GET).'" >'.$i.'</a> &nbsp; ';

			}
		}
	}	

	$pageCtrl.=''.$currentPage.' &nbsp; ';

	for($i = $currentPage + 1; $i <= $lastPage; $i++){
		$pageCtrl.='<a href ="'.$_SERVER['PHP_SELF'].'?page=resources&current='.$i.'&'.http_build_query($_GET).'" >'.$i.'</a> &nbsp; ';
		if($i >= $currentPage +4){
			break;
		}
	}
	
	if ($currentPage != $lastPage){
		$next = $currentPage+1;
				$pageCtrl.= '<a href="'.$_SERVER['PHP_SELF'].'?page=resources&current='.$next.'&'.http_build_query($_GET).'" >Next</a> &nbsp; &nbsp; ';

	}

}

$criteria = (isset($_GET['search']))? $_GET : null ;
$var = new database_join_queries($pdo);
$templateVars = [
'dbconn'=>$var,
'search_criteria'=>$criteria,
'subjects' => $retrievedsubjects,
'docs'=> $got,
'connect' => $fd,
'userID'=>$_SESSION['user_id'],
'pageCtrl'=>$pageCtrl
];

$title = 'Resources Page';
$content = loadTemplate('resource_template.php', $templateVars);

>>>>>>> origin/master
?>