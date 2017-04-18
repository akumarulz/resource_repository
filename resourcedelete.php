
<?php
require_once('connect.php');
require_once('database_query.php');
$remove = new database_query($pdo,'document_resources');
$array = ['resource_id'=>$_GET['resourceid']];
$result = $remove->remove($array);
if($result){
    echo'1';
}
?>