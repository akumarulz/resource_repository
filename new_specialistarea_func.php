
<?php
function newSpecialarea($specialistareas,$area){
	$valid = true;
	
	if(trim($area['specialist_area']) != true || !preg_match("/^[a-zA-Z ]*$/", $area['specialist_area']) || ctype_space($area['specialist_area'])){
		$valid = false;
	}
	
	if($valid){
		$specialistareas->save($area,'speciality_id');
	}
	return $valid;
}

?>