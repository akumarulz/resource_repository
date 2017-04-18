<<<<<<< HEAD
<?php
class friendsobj{
    private $friendsRowId;
    private $reciever_id;
    private $from_user_id;
    private $conn;

    //setters
    public function setRowId(int $id){
        $this->friendsRowId = $id;
    }
    public function setRecieverid(int $id){
        $this->reciever_id = $id;
    }
    public function setFromid(int $id){
        $this->from_user_id = $id;
    }
    public function setConn(database_query $conn){
        $this->conn = $conn;

    }


    public function checkforfriends(){
        $temp =[
            'user_id' => $this->reciever_id,
            'has_friend' => $this->from_user_id
        ];
        return $this->conn->findfriendsV2($temp);
    }

    public function save(){
        $temp =[
            'user_id' => $this->reciever_id,
            'has_friend' => $this->from_user_id
        ];
        return $this->conn->save($temp,'');
    }
    public function unfriend():bool{
        $temp=[
            'id'=>$this->friendsRowId
        ];
        return $this->conn->remove($temp);
    }
}

=======
<?php
class friendsobj{
    private $friendsRowId;
    private $reciever_id;
    private $from_user_id;
    private $conn;

    //setters
    public function setRowId(int $id){
        $this->friendsRowId = $id;
    }
    public function setRecieverid(int $id){
        $this->reciever_id = $id;
    }
    public function setFromid(int $id){
        $this->from_user_id = $id;
    }
    public function setConn(database_query $conn){
        $this->conn = $conn;

    }


    public function checkforfriends(){
        $temp =[
            'user_id' => $this->reciever_id,
            'has_friend' => $this->from_user_id
        ];
        return $this->conn->findfriendsV2($temp);
    }

    public function save(){
        $temp =[
            'user_id' => $this->reciever_id,
            'has_friend' => $this->from_user_id
        ];
        return $this->conn->save($temp,'');
    }
    public function unfriend():bool{
        $temp=[
            'id'=>$this->friendsRowId
        ];
        return $this->conn->remove($temp);
    }
}

>>>>>>> origin/master
?>