<?php
class commentobj{
private $comment_id;
private $resource_id;
private $user_id;
private $topic_id;
private $comment;
private $comment_reply_id;
private $connect;

private function validate(string $str):bool{
    if (trim($str) != true || !preg_match("/^[a-zA-Z0-9.,;:+-?@()£$&!'#<>\r\n ]*$/", $str) || ctype_space($str)) {
	    return false;
	}else{
        return true;
    }
}

//setters
public function setComment_id(int $id){
    $this->comment_id = $id;
}
public function setResourceid(int $resourceid){
$this->resource_id = $resourceid;
}
public function setUserid(int $userid){
    $this->user_id = $userid;
}
public function setTopicid(int $topicid){
    $this->topic_id = $topicid;
}
public function setComment(string $comment){
    $valid = $this->validate($comment);
    if($valid){
        $this->comment = $comment;
    }else{
        throw new Exception("Comment error please try again");
        
    }
}
public function setReply(int $reply){
    $this->comment_reply_id = $reply;
}
public function setConnection(database_query $conn){
    $this->connect = $conn;
}
    public function saveRcomment(){
        $temp = array();
        $temp['resource_id'] = $this->resource_id;
        $temp['user_id'] = $this->user_id;
        $temp['comment'] = $this->comment;
        if($this->comment_reply_id != null){
            $temp['comment_reply_id'] = $this->comment_reply_id;
        }
       
        return $this->connect->save($temp,'');
    }

    public function saveTcomment(){
        $temp = array();
        $temp['forum_id'] = $this->topic_id;
        $temp['user_id'] = $this->user_id;
        $temp['comment'] = $this->comment;
            if($this->comment_reply_id != null){
            $temp['comment_reply_id'] = $this->comment_reply_id;
        }
       
        return $this->connect->save($temp,'');
    }

    public function removeComment(){
        $temp = array();
        $temp['comment_id'] = $this->comment_id;
        return $this->connect->remove($temp);
    }

}
?>