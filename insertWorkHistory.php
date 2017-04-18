<?php

require 'autoload.php';
require 'connect.php';
$userid = $_POST['work']['userid'];
$error = null;
if(isset($_POST)){
	
	
	$error = null;
	//contruct table name and query class object
	
	
		
	if(isset($_POST['work']['establishment'])){
		$var = new database_query ($pdo,'workhistory');
		
		try{
			$WH = new workhistoryObj();
			$WH->setUser($_POST['work']['userid']);
			$WH->setEst($_POST['work']['establishment']);
			$WH->setWF($_POST['work']['workFrom']);
			if(isset($_POST['work']['current'])){
							$WH->setCurrent();
						}else{
			$WH->setWT($_POST['work']['workTo']);
						}
			$WH->setConn($var);
			$result = $WH->save();
			if(!$result){
				throw new Exception("Error, please try again");
				
			}
		}catch(exception $e){
			$error = $e->getMessage();
		}			
	}
	
	
	
	//save personal summary
	if (isset($_POST['personalSummary'])){
		
		$var = new database_query ($pdo,'users');
		
		try{
			$PS = new memberobj();
			$PS->setUser_id($_POST['work']['userid']);
			$PS->setPersonalSummary($_POST['personalSummary']['summary']);
			$PS->setConn($var);
			$result = $PS->saveSummary();
			if(!$result){
				throw new Exception("Error, please try again");
			}
		}catch(exception $e){
			$error = $e->setMessage();
		}
	}

	
	//save specialist choices
	if(isset($_POST['choice'])){
		$var = new database_query ($pdo,'has_specialist_subject');
		unset($_POST['choice']['send']);
		//delete old entries first
		$array = ['user_id'=> $userid ];
		$var->remove($array);
		//update with new selection
		foreach($_POST['choice'] as $row){
			
			$array = [
			'user_id' => $userid,
			'subject_id'=>$row
			];
		
			$result = $var->insert($array);
		}
	}
	
		if($error != null){
			echo $error;
		}else{
			echo 'Saved';
		}
	
}
?>