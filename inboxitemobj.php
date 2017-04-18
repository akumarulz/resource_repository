<?php
class inboxitemobj{
private $item=[];
private $conn;
private $user_id;
private $reciever;
private $sender;
private $title;
private $message;
private $messageid;


	private function ValidateTitle($str){
		if(trim($str) != true || !preg_match("/^[a-zA-Z0-9.,;:+-?@()£$&!'#<> ]*$/", $str) || ctype_space($str)){
					return false; 
				}else{
					return true;
				}
	}
	private function ValidateMessage($str){
		if(trim($str) != true || !preg_match("/^[a-zA-Z0-9.,;:+-?@()£$&!'#<>\r\n ]*$/", $str) || ctype_space($str)){
					return false; 
				}else{
					return true;
				}
	}

//setters
public function setMessageid(int $in_messageid){
	$this->messageid = $in_messageid;
}
public function setItem(array $in_item){
	$this->item[] = $in_item;
}
public function setConn(database_query $in_conn){
	$this->conn = $in_conn;
}
public function setUser_id(int $in_userid){
	$this->user_id = $in_userid;
}

public function setReciever(int $in_reciever){
	$this->reciever = $in_reciever;
}
public function setSender(int $in_sender){
	$this->sender = $in_sender;
}
public function setTitle(string $in_title){
	$valid = $this->ValidateTitle($in_title);
	if($valid){
		$this->title = $in_title;
	}else{
		throw new Exception("Error in title, please try again");
	}
}
public function setMessage(string $in_message){
	$valid = $this->Validatemessage($in_message);
	if($valid){
		$this->message = $in_message;
	}else{
		throw new Exception("Error in Message please try again");
	}

}

public function sendMessage(){
	$temp = [
		'reciever_id'=>$this->reciever,
		'sender_id'=>$this->sender,
		'message_title'=>$this->title,
		'message'=>$this->message
	];
	return $this->conn->save($temp,'');
}

public function removeMessage(){
	$temp = [
		'messageid'=>$this->messageid
	];
	return $this->conn->remove($temp);
}
public function setMessageRead(){
	$temp =[
		'messageid'=>$this->messageid,
		'mread'=>1
	];
	return $this->conn->save($temp,'messageid');
}

public function getHTML(){
	$result='<div class="inboxItem"><a href="readmessage?messageid='.$this->item[0]['messageid'].'" >';
		
		$found = $this->conn->select('user_id', $this->item[0]['user_id']);
				$result = $result.'<h3 class="messagetitle">'.substr($this->item[0]['message_title'],0,70).'</h3>';

	$result = $result.'<p >From:<b> '.ucfirst(strtolower($found['first_name'])).' '.ucfirst(strtolower($found['surname'])).'</b>, sent: '.date( 'H:i l jS M Y',strtotime($this->item[0]['date'])).'</p>';
		
		//$result = $result.'<p class="message"> Message: '.wordwrap(substr($this->item[0]['message'],0,50),50 ,"\n",false).' ...</p>';
		
			if($this->item[0]['mread'] == 0){
				$result = $result.'<img class="messageicon" src="images/envelope-closed.png" alt="message not read icon" />';
			}else{
				$result = $result.'<img class="messageicon" src="images/envelope-open.png" alt="message read icon" />';
			}
		
	
	$result=$result.'</a>';
	$result = $result.'<img id="'.$this->user_id.'-'.$this->item[0]['messageid'].'"  class="messageiconbin" src="images/trash-can.png" alt="message delete icon" /></div>';
	
	return $result;
	
	
}
}

?>