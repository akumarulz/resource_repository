<?php
require_once('connect.php');
require_once('autoload.php');

if ($_SERVER['REQUEST_METHOD'] ==='POST'){
	
	$criteria = null;
	if(is_numeric(trim($_POST['user'])) && preg_match('/[0-9]/', $_POST['user'])){
		$criteria = 'user_id';
		
	}elseif(is_string(trim($_POST['user'])) && preg_match('/[a-zA-Z0-9 ]/', $_POST['user'])){
		$criteria = 'username';
	}else{$criteria=null;}
	
	if($criteria != null){
		$var = new database_query($pdo,'users');
		$searchArray = [$criteria=>trim($_POST['user'])];
		$result = $var->selectcols($searchArray);
		
		if($result){
			if($result['user_id'] != $_POST['current']){
				$reply = [
			'username'=>$result['username'],
			'user_id'=>$result['user_id']
			];
			echo json_encode($reply);
			}else{
				echo 'Self';
			}
			
		}else{
			echo 'NF';
		}
	}else{echo 'NF';}
}
?>