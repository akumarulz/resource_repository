
<?php
require_once('cleantext.php');
//user id of logged in user
$id = $_SESSION['user_id'];

//connection to resource table
$var = new database_query($pdo,'document_resources');
$column = 'resource_id';
//get the id of the resource selected to create its associated discussion table name
$clean = cleantext($_GET['resource_id']);
$tablename ='discussion';
$get_comments = new database_query($pdo,$tablename);


//get all comments from the table organised by date
$found_comments = $get_comments->getComments($column, $clean);

 //get the details of the resource to display
$result = $var->selectFTall($column,$clean);

 //check if user is blocked from discussion
 $blockedUsers = explode(',',$result[0]['blocked_users']);

 if(in_array('ARCHIVED',$blockedUsers)){
		 $title='Blocked';
		 $content=loadinnerTemplate('error_template.php');

	}elseif(!in_array($id,$blockedUsers)){
 
		 
		//connection to users, user id from comments compared with users' userid to get upto date name information
		$users = new database_query($pdo,'users');

		$templateVars=[
		'id'=>$clean,
		'column'=>$column,
		'resource'=>$result,
		'user_id'=>$id,
		'comments'=> $found_comments,
		'conn'=>$users,
		'is_admin'=>$_SESSION['is_admin'],
		'pdo'=>$pdo
		];

		$title = 'Resource Discussion';

		$content = loadTemplate('resource_discussion_templatev2.php', $templateVars);
 }else{
	 $title ='Blocked';
	 $content = loadinnerTemplate('error_template.php');
 }

?>