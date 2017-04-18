
<?php
require_once('connect.php');
require_once('autoload.php');
require_once('cleantext.php');

if(strtoupper($_SERVER['REQUEST_METHOD']) === 'GET') {
$var = new database_query($pdo,'users');

if(trim($_GET['findName']) != '' && strlen($_GET['findName']) > 2 && preg_match("/^[a-zA-Z ]*$/" ,$_GET['findName']) && !ctype_space($_GET['findName'])){
		$rs = null;
		$string = explode(' ',$_GET['findName']);
		
		$f=$m=$s=null;
		
		if(isset($string[0])){
			$f = cleantext($string[0]);
		}
		if(isset($string[1])){
			$s = cleantext($string[1]);
		}
		if(isset($string[2])){
			$m = cleantext($string[2]);
		}
		
		
		if(sizeof($string) < 3){
		$array = [
			'first_name'=>$f,
			'surname'=>$s
		];
		}else{
		$array = [
			'first_name'=>$f,
			'middle_name'=>$s, 
			'surname'=>$m
		];
		}
		
		$userQuery = 'SELECT * FROM users where first_name LIKE \'%'.$array['first_name'].'%\'';
		
		if(isset($array['surname'])){
			$userQuery = $userQuery.' AND surname LIKE \'%'.$array['surname'].'%\'';
		}
		if(isset($array['middle_name'])){
			$userQuery = $userQuery.' AND middle_name LIKE \'%'.$array['middle_name'].'%\'';
		}
		
		$fnd = $pdo->query($userQuery);
		$rs = $fnd->fetchall(PDO::FETCH_ASSOC);
		
		if($rs){
			$temp = array();
			
			foreach ($rs as $row){
				$img = ($row['profilePic'] == '') ?  'images/Profileavatar.png': 'data:image/jpeg;base64,'.base64_encode($row['profilePic']) ;
			$array = [
			'user_id'=> $row['user_id'],
			'firstname' => ucfirst(strtolower($row['first_name'])),
			'surname' => ucfirst(strtolower($row['surname'])),
			'school' => $row['school_name'],
			'img' => $img
			
			];
			array_push($temp,$array);
			
			}
			
		echo json_encode($temp);
	}else{
		echo 'NONE';
	}
	}
	
	

}


?>