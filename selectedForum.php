
<?php
	require_once('cleantext.php');
	$tablename = 'discussion';
	$column = 'forum_id';
	//user id of logged in user
	$id = cleantext($_SESSION['user_id']);
	$var = new database_query($pdo,'forum_topics');
	$varcoms = new database_query($pdo,$tablename);
	$users = new database_query($pdo,'users');
	
	//find the topic and disussion table the user clicked on
	$clean = cleantext($_GET['topic_id']);
	$find = ['Topic_id'=>$clean];
	$found = $var->selectcol($find);
	

	//select all comments by date from comments table
	$result = $varcoms->getComments($column, $clean);
	

	//find user in collection of blocked users
	$blockedusers = explode(',',$found[0]['blocked_users']);
	
	if(in_array('ARCHIVED',$blockedusers)){
		 $title='Blocked';
		 $content=loadinnerTemplate('error_template.php');

	}elseif(!in_array($id,$blockedusers)){
		
		$templateVars = [
		'id'=>$clean,
		'column'=>$column,
		'conn'=>$users,
		'topic'=>$found,
		'userid'=>$id,
		'comments'=>$result,
		'is_admin'=>$_SESSION['is_admin'],
		'tablename'=>$tablename,
		'pdo'=>$pdo
		];

		$title = 'Forum';
		$content = loadTemplate('forum_template.php', $templateVars);

	}else{
		 $title='Blocked';
		 $content=loadinnerTemplate('error_template.php');
	 }

?>