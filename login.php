<?php
$confirmed = null;
$var = new database_query ($pdo,'users');

if(isset($_GET['confirmed'])=='xy42plu'){
	$user_id = $_GET['user_id'];
	$confirm = ['user_id'=>$user_id, 'confirmed'=> 'Y'];
		$stmt = $var->save($confirm,'user_id');
		if($stmt){$confirmed = 'Thank you, Your Account has been Confirmed';}
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
	
	
	//search database for matching email address
	$criteria = [
		'email' => $_POST['login']['email']
		];
		
	$result = $var->selectcols($criteria);
	
	//store the login details to return if unsuccessful
	$login = $_POST['login'];
	
	//compare stored password with submitted password
	if (password_verify($_POST['login']['password'],$result['password'])){
		
			
			
			//check if user is blocked
			$var = new database_query($pdo,'blocked_users_table');
			$search = ['user_id'=>$result['user_id']];
			$found=$var->selectcols($search);
			
			
			if($result['confirmed']=='N'){
				$templateVars = [
					'page'=>'login',
					'reply'=>'Account unconfirmed, please go to your email inbox and follow the link'
				];
					
					$title = 'Unconfirmed';
					$content = loadTemplate('user_thankyou_template.php', $templateVars);
				
			}elseif($found){
				$title = 'Blocked';
				$content= loadinnerTemplate('error_template.php');
			}else{
					$_SESSION['logged_in']=true;
					$_SESSION['user_id'] = $result['user_id'];
				include 'summary.php';
			}
			
			
	}else{
		
		//load login page with
		$templateVars = [
			'login'=>$login
		];
		$title = 'Login Page';
		$content = loadTemplate('login_template.php', $templateVars);
	}
}else{
$templateVars = [
'confirmed'=>$confirmed
];
$title = 'Login Page';
$content = loadTemplate('login_template.php', $templateVars);
}

?>