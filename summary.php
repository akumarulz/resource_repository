<?php
$userid = $_SESSION['user_id'];

$newusers = array();
$msgsummary = array();
$friendRequest = array();
$recommendations = null;
//find the newest registered users
$newest = new database_join_queries($pdo);
$newestusers = $newest->newestmembers();
$users = new database_query($pdo,'users');
foreach($newestusers as $new){
	$userarray = ['user_id'=>$new['user_id']];
	$result = $users->selectcols($userarray);
	array_push($newusers,$result);
}//-------------------------------------

//get the messages and recent posts in participating topics
$msg = new database_join_queries($pdo);
$msgsrch = ['mread'=> 0,'reciever'=>$userid];
$messages = $msg->getMessage($msgsrch);

foreach($messages as $message){
	
	$ar = ['user_id'=>$message['sender_id']];
	$tempar = $users->selectcols($ar);
	$temp = array();
	$temp['id'] = $message['messageid'].'-'.$userid;
	$temp['type'] = 'message';
	$temp['img'] = $tempar['profilePic'];
	$temp['date'] = $message['date']; //share with topic start date
	$temp['name'] = $tempar['first_name'].' '.$tempar['surname']; //share with latest topic comment
	$temp['title'] = $message['message_title']; // share with topic title
	$temp['message'] = $message['message']; //share with topic comment count
	array_push($msgsummary,$temp);
}
//---------------------------------------

//get all notifications
$notifications = new database_query($pdo,'notifications');
$getnotifications =['reciever_id'=>$userid];
$notes = $notifications->selectcol($getnotifications);
if($notes){
	foreach($notes as $note){
		if($note['accept'] == 'BLOCK'){
			continue;
		}
		$ar = ['user_id'=>$note['from_user_id']];
		$tempar = $users->selectcols($ar);
		
		//if the notification is a friend request
		$notemsg = ($note['notification'] == 'Friend request') ? $tempar['title'].' '.ucfirst(strtolower($tempar['first_name'])).' '.ucfirst(strtolower($tempar['surname'])).' has sent 
		a friend request. <a href="'.$note['from_user_id'].'-'.$userid.'-'.$note['id'].'" id="friendAcceptLink">ACCEPT</a>  <a href="'.$userid.'-'.$note['id'].'"  id="friendDeleteLink">DELETE</a> <a href="'.$userid.'-'.$note['id'].'"  id="friendBlockLink" >BLOCK</a>' : '' ;
		
		$temp=array();
		$temp['id'] = $note['id'].'-'.$userid;
		
		$temp['discussion_id']=null;

		//determin the source of the notification, either from a resource or forum discussion
		if($note['resource_id'] != null){
			$temp['discussion_id'] = $note['resource_id'];
		}elseif($note['topic_id'] != null){
			$temp['discussion_id'] = $note['topic_id'];
		}
		
		$temp['accept'] = $note['accept'];
		$temp['type'] = $note['notification'];	 //type of notification
		$temp['img'] = $tempar['profilePic']; 	//image of who the notification is from
		$temp['date']=$note['date'];			//date notification was made
		$temp['name']= ucfirst(strtolower($tempar['first_name'])).' '.ucfirst(strtolower($tempar['surname']));		//name of notification sender
		$temp['title']= $note['title'];
		$temp['message']= ($notemsg == '') ? $note['message'].'('.$note['number_of'].')' :  $notemsg ;
		
		if($note['notification'] == 'Friend request'){
			if($note['accept'] != 'BLOCK'){
			array_push($friendRequest,$temp);
			}		
		}else{
		array_push($msgsummary,$temp);
		}
	}
}

//get friends from friendstable
$findfriends = new database_query($pdo,'friends');
$friendsSearch =['user_id'=>$userid];
	//retrieve friends list 
$friendslist = $findfriends->findfriends($friendsSearch);

$friends = array(array());
$i = 0;
$r =0;

//make this into a stored procedure on workbench
foreach ($friendslist as $friend) {
	if ($friend['user_id'] != $userid){
		$friends[$i][0] = $friend['user_id'];
		$friends[$i][1]= $friend['id'];
	}elseif($friend['has_friend'] != $userid){
		$friends[$i][0]= $friend['has_friend'];
		$friends[$i][1] = $friend['id'];

	}
	$i++;
}

$found_friends = array();

if(sizeof($friendslist) > 0){
	foreach($friends as $retrieve){

		$getfriend = ['user_id' =>$retrieve[0]];
		$f[$r][0] = $users ->selectcols($getfriend);
		$f[$r][1] =  $retrieve[1];
		
		array_push( $found_friends,$f);
		$r++;
	}
}

//check if the user has made any downloads
$csv = new database_query($pdo,'download_history');
$search = ['user_id'=>$userid];
$num = $csv->selectcol($search); 

//only provide recommendations after more than 5 occurances of down loads
if(sizeof($num) > 4){
		//recommender java wsdl access
		
		$wsdl_url = "http://localhost:9999/recommender/services/resourceRecommender?wsdl";
		$client = new SoapClient($wsdl_url);


		//make csv file

		$dl = $csv->selectall();
		//make directory to store user recommendations
		if (!file_exists(dirname(__DIR__).'\\resource_repository\\recommendations')) {
			mkdir(dirname(__DIR__).'\\resource_repository\\recommendations', 0777, true);
		}

		$filename = 'recommendations'.$userid.'.csv';
		$csv_file = dirname(__DIR__).'\\resource_repository\\recommendations\\'.$filename;
		$file = fopen($csv_file,"w+");

		foreach($dl as $row){
			$arr = array($row['user_id'],$row['resource_id'],$row['times_downloaded']);
			$str = implode(',',$arr);
			fputcsv($file,explode(',',$str));
		}
		//get recommendations
		$arr = array(0=>$csv_file,1=>$userid);
		$result = $client->recommendations($arr);
		if($result->recommendationsReturn[0]!= null && $result->recommendationsReturn[1]!= null && $result->recommendationsReturn[2]!= null){
		//get recommender files
		$resources = new database_query($pdo,'document_resources'); 

		$recommendations = array();
		foreach($result->recommendationsReturn as $item){
			//get the resource id
			$recs = explode(',',$item);
			$recs = explode(':',$recs[0]);
			$id = ['resource_id'=>$recs[1]];
			$found = $resources->selectcol($id);

		array_push($recommendations,$found);
		}
	}
		fclose($file);
	
		//chmod($csv_file,0777);
		//unlink($csv_file);
}

$vars = [
'user_id'=>$userid,
'pdo'=>$pdo
];

$templateVars = [
'todo' => $main_summary = loadTemplate('todo_template.php',$vars),
'newusers'=>$newusers,
'summary'=>$msgsummary,
'friendRequest'=>$friendRequest,
'friends'=>$found_friends,
'recommendations'=>$recommendations
];
$title = 'Summary';
$content = loadTemplate('summary_template.php', $templateVars);

?>