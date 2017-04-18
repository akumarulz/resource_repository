<?php
class resource{

    protected $resource_id;
    protected $user_id;
    protected $category_id;
    protected $title;
    protected $date; 
    protected $file_type;
    protected $description;
    protected $favourited;
    protected $downloaded;
    protected $rating;
    protected $total_ratings;
    protected $total_rates;
    protected $rated_user_id;
    protected $blocked_users;
    protected $filesize;
    protected $conn;
    protected $resourcearray=[];
	protected $author=[];
	protected $userID;
	protected $num;
   	
        public function __construct(){
          $this->date = date("Y-m-d h:i:s");
        }

    protected function ValidateTitle(string $str){
       
        if(trim($str) != true || !preg_match("/^[a-zA-Z0-9.\\-_+' ]*$/", $str) || ctype_space($str)){
		     return false;
		}else{
            return true;
        }
    }

    protected function ValidateDescription(string $str){
        if(trim($str) != true || !preg_match("/^[a-zA-Z0-9.,;:+-?@()£$&!'#<>\r\n ]*$/", $str) || ctype_space($str)){
		    return false; 
            }else{
             return true;
        }
	}

    private	function ValidateType(string $str1){
        $str = strtolower($str1);
        if(
            $str != "png" && $str != "jpeg" && $str !="jpg" && $str != "bmp"  && $str != "gif"// allowed images
            && $str != "doc" && $str != "docx" && $str != "txt" && $str != "odt"//allowed documents
            && $str != "pdf" // allowed pdfs
            && $str != "pptx" && $str != "ppt" // allowed power point types
            && $str != "mp4" && $str != "wmv" && $str != "mp3" && $str != "wav" // allowed audio visual files
            && $str != "csv" && $str != "ods" && $str != "xlsx" && $str != "accdb"// allowed excel files
		) {
            return false;
        }else{
            return true;
        }
    }

    //setters
    public function setConnection($conn){
        $this->conn = $conn;
    }
    public function setResource_id(int $in_resource_id){
        $this->resource_id = $in_resource_id;
    }
    public function setUser_id(int $in_user_id){
        $this->user_id = $in_user_id;
    }
     public function setCategory_id(int $in_cate_id){
        $this->category_id = $in_cate_id;
    }
     public function setTitle(string $in_title){
         $valid = $this->ValidateTitle($in_title);
         if($valid){
             $this->title = $in_title;
         }else{
             throw new Exception(' a-zA-Z0-9 +()- characters only for title.');
             
         }
    }
     public function setFiletype(string $in_type = 'url',string $in_mime= ''){
        if($in_type == 'url'){
            $this->file_type = $in_type;
        }else{
                $valid = $this->ValidateType($in_type);
                if($valid){
                   $this->file_type = $in_mime;
                }else{
                    throw new Exception ('File type not accepted '.$in_type);
                }
        }
    }
     public function setDescription(string $in_description){
         $valid = $this->ValidateDescription($in_description);
         if($valid){
             $this->description = $in_description;
         }else{
            throw new Exception ('Description not completed or illegal character ');
         }
        
    }
     public function setFilesize(int $in_file_size){
         if($in_file_size < 1 || round($in_file_size/1048576) > 200){
             throw new Exception('Empty file or file larger than 200MB');
         }else{
                $this->filesize = $in_file_size;
         }
    }
    public function setRating(float $in_rating){
        $this->rating = $in_rating;
    }
    

    

    //getters
     public function getFilesize():int{
        return $this->filesize;
    }
    public function getDate(){
        return $this->date;
    }
    public function getResource_id():int {
       return $this->resource_id;
    }
    public function getUser_id():int{
       return  $this->user_id;
    }
     public function getCategory_id():int{
        return $this->category_id;
    }
     public function getTitle():string{
       return $this->title;
    }
     public function getFiletype():string{
         
        return $this->file_type;
    }
     public function getDescription():string{
      return $this->description;
    }
    /* public function getFavorited():int{
      return $this->favourited;
    }
     public function getDownloaded():int{
       return $this->downloaded;
    }
     public function getRating():float{
       return $this->rating;
    }
     public function getTotal_ratings():float{
       return $this->total_ratings;
    }
     public function getTotal_rates():int{
       return $this->total_rates;
    }
     public function getRated_user_id():int{
        return $this->rated_user_id;
    }
     public function getBlocked_users():string{
        return $this->blocked_users;
    }*/

    public function getHTML(){
        $result = '<li>';
            $result = $result.'<a href = "'.htmlspecialchars($_SERVER["PHP_SELF"].'?page=resource_discussion&resource_id='.$this->resource_id).'" ><p><b>'.$this->title.'</b></p></a>';
            $result = $result.'<p>Rating: '.$this->rating.'</p>';
            $result = $result.'<p>Resource: '.$this->description.'</p>';
        $result = $result.'</li>';
        return $result;
    }
}


class resourceURL extends resource{
    private $url;
    
    private function ValidateURL($value){
        if(!filter_var($value, FILTER_VALIDATE_URL) === false){
            return true;
        }else{
            return false;
        }
    }
    //check for duplicate url entries
    public function URLchecker(string $in_checkurl){
        $valid = $this->ValidateURL($in_checkurl);
        if($valid){
            $temp=['url_address'=>$in_checkurl];
            return $this->conn->selectcols($temp);
        }
    }

    //setters
    public function setUrl(string $in_url){
        $valid = $this->ValidateURL($in_url);
        if($valid){
            $this->url = $in_url;
        }else{
             throw new Exception ('Invalid URL');
        }
    }
    
    //getters
    public function getUrl():string{
        return $this->url;
    }

    //save url functions
    public function saveURL(){
        $temp = array();
        $temp['user_id'] = $this->user_id;
        $temp['category_id'] = $this->category_id;
        $temp['title'] = $this->title;
        $temp['date'] = $this->date;
        $temp['url_address'] = $this->url;
        $temp['description'] = $this->description;
        $temp['file_type'] = $this->file_type;
        $temp['favorited'] = $temp['downloaded'] = $temp['rating'] = $temp['total_ratings'] = $temp['total_rates'] = $temp['rated_user_id'] = $temp['blocked_users'] = 0;
       return $this->conn->save($temp,'');
    }
    public function updateURL(){
        $temp = array();
        $temp['resource_id'] = $this->resource_id;
        $temp['user_id'] = $this->user_id;
        $temp['category_id'] = $this->category_id;
        $temp['title'] = $this->title;
        $temp['url_address'] = $this->url;
        $temp['description'] = $this->description;
       
        return $this->conn->save($temp,'resource_id');
    }
}


class resourcedocument extends resource{
    private $filename;
    private $filecontent;
  
    //setters
    public function setFilename(string $in_filename){
        $valid = $this->ValidateTitle($in_filename);
        if($valid){
            $this->filename = $in_filename;
        }else{
            throw new Exception ('Filename error, please A-Z0-9 only '.$in_filename);
        }
    }
    
    public function setFilecontents($in_contents){
        $this->filecontent = $in_contents;
    }

    //getters
    public function getFilename():string{
        return $this->filename;
    }
    public function getFilecontent(){
        return $this->filecontent;
    }

    //save functions
    public function saveResource(){
        $temp = array();
        $temp['user_id'] = $this->user_id;
        $temp['category_id'] = $this->category_id;
        $temp['title'] = $this->title;
        $temp['date'] = $this->date;
       
        $temp['description'] = $this->description;
        $temp['filename'] = $this->filename;
        $temp['filecontent'] = $this->filecontent;
        $temp['file_type'] = $this->file_type;
        $temp['file_size'] = $this->filesize;
        $temp['favorited'] = $temp['downloaded'] = $temp['rating'] = $temp['total_ratings'] = $temp['total_rates'] = $temp['rated_user_id'] = $temp['blocked_users'] = 0;
     
       return $this->conn->save($temp,'');

    }
    public function updateResource(int $val=0){
        $temp = array();
        $temp['resource_id'] = $this->resource_id;
        $temp['user_id'] = $this->user_id;
        $temp['category_id'] = $this->category_id;
        $temp['title'] = $this->title;
        $temp['description'] = $this->description;
           
            if($val==1){
            
            $temp['filename'] = $this->filename;
            $temp['filecontent'] = $this->filecontent;
            $temp['file_type'] = $this->file_type;
            $temp['file_size'] = $this->filesize;
            }
      return $this->conn->save($temp,'resource_id');
    }
}

class resourceobj extends resource{
		
	public function __construct($in_resource, $connect,$userID,$in_num){
	$this->userID = $userID;	
	$this->resourcearray[] = $in_resource;
	$this->author[] = $connect->selectFTall('user_id',$in_resource['user_id']);
	$this->num = $in_num;	
}
	
	public function getHTML(){
		$allID = explode(',',$this->resourcearray[0]['rated_user_id']);
		
		if(in_array($this->userID,$allID)){
			$class = 'jDisabled';
		}else{$class='';}
		
		$result='<div class="resource_result_div">';
		$result = $result.'<div class="rating '.$class.'" id="'.$this->resourcearray[0]['rating'].'_'.$this->resourcearray[0]['resource_id'].'"></div>';
		$result = $result.'<a href="resource_discussion?resource_id='.$this->resourcearray[0]['resource_id'].'" >';
		
		$fileext = pathinfo($this->resourcearray[0]['filename']);
		$var = ($this->resourcearray[0]['file_type'] == 'url') ?  $this->resourcearray[0]['file_type']  :  $fileext['extension'] ;
			switch(strtolower($var)){
				case "url": $result = $result.'<img class="results_icon" src="images/htmls.png" alt="a url link"/>';break;
				case "txt": $result = $result.'<img class="results_icon" src="images/txts.png" alt="a text document"/>';break;
				case "avi": $result = $result.'<img class="results_icon" src="images/avi.png" alt="an avi file"/>';break;
				case "doc": $result = $result.'<img class="results_icon" src="images/docs.png" alt="a word document"/>';break;
				case "jpg": $result = $result.'<img class="results_icon" src="images/jpg.png" alt="an image file"/>';break;
				case "mp3": $result = $result.'<img class="results_icon" src="images/mp3.png" alt="an audio file"/>';break;
				case "mp4": $result = $result.'<img class="results_icon" src="images/mp4.png" alt="an audio or video file"/>';break;
				case "pdf": $result = $result.'<img class="results_icon" src="images/pdf.png" alt="a pdf document"/>';break;
				case "movs": $result = $result.'<img class="results_icon" src="images/movs.png" alt="a movie file"/>';break;
				case "png": $result = $result.'<img class="results_icon" src="images/png.png" alt="an image file"/>';break;
				case "gif": $result = $result.'<img class="results_icon" src="images/gif.png" alt="an image file"/>';break;
				default: $result = $result.'<img class="results_icon" src="images/docs.png" alt="a word document"/>';
				
			}
		
		$result = $result.'<h3>'.wordwrap($this->resourcearray[0]['title'],30,"<br>\n",true).'</h3></a>';
		$result = $result.'<h4>Author: <a href="profile&user_id='.$this->author[0][0]['user_id'].'">'.$this->author[0][0]['title'].' '.$this->author[0][0]['first_name'].' '.$this->author[0][0]['surname'].'</a></h4>';
		$result = $result.'<h4>'.date('H:i jS M Y', strtotime($this->resourcearray[0]['date'])).'</h4>';
		$result = $result.'<p>'.wordwrap(substr($this->resourcearray[0]['description'],0,75),50 ,"\n",false).'</p>';
		$result = $result.'<button class="favorite" value="'.$this->resourcearray[0]['resource_id'].'">Favourite</button>';
		
		if($this->resourcearray[0]['url_address'] != '' || $this->resourcearray[0]['url_address'] != null){
			
			$result = $result.'<a href="'.$this->resourcearray[0]['url_address'].'" class="downloadCounter" id="'.$this->resourcearray[0]['resource_id'].'-'.$this->userID.'" target="_blank"><button class="url" >Go to Resource</button></a>';
		}else{
			$result = $result.'<form action = "downloaderv3.php" method = "POST">';
			$result = $result.'<input type="hidden" name="user_id" value="'.$this->userID.'" />';
			$result = $result.'<input type="hidden" name="file" value="'.$this->resourcearray[0]['resource_id'].'"/>';
			$result = $result.'<button class="download" value="'.$this->resourcearray[0]['resource_id'].'">Download</button>';
			$result = $result.'</form>';
		}
		$counter = $this->num->counter('resource_id',$this->resourcearray[0]['resource_id']);
		$result = $result.'<p>Comments ('.$counter['NUM'].') </p>';
		$result = $result.'</div>';
		return $result;	
	}
}

class user_owned_resourceobj extends resource{
		
	public function __construct($in_resource, $in_owner,$in_num){
	$this->author[] = $in_owner;	
	$this->resourcearray[] = $in_resource;
	$this->num = $in_num;
	
}
	
	public function getHTML(){
		
	
		$allID = explode(',',$this->resourcearray[0]['rated_user_id']);
		
		if(in_array($this->author[0]['user_id'],$allID)){
			$class = 'jDisabled';
		}else{$class='';}
		
		$result='<div class="resource_result_div">';
		$result = $result.'<div class="rating '.$class.'" id="'.$this->resourcearray[0]['rating'].'_'.$this->resourcearray[0]['resource_id'].'"></div>';
		$result = $result.'<a href="resource_discussion?resource_id='.$this->resourcearray[0]['resource_id'].'" >';
		
		$fileext = pathinfo($this->resourcearray[0]['filename']);
		$var = ($this->resourcearray[0]['file_type'] == 'url') ?  $this->resourcearray[0]['file_type']  :  $fileext['extension'] ;
			switch(strtolower($var)){
				case "url": $result = $result.'<img class="results_icon" src="images/htmls.png" alt="a url link"/>';break;
				case "txt": $result = $result.'<img class="results_icon" src="images/txts.png" alt="a text document"/>';break;
				case "avi": $result = $result.'<img class="results_icon" src="images/avi.png" alt="an avi file"/>';break;
				case "doc": $result = $result.'<img class="results_icon" src="images/docs.png" alt="a word document"/>';break;
				case "jpg": $result = $result.'<img class="results_icon" src="images/jpg.png" alt="an image file"/>';break;
				case "mp3": $result = $result.'<img class="results_icon" src="images/mp3.png" alt="an audio file"/>';break;
				case "mp4": $result = $result.'<img class="results_icon" src="images/mp4.png" alt="an audio or video file"/>';break;
				case "pdf": $result = $result.'<img class="results_icon" src="images/pdf.png" alt="a pdf document"/>';break;
				case "movs": $result = $result.'<img class="results_icon" src="images/movs.png" alt="a movie file"/>';break;
				case "png": $result = $result.'<img class="results_icon" src="images/png.png" alt="an image file"/>';break;
				case "gif": $result = $result.'<img class="results_icon" src="images/gif.png" alt="an image file"/>';break;
				default: $result = $result.'<img class="results_icon" src="images/docs.png" alt="a word document"/>';
				
			}
		
		$result = $result.'<h3>'.wordwrap($this->resourcearray[0]['title'],30,"<br>\n",true).'</h3></a>';
		$result = $result.'<h4>Author: '.$this->author[0]['title'].' '.$this->author[0]['first_name'].' '.$this->author[0]['surname'].'</a></h4>';
		$result = $result.'<h4>'.date('H:i jS M Y', strtotime($this->resourcearray[0]['date'])).'</h4>';
		$result = $result.'<p>'.wordwrap(substr($this->resourcearray[0]['description'],0,100),50 ,"\n",false).'</p>';
		$result = $result.'<button class="resourceDelete"  value="'.$this->resourcearray[0]['resource_id'].'">Delete</button>';
		
		if($this->resourcearray[0]['url_address'] != '' || $this->resourcearray[0]['url_address'] != null){
			
			$result = $result.'<a href="'.$this->resourcearray[0]['url_address'].'"  target="_blank"><button class="url" >Go to Resource</button></a>';
		}else{
			$result = $result.'<form action = "downloaderv3.php" method = "post">';
			$result = $result.'<input type="hidden" name="file" value="'.$this->resourcearray[0]['resource_id'].'"/>';
			$result = $result.'<button class="download" value="'.$this->resourcearray[0]['resource_id'].'">Download</button>';
			$result = $result.'</form>';
		}
		
		$counter = $this->num->counter('resource_id',$this->resourcearray[0]['resource_id']);
		$result = $result.'<p>Comments ('.$counter['NUM'].') </p>';
		$result = $result.'</div>';
		return $result;	
	}
}
?>