<?php
class topicobj{
	private $topic=[];
	private $conn;
	private $num;
	private $title;
	private $description;
	private $user_id;
	private $category;
	private $topicId;
	private $date;
	
	public function __construct($in_topic){
		$this->topic[] = $in_topic;
		
	}

	private function validateTitle($str){
		if (trim($str) != true || !preg_match("/^[a-zA-Z0-9.,;:+-?@()' ]*$/", $str) || ctype_space($str)) {
			return false;	
		}else{
			return true;
		}
	}

	private function validateDesc($str){
		if (trim($str) != true || !preg_match("/^[a-zA-Z0-9.,;:+-?@()£$&!'#<>\r\n ]*$/", $str) || ctype_space($str)) {
			return false;	
		}else{
			return true;
		}
	}
	
	public function setUserId(int $id){
		$this->user_id = $id;
	}
	public function setConn(database_query $in_conn){
		$this->conn = $in_conn;
	}
	public function setNum(database_join_queries $in_num){
		$this->num = $in_num;
	}
	public function setTitle(string $in_title){
		$valid = $this->validateTitle($in_title);
		if($valid){
			$this->title = $in_title;
		}else{
			throw new Exception("Sorry a-zA-Z0-9.,;:+-?@()' characters only");
			}
		
	}
	public function setDesc(string $in_des){
		$valid = $this->validateDesc($in_des);
		if($valid){
		$this->description = $in_des;
		}else{
			throw new Exception("Error Processing Request, please try again");
			
		}
	}
	public function setCategory(string $str){
		$this->category = $str;
	}
public function setTopicId(int $id){
	$this->topicId = $id;
}
public function setDate($date){
	$this->date = $date;
}


public function getDate(){
	return $this->date;
}
public function getTitle():string{
	return $this->title;
}
public function getDesc():string{
	return $this->description;
}
public function getCategory():string{
return $this->category;
}
public function getTopicId():int{
	return $this->topicId;
}

public function save(){
	$temp =[
		'user_id' => $this->user_id,
		'topic_title' => $this->title,
		'topic_description' => $this->description,
		'date' => $this->topic[0]['date'],
		'category' => $this->category,
		'blocked_users'=> 0
	];
	return $this->conn->save($temp,'');
}

public function upDateTopic(){
	$temp =[
		'topic_id' => $this->topicId,
		'topic_title' => $this->title,
		'topic_description' => $this->description,
		'category' => $this->category,
		];
	return $this->conn->save($temp,'topic_id');
}



	public function getHTML(){
		
				$result='<div class="resource_result_div">';
		//get profile picture of
		$array =['user_id'=>$this->topic[0]['user_id']];
		$author = $this->conn->selectcol($array);
		$pic = ($author[0]['profilePic'] != '') ? 'data:image/jpeg;base64,'.base64_encode($author[0]['profilePic']) : 'images/profileavatar.png';
		
		$result = $result.'<img class="profileavatar" src="'.$pic.'" alt="a profile picture" />';
		
		$result = $result.'<a href="selectedForum?topic_id='.$this->topic[0]['topic_id'].'" ><h3>'.wordwrap($this->topic[0]['topic_title'],30,"<br>\n",true).'</h3></a>';
		$result = $result.'<h4>'.$this->topic[0]['category'].'</h4>';

		$result = $result.'<p>Author: <a href="profile&user_id='.$author[0]['user_id'].'">'.ucfirst(strtolower($author[0]['first_name'])).' '.ucfirst(strtolower($author[0]['surname'])).'</a></p>';
		$result = $result.'<p>'.date( 'H:i jS M Y',strtotime($this->topic[0]['date'])).'</p>';
		$result = $result.'<p>'.wordwrap(substr($this->topic[0]['topic_description'],0,50),50 ,"\n",false).'</p>';
			$counter = $this->num->counter('forum_id',$this->topic[0]['topic_id']);
		//var_dump($counter);	
		$result = $result.'<p>Comments('.$counter['NUM'].')</p>';
		$result = $result.'</div>';
		return $result;
		
	}
}

?>