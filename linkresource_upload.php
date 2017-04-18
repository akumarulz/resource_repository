<script>

	function sendNotifications (userid,resourceid,categoryid){
	
		var data = new FormData();
		data.append('user_id',userid);
		data.append('resource_id',resourceid);
		data.append('category_id',categoryid);

		var request = new XMLHttpRequest();
		var url = "sendNewNotifications.php";
		
		request.open("POST",url,true);
		request.send(data);
		return false;
};

</script>
<?php

//get the list of stored subject areas
$subjects = new database_query($pdo,'specialist_subjects');
$newcommentTable = new database_join_queries($pdo);
$getResource = new database_query($pdo,'document_resources');
$retrievedsubjects = $subjects->selectall();
$result = null;
$resource=null;
$error=null;
$reply = null;
$user_id = $_SESSION['user_id'];

if (strtoupper($_SERVER['REQUEST_METHOD']) ==='GET'){

	if(isset($_GET['resource_id'])){
		$resource = $getResource->selectFTall('resource_id',$_GET['resource_id']);
	}
}

if (strtoupper($_SERVER['REQUEST_METHOD']) ==='POST' && isset($_POST['link'])){
	
	require_once('resource.php');
	
	

	try{
		$newURL = new resourceURL ();
		if($_POST['link']['resource_id'] > 0){
			$newURL->setResource_id($_POST['link']['resource_id']);
		}
		$newURL->setUser_id($_POST['link']['user_id']);
		$newURL->setCategory_id($_POST['resourcedoc']['subject']);
		$newURL->setTitle($_POST['link']['title']);
		$newURL->setFiletype();
		$newURL->setDescription($_POST['link']['description']);
		$newURL->setUrl($_POST['link']['url_address']);
		$newURL->setConnection($getResource);

		if($_POST['link']['resource_id'] == ''){
			//check new url is not a duplicate
			$resource = $newURL->URLchecker($newURL->getUrl());
				if(!$resource){
					$result = $newURL->saveURL();
					$reply = 'URL Submitted';
					if($result){
						
						//send email Notifications
						$array = ['url_address'=>$_POST['link']['url_address']];
						$Newresource = $getResource->selectcols($array);
						echo '<script>
						sendNotifications('.$user_id.','.$Newresource['resource_id'].','.$Newresource['category_id'].');
						</script>';

					}
					}else{
						throw new Exception ( 'Not Saved, Possible duplicate url submitted');
					}
		}else{
			//updateURL
			$result = $newURL->updateURL();
			if(!$result){
				throw new Exception ( 'Not Saved, please try again');
			}else{
				$reply = 'URL updated';
			}
		}

		}catch(Exception $e){
			$error = $e->getMessage();
		}

}

if($error !=null){
	$templateVars=[
		'msg'=>$error,
		'postedResource'=>$_POST,
		'subjects' => $retrievedsubjects,
		'userID'=>$user_id,
		'resource' =>$resource
	];
	
	$title = 'Link Resources Page';
	$content = loadTemplate('linkresource_upload_template.php', $templateVars);
}elseif($result == true){

		$templateVars = [
		'reply'=>$reply,
		'page'=>'summary'
		];
	$title = 'Thankyou';
	$content = loadTemplate('user_thankyou_template.php', $templateVars);
	
}else{
$templateVars=[
'subjects' => $retrievedsubjects,
'userID'=>$user_id,
'resource' =>$resource
];
$title = 'Link Resources Page';
$content = loadTemplate('linkresource_upload_template.php', $templateVars);
}

?>