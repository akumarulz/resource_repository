
<?php
require_once('connect.php');
require_once('autoload.php');
require_once('cleantext.php');
$var = new database_query($pdo,'reports');
$reportId = cleantext($_POST['reportid']);
$arr=['report_id'=>$reportId];
$found = $var->selectcols($arr);

$array = explode('$$',$found['result']);
foreach($array as $entry){
	echo $entry.'<br>';
}
?>