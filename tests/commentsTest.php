<?php
require 'commentobj.php';
class ccommentsTest extends PHPUnit\Framework\TestCase{
	public $conn;
	
	public function setUp(){
		$pdo = new PDO("mysql:host=127.0.0.1;dbname=repository","root","");
        $this->conn = new database_query($pdo,'discussion');
	}

    public function testValidComment(){
        $com = new commentobj();
        $com->setConnection($this->conn);
        $error = null;

        try{
         $com->setComment('');
        }catch(exception $e){
            $error = $e->getMessage();
        }
        $this->assertEquals('Comment error please try again',$error);

        try{
            $com->setComment('comment');
            $com->setResourceid(272);
            $com->setUserid(77);
            $com->saveRcomment();
        }catch(exception $e){
            $error = $e->getMessage();
        }

        $find = ['comment'=>'comment'];
        $found = $this->conn->selectcol($find);
        $this->assertEquals('comment',$found[0]['comment']);

         try{
            $reply = new commentobj();
            $reply->setConnection($this->conn);
            $reply->setComment('reply to comment');
            $reply->setResourceid($found[0]['resource_id']);
            $reply->setUserid(79);
            $reply->setReply($found[0]['comment_id']);
            $reply->saveRcomment();
        }catch(exception $e){
           $error = $e->getMessage();
        }



        try{
        $com->setComment_id($found[0]['comment_id']);
        $com->removeComment();
        }catch(exception $e){
            $error = $e->getMessage();
        }

         $found = $this->conn->selectcol($find);
        $this->assertEquals(0,sizeof($found));
    }

    public function testValidTComment(){
        $com = new commentobj();
        $com->setConnection($this->conn);
        $error = null;

        try{
            $com->setComment('comment');
            $com->setTopicid(24);
            $com->setUserid(77);
            $com->saveTcomment();
        }catch(exception $e){
            $error = $e->getMessage();
        }

        $find = ['comment'=>'comment'];
        $found = $this->conn->selectcol($find);
        $this->assertEquals('comment',$found[0]['comment']);

        try{
        $com->setComment_id($found[0]['comment_id']);
        $com->removeComment();
        }catch(exception $e){
            $error = $e->getMessage();
        }

         $found = $this->conn->selectcol($find);
        $this->assertEquals(0,sizeof($found));
    }

    public function testValidreplyComment(){
        $com = new commentobj();
        $com->setConnection($this->conn);
        $error = null;

        try{
            $com->setComment('comment');
            $com->setTopicid(24);
            $com->setUserid(77);
            $com->saveTcomment();
        }catch(exception $e){
            $error = $e->getMessage();
        }

        $find = ['comment'=>'comment'];
        $found = $this->conn->selectcol($find);
        $this->assertEquals('comment',$found[0]['comment']);

        try{
            $reply = new commentobj();
            $reply->setConnection($this->conn);
            $reply->setComment('reply to comment');
            $reply->setTopicid($found[0]['forum_id']);
            $reply->setUserid(79);
            $reply->setReply($found[0]['comment_id']);
            $reply->saveTcomment();
        }catch(exception $e){
            $error = $e->getMessage();
        }

        try{
        $com->setComment_id($found[0]['comment_id']);
        $com->removeComment();
        }catch(exception $e){
            $error = $e->getMessage();
        }

         $found = $this->conn->selectcol($find);
         $this->assertEquals(0,sizeof($found));
    }

}
?>