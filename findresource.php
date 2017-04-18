<?php
require_once('connect.php');
require_once('autoload.php');

if ($_SERVER['REQUEST_METHOD'] ==='POST'){
	//determin the table to search topic_id = forums table, resource_id = document resources tables
	$id = (isset($_POST['topic_id'])) ? 'topic_id' : 'resource_id';
	
	$reply = null;
	switch($id){
		case"topic_id":
		$var = new database_query($pdo,'forum_topics');
			$search = [$id=>trim($_POST['topic_id'])];
		$found = $var->selectcols($search);
		if($found){
			
			$reply = [
			'id'=> $found['topic_id'],
			'title' => 'Topic title: '.$found['topic_title'],
			'date' => 'Start date: '.date('H:i l jS M Y', strtotime($found['date']))
			];
			
		}

			break;
		case"resource_id":
			$var = new database_query($pdo,'document_resources');
				$search = [$id=>trim($_POST['resource_id'])];
				$found = $var->selectcols($search);
		if($found){
			$reply = [
			'id'=>$found['resource_id'],
			'title' => 'Resource title: '.$found['title'],
			'date'=> 'Upload date: '.date('H:i l jS M Y', strtotime($found['date']))
			];
		}	
		break;
		
	}
	if(!empty($reply)){
		echo json_encode($reply);
	}else{
		echo 'Not Found';
	}
	
	
	
}

?>