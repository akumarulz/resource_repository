<?php
/*require_once('connect.php');
require_once('database_query.php');

$saveResource = new database_query($pdo,'document_resources');*/

function editResourceDetails($resources,$resource){
	$valid = true;
	
	if( trim($resource['title']) != true || !preg_match("/^[a-zA-Z0-9.,;:+-?@()£$&!' ]*$/",$resource['title'])){
		$valid = false;
	}
	if( trim($resource['description']) != true || !preg_match("/^[a-zA-Z0-9.,;:+-?@()£$&!' ]*$/",$resource['description'])){
		$valid = false;
	}
	if($valid){
		$resources->update($resource,'resource_id');
	}
	return $valid;
	
}

/*$array = [
'resource_id'=>$_POST['resource_id'],
'category_id'=>$_POST['category_id'],
'title'=>$_POST['title'],
'description'=>$_POST['description'],
'user_id'=>$_POST['user_id'],
'date'=>date("Y-m-d h:i:s")
];

$result = editResourceDetails($saveResource,$array);
if($result){
	echo 'updated';
}else{
	echo 'update error';}*/

?>