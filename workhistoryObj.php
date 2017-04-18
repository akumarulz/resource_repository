<<<<<<< HEAD
<?php
class workhistoryObj{
private $workhistoryArray = [];
private $user;
private $visitor;
private $conn;
private $est;
private $workfrom;
private $workto;
private $current;
private $ID;

private function ValidateEst(string $str){
	if($str!='' && !ctype_space($str) && preg_match("/[a-zA-Z0-9 ]/", $str)){
		return true;
	}else{
		return false;
	}
}

private function ValidateDate(string $str){
	$date = dateTime::createFromFormat('Y-m-d',$str);
		if($date === false){
			return false;
		}else{
			return true;
		}
}

//setters
public function setID(int $id){
	$this->ID = $id;
}
public function setConn(database_query $in_conn){
	$this->conn = $in_conn;
}
public function setHistory(Array $in_work){
	$this->workhistoryArray[] = $in_work;
}
public function setUser(int $in_user){
		$this->user = $in_user;
}
public function setVisitor(int $in_visitor){
$this->visitor = $in_visitor;
}
public function setEst(string $in_est){
	$valid = $this->ValidateEst($in_est);
	if($valid){
		$this->est = $in_est;
	}else{
		throw new Exception("Empty String or illegal characters used, A-Z 0-9 only");
		
	}
	
}
public function setWF(string $in_WF){
	$valid = $this->ValidateDate($in_WF);
	if($valid){
		if($in_WF > date("Y-m-d")){
			throw new Exception("Start date is before current date");
			
		}else{
			$this->workfrom = $in_WF;
		}
	}else{
		throw new Exception("Incorrect date format yyyy/mm/dd only");
	}
	
}
public function setWT(string $in_WT){
	$valid = $this->ValidateDate($in_WT);
	if($valid){
		if($in_WT < $this->workfrom ){
			throw new Exception("Start date is after end date");
		}else{
			$this->workto = $in_WT;
		}
	}else{
			throw new Exception("Incorrect date format yyyy/mm/dd only");
	}
	
}
public function setCurrent(string $in_current = "Current"){
	$this->current = $in_current;
	$this->workto = null;

}

public function save(){
	$temp = array();
	$temp['user_id'] = $this->user;
	$temp['establishment'] = $this->est;
	$temp['workFrom'] = $this->workfrom;
	$temp['workTo'] = $this->workto;
	if($this->current != null){
	$temp['current'] = $this->current;
	}
	return $this->conn->save($temp,'');
}
public function remove(){
	$temp = array();
	$temp['rowid']=$this->ID;
	return $this->conn->remove($temp);
}
	public function getHTML(){
	$result = '<div class="profile_work_history">';
	
		foreach ($this->workhistoryArray as $object){
			foreach($object as $row){
			
				$result = $result.'<div class="profile_work_history_list_div">';
				if($this->user == $this->visitor){
					$result = $result.'<img id="'.$row['rowid'].'-removeworkhistory.php-'.$this->user.'" class="cancel_icon" src="images/cancel.png" alt="a cross to remove this item" />';	
				}
				$result = $result.'<p><b>'.$row['establishment'].'</b></p>';
				$current = ($row['current'] != null) ? $row['current'] : date("M y",strtotime($row['workTo']));
				$result = $result.'<p>'.date("M y",strtotime($row['workFrom'])) .' - '.$current.'</p>';
				$result = $result.'</div>';
			}
		}
	
	$result = $result.'</div>';
	return $result;
	
	
	}

	
}

?>
=======
<?php
class workhistoryObj{
private $workhistoryArray = [];
private $user;
private $visitor;
private $conn;
private $est;
private $workfrom;
private $workto;
private $current;
private $ID;

private function ValidateEst(string $str){
	if($str!='' && !ctype_space($str) && preg_match("/[a-zA-Z0-9 ]/", $str)){
		return true;
	}else{
		return false;
	}
}

private function ValidateDate(string $str){
	$date = dateTime::createFromFormat('Y-m-d',$str);
		if($date === false){
			return false;
		}else{
			return true;
		}
}

//setters
public function setID(int $id){
	$this->ID = $id;
}
public function setConn(database_query $in_conn){
	$this->conn = $in_conn;
}
public function setHistory(Array $in_work){
	$this->workhistoryArray[] = $in_work;
}
public function setUser(int $in_user){
		$this->user = $in_user;
}
public function setVisitor(int $in_visitor){
$this->visitor = $in_visitor;
}
public function setEst(string $in_est){
	$valid = $this->ValidateEst($in_est);
	if($valid){
		$this->est = $in_est;
	}else{
		throw new Exception("Empty String or illegal characters used, A-Z 0-9 only");
		
	}
	
}
public function setWF(string $in_WF){
	$valid = $this->ValidateDate($in_WF);
	if($valid){
		if($in_WF > date("Y-m-d")){
			throw new Exception("Start date is before current date");
			
		}else{
			$this->workfrom = $in_WF;
		}
	}else{
		throw new Exception("Incorrect date format yyyy/mm/dd only");
	}
	
}
public function setWT(string $in_WT){
	$valid = $this->ValidateDate($in_WT);
	if($valid){
		if($in_WT < $this->workfrom ){
			throw new Exception("Start date is after end date");
		}else{
			$this->workto = $in_WT;
		}
	}else{
			throw new Exception("Incorrect date format yyyy/mm/dd only");
	}
	
}
public function setCurrent(string $in_current = "Current"){
	$this->current = $in_current;
	$this->workto = null;

}

public function save(){
	$temp = array();
	$temp['user_id'] = $this->user;
	$temp['establishment'] = $this->est;
	$temp['workFrom'] = $this->workfrom;
	$temp['workTo'] = $this->workto;
	if($this->current != null){
	$temp['current'] = $this->current;
	}
	return $this->conn->save($temp,'');
}
public function remove(){
	$temp = array();
	$temp['rowid']=$this->ID;
	return $this->conn->remove($temp);
}
	public function getHTML(){
	$result = '<div class="profile_work_history">';
	
		foreach ($this->workhistoryArray as $object){
			foreach($object as $row){
			
				$result = $result.'<div class="profile_work_history_list_div">';
				if($this->user == $this->visitor){
					$result = $result.'<img id="'.$row['rowid'].'-removeworkhistory.php-'.$this->user.'" class="cancel_icon" src="images/cancel.png" alt="a cross to remove this item" />';	
				}
				$result = $result.'<p><b>'.$row['establishment'].'</b></p>';
				$current = ($row['current'] != null) ? $row['current'] : date("M y",strtotime($row['workTo']));
				$result = $result.'<p>'.date("M y",strtotime($row['workFrom'])) .' - '.$current.'</p>';
				$result = $result.'</div>';
			}
		}
	
	$result = $result.'</div>';
	return $result;
	
	
	}

	
}

?>
>>>>>>> origin/master
