<?php 
require 'database_query.php';
require 'resource.php';

class resourceTest extends PHPUnit\Framework\TestCase{
	public $Resource;
	
	public function setUp(){
			$pdo = new PDO("mysql:host=127.0.0.1;dbname=repository","root","");
		$this->Resource = new database_query($pdo,'document_resources');
	}


public function testvalidNewURL(){
    $valid = null;
    $var = new resourceURL();
    try{
        //set up object and insert into database
        $var->setConnection($this->Resource);
        $var->setUser_id(79);
        $var->setCategory_id(13);
        $var->setTitle('hello');
        $var->setFiletype('url');
        $var->setDescription('world');
        $var->setUrl('https://www.facebook.com/');
        $valid = $var->saveURL($this->Resource);
    }catch(exception $e){
         $error = $e->getMessage();
    }
    //check the right strings are returned
  $this->assertEquals('hello',$var->getTitle());
   $this->assertEquals('world',$var->getDescription());
   $this->assertEquals('url',$var->getFiletype());
    $R = $var->URLchecker($var->getUrl());
    $this->assertEquals($var->getUrl(),$R['url_address']);

   //get inserted row and check correct strings returned
    $array = ['url_address'=>$var->getUrl()];
    $find = $this->Resource->selectcol($array);
    $this->assertEquals($var->getTitle(),$find[0]['title']);
    $this->assertEquals($var->getDescription(),$find[0]['description']);
    $this->assertEquals($var->getFiletype(),$find[0]['file_type']);

    //update row
    $var->setUser_id(79);
    $var->setResource_id($find[0]['resource_id']);
    $var->setTitle('the simpsons');
    $var->setDescription('stones');
    $var->setUrl('https://www.youtube.com/watch?v=CcsUYu0PVxY&t=10285s');
    $valid = $var->updateURL();

    //get row and then remove from database
    $array = ['url_address'=>$var->getUrl()];
    $found = $this->Resource->selectcol($array);
    $this->assertEquals($var->getUrl(),$found[0]['url_address']);
    $found = $this->Resource->remove($array);
    $this->assertEquals(1,$found);
}


    public function testInValidURL(){
        $fail = new resourceURL();
       
        try{
            $fail->setTitle('!"£$%^&*()_+');
            
        }catch(exception $e){
            $this->assertEquals(' a-zA-Z0-9 +()- characters only for title.',$e->getMessage());
        }
         try{
            $fail->setDescription('!"£$%^&*()_+');
           
        }catch(exception $e){
            $this->assertEquals('Description not completed or illegal character ',$e->getMessage());
        }
        try{
            $fail->setFilesize(0);
            
        }catch(exception $e){
            $this->assertEquals('Empty file or file larger than 200MB',$e->getMessage());
        }
         try{
            $fail->setFilesize(1000000000);
           
        }catch(exception $e){
            $this->assertEquals('Empty file or file larger than 200MB',$e->getMessage());
        }
        try{
            $fail->setUrl('ppp');
            
        }catch(exception $e){
             $this->assertEquals('Invalid URL',$e->getMessage());
        }
    }



}


    ?>