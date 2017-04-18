<<<<<<< HEAD
<?php
require_once('connect.php');
require_once('autoload.php');

$savepic = new database_query($pdo,'users');

if(isset($_FILES['profile'])){
	$error = 'An error occured';
	$valid = true;
	
	$filetype = pathinfo($_FILES['profile']['name']['img']);
	
	//add extra checks here
	if(strtolower($filetype['extension']) != "jpeg" && strtolower($filetype['extension'])!="jpg" && strtolower($filetype['extension']) != "png"){
			$error = $error.' Incorrect file type';
			$valid = false;
		}
	if(round($_FILES['profile']['size']['img']/1048576) > 2 || $_FILES['profile']['size']['img'] < 1){
		$error = $error.' Image file too large, 2MB max or empty file';
			$valid = false;
	} 
	
	if($valid){
		$array = [
		'user_id'=> $_POST['user'],
		'profilePic' =>file_get_contents($_FILES['profile']['tmp_name']['img']),
		'filetype' => $_FILES['profile']['type']['img']
		];
		
		$result = $savepic->update($array,'user_id');
		
		if($result){
			//echo 'image updated';
			
			$pic =  'data:image/jpeg;base64,'.base64_encode(file_get_contents($_FILES['profile']['tmp_name']['img']));
			echo $pic;
		}else{
			echo 'upload error';
		}
	}else{
		echo $error;
	}
}

=======
<?php
require_once('connect.php');
require_once('autoload.php');

$savepic = new database_query($pdo,'users');

if(isset($_FILES['profile'])){
	$error = 'An error occured';
	$valid = true;
	
	$filetype = pathinfo($_FILES['profile']['name']['img']);
	
	//add extra checks here
	if(strtolower($filetype['extension']) != "jpeg" && strtolower($filetype['extension'])!="jpg" && strtolower($filetype['extension']) != "png"){
			$error = $error.' Incorrect file type';
			$valid = false;
		}
	if(round($_FILES['profile']['size']['img']/1048576) > 2 || $_FILES['profile']['size']['img'] < 1){
		$error = $error.' Image file too large, 2MB max or empty file';
			$valid = false;
	} 
	
	if($valid){
		$array = [
		'user_id'=> $_POST['user'],
		'profilePic' =>file_get_contents($_FILES['profile']['tmp_name']['img']),
		'filetype' => $_FILES['profile']['type']['img']
		];
		
		$result = $savepic->update($array,'user_id');
		
		if($result){
			//echo 'image updated';
			
			$pic =  'data:image/jpeg;base64,'.base64_encode(file_get_contents($_FILES['profile']['tmp_name']['img']));
			echo $pic;
		}else{
			echo 'upload error';
		}
	}else{
		echo $error;
	}
}

>>>>>>> origin/master
?>