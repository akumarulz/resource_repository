<?php 
require 'reportobj.php';
class reportTest extends PHPUnit\Framework\TestCase{
	public $conn;
	
	public function setUp(){
			$pdo = new PDO("mysql:host=127.0.0.1;dbname=repository","root","");
		$this->conn = new database_query($pdo,'reports');
	}

    public function testReport(){
        $error = null;
        $report = new resourceReport();

        try{
        $report->setReason('¬`{}');
        }catch(exception $e){
            $error = $e->getMessage();
        }
        $this->assertEquals("Illegal characters found, please check and try again.",$error);
        $error = null;

        try{
            $report->setResourceId(272);
            $report->setUserId(77);
            $report->setReason('reason');
            $report->setType('Resource');
            $report->save($this->conn);
        }catch(exception $e){
            $error = $e->getMessage();
        }

        $find = ['reason'=>'reason'];
        $found = $this->conn->selectcol($find);

        $RO = new reportobj();
        try{
        $RO->setConn($this->conn);
        $found = ['report_id'=>$found[0]['report_id']];
        $found = $this->conn->selectcol($find);
        $RO->closeReport($found[0]['report_id'],79);
        $found = $this->conn->selectcol($find);
        $this->assertEquals(79,$found[0]['delt_by']);
        }catch(exception $e){
           $error = $e->getMessage();
        }

        $remove =['report_id'=>$found[0]['report_id']];
        $value = $this->conn->remove($remove);
        $this->assertEquals(1,$value);
    }

    public function testOffenderreport(){
        $error = null;
        $offender = new OffenderReport();
        try{
        $offender->setType('Offender');
        $offender->setUserId(77);
        $offender->setOffenderId(79);
        $offender->setReason('reason offender');
        $offender ->save($this->conn);
        }catch(exception $e){
            $error = $e->getMessage();
        }

        $find = ['reason'=>'reason offender'];
        $found = $this->conn->selectcol($find);

        $remove=['report_id'=> $found[0]['report_id']];
        $removed = $this->conn->remove($remove);
        $this->assertEquals(1,$removed);
    }

    public function testTopicReport(){
        $error = null;
        $topic = new TopicReport();
        try{
        $topic->setType('Topic');
        $topic->setUserId(77);
        $topic->setTopicId(41);
        $topic->setReason('topic reason');
        $topic->save($this->conn);
    }catch(exception $e){
        $error = $e->getMessage();
    }

    $find = ['reason'=>'topic reason'];
    $found = $this->conn->selectcol($find);

    $remove=['report_id'=> $found[0]['report_id']];
    $removed = $this->conn->remove($remove);
    $this->assertEquals(1,$removed);
    }
}
?>