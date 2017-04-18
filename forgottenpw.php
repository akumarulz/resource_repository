<?php
require_once('email_function.php');
$templateVars =[];
$title = 'Forgotten password';
$content = loadTemplate('forgottenpw_template.php',$templateVars);

if(isset($_POST['email'])){
	$var = new database_query($pdo,'users');
	$array = ['email'=>$_POST['email']];
	$result = $var->selectcol($array);
	if($result){
		
		$message = '<p>Please follow this link to reset your <a href = "http://127.0.0.1:8000/edsa-new%20dissertation%20folder/index.php?page=resetpw&user_id='.$result[0]['user_id'].'">Password</a></p>';
		
		$msg = [
		'firstname' => $result[0]['first_name'],
		'surname'=>$result[0]['surname'],
		'email'=>$result[0]['email'],
		'subject'=> 'Reset Password',
		'message'=> $message
		];
		
		sendEmail($msg);
		$templateVars = [
		'reply'=>'Thank you',
		'page'=>'login'
		];
		
		$title;
		$content = loadTemplate('user_thankyou_template.php',$templateVars);
		
	}else{
		$templateVars = [
		'reply'=>'Unrecognised Email Address'
		];
		$title;
		$content = loadTemplate('forgottenpw_template.php',$templateVars);
	}
	
	
}else{
$title;
$content;
}

?>