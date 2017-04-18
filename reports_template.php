<h1>Reports</h1>
<?php 
echo $pages;
if(sizeof($foundReports > 0)){
	$table = new reportobj();
	$table->setHTML($foundReports,$users,$topics,$resources);
	echo $table->getHTML(); 
}else{
	echo '<p>No Reports</p>';
}
echo $pages;
?>