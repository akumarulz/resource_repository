<?php 
require 'notificationobj.php';
class notificationTest extends PHPUnit\Framework\TestCase{
	public $conn;
	
	public function setUp(){
			$pdo = new PDO("mysql:host=127.0.0.1;dbname=repository","root","");
		$this->conn = new database_query($pdo,'notifications');
	}

    public function testRepository(){
		$note = new  notificationobj();
		$error= null;
		try{
			$note->setReciever(77);
			$note->setColumn('resource_id');
			$note->setNotificationId(0);
			$note->setSenderId(79);
			$note->setConn($this->conn);
			$reply = $note->increaseNumberOf();
			$this->assertequals('NOT FOUND',$reply);
			}catch(exception $e){
			$error =$e->getMessage();
		}

		try{
		$note->setConn($this->conn);
		$note->setReciever(77);
		$note->setSenderId(79);
		$note->setColumn('resource_id');
		$note->setResourceId(116);
		$note->setTitle('title');
		$note->setMessage('message');
		$note->saveNotification();

		$find = ['message'=>'message'];
		$found = $this->conn->selectcol($find);
		
		$note->setNotificationId($found[0]['id']);
		}catch(exception $e){
			$error = $e->getMessage();
		}

		//set notification to block
		try{
		$note->block();
		$found = $this->conn->selectcol($find);
		$this->assertEquals('BLOCK',$found[0]['accept']);
		}catch(exception $e){
			$error = $e->getMessage();
		}
		//check if blocked
		try{
			$note->setAccept(2);
			$note->CheckIfBlocked();
			$found = $this->conn->selectcol($find);
			$this->assertEquals('BLOCK',$found[0]['accept']);
		}catch(exception $e){
			$error = $e->getMessage();
		}
		//unblock notification
		try{
		$note->unblock();
		$found = $this->conn->selectcol($find);
		$this->assertEquals('UNBLOCK',$found[0]['accept']);
		}catch(exception $e){
			$error = $e->getMessage();
		}

		//increase number of column by 1
		try{
			$note->increaseNumberOf();
			$found = $this->conn->selectcol($find);
			$this->assertEquals(2,$found[0]['number_of']);
		}catch(exception $e){
			$error = $e->getMessage();
		}
		//Remove Notification
		try{
		$note->setTopicId(0);
		$note->setNoteRead(0);
		$note->setnumberOf(0);
		$note->RemoveNotification();
		$found = $this->conn->selectcol($find);
		$this->assertEquals(0,sizeof($found));
		}catch(exception $e){
			$error = $e->getMessage();
		}
	} 

	public function testFriendsNotification(){
		$friend = new notificationobj();
		$error = null;
		$found = null;
		try{
		$friend->setConn($this->conn);
		$friend->setReciever(77);
		$friend->setSenderId(79);
		$friend->setNotification('Test Friend request');
		$friend->saveFriendRequestNotification();
		}catch(exception $e){
			$error = $e->getMessage();
		}

		try{
			$found = $friend->checkforfriendsNotification();
			$this->assertEquals('Test Friend request',$found['notification']);
		}catch(exception $e){
			$error = $e->getMessage();
		}

		try{
			$friend->setNotificationId($found['id']);
			$friend->RemoveNotification();
			$found = $friend->checkforfriendsNotification();
			$this->assertEquals(0,sizeof($found));
		}catch(exception $e){
			$error = $e->getMessage();
		}

	}
}
?>