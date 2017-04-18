<?php 
require 'memberobj.php';
require 'password.php';

class newUserTest extends PHPUnit\Framework\TestCase{
	public $conn = null;
	
	public function setUp(){
	$pdo = new PDO("mysql:host=127.0.0.1;dbname=repository","root","");
		$this->conn = new database_query($pdo,'users');
		
	}
		public function testAllvalid(){
			
			$member = new memberobj();
			//create a new object to insert into database
			try{
					$member->setUser_id(1);
					$member->setTitle('Ms');
					$member->setFirstname('Jill');
					$member->setMiddlename('B');
					$member->setSurname('ROLLING');
					$member->setEmail('JILL@GMAIL.COM');
					$member->setLocation('LONDON');
					$member->setSchool('ST TRINIANS');
					$member->setPassword('pw');
					$member->setPersonalSummary('foo');
					$member->save($this->conn); //save the object
			}catch(Exception $e){
				$response = $e->getMessage();
			}
			//search the database and retrieve the data 
			$emailTest =['email'=>$member->getEmail()];
			$selectTest = $this->conn->selectcol($emailTest);
			//check to make sure the information retrived mathes the submitted details
			$this->assertEquals($member->getTitle(),$selectTest[0]['title']);
			$this->assertEquals($member->getFirstname(),$selectTest[0]['first_name']);
			$this->assertEquals($member->getSurname(),$selectTest[0]['surname']);
			$this->assertEquals($member->getMiddlename(),$selectTest[0]['middle_name']);
			$this->assertEquals($member->getSchool(),$selectTest[0]['school_name']);
			$this->assertEquals($member->getEmail(),$selectTest[0]['email']);
			$this->assertEquals('foo',$member->getPersonalSummary());
			$this->assertEquals($member->getLocation(),$selectTest[0]['location']);
			$this->assertEquals(1,$member->getUser_id());
			$this->conn->remove($emailTest); //delete the user from the database
			$selectTest = $this->conn->selectcols($emailTest);
			$this->assertFalse($selectTest); //ensure it has been removed
		}

		public function testSavenew(){
			// create a new member object
			$member = new memberobj();
			try{
				$member->setTitle('MR');
				$member->setFirstname('dave');
				$member->setMiddlename('m');
				$member->setSurname('jim');
				$member->setEmail('m@gmail.com');
				$member->setLocation('ldn');
				$member->setSchool('school');
				$member->setPassword('pw');
				$member->savenew($this->conn);				
			}catch(exception $e){
				$error = $e->getMessage();
			}

			//retrieve the object
			$emailTest =['email'=>$member->getEmail()];
			$selectTest = $this->conn->selectcol($emailTest);

			//create a new object and set the user id from the stored object
			$summary = new memberobj();
			$summary->setConn($this->conn);
			$summary->setUser_id($selectTest[0]['user_id']);
			$summary->setPersonalSummary('hello');//update the personal summary column
			$saved = $summary->saveSummary(); //save back to database updating the stored information
			
			 //retrieve entry from database and ensure it has been updated
			$selectTest2 = $this->conn->selectcol($emailTest);
			$this->assertEquals('hello',$selectTest2[0]['personalSummary']);

			$this->conn->remove($emailTest); //remove entry from database
		}
		
		//these tests are to check the correct exceptions are thrown when non accepted information is submitted
		public function testInvalid(){
			
			$member = new memberobj();
			$er = 'A-Z characters only permitted no empty spaces';
			try{
					$member->setFirstname('Jill7');
			}catch(Exception $e){
				$response = $e->getMessage();
				$this->assertEquals('firstname error: '.$er,$response);
			}
			try{
				$member->setMiddlename('B7');
			}catch(Exception $e){
				$response = $e->getMessage();
				$this->assertEquals('middlename error : '.$er,$response);
			}
			try{
				$member->setSurname('ROLLING7');
			}catch(Exception $e){
				$response = $e->getMessage();
				$this->assertEquals('Surname error: '.$er,$response);
			}
			try{
				$member->setEmail('JILL.GMAIL.COM');
			}catch(Exception $e){
				$response = $e->getMessage();
				$this->assertEquals('Email error: Invalid email supplied',$response);
			}
			try{
				$member->setLocation('LONDON7');
			}catch(Exception $e){
				$response = $e->getMessage();
				$this->assertEquals('Location error: '.$er,$response);
			}
			try{
				$member->setSchool('ST TRINIANS7');
			}catch(Exception $e){
				$response = $e->getMessage();
				$this->assertEquals('School name error: '.$er,$response);
			}
			try{
				$member->setPassword('pw£');
			}catch(Exception $e){
				$response = $e->getMessage();
				$this->assertEquals('Password error: 0-9 '.$er,$response);
			}	
			try{
				$member->setPersonalSummary('pw£');
			}catch(Exception $e){
				$response = $e->getMessage();
				$this->assertEquals('Charaters £¬`$ not accepted',$response);
			}	
		}

		//this tests are to check the correct errors are thrown for empty fields. 
		public function testEmpty(){
			
			$member = new memberobj();
			$er = 'A-Z characters only permitted no empty spaces';			
			try{
					$member->setFirstname(' ');
			}catch(Exception $e){
				$response = $e->getMessage();
				$this->assertEquals('firstname error: '.$er,$response);
			}
			try{
				$member->setMiddlename(' ');
			}catch(Exception $e){
				$response = $e->getMessage();
				$this->assertEquals('middlename error : '.$er,$response);
			}
			try{
				$member->setSurname(' ');
			}catch(Exception $e){
				$response = $e->getMessage();
				$this->assertEquals('Surname error: '.$er,$response);
			}
			try{
				$member->setEmail(' ');
			}catch(Exception $e){
				$response = $e->getMessage();
				$this->assertEquals('Email error: Invalid email supplied',$response);
			}
			try{
				$member->setLocation(' ');
			}catch(Exception $e){
				$response = $e->getMessage();
				$this->assertEquals('Location error: '.$er,$response);
			}
			try{
				$member->setSchool(' ');
			}catch(Exception $e){
				$response = $e->getMessage();
				$this->assertEquals('School name error: '.$er,$response);
			}
			try{
				$member->setPassword(' ');
			}catch(Exception $e){
				$response = $e->getMessage();
				$this->assertEquals('Password error: 0-9 '.$er,$response);
			}
		}
	}
?>