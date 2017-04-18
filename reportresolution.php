<<<<<<< HEAD
<?php
	$report = new database_query($pdo,'reports');
if(strtoupper($_SERVER['REQUEST_METHOD']) === 'POST' && $_POST['report']['close']=='Confirm') {
	
	$type = $_POST['report']['type'];
	$report_id = $_POST['report']['report_id'];
	$user_id = $_POST['report']['user_id'];
	$reported_id = $_POST['report']['reported_id'];
	
 

	$reply = null;
	switch($type){
		case 'Offender': 
			//block user from site by adding to blocked_users_table
			$var = new database_query($pdo,'blocked_users_table');
			
				//search table to see if users is already blocked
			$block = ['user_id'=>$reported_id];
			$found = $var->selectcols($block);
			
			if($user_id != $reported_id){
			//if not found then add them
				if(!$found){
					$complete = $var->save($block,'');
					if(!$complete){
						
						$reply = 'Error completing task';
					}else{
						$reply = 'Member Blocked from site';
						
						$update_report = new reportobj();
						$update_report->setConn($report);
						$update_report->closeReport($report_id,$user_id);
					}
				}else{
					$reply = 'Member Already Blocked';
				}
			}else{
				$reply = 'Cannot block yourself';
			}
		break;
		
		case 'Resource':
			//block all users from resource by archiving discussion and remove resource
			$var = new database_query($pdo,'document_resources');
			$get = ['resource_id'=>$reported_id];
			$found = $var->selectcols($get);
			
				if($found['file_type'] == 'url' && $found['blocked_users'] != 'ARCHIVED' ){
					
					//remove url and prevent resource showing in search results
					//remove all comments from database
					$archive = ['resource_id'=>$reported_id, 'url_address'=>'', 'blocked_users'=>'ARCHIVED' ];
					$complete = $var->save($archive,'resource_id');
					if(!$complete){
						
						$reply = 'Error completing task';
					}else{
						
						$reply = 'URL removed and discussion archived';

						$update_report = new reportobj();
						$update_report->setConn($report);
						$update_report->closeReport($report_id,$user_id);
					}
				}elseif ($found['file_type'] != 'url' && $found['blocked_users'] != 'ARCHIVED' ){
					//remove file contents in blob and archieve 
					$archive = ['resource_id'=>$reported_id, 'filecontent'=>'', 'blocked_users'=>'ARCHIVED' ];
					$complete = $var->save($archive,'resource_id');
					if(!$complete){
						
						$reply = 'Error completing task';
					}else{
						$reply = 'resource removed and discussion archived';
						$update_report = new reportobj();
						$update_report->setConn($report);
						$update_report->closeReport($report_id,$user_id);
					}
					
				}else{
					$reply = 'Resource already archived';
				}
			
		break;
		case 'Topic':
			//remove topic from search results by archiving 
			$var = new database_query($pdo,'forum_topics');
			
			//check if already archived
			$check = ['topic_id'=>$reported_id];
		
			$found = $var->selectcols($check);
			
			if($found['blocked_users'] != 'ARCHIVED'){
				$archived = ['topic_id'=>$reported_id, 'blocked_users'=>'ARCHIVED']; 
				$complete = $var->save($archived,'topic_id');
				if(!$complete){
							
							$reply = 'Error completing task';
						}else{
							$reply = 'Topic archived';
							$update_report = new reportobj();
						$update_report->setConn($report);
						$update_report->closeReport($report_id,$user_id);
						}
			}else{
				$rely = 'Topic already archived';
			}
		break;
	}
}

if(strtoupper($_SERVER['REQUEST_METHOD']) === 'POST' && $_POST['report']['close']=='Close') {
	
	$report_id = $_POST['report']['report_id'];
	$user_id = $_POST['report']['user_id'];
	
		$update_report = new reportobj();
		$update_report->setConn($report);
		$complete = $update_report->closeReport($report_id,$user_id);
		
	if ($complete){
		$reply = 'Report closed';
	}else{
		$reply = 'error';
	}
}
		$templateVars = [
				'page'=>'Reports',
				'reply'=>$reply
			];

			$title = 'Resolve';
			$content = loadTemplate('user_thankyou_template.php', $templateVars);
	
=======
<?php
	$report = new database_query($pdo,'reports');
if(strtoupper($_SERVER['REQUEST_METHOD']) === 'POST' && $_POST['report']['close']=='Confirm') {
	
	$type = $_POST['report']['type'];
	$report_id = $_POST['report']['report_id'];
	$user_id = $_POST['report']['user_id'];
	$reported_id = $_POST['report']['reported_id'];
	
 

	$reply = null;
	switch($type){
		case 'Offender': 
			//block user from site by adding to blocked_users_table
			$var = new database_query($pdo,'blocked_users_table');
			
				//search table to see if users is already blocked
			$block = ['user_id'=>$reported_id];
			$found = $var->selectcols($block);
			
			if($user_id != $reported_id){
			//if not found then add them
				if(!$found){
					$complete = $var->save($block,'');
					if(!$complete){
						
						$reply = 'Error completing task';
					}else{
						$reply = 'Member Blocked from site';
						
						$update_report = new reportobj();
						$update_report->setConn($report);
						$update_report->closeReport($report_id,$user_id);
					}
				}else{
					$reply = 'Member Already Blocked';
				}
			}else{
				$reply = 'Cannot block yourself';
			}
		break;
		
		case 'Resource':
			//block all users from resource by archiving discussion and remove resource
			$var = new database_query($pdo,'document_resources');
			$get = ['resource_id'=>$reported_id];
			$found = $var->selectcols($get);
			
				if($found['file_type'] == 'url' && $found['blocked_users'] != 'ARCHIVED' ){
					
					//remove url and prevent resource showing in search results
					//remove all comments from database
					$archive = ['resource_id'=>$reported_id, 'url_address'=>'', 'blocked_users'=>'ARCHIVED' ];
					$complete = $var->save($archive,'resource_id');
					if(!$complete){
						
						$reply = 'Error completing task';
					}else{
						
						$reply = 'URL removed and discussion archived';

						$update_report = new reportobj();
						$update_report->setConn($report);
						$update_report->closeReport($report_id,$user_id);
					}
				}elseif ($found['file_type'] != 'url' && $found['blocked_users'] != 'ARCHIVED' ){
					//remove file contents in blob and archieve 
					$archive = ['resource_id'=>$reported_id, 'filecontent'=>'', 'blocked_users'=>'ARCHIVED' ];
					$complete = $var->save($archive,'resource_id');
					if(!$complete){
						
						$reply = 'Error completing task';
					}else{
						$reply = 'resource removed and discussion archived';
						$update_report = new reportobj();
						$update_report->setConn($report);
						$update_report->closeReport($report_id,$user_id);
					}
					
				}else{
					$reply = 'Resource already archived';
				}
			
		break;
		case 'Topic':
			//remove topic from search results by archiving 
			$var = new database_query($pdo,'forum_topics');
			
			//check if already archived
			$check = ['topic_id'=>$reported_id];
		
			$found = $var->selectcols($check);
			
			if($found['blocked_users'] != 'ARCHIVED'){
				$archived = ['topic_id'=>$reported_id, 'blocked_users'=>'ARCHIVED']; 
				$complete = $var->save($archived,'topic_id');
				if(!$complete){
							
							$reply = 'Error completing task';
						}else{
							$reply = 'Topic archived';
							$update_report = new reportobj();
						$update_report->setConn($report);
						$update_report->closeReport($report_id,$user_id);
						}
			}else{
				$rely = 'Topic already archived';
			}
		break;
	}
}

if(strtoupper($_SERVER['REQUEST_METHOD']) === 'POST' && $_POST['report']['close']=='Close') {
	
	$report_id = $_POST['report']['report_id'];
	$user_id = $_POST['report']['user_id'];
	
		$update_report = new reportobj();
		$update_report->setConn($report);
		$complete = $update_report->closeReport($report_id,$user_id);
		
	if ($complete){
		$reply = 'Report closed';
	}else{
		$reply = 'error';
	}
}
		$templateVars = [
				'page'=>'Reports',
				'reply'=>$reply
			];

			$title = 'Resolve';
			$content = loadTemplate('user_thankyou_template.php', $templateVars);
	
>>>>>>> origin/master
?>