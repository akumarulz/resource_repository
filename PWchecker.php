
<?php
if($_POST['check'] === $_POST['pw'] && strlen($_POST['pw']) > 7){

	echo "1";
	
}else{
	echo "0";
}

?>