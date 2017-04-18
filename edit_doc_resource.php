<?php
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
?>