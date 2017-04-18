<<<<<<< HEAD
<?php
//search database for all report
$var = new database_query($pdo,'reports');
$results = $var->selectallbydate();
$pageCtrl=null;
$subjects = new database_query($pdo,'specialist_subjects');
$retrievedsubjects = $subjects->selectall();


$query = 'SELECT * FROM reports ORDER BY date DESC';


$stmt = $pdo->query($query);
$num = $stmt->rowCount();

$itemsPerPage = 10;

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
		$pageCtrl.= '<a href="'.$_SERVER['PHP_SELF'].'?page=Reports&current='.$previous.'&'.http_build_query($_GET).'" >Previous</a> &nbsp; &nbsp; ';
		
		for($i = $currentPage - 4; $i < $currentPage; $i++){
			if($i > 0){
						$pageCtrl.= '<a href="'.$_SERVER['PHP_SELF'].'?page=Reports&current='.$i.'&'.http_build_query($_GET).'" >'.$i.'</a> &nbsp; ';

			}
		}
	}	

	$pageCtrl.=''.$currentPage.' &nbsp; ';

	for($i = $currentPage + 1; $i <= $lastPage; $i++){
		$pageCtrl.='<a href ="'.$_SERVER['PHP_SELF'].'?page=Reports&current='.$i.'&'.http_build_query($_GET).'" >'.$i.'</a> &nbsp; ';
		if($i >= $currentPage +4){
			break;
		}
	}
	
	if ($currentPage != $lastPage){
		$next = $currentPage+1;
				$pageCtrl.= '<a href="'.$_SERVER['PHP_SELF'].'?page=Reports&current='.$next.'&'.http_build_query($_GET).'" >Next</a> &nbsp; &nbsp; ';

	}

}

$templateVars = [
'foundReports'=>$got,
'users'=> new database_query ($pdo,'users'),
'topics'=> new database_query ($pdo,'forum_topics'),
'resources'=> new database_query ($pdo,'document_resources'),
'pages'=>$pageCtrl
];
$title = 'Reports';
$content = loadTemplate('reports_template.php', $templateVars);


=======
<?php
//search database for all report
$var = new database_query($pdo,'reports');
$results = $var->selectallbydate();
$pageCtrl=null;
$subjects = new database_query($pdo,'specialist_subjects');
$retrievedsubjects = $subjects->selectall();


$query = 'SELECT * FROM reports ORDER BY date DESC';


$stmt = $pdo->query($query);
$num = $stmt->rowCount();

$itemsPerPage = 10;

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
		$pageCtrl.= '<a href="'.$_SERVER['PHP_SELF'].'?page=Reports&current='.$previous.'&'.http_build_query($_GET).'" >Previous</a> &nbsp; &nbsp; ';
		
		for($i = $currentPage - 4; $i < $currentPage; $i++){
			if($i > 0){
						$pageCtrl.= '<a href="'.$_SERVER['PHP_SELF'].'?page=Reports&current='.$i.'&'.http_build_query($_GET).'" >'.$i.'</a> &nbsp; ';

			}
		}
	}	

	$pageCtrl.=''.$currentPage.' &nbsp; ';

	for($i = $currentPage + 1; $i <= $lastPage; $i++){
		$pageCtrl.='<a href ="'.$_SERVER['PHP_SELF'].'?page=Reports&current='.$i.'&'.http_build_query($_GET).'" >'.$i.'</a> &nbsp; ';
		if($i >= $currentPage +4){
			break;
		}
	}
	
	if ($currentPage != $lastPage){
		$next = $currentPage+1;
				$pageCtrl.= '<a href="'.$_SERVER['PHP_SELF'].'?page=Reports&current='.$next.'&'.http_build_query($_GET).'" >Next</a> &nbsp; &nbsp; ';

	}

}

$templateVars = [
'foundReports'=>$got,
'users'=> new database_query ($pdo,'users'),
'topics'=> new database_query ($pdo,'forum_topics'),
'resources'=> new database_query ($pdo,'document_resources'),
'pages'=>$pageCtrl
];
$title = 'Reports';
$content = loadTemplate('reports_template.php', $templateVars);


>>>>>>> origin/master
?>