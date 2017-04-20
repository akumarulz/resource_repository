
<?php

$valid=null;
$user_id = $_GET['user_id'];
$template = 'resetpw_template.php';
$heading = 'Reset';
$error = null;
$templateVars = ['user_id'=>$user_id];
if(isset($_POST['user'])){
$user_id = $_POST['user']['user_id'];
	$var = new database_query($pdo,'users');
		
	if ($_POST['user']['checker']=="1"){

			try{
				$pwRset = new memberobj();
				$pwRset->setConn($var);
				$pwRset->setUser_id($user_id);
				$pwRset->setPassword($_POST['user']['password']);
				$valid = $pwRset->resetPassword();
				if(!$valid){
					throw new Exception("Error, please try again");
				}			
			}catch(exception $e){
			$error = $e->getMessage();
			}

		}else{
			$error = "<br>Passwords do not match";
		}
}

if($error != null){
$templateVars = [
		'user_id'=>$user_id,
		 'reply'=>$error,
		 ];
		 
}elseif($valid){
	$templateVars=[
		'page'=>'login',
		'reply'=>'Password Reset'
	];
	$heading = "password Reset";
	$template = 'user_thankyou_template.php';
}
		
		
		$title = $heading;
		$content = loadTemplate($template,$templateVars);


?>