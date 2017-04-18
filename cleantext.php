<?php
function cleantext($val){
		$val = trim($val);
		$val = stripslashes($val);
		$val = htmlspecialchars($val);
		$val = str_replace("£","",$val);
		return $val;
	}

?>