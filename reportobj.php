<?php

interface saveReport{
	public function save(database_query $conn);
}

class reportobj{
	//table
private $items=[];
private $usersConn;
private $topicConn;
private $resourceConn;
	//new report
protected $user_id;
protected $resource_id;
protected $topic_id;
protected $offender_id;
protected $reason;
protected $type;
	//closing report
protected $delt_by;
protected $result;
protected $date_time;


protected function validate($str){
	if(trim($str) != true || !preg_match("/^[a-zA-Z0-9.,;:+-?@()£$&!'#<>\r\n ]*$/", $str) || ctype_space($str)){
			return false;
		}else{
			return true;
		}
}
public function setConn (database_query $conn){
	$this->usersConn = $conn;
}
public function setUserId(int $id){
	$this->user_id = $id;
}
public function setResourceId(int $id){
	$this->resource_id = $id;
}
public function setTopicId(int $id){
	$this->topic_id = $id;
}
public function setOffenderId(int $id){
	$this->offender_id = $id;
}
public function setType(string $str){
	$this->type = $str;
}
public function setReason(string $str){
	$valid = $this->validate($str);
	if ($valid) {
		$this->reason = $str;
	}else{
		throw new Exception("Illegal characters found, please check and try again.");
		
	}
	
}

public function setHTML(array $in_items,database_query $in_usersConn,database_query $in_topicConn, database_query $in_resourceConn){
	$this->items[] = $in_items;
	$this->usersConn = $in_usersConn;
	$this->topicConn = $in_topicConn;
	$this->resourceConn = $in_resourceConn;
}


public function getHTML():string{
	$result = '<table class="reportDisplayTable">';
	$result = $result.'<thead>';
		$result = $result.'<tr>';
			$result = $result.'<th class="reportTableIDcol">Report ID</th>';
			$result = $result.'<th>Submitted</th>';
			$result = $result.'<th>BY</th>';
			$result = $result.'<th>Description</th>';
			$result = $result.'<th>Delt by</th>';
			$result = $result.'<th></th>';
		$result = $result.'</tr>';
	$result = $result.'</thead>';
	$result = $result.'<tbody>';
	
		foreach($this->items as $row){
			foreach($row as $td){
				$findreporter = ['user_id'=>$td['user_id']];
				$foundreporter = $this->usersConn->selectcols($findreporter);
				
				$delt_by = '';
				if($td['delt_by'] >0){
				$findadmin = ['user_id'=>$td['delt_by']];
				$foundadmin = $this->usersConn->selectcols($findadmin);
				$delt_by = ucfirst(strtolower($foundadmin['first_name'])).' '.ucfirst(strtolower($foundadmin['surname'])).' ('.date("d/m/Y", strtotime($td['date_time'])).')';
				}
				$result = $result.'<tr>';
					$result = $result.'<td class="reportTableIDcol">'.$td['report_id'].'</td>';
					$result = $result.'<td>'.date("d/m/Y", strtotime($td['date'])).'</td>';	
					$result = $result.'<td>'.ucfirst(strtolower($foundreporter['first_name'])).' '.ucfirst(strtolower($foundreporter['surname'])).'</td>';
					$result = $result.'<td class = "reportTabledesccol" >'.substr($td['reason'],0,50).'...</td>';
					$result = $result.'<td>'.$delt_by.'</td>';
					$result = $result.'<td><a href="'.htmlspecialchars($_SERVER["PHP_SELF"].'?page=viewreport&reportid='.$td['report_id'].'&user_id='.$td['user_id'].'&delt_by='.$delt_by.'').'"><button>view</button></a></td>';
				$result = $result.'</tr>';
			}
		}
	//foreach end
	$result = $result.'</tbody>';
	
	$result = $result.'</table>';
	return $result;
}

public function closeReport(int $reportId,int $dealtBy){
	$temp =[
		'report_id'=> $reportId,
		'delt_by'=> $dealtBy,
		'date_time'=> date('Y-m-d')
	];
	return $this->usersConn->save($temp,'report_id');
}

}

class resourceReport extends reportobj implements saveReport{

public function save(database_query $conn){
	$temp = [
		'type' => $this->type,
		'user_id' => $this->user_id,
		'resource_id' => $this->resource_id,
		'reason' =>$this->reason,
		'result' => date('Y-m-d h:i:s').' ->Start'
	];
return $conn->save($temp,'');
}

}
class TopicReport extends reportobj implements saveReport{

public function save(database_query $conn){
	$temp = [
		'type' => $this->type,
		'user_id' => $this->user_id,
		'topic_id' => $this->topic_id,
		'reason' =>$this->reason,
		'result' => date('Y-m-d h:i:s').' ->Start'
	];
return $conn->save($temp,'');
}

}
class OffenderReport extends reportobj implements saveReport{

public function save(database_query $conn){
	$temp = [
		'type' => $this->type,
		'user_id' => $this->user_id,
		'offender_id' => $this->offender_id,
		'reason' =>$this->reason,
		'result' => date('Y-m-d h:i:s').' ->Start'
	];
return $conn->save($temp,'');
}

}

?>