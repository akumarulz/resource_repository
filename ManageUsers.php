<?php
require_once('cleantext.php');
$adminuserid = $_SESSION['user_id'];
$reply=null;

if($_SESSION['is_admin'] =='Y'){
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		if($_POST['block']['user'] != $adminuserid){
	
				//allow a user back to the site
				if ($_POST['block']['searchtype']=='bringback' && $_POST['block']['confirmuser']==1){
					$var = new database_query($pdo,'users');
					$search =['user_id'=>$_POST['block']['user']];
					$found = $var->selectcols($search);
					if($found){
						//ensure the user has not already been blocked
						$block = new database_query($pdo,'blocked_users_table');
						
						$check = ['user_id'=>$found['user_id']];
						$checked = $block->selectcols($check);
						
						//if the user is found in table remove them
						if($checked){
							$complete = $block->remove($search);
							if($complete){
								$reply = 'User no longer blocked from site';
							}
						}else{
							$reply = 'User not found in blocked users table';
						}
					}else{
							$reply = 'User not found';
						}
				}
				
				//block user from site
				if ($_POST['block']['searchtype']=='all' && $_POST['block']['confirmuser']==1){
					$var = new database_query($pdo,'users');
					$search =['user_id'=>$_POST['block']['user']];
					$found = $var->selectcols($search);
					if($found){
						//ensure the user has not already been blocked
						$block = new database_query($pdo,'blocked_users_table');
						
						$check = ['user_id'=>$found['user_id']];
						$checked = $block->selectcols($check);
						
						//if user has not already been blocked
						if(!$checked){
							$complete = $block->save($search,'');
							if($complete){
								$reply = 'User blocked';
							}
						
						}else{
							$reply = $found['first_name'].' '.$found['surname'].' has already been blocked';
						}
						
					}else{
						$reply = 'Error';
					}
				}
				
				//block from a discussion
				if($_POST['block']['confirmblock']==1 && $_POST['block']['confirmuser']==1){
					
					//remove user from list of blocked users in a discussion
					if($_POST['block']['searchtype']=='backinTopic'){
						
						//find topic
						$var3 = new database_query($pdo,'forum_topics');
							$find = ['topic_id'=>$_POST['block']['id']];
							$found = $var3->selectcols($find);
							if($found){
								$alluser = explode(',',$found['blocked_users']);// explode string to get all users
								
								if(in_array($_POST['block']['user'],$alluser)){ //if user is in array 
									$key = array_search($_POST['block']['user'],$alluser); //search for the key for the users entry
										unset($alluser[$key]); //unset the key value pair
									$array = implode(',',$alluser);
									 
									 // save the string back
										$save = [
										'topic_id'=>$_POST['block']['id'],
										'blocked_users'=>$array
										];
										
										$done = $var3->save($save,'topic_id');
										if($done){
											$reply = 'User removed from block list';
										}
								}
							}else{
									$reply = 'User not found';
							}
						
					}elseif($_POST['block']['searchtype']=='backinResource'){
						
						//find resource
						$var4 = new database_query($pdo,'document_resources');
							$find = ['resource_id'=>$_POST['block']['id']];
							$found = $var4->selectcols($find);
							if($found){
								$alluser = explode(',',$found['blocked_users']);// explode string to get all users
								
								if(in_array($_POST['block']['user'],$alluser)){ //if user is in array 
									$key = array_search($_POST['block']['user'],$alluser); //search for the key for the users entry
										unset($alluser[$key]); //unset the key value pair
									$array = implode(',',$alluser);
									 
									 // save the string back
										$save = [
										'resource_id'=>$_POST['block']['id'],
										'blocked_users'=>$array
										];
										
										$done = $var4->save($save,'resource_id');
										if($done){
											$reply = 'User removed from block list';
										}
								}
							}else{
									$reply = 'User not found';
							}
						
					}else{
					
							$tablename = null;
							if($_POST['block']['searchtype']=='topic_id'){
								$tablename = 'forum_topics';
							}else{
								$tablename = 'document_resources';
							}
							$var = new database_query($pdo,$tablename);
							
							$search =[$_POST['block']['searchtype']=>$_POST['block']['id']];
							
							$result = $var->selectcols($search);
							if($result){
								$allusers = explode(',',$result['blocked_users']);
								
								//only add user to array if not already in it.
								if (!in_array($_POST['block']['user'],$allusers)){
														
									$ar = [
									'tablename'=>cleantext($tablename),
									'blocked'=>cleantext($_POST['block']['user']),
									'idtype'=> cleantext($_POST['block']['searchtype']),
									'id'=>cleantext($_POST['block']['id'])
									];
									
									$var2 = new database_join_queries($pdo);
									$blocked = $var2->block_user($ar);
									
									if($blocked > 0){
										$reply = 'User has been blocked';
									}
									
								}else {
									$reply = 'User already blocked';
									}
							}else{
							$reply = 'Please check and try again';
							}
					}	
				}
		}else{
			$reply='Cannot block yourself';
		}
	}
	$templateVars = [
	'adminid'=>$adminuserid,
	'reply' =>$reply
	];

$title ='Manage Users';
$content = loadTemplate('ManageUsers_template.php',$templateVars);
	
}else{
$title ='Error';
$content = loadinnerTemplate('error_template.php');	
}


?>