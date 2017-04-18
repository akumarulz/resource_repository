<<<<<<< HEAD
<?php
require_once('connect.php');
require_once('autoload.php');
require_once('cleantext.php');
if ($_SERVER['REQUEST_METHOD'] ==='POST'){
	$note = new database_query($pdo,'notifications');
//var_dump($_POST);
	
	$sender_id = $_POST['sender_id'];
	$resourceSourceType = $_POST['source'];
	$sourceid = $_POST['id'];
	$title = null;
	$valid = true;
	$result = null;
	
	//get title
	if($resourceSourceType === 'resource_id'){
		$find = new database_query($pdo,'document_resources');
		$ar=['resource_id'=>$sourceid];
		$fnd = $find->selectcols($ar);
		if($fnd){
			$title = $fnd['title'];
		}
		
	}elseif ($resourceSourceType === 'topic_id'){
		$find = new database_query($pdo,'forum_topics');
		$ar=['topic_id'=>$sourceid];
		$fnd = $find->selectcols($ar);
				if($fnd){
			$title = $fnd['topic_title'];
		}
		
	}else{
		$valid=false;
	}
	
	//get the users' friends table and get all their friends on the list
	
	$var2 = new database_query($pdo,'users');
		$ar=['user_id'=>$sender_id];
	$name = $var2->selectcols($ar);
	
	$findfriends = new database_query($pdo,'friends');
	$friendsSearch =['user_id'=>$sender_id];
	//retrieve friends list 
$friendslist = $findfriends->findfriends($friendsSearch);

$friends = array(array());
$i = 0;
$r = 0;

//make this into a stored procedure on workbench
foreach ($friendslist as $friend) {
	if ($friend['user_id'] != $sender_id){
		$friends[$i][0] = $friend['user_id'];
		$friends[$i][1] = $friend['id'];
	}elseif($friend['has_friend'] != $sender_id){
		$friends[$i][0] = $friend['has_friend'];
		$friends[$i][1] = $friend['id'];
	}
	$i++;
}

	if(sizeof($friends > 0)){
		foreach($friends as $friend){
			//insert notification into friends notification table
				//var_dump($friend[0]);
			
					
				//check if user has blocked notification 
					
					$notification = new notificationobj();
					$notification->setConn($note);

					if($resourceSourceType == 'resource_id'){
						$notification->setResourceId($sourceid);
					}else{
						$notification->setTopicId($sourceid);
					}
					
					$notification->setReciever($friend[0]);
					$notification->setColumn($resourceSourceType);

					//1 = unblocked 2 = blocked
					$notification->setAccept(2);
					
					$chk = $notification->CheckIfBlocked($sender_id);
					
					if(!$chk){
					
								$notification = new notificationobj();
								if($resourceSourceType == 'resource_id'){
								$notification->setResourceId($sourceid);
							}else{
								$notification->setTopicId($sourceid);
							}
							
							$notification->setReciever($friend[0]);
							$notification->setColumn($resourceSourceType);
							$notification->setSenderId($sender_id);
							$notification->setConn($note);
								$result = $notification->increaseNumberOf();
								//var_dump($result);
						}

						
						if($result === 'NOT FOUND'){
						//new notification entry
						
						$notification = new notificationobj();
						$notification->setConn($note);

							if($resourceSourceType == 'resource_id'){
								$notification->setResourceId($sourceid);
							}else{
								$notification->setTopicId($sourceid);
							}
							
							$notification->setReciever($friend[0]);
							$notification->setSenderId($name['user_id']);
							$notification->setColumn($resourceSourceType);
							$notification->setTitle($title);
							
							$notification->setMessage(ucfirst(strtolower($name['first_name'])).' '.ucfirst(strtolower($name['surname'])).', has written a new comment');
							
								$sent = $notification->saveNotification();
								if($sent){
									echo 'new notification sent';
								}else{
									echo 'new not sent';
								}
						}
						
					}
		}
	}


=======
<?php
require_once('connect.php');
require_once('autoload.php');
require_once('cleantext.php');
if ($_SERVER['REQUEST_METHOD'] ==='POST'){
	$note = new database_query($pdo,'notifications');
//var_dump($_POST);
	
	$sender_id = $_POST['sender_id'];
	$resourceSourceType = $_POST['source'];
	$sourceid = $_POST['id'];
	$title = null;
	$valid = true;
	$result = null;
	
	//get title
	if($resourceSourceType === 'resource_id'){
		$find = new database_query($pdo,'document_resources');
		$ar=['resource_id'=>$sourceid];
		$fnd = $find->selectcols($ar);
		if($fnd){
			$title = $fnd['title'];
		}
		
	}elseif ($resourceSourceType === 'topic_id'){
		$find = new database_query($pdo,'forum_topics');
		$ar=['topic_id'=>$sourceid];
		$fnd = $find->selectcols($ar);
				if($fnd){
			$title = $fnd['topic_title'];
		}
		
	}else{
		$valid=false;
	}
	
	//get the users' friends table and get all their friends on the list
	
	$var2 = new database_query($pdo,'users');
		$ar=['user_id'=>$sender_id];
	$name = $var2->selectcols($ar);
	
	$findfriends = new database_query($pdo,'friends');
	$friendsSearch =['user_id'=>$sender_id];
	//retrieve friends list 
$friendslist = $findfriends->findfriends($friendsSearch);

$friends = array(array());
$i = 0;
$r = 0;

//make this into a stored procedure on workbench
foreach ($friendslist as $friend) {
	if ($friend['user_id'] != $sender_id){
		$friends[$i][0] = $friend['user_id'];
		$friends[$i][1] = $friend['id'];
	}elseif($friend['has_friend'] != $sender_id){
		$friends[$i][0] = $friend['has_friend'];
		$friends[$i][1] = $friend['id'];
	}
	$i++;
}

	if(sizeof($friends > 0)){
		foreach($friends as $friend){
			//insert notification into friends notification table
				//var_dump($friend[0]);
			
					
				//check if user has blocked notification 
					
					$notification = new notificationobj();
					$notification->setConn($note);

					if($resourceSourceType == 'resource_id'){
						$notification->setResourceId($sourceid);
					}else{
						$notification->setTopicId($sourceid);
					}
					
					$notification->setReciever($friend[0]);
					$notification->setColumn($resourceSourceType);

					//1 = unblocked 2 = blocked
					$notification->setAccept(2);
					
					$chk = $notification->CheckIfBlocked($sender_id);
					
					if(!$chk){
					
								$notification = new notificationobj();
								if($resourceSourceType == 'resource_id'){
								$notification->setResourceId($sourceid);
							}else{
								$notification->setTopicId($sourceid);
							}
							
							$notification->setReciever($friend[0]);
							$notification->setColumn($resourceSourceType);
							$notification->setSenderId($sender_id);
							$notification->setConn($note);
								$result = $notification->increaseNumberOf();
								//var_dump($result);
						}

						
						if($result === 'NOT FOUND'){
						//new notification entry
						
						$notification = new notificationobj();
						$notification->setConn($note);

							if($resourceSourceType == 'resource_id'){
								$notification->setResourceId($sourceid);
							}else{
								$notification->setTopicId($sourceid);
							}
							
							$notification->setReciever($friend[0]);
							$notification->setSenderId($name['user_id']);
							$notification->setColumn($resourceSourceType);
							$notification->setTitle($title);
							
							$notification->setMessage(ucfirst(strtolower($name['first_name'])).' '.ucfirst(strtolower($name['surname'])).', has written a new comment');
							
								$sent = $notification->saveNotification();
								if($sent){
									echo 'new notification sent';
								}else{
									echo 'new not sent';
								}
						}
						
					}
		}
	}


>>>>>>> origin/master
?>