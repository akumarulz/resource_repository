<?php
require 'inboxitemobj.php';
class communicationTest extends PHPUnit\Framework\TestCase{
	public $conn;
	
	public function setUp(){
		$pdo = new PDO("mysql:host=127.0.0.1;dbname=repository","root","");
        $this->conn = new database_query($pdo,'messages');
	}

public function testValidMessage(){
    $message = new inboxitemobj(); 
    try{  
        $message ->setConn($this->conn);
        $message->setSender(79);
        $message->setReciever(77);
        $message->setTitle('title');
        $message->setMessage('message');
        $valid = $message->sendMessage();
        if(!$valid){
            throw new Exception("Error Processing Request");
        }
    }catch(exception $e){
         $error = $e->getMessage();
    }

    //retrieve sent message
    $found = ['message' => 'message'];
    $select = $this->conn->selectcol($found);

    
    $message->setMessageid($select[0]['messageid']); //set message id
    $message->setMessageRead(); //set message as read
        $select = $this->conn->selectcol($found);
        $this->assertEquals(1,$select[0]['mread']);

    $message->removeMessage(); //remove message

    //test message has been deleted
     $select = $this->conn->selectcol($found);
     $this->assertEquals(0,sizeof($select));
}

public function testInvalidmessage(){
    $fail = new inboxitemobj();
    $error=null;
    try{
        $fail ->setTitle('!"£$%^&*()');
    }catch(exception $e){
        $error = $e->getMessage();
    }
    $this->assertEquals("Error in title, please try again",$error);
      try{
        $fail->setMessage('!"£$%^&*()');
    }catch(exception $e){
        $error = $e->getMessage();
    }
    $this->assertEquals("Error in Message please try again",$error);
}

}
?>