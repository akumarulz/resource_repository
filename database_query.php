<?php
	class database_query{
		private $table;
		private $pdo;
	
		
		public function __construct($pdo,$table){
			$this->pdo=$pdo;
			$this->table=$table;
		}		
		
		function update($record, $primaryKey) {
			try{
				$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$query = 'UPDATE ' . $this->table . ' SET ';
			$parameters = [];
			foreach ($record as $key => $value) {
				$parameters[] = $key . ' = :' .$key;
			}
			$query .= implode(', ', $parameters);
			$query .= ' WHERE ' . $primaryKey . ' = :primaryKey';
			$record['primaryKey'] = $record[$primaryKey];
			$stmt = $this->pdo->prepare($query);
			return $stmt->execute($record);
			}catch(PDOException $e){
				//echo $e->getMessage();
			}
		}
		
		 public function insert($value){ 
			 try{
				$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			
			//get the values for the query
			$keys = array_keys($value);
			$values= implode(', ', $keys);
			$valuescolon = implode(', :',$keys);
			
			//set up the query
			$query = 'INSERT INTO ' . $this->table . ' ('.$values.') 
			VALUES (:'.$valuescolon.');';
			
			//prepare and execute the query 
			$stmt = $this->pdo -> prepare($query);
			$stmt -> execute($value);
		
			return $stmt->rowCount();
			}catch(PDOException $e){
				//echo $e->getMessage();
			}
		}
		
		
		function remove($value){
			try{
				$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$keys = array_keys($value);
			$col = implode('',$keys);
			$valuescolon = implode(', :', $keys);
			//set up the query
			$query = 'DELETE FROM '.$this->table.' 
			WHERE '.$col.' =:'.$valuescolon.';';
			
			//prepare and execute the query
			$stmt = $this->pdo ->prepare($query);
			$stmt ->execute($value);
			//return the result of the query
			return $stmt->rowCount();
			}catch(PDOException $e){
				//return $e->getMessage();
			}
		}
		
		function selectall(){
			try{
				$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$query = 'SELECT * FROM '.$this->table;
			
			$stmt = $this->pdo ->query($query);
			return $stmt->fetchall(PDO::FETCH_ASSOC);
			}catch(PDOException $e){
				//return $e->getMessage();
			}
		}
		
		function selectallbydate(){
			try{
				$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$query = 'SELECT * FROM '.$this->table;
			$query = $query.' ORDER BY date DESC'; // if any errors this is why
			$stmt = $this->pdo ->query($query);
			return $stmt->fetchall(PDO::FETCH_ASSOC);
			}catch(PDOException $e){
				//return $e->getMessage();
			}
		}
		
		public function getComments($col,$id){
			try{
				$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$query = 'SELECT * FROM '.$this->table.' WHERE '.$col.' = '.$id.' ORDER BY date DESC';

			$stmt = $this->pdo ->query($query);
			return $stmt->fetchall(PDO::FETCH_ASSOC);
			}catch(PDOException $e){
				//return $e->getMessage();
			}
		}
		
		
		function select($field, $value){
			try{
				$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$query = 'SELECT * 
			FROM '.$this->table.' 
			WHERE '.$field.' ='.$value;
			
			$stmt = $this->pdo -> query($query);
			return $stmt->fetch();
			}catch(PDOException $e){
				//return $e->getMessage();
			}
			
		}
		function findBlockedFriendrequest(){
			try{
				$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$query = 'SELECT * FROM '.$this->table.' 
			WHERE notification = "Friend request" 
			AND accept = "BLOCK"';
			
			$stmt = $this->pdo -> query($query);
			return $stmt->fetchall(PDO::FETCH_ASSOC);
			}catch(PDOException $e){
			//return $e->getMessage();
			}			
		}
		
		function selectFTall($field, $value){
			try{
				$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$query = 'SELECT * 
			FROM '.$this->table.' 
			WHERE '.$field.' ='.$value;
			$stmt = $this->pdo->query($query);
			return $stmt->fetchall(PDO::FETCH_ASSOC);
			}catch(PDOException $e){
				//return $e->getMessage();
			}
		}
		
		function selectcol($value){
			try{
				$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$keys = array_keys($value);
			$col = implode(', ',$keys);
			$valuescolon = implode(', :', $keys);
			
			$query = 'SELECT *  
			FROM '. $this->table .' 
			WHERE ' .$col .' =:'.$valuescolon;
			$stmt = $this->pdo->prepare($query);
			$stmt ->execute($value);
			
			return $stmt->fetchall(PDO::FETCH_ASSOC);
			}catch(PDOException $e){
				//return $e->getMessage();
			}
		}	
			function selectcols($value){
				try{
				$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$keys = array_keys($value);
			$col = implode(', ',$keys);
			$valuescolon = implode(', :', $keys);
			
			$query = 'SELECT *  
			FROM '. $this->table .' 
			WHERE ' .$col .' =:'.$valuescolon;
			
			$stmt = $this->pdo->prepare($query);
			$stmt ->execute($value);
			
			return $stmt->fetch(PDO::FETCH_ASSOC);
			}catch(PDOException $e){
				//return $e->getMessage();
			}
		}
			
	
		public function findfriendsV2($values){
			$query = 'SELECT * FROM '.$this->table.'
			 WHERE (user_id = '.$values['user_id'].' AND has_friend = '.$values['has_friend'].') 
			 OR (user_id = '.$values['has_friend'].' AND has_friend = '.$values['user_id'].')';
			 $stmt = $this->pdo->query($query);
		return $stmt->fetch(PDO::FETCH_ASSOC);
		}
		
		function checkForBlock($value){
			$query = 'SELECT * FROM '.$this->table.' 
			WHERE reciever_id ='.$value['reciever_id'].' 
			AND '.$value['column'].' = '.$value['source'].' 
			AND accept = '.$value['accept'];
			$stmt = $this->pdo->query($query);
			
			return $stmt->fetch(PDO::FETCH_ASSOC);
			
		}
		public function findNotification($values){
			$query = 'SELECT * FROM '.$this->table.' 
			WHERE reciever_id ='.$values['reciever_id'].' 
			AND from_user_id ='.$values['from_user_id'].'
			AND '.$values['column'].' =\''.$values['source'].'\'';
			
			$stmt = $this->pdo->query($query);
			
			return $stmt->fetch(PDO::FETCH_ASSOC);
		}
		
		public function findfriends($value){
		$query = 'SELECT * FROM friends WHERE user_id = '.$value['user_id'].' or has_friend = '.$value['user_id'];
			
			$stmt = $this->pdo ->query($query);
			return $stmt->fetchall(PDO::FETCH_ASSOC);
		}

		public function findDownloads($values){
			$query = 'SELECT * FROM '.$this->table.' WHERE user_id = '.$values['user_id'].' AND resource_id = '.$values['resource_id'];
			$stmt = $this->pdo->query($query);
			
			return $stmt->fetch(PDO::FETCH_ASSOC);
		}

		public function findResources(){
			$query = 'SELECT * FROM '.$this->table.' WHERE `blocked_users` != "ARCHIVED" ORDER BY DATE DESC';
				$stmt = $this->pdo ->query($query);
			return $stmt->fetchall(PDO::FETCH_ASSOC);

		}
		
		 public function save($record, $primaryKey) {
		
			$success = $this->insert($record);
			
			if (!$success) 
				$success = $this->update($record, $primaryKey);
			
		return $success;
		}
	}
?>



