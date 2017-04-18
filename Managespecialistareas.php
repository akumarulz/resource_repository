<?php
	require_once('cleantext.php');
	$adminuserid = $_SESSION['user_id'];
	$reply=null;
	$table = new database_query($pdo,'specialist_subjects');
	
	if($_SESSION['is_admin'] =='Y'){
		if($_SERVER["REQUEST_METHOD"] == "POST"){
			
			//change text routine
			if(isset($_POST['specialist_area']['edit'])){
				
				if(trim($_POST['specialist_area']['specialist_area']) !='' && preg_match("/^[a-zA-Z0-9.,;:+-?@()£$&!# ]*$/",$_POST['specialist_area']['specialist_area']) && !ctype_space($_POST['specialist_area']['specialist_area'])){
					$update = [
					'speciality_id' => $_POST['speciality_id'],
					'specialist_area'=> $_POST['specialist_area']['specialist_area']
					];
					
					$table->save($update,'speciality_id');
					$reply = 'Subject Updated';
				}
			}
			
			//remove specialist area option
			if(isset($_POST['specialist_area']['remove'])){
				$id = $_POST['speciality_id'];
				//check to make sure no resource is linked to subject
				
				$query = 'SELECT * FROM document_resources where category_id = '.$id;
				$stmt = $pdo->query($query);
				$num = $stmt->rowCount();
				
				// if none found then remove subject
				if($num < 1){
				$delete = ['speciality_id' => $id];
				$table->remove($delete);
				$reply = 'Subject Removed';
				}else{
					$reply = 'Cannot remove subject';
				}
				
			}
			
			//add new specialist area
			if(isset($_POST['specialist_area']['add'])){
				
				if(trim($_POST['specialist_area']['specialist_area']) !='' && preg_match("/^[a-zA-Z0-9.,;:+-?@()£$&!# ]*$/",$_POST['specialist_area']['specialist_area']) && !ctype_space($_POST['specialist_area']['specialist_area'])){
					unset($_POST['specialist_area']['add']);
					$table->save($_POST['specialist_area'],'');
					$reply = 'Subject Updated';
				}
				
			}
			
		}
		
		
		
		$result = $table->selectall();
		$templateVars = [
		'adminid'=>$adminuserid,
		'specialist_subjects'=>$result,
		'reply'=>$reply
		];

	$title ='Manage specialist subjects';
	$content = loadTemplate('Managespecialistareas_template.php',$templateVars);
		
	}else{
		$title ='Error';
	$content = loadinnerTemplate('error_template.php');	
	}

?>