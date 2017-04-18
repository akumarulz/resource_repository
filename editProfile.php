<?php
if(strtoupper($_SERVER['REQUEST_METHOD']) === 'POST' || strtoupper($_SERVER['REQUEST_METHOD']) === 'GET' ) {

$edit = (isset($_POST['edit'])) ? $_POST['edit'] : $_GET['edit'];
$page = null;
switch($edit){
	case 'Edit Summary': $page = 'editPersonalSummary.php' ;break;
	case 'Add Work history' : $page = 'editProfile_template.php'; break;
	case 'Edit Interests': $page = 'editSpecialistAreas.php'; break;
}
}
$userid = $_SESSION['user_id'];

//get all the subject areas
$var = new database_query($pdo,'specialist_subjects');
$result = $var->selectall();

//get the subject areas the users has selected
$var_subjects = new database_query($pdo,'has_specialist_subject');
$resultSubject = $var_subjects->selectFTall('user_id',$userid);

$user = new database_query($pdo,'users');
$array=['user_id'=>$_SESSION['user_id']];
$fnd = $user->selectcol($array);


$templateVars = [
'specialistSubjects' =>$result,
'user_subjects' => $resultSubject,
'personalSummary'=>$fnd[0]['personalSummary'],
'userid'=>$userid
];

$title = 'Edit';
$content = loadTemplate($page, $templateVars);

?>