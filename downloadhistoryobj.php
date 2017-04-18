<<<<<<< HEAD
<?php

class downloadhistoryobj{
    private $userId;
    private $resourceId;
    private $conn;

    public function setConn(database_query $conn){
        $this->conn = $conn;
    }
    public function setUserid(int $id){
        $this->userId = $id;
    }

    public function setResourceId(int $id){
        $this->resourceId = $id;
    }

    public function insert(){
        //see if the user has downloaded this resource before
        $temp = [
             'user_id' => $this->userId,
            'resource_id'=> $this->resourceId
        ];
        $found = $this->conn->findDownloads($temp);
       
        if(!$found){
            // if not found then save a new entry
            $temp =[
                'user_id' => $this->userId,
                'resource_id'=> $this->resourceId,
                'times_downloaded' => 1
            ];
        return $this->conn->save($temp,'');
        }else{
            //other wise increase the old entry by one
            $temp = [
                'id'=>$found['id'],
                'times_downloaded'=>$found['times_downloaded']+1,
                'date'=>date("Y-m-d h:i:s")
            ];
        return $this->conn->save($temp,'id');
        }
    }
}


=======
<?php

class downloadhistoryobj{
    private $userId;
    private $resourceId;
    private $conn;

    public function setConn(database_query $conn){
        $this->conn = $conn;
    }
    public function setUserid(int $id){
        $this->userId = $id;
    }

    public function setResourceId(int $id){
        $this->resourceId = $id;
    }

    public function insert(){
        //see if the user has downloaded this resource before
        $temp = [
             'user_id' => $this->userId,
            'resource_id'=> $this->resourceId
        ];
        $found = $this->conn->findDownloads($temp);
       
        if(!$found){
            // if not found then save a new entry
            $temp =[
                'user_id' => $this->userId,
                'resource_id'=> $this->resourceId,
                'times_downloaded' => 1
            ];
        return $this->conn->save($temp,'');
        }else{
            //other wise increase the old entry by one
            $temp = [
                'id'=>$found['id'],
                'times_downloaded'=>$found['times_downloaded']+1,
                'date'=>date("Y-m-d h:i:s")
            ];
        return $this->conn->save($temp,'id');
        }
    }
}


>>>>>>> origin/master
?>