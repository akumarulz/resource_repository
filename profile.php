<?php
require_once('cleantext.php');

$userid = (isset($_GET['user_id'])) ? cleantext($_GET['user_id']) : cleantext($_SESSION['user_id']) ;
$visitor = cleantext($_SESSION['user_id']);


setcookie("userid", $userid, time()+3600);
setcookie("visitor", $visitor, time()+3600);

$users = new database_query($pdo,'users');

$var = new database_query($pdo,'workhistory');

$var_userSubjects = new database_join_queries($pdo);

	$results_userSubjects = $var_userSubjects->findSubjects($userid);

	
	$array = ['user_id'=>$userid];
	$userDetails = $users->selectcols($array);

	//select all from user work history
	$result = $var->selectcol($array);
	

	if($userDetails['profilePic'] ==''){
		$userDetails['profilePic']='images/profileavatar.png';
	}

$templateVars = [
'is_admin'=>$_SESSION['is_admin'],
'visitor' => $visitor,
'Name'=> $userDetails['title'].' '.ucfirst(strtolower($userDetails['first_name'])).' '.ucfirst(strtolower($userDetails['middle_name'])).' '.ucfirst(strtolower($userDetails['surname'])),
'location'=>$userDetails['location'],
'personalSummary'=>$userDetails['personalSummary'],
'interestSubjects' => $results_userSubjects,
'workHistoryArray'=>$result,
'userid'=>$userid,
'profilePic'=>$userDetails['profilePic']
];


$title = 'Profile';
$content = loadTemplate('profile_template.php', $templateVars);


?>