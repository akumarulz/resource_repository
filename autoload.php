<<<<<<< HEAD
<?php
function autoload($name){
		
		require strtolower($name).'.php';
	}
	spl_autoload_register('autoload');
?>