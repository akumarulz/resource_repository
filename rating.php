<<<<<<< HEAD
<?php 

require_once('database_join_queries.php');
require_once('database_query.php');
require_once('connect.php');
Require_once('session.php');

$getinfo = new database_query($pdo,'document_resources');
$insertnewRating = new database_join_queries($pdo);

if ($_POST){
	//get details of current file being rated
	$result = $getinfo ->selectFTall('resource_id',$_POST['idBox']);
	$_POST['rate'];
}

$ID = $_SESSION['user_id'];

//work out new rating score
$current_rating = $result[0]['total_ratings'] + $_POST['rate'];
$new_total_rates = $result[0]['total_rates'] + 1;
$new_rating = $current_rating / $new_total_rates;

//insert new rating
$inserted = $insertnewRating->insertRatings($_POST['idBox'],$new_rating,$current_rating,$new_total_rates,$ID);

//keep for debugging
/*if($inserted){
	echo 'success';
}else{
	echo 'error, not updated';
}*/

=======
<?php 

require_once('database_join_queries.php');
require_once('database_query.php');
require_once('connect.php');
Require_once('session.php');

$getinfo = new database_query($pdo,'document_resources');
$insertnewRating = new database_join_queries($pdo);

if ($_POST){
	//get details of current file being rated
	$result = $getinfo ->selectFTall('resource_id',$_POST['idBox']);
	$_POST['rate'];
}

$ID = $_SESSION['user_id'];

//work out new rating score
$current_rating = $result[0]['total_ratings'] + $_POST['rate'];
$new_total_rates = $result[0]['total_rates'] + 1;
$new_rating = $current_rating / $new_total_rates;

//insert new rating
$inserted = $insertnewRating->insertRatings($_POST['idBox'],$new_rating,$current_rating,$new_total_rates,$ID);

//keep for debugging
/*if($inserted){
	echo 'success';
}else{
	echo 'error, not updated';
}*/

>>>>>>> origin/master
?>