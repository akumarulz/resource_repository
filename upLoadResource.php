
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
require_once('cleantext.php');
$user_id = $_SESSION['user_id'];

//get the list of stored subject areas
$subjects = new database_query($pdo,'specialist_subjects');
$retrievedsubjects = $subjects->selectall();
$error = null;
$found=null;
$form=null;
$reply = null;
$title = 'Upload File';
$result = null;
$newcommentTable = new database_join_queries($pdo);
$conn = new database_query($pdo,'document_resources');
$resourceId = null;

if (strtoupper($_SERVER['REQUEST_METHOD']) ==='GET'){
	if(isset($_GET['resource_id'])){
				
				$found = $conn->select('resource_id',$_GET['resource_id']);
				$form = 'editDoc';
				$title ='Edit uploaded file';
				$resourceId = $_GET['resource_id'];
			}
}

if (strtoupper($_SERVER['REQUEST_METHOD']) ==='POST'){
	
	//displaying an uploaded resource details
		
		require_once('resource.php');
		try{
			$newResource = new resourcedocument ();

			if($_POST['resourcedoc']['resource_id'] != ''){
				$form = 'editDoc';
				$found = $_POST['resourcedoc'];
				$newResource->setResource_id($_POST['resourcedoc']['resource_id']);
				$newResource->setUser_id($user_id);
				$newResource->setCategory_id($_POST['resourcedoc']['subject']);
				$newResource->setTitle(cleantext($_POST['resourcedoc']['title']));
				$newResource->setDescription(cleantext($_POST['resourcedoc']['description']));
				$newResource->setConnection($conn);

				if($_FILES['resourcedoc']['error'] != 4 ){
					 $finfo = finfo_open(FILEINFO_MIME_TYPE);
    				$in_mime = finfo_file($finfo, $_FILES['resourcedoc']['tmp_name']);
					finfo_close($finfo);
					$newResource->setFilename($_FILES['resourcedoc']['name']);
					$newResource->setFilesize($_FILES['resourcedoc']['size']);
					$filetype = pathinfo($_FILES['resourcedoc']['name']);
					$newResource->setFiletype($filetype['extension'],$in_mime);
					$newResource->setFilecontents(file_get_contents($_FILES['resourcedoc']['tmp_name']));
						$result = $newResource->updateResource(1);
					}else{
						$result = $newResource->updateResource();
					}

			}elseif($_FILES['resourcedoc']['tmp_name'] != null){

				 $finfo = finfo_open(FILEINFO_MIME_TYPE);
    			$in_mime = finfo_file($finfo, $_FILES['resourcedoc']['tmp_name']);
				finfo_close($finfo);
				$date = $newResource->getDate();	
			
				$newResource->setUser_id($user_id);
				$newResource->setCategory_id($_POST['resourcedoc']['subject']);
				$newResource->setTitle(cleantext($_POST['resourcedoc']['title']));
				$newResource->setDescription(cleantext($_POST['resourcedoc']['description']));

					$newResource->setFilename($_FILES['resourcedoc']['name']);
					$newResource->setFilecontents(file_get_contents($_FILES['resourcedoc']['tmp_name']));
						$filetype = pathinfo($_FILES['resourcedoc']['name']);
					$newResource->setFiletype($filetype['extension'],$in_mime);
					$newResource->setFilesize($_FILES['resourcedoc']['size']);
						
					$newResource->setConnection($conn);

					$result = $newResource->saveResource();
					}

				if(!$result){
					throw new Exception ('Error uploading file, please try again');
				}

		}catch(Exception $e){
			$error = 'An error occurred '.$e->getMessage();
		}
}
		
							if($result){
								if($form == null){
										$array2 =['date'=>$date];
										
										$fileID = $conn->selectcols($array2);
										
										if($fileID){
											//send notifications
											
											echo '<script>
											sendNotifications('.$user_id.','.$fileID['resource_id'].','.$fileID['category_id'].');
											</script>';

											$reply = 'File uploaded';
										
										}
								}else{
									$reply = 'Updated';
								}
							}
			

if($error != null){
	//variable to pass to template
$templateVars = [
'subjects'=>$retrievedsubjects,
'editResource'=>$found,
'error'=>$error,
'submitError'=>$_POST
];


$content = loadTemplate('UpLoadResource_template.php', $templateVars);
	
	
}elseif($reply == 'File uploaded' || $reply=='Updated'){
	$templateVars = [
	'page' =>'summary',
	'reply'=>$reply
	];


$content = loadTemplate('user_thankyou_template.php', $templateVars);
	
	
}else{
	$templateVars = [
	
		'subjects'=>$retrievedsubjects,
		'editResource'=>$found,
		'formName'=>$form,
		'submitError'=>$_POST
	];


$content = loadTemplate('UpLoadResource_template.php', $templateVars);
	
}


?>