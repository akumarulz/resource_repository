<?php
class notificationobj{
private $notificationid;
private $recieverId;
private $resourceId;
private $topicId;
private $from_userId;
private $notification;
private $title;
private $accept;
private $noteRead;
private $date;
private $numberOf;
private $message;
private $conn;
private $column;


//setters
public function setNotificationId(int $id){
    $this->notificationid = $id;
}
public function setColumn(string $str){
    $this->column = $str;
}
public function setReciever(int $id){
    $this->recieverId = $id;
}
public function setResourceId(int $id){
    $this->resourceId = $id;
}
public function setTopicId(int $id){
     $this->topicId = $id;
}
public function setSenderId(int $id){
     $this->from_userId = $id;
}
public function setNotification(string $str){
     $this->notification = $str;
}
public function setTitle(string $str){
     $this->title = $str;
}
public function setAccept(int $int){
    $this->accept = $int;
}
public function setNoteRead(int $int){
    $this->noteRead = $int;
}
public function setnumberOf(int $int){
    $this->numberOf = $int;
}
public function setMessage(string $str){
    $this->message = $str;
}
public function setConn(database_query $in_conn){
    $this->conn = $in_conn;
}

//checker functions
public function CheckIfBlocked(){
    $source =  $this->topicId ?? $this->resourceId;

    $temp =[
        
        'reciever_id' => $this->recieverId,
        'column'=> $this->column,
        'source'=>$source,
        'accept'=>$this->accept
    ];
    return $this->conn->checkForBlock($temp);
}

public function increaseNumberOf(){
     $source =  $this->topicId ?? $this->resourceId;
     $temp =[
        'reciever_id' => $this->recieverId,
        'column' =>$this->column,
        'source' => $source,       
        'from_user_id' => $this->from_userId,       
     ];
    
     $result = $this->conn->findNotification($temp);
    
     if($result){
        $inc=[
            'id'=>$result['id'],
            'number_of' =>$result['number_of']+1
        ];
        return $this->conn->update($inc,'id');
     }else{
        return 'NOT FOUND';
     }
}


//save functions
public function saveNotification(){
    $source =  $this->topicId ?? $this->resourceId;
    $notification = ($this->topicId != null) ? 'Forum Comment' : 'Resource Comment';
    $temp =[
        'reciever_id' => $this->recieverId,
        'from_user_id'=>$this->from_userId,
         $this->column => $source,
        'notification' =>$notification,
        'title'=>$this->title,
        'message'=>$this->message,
        'number_of'=> 1,
    ];
   
    return $this->conn->save($temp,'');

}

public function saveFriendRequestNotification(){
$temp =[
        'reciever_id' => $this->recieverId,
        'from_user_id' =>$this->from_userId,
        'notification' =>$this->notification,
        'title'=>'Friend request', 
        'message'=>'New friend request' //try and includ href tag
      ];
    return $this->conn->save($temp,'');
}
public function checkforfriendsNotification(){
    $temp =[
        'reciever_id' => $this->recieverId,
        'from_user_id' =>$this->from_userId,
        'column'=>'notification',
        'source' =>$this->notification
      ];
     return $this->conn->findNotification($temp);
}

public function RemoveNotification(){
    $temp =[
        'id'=>$this->notificationid,
    ];
    return $this->conn->remove($temp);
}
public function block(){
    //1 = unblock 2 = block
    $temp =[
        'id' =>$this->notificationid,
        'accept' => 2
    ];
  return  $this->conn->save($temp,'id');
}
public function unblock():bool{
     //1 = unblock 2 = block
    $temp =[
        'id'=> $this->notificationid,
        'accept'=> 1
    ];
    return $this->conn->save($temp,'id');
}

public function findBlockedMembers(){
    $temp=[
        'reciever'=> $this->recieverId,
        'accept'=> 2,
        'notification' => $this->notification
    ];
    return $this->conn->findBlockedFriendrequest($temp);
}
}
?>