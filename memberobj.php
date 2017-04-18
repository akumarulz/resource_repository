<?php
class memberobj{
	private $conn;
	private $user_id;
	private $title;
	private $firstname;
	private $middlename;
	private $surname;
	private $email;
	private $location;
	private $school;
	private $password;
	private $personalSummary;
	private $errormsg = 'A-Z characters only permitted no empty spaces';
	
	private function validateSummary($str){
			if (trim($str) != '' && !ctype_space($str) && !preg_match('/[£¬`$]/', $str)){
				return true;
		}else{
			return false;
		}
	}
	
	private function validate($str){
		
		if(trim($str) != true || !preg_match("/^[a-zA-Z ]*$/", $str) || ctype_space($str)){
			return false;
		}else{
			return true;
		}
		
		
	}
	
	private function validatemiddlename($str){
		$valid = true;
			if(!preg_match("/^[a-zA-Z ]*$/", $str) || ctype_space($str)){
			$valid = false;
		}
		return $valid;
	}
	
	private function validateEmail($email){
		$valid = true;
		if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
			$valid = false;
		}
		return $valid;
	}
	
	private function validatepw($pw){
		$valid = true;
		if($pw != '' && preg_match("/^[a-zA-Z0-9]*$/", $pw)){
			return $valid;
		}else{
				return $valid = false;
			}
	}
	
	//setters
	public function setConn(database_query $conn){
		$this->conn = $conn;
	}
	public function setUser_id(int $user_id){
		$this->user_id = $user_id;
	}
	public function setTitle(string $title){
		$this->title = $title;
	}
	public function setFirstname(string $fname){
		$valid = $this->validate($fname);
		if($valid){
			$this->firstname = $fname;
		}else{
			throw new Exception('firstname error: '.$this->errormsg);
		}
	}
	public function setMiddlename(string $mname){
		$valid = $this->validatemiddlename($mname);
		if($valid){
			$this->middlename = $mname;
		}else{
			throw new Exception('middlename error : '.$this->errormsg);
		}
		
	}
	public function setSurname(string $sname){
		$valid = $this->validate($sname);
		if($valid){
			$this->surname = $sname;
		}else{
			throw new Exception('Surname error: '.$this->errormsg);
		}
		
	}
	public function setEmail(string $email){
		$valid = $this->validateEmail($email);
		if($valid){
			$this->email = $email;
		}else{
			throw new Exception('Email error: Invalid email supplied');
		}
	}
	
	public function setLocation(string $loc){
		$valid = $this->validate($loc);
		if($valid){
			$this->location = $loc;
		}else{
			throw new Exception('Location error: '.$this->errormsg);
		}
		
	}
	public function setSchool(string $school){
		$valid = $this->validate($school);
		if($valid){
			$this->school = $school;
		}else{
			throw new Exception('School name error: '.$this->errormsg);
		}
		
	}
	
	public function setPassword(string $pw){
		$valid = $this->validatepw($pw);
		if($valid){
			$this->password = password_hash($pw, PASSWORD_DEFAULT);
		}else{
			throw new Exception('Password error: 0-9 '.$this->errormsg);
		}
	}
	public function setPersonalSummary(string $in_summary){
		$valid = $this->validateSummary($in_summary);
		if($valid){
		$this->personalSummary = $in_summary;
		}else{
			throw new Exception("Charaters £¬`$ not accepted");
			
		}
	}
	
	
	//getters
	public function getUser_id():int{
		return $this->user_id;
	}
	public function getTitle():string{
		return $this->title;
	}
	public function getFirstname():string{
		return $this->firstname;
	}
	//middle name return type hint must be blank or it will cause an error 
	public function getMiddlename(){
		return $this->middlename;
	}
	public function getSurname():string{
		return $this->surname;
	}
	public function getEmail():string{
		return $this->email;
	}
	public function getLocation():string{
		return $this->location;
	}
	public function getSchool():string{
		return $this->school;
	}
	public function getPersonalSummary():string{
		return $this->personalSummary;
	}

	
	//functions
	public function save($conn){
		$this->conn = $conn;
		
		$save = array();
		$save['user_id'] = $this->user_id;
		$save['title'] = $this->title;
		$save['first_name'] = $this->firstname;
		if($this->middlename != '') {$save['middle_name'] = $this->middlename;}
		$save['surname'] = $this->surname;
		$save['email'] = $this->email;
		$save['location'] = $this->location;
		$save['school_name'] = $this->school;
		if($this->password != ''){$save['password'] = $this->password;}
		return  $this->conn->save($save,'user_id');
	}

	public function savenew(database_query $conn){
		$this->conn = $conn;
		
		$save = array();
		$save['profilePic'] = $save['middle_name'] = $save['personalSummary'] = '';
		$save['title'] = $this->title;
		$save['first_name'] = $this->firstname;
		if($this->middlename != '') {$save['middle_name'] = $this->middlename;}
		$save['surname'] = $this->surname;
		$save['email'] = $this->email;
		$save['location'] = $this->location;
		$save['school_name'] = $this->school;
		$save['password'] = $this->password;
		return $this->conn->save($save,'');
		}

	public function saveSummary(){
		$summary = [
			'user_id' => $this->user_id,
			'personalSummary' => $this->personalSummary
		];
		
		return $this->conn->update($summary,'user_id');
	}
	public function resetPassword(){
		$temp =[
			'user_id'=>$this->user_id,
			'password'=>$this->password
		];
		return $this->conn->save($temp,'user_id');
	}
		
}

?>