<?php
require_once('connect.php');
require_once('autoload.php');
if(isset($_POST['wh'])){
	
	$var = new database_query($pdo,'workhistory');
	$WH = new workhistoryObj();
	$WH->setConn($var);
	$WH->setID($_POST['wh']);
	$result = $WH->remove();
	if(!$result){
		echo'Error';
	}	
}

?>