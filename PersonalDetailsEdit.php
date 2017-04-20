
<?php

$useid = $_SESSION['user_id'];
$errorMsg = null;
$var = new database_query($pdo,'users');

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['Edit'])){
	
	
	try{
		$member = new memberobj();
		$member->setUser_id($_POST['user']['user_id']);
		$member->setTitle($_POST['user']['title']);
		$member->setFirstname($_POST['user']['first_name']);
		if ($_POST['user']['middle_name'] != ''){$member->setMiddlename($_POST['user']['middle_name']);}
		$member->setSurname($_POST['user']['surname']);
		$member->setEmail($_POST['user']['email']);
		$member->setLocation($_POST['user']['location']);
		$member->setSchool($_POST['user']['school_name']);
		if($_POST['user']['checker'] == 1){
			$member->setPassword($_POST['user']['password']);
		}elseif ($_POST['user']['checker'] == -1){
			throw new Exception('Passwords not Matching');			
		}
		$member->save($var);
		
		$templateVars = [
		'page'=>'profile',
		'reply'=>'Details Saved'
		];
		
		$title = 'Updated';
		$content = loadTemplate('user_thankyou_template.php', $templateVars);
		return;
	}catch (Exception $e){
		$errorMsg = $e->getMessage();
	}
	
}



$retrieve = ['user_id'=>$useid];
$userdetails = $var->selectcol($retrieve);

$member = new memberobj();
$member->setUser_id($userdetails[0]['user_id']);
$member->setTitle($userdetails[0]['title']);
$member->setFirstname($userdetails[0]['first_name']);
if($userdetails[0]['middle_name'] != '') {$member->setMiddlename($userdetails[0]['middle_name']);}
$member->setSurname($userdetails[0]['surname']);
$member->setEmail($userdetails[0]['email']);
$member->setLocation($userdetails[0]['location']);
$member->setSchool($userdetails[0]['school_name']);

$templateVars = [
'member'=>$member,
'response'=>$errorMsg
];
$title = 'Edit';
$content = loadTemplate('register_template.php', $templateVars);

?>