<<<<<<< HEAD
<?php
$userid = $_SESSION['user_id'];
$report = null;
$result = null;
$reportAbout = null;
$reportAboutId = null;
$title = null;
$name = null;
$offender_id = null;
$error = null;
$valid = null;


if ($_SERVER['REQUEST_METHOD'] ==='GET'){
	
	$type = $_GET['source'];
	$id = $_GET['id'];
	$var=null;
	switch($type){
	case'forum': 
		$reportAbout='Topic'; 
		$var= new database_query($pdo,'forum_topics');
		$search = ['topic_id'=>$id]; 
		$found = $var->selectcols($search);
		$title = $found['topic_title'];
		$reportAboutId = $id;
		
		break;	
	case'offender': 
		$reportAbout='Offender'; 
		$var= new database_query($pdo,'users'); 
		$search = ['user_id'=>$id]; 
		$found = $var->selectcols($search);
		$name = ucfirst(strtolower($found['first_name'])).' '.ucfirst(strtolower($found['surname']));
		$offender_id = $id;
		
		break;	
	case'resource': 
		$reportAbout='Resource'; 
		$var= new database_query($pdo,'document_resources'); 
		$search = ['resource_id'=>$id]; 
		$found = $var->selectcols($search);
		$title = $found['title'];
		$reportAboutId = $id;
		break;
	}

	
	
}

if ($_SERVER['REQUEST_METHOD'] ==='POST'){
	require_once('reportobj.php');
		$reports = new database_query($pdo,'reports');
	$type = $_POST['report']['type'];
	$var=null;
	switch($type){
	case'Topic':
		$topicReport = new topicReport();
		try{
		
			$topicReport->setUserId($userid);
			$topicReport->setTopicId($_POST['report']['id']);
			$topicReport->setType($_POST['report']['type']);
			$topicReport->setReason($_POST['report']['reason']);
			$valid = $topicReport->save($reports);
				if(!$valid){
					throw new Exception("Report not submitted please try again");
					
				}
		}catch(exception $e){
			$error = $e->getMessage();
		}
		
	 break;	

	case'Offender':
		$offenderReport = new offenderReport();
		try{
			
			$offenderReport->setUserId($userid);
			$offenderReport->setOffenderId($_POST['report']['user_id']);
			$offenderReport->setType($_POST['report']['type']);
			$offenderReport->setReason($_POST['report']['reason']);
			$valid = $offenderReport->save($reports);
				if(!$valid){
					throw new Exception("Report not submitted please try again");
					
				}
		}catch(exception $e){
			$error = $e->getMessage();
		}
	break;	
	case'Resource': 
		$resourceReport = new resourceReport();
		try{
			
			$resourceReport->setUserId($userid);
			$resourceReport->setResourceId($_POST['report']['id']);
			$resourceReport->setType($_POST['report']['type']);
			$resourceReport->setReason($_POST['report']['reason']);
			$valid = $resourceReport->save($reports);
				if(!$valid){
					throw new Exception("Report not submitted please try again");
				}
		}catch(exception $e){
			$error = $e->getMessage();
		}
	break;
	}

}


$templateVars = [
'type'=> $_POST['report']['type'] ?? $reportAbout,
'errormsg'=>$error ,
'resourceTitle' => $_POST['report']['title'] ?? $title,
'resource_id' => $_POST['report']['id'] ?? $reportAboutId,
'offender'=>  $_POST['report']['offender'] ?? $name,
'offender_id' =>  $_POST['report']['user_id'] ?? $offender_id
];


if($error != null){

$title = 'Report';
$content = loadTemplate('user_writereport_template.php', $templateVars);
}elseif($valid){
	$templateVars = [
		'reply'=>'Thank you',
		'page'=>'summary'
		];
	$title = 'Thankyou';
$content = loadTemplate('user_thankyou_template.php', $templateVars);
}else{
	$title = 'Report';
$content = loadTemplate('user_writereport_template.php', $templateVars);
}



=======
<?php
$userid = $_SESSION['user_id'];
$report = null;
$result = null;
$reportAbout = null;
$reportAboutId = null;
$title = null;
$name = null;
$offender_id = null;
$error = null;
$valid = null;


if ($_SERVER['REQUEST_METHOD'] ==='GET'){
	
	$type = $_GET['source'];
	$id = $_GET['id'];
	$var=null;
	switch($type){
	case'forum': 
		$reportAbout='Topic'; 
		$var= new database_query($pdo,'forum_topics');
		$search = ['topic_id'=>$id]; 
		$found = $var->selectcols($search);
		$title = $found['topic_title'];
		$reportAboutId = $id;
		
		break;	
	case'offender': 
		$reportAbout='Offender'; 
		$var= new database_query($pdo,'users'); 
		$search = ['user_id'=>$id]; 
		$found = $var->selectcols($search);
		$name = ucfirst(strtolower($found['first_name'])).' '.ucfirst(strtolower($found['surname']));
		$offender_id = $id;
		
		break;	
	case'resource': 
		$reportAbout='Resource'; 
		$var= new database_query($pdo,'document_resources'); 
		$search = ['resource_id'=>$id]; 
		$found = $var->selectcols($search);
		$title = $found['title'];
		$reportAboutId = $id;
		break;
	}

	
	
}

if ($_SERVER['REQUEST_METHOD'] ==='POST'){
	require_once('reportobj.php');
		$reports = new database_query($pdo,'reports');
	$type = $_POST['report']['type'];
	$var=null;
	switch($type){
	case'Topic':
		$topicReport = new topicReport();
		try{
		
			$topicReport->setUserId($userid);
			$topicReport->setTopicId($_POST['report']['id']);
			$topicReport->setType($_POST['report']['type']);
			$topicReport->setReason($_POST['report']['reason']);
			$valid = $topicReport->save($reports);
				if(!$valid){
					throw new Exception("Report not submitted please try again");
					
				}
		}catch(exception $e){
			$error = $e->getMessage();
		}
		
	 break;	

	case'Offender':
		$offenderReport = new offenderReport();
		try{
			
			$offenderReport->setUserId($userid);
			$offenderReport->setOffenderId($_POST['report']['user_id']);
			$offenderReport->setType($_POST['report']['type']);
			$offenderReport->setReason($_POST['report']['reason']);
			$valid = $offenderReport->save($reports);
				if(!$valid){
					throw new Exception("Report not submitted please try again");
					
				}
		}catch(exception $e){
			$error = $e->getMessage();
		}
	break;	
	case'Resource': 
		$resourceReport = new resourceReport();
		try{
			
			$resourceReport->setUserId($userid);
			$resourceReport->setResourceId($_POST['report']['id']);
			$resourceReport->setType($_POST['report']['type']);
			$resourceReport->setReason($_POST['report']['reason']);
			$valid = $resourceReport->save($reports);
				if(!$valid){
					throw new Exception("Report not submitted please try again");
				}
		}catch(exception $e){
			$error = $e->getMessage();
		}
	break;
	}

}


$templateVars = [
'type'=> $_POST['report']['type'] ?? $reportAbout,
'errormsg'=>$error ,
'resourceTitle' => $_POST['report']['title'] ?? $title,
'resource_id' => $_POST['report']['id'] ?? $reportAboutId,
'offender'=>  $_POST['report']['offender'] ?? $name,
'offender_id' =>  $_POST['report']['user_id'] ?? $offender_id
];


if($error != null){

$title = 'Report';
$content = loadTemplate('user_writereport_template.php', $templateVars);
}elseif($valid){
	$templateVars = [
		'reply'=>'Thank you',
		'page'=>'summary'
		];
	$title = 'Thankyou';
$content = loadTemplate('user_thankyou_template.php', $templateVars);
}else{
	$title = 'Report';
$content = loadTemplate('user_writereport_template.php', $templateVars);
}



>>>>>>> origin/master
?>