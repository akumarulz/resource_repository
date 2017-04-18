<?php 
require 'downloadhistoryobj.php';
class downloadHistoryTest extends PHPUnit\Framework\TestCase{

	public $conn;
	
	public function setUp(){
			$pdo = new PDO("mysql:host=127.0.0.1;dbname=repository","root","");
		$this->conn = new database_query($pdo,'download_history');
	}

    public function testinput(){
        $dw = new downloadhistoryobj();

        //set up object
        $dw->setConn($this->conn);
        $dw->setResourceId(117);
        $dw->setUserid(79);
        //insert row
        $dw->insert();
    
    
    $find = ['user_id' => 79, 'resource_id'=>117]; 
    //retrive entered row and check correctly entered
    $found = $this->conn->findDownloads($find);
    $this->assertEquals(79,$found['user_id']);
    //insert same data again to increase times downloaded by 1
    $dw->insert();
    $found = $this->conn->findDownloads($find);
    //check it has increased
    $this->assertEquals(2,$found['times_downloaded']);
    $remove = ['id'=>$found['id']];
    //remove row
    $this->conn->remove($remove);
    }
}
?>