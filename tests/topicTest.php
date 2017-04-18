<?php
require 'topicobj.php';
require 'database_join_queries.php';
class topicTest extends PHPUnit\Framework\TestCase{
	public $conn;
	public $conn2;
	
	public function setUp(){
		$pdo = new PDO("mysql:host=127.0.0.1;dbname=repository","root","");
        $this->conn = new database_query($pdo,'forum_topics');
		$this->conn2 = new database_join_queries($pdo);
	}

	public function testValidTopic(){
		$arr = ['date'=>date('Y-m-d h:i:s')];
		$topic = new topicobj($arr);
		$error = null;

		try{
			$topic->setUserId(77);
			$topic->setCategory('category');
			$topic->setDesc('description');
			$topic->setTitle('title');
			$topic->setConn($this->conn);
			$topic->save();
		}catch(exception $e){
			$error->$e->getMessage();
		}
		
		$topic->setNum($this->conn2);
		$topic->setTopicId(1);
		$topic->setDate(date('Y-m-d h:i:s'));
		$this->assertEquals($topic->getDate(),$topic->getDate());
		$this->assertEquals('title',$topic->getTitle());
		$this->assertEquals('description',$topic->getDesc());
		$this->assertEquals('category',$topic->getCategory());
		$this->assertEquals(1,$topic->getTopicId());
		

		try{
			$topic->setTitle('!"£$%^&*()');
		}catch(exception $e){
			$error = $e->getMessage();
		}
		$this->assertEquals("Sorry a-zA-Z0-9.,;:+-?@()' characters only",$error);

		try{
			$topic->setDesc('|\\`¬!');
		}catch(exception $e){
			$error = $e->getMessage();
		}
		$this->assertEquals("Error Processing Request, please try again",$error);
	
		
	$found = $this->conn->selectcol($arr);

		$update = new topicobj($arr);
		$update ->setConn($this->conn);
		try{
			$update->setTopicId($found[0]['topic_id']);
			$update->setCategory('new category');
			$update->setDesc('new description');
			$update->setTitle('new title');
			$update->upDateTopic();
		}catch(exception $e){
			$error = $e->getMessage();
		}

		$found = $this->conn->selectcol($arr);
		$this->assertEquals('new description',$found[0]['topic_description']);


	$remove = ['date'=>$found[0]['date']];

	$this->conn->remove($remove);

	$found = $this->conn->selectcol($arr);
	$this->assertEquals(0,sizeof($found));

	}
}
?>