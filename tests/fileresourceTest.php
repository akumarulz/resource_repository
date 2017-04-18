<?php 
class fileTest extends PHPUnit\Framework\TestCase{
	public $Resourcefile;
	
	public function setUp(){
			$pdo = new PDO("mysql:host=127.0.0.1;dbname=repository","root","");
		$this->Resourcefile = new database_query($pdo,'document_resources');
	}

    //test a valid upload image
public function testValid(){
    //static::markTestSkipped('');
    $file = new resourcedocument();

     $finfo = finfo_open(FILEINFO_MIME_TYPE);
     //get the mime data
     $in_mime = finfo_file($finfo,dirname(__DIR__)."/../test files/acceptimg.png" );
    finfo_close($finfo);
    $content = file_get_contents(dirname(__DIR__)."/../test files/acceptimg.png");

    $size = filesize(dirname(__DIR__)."/../test files/acceptimg.png");
    $ext = pathinfo(dirname(__DIR__)."/../test files/acceptimg.png");
     
    $file->setConnection($this->Resourcefile);
    try{
        //inititate values
        $file->setUser_id(79);
        $file->setCategory_id(13);
        $file->setTitle('title');
        $file->setDescription('description');
        $file->setFilename($ext['filename']);
        $file->setFilecontents($content);
        $file->setFiletype($ext['extension'],$in_mime);
        $file->setFilesize($size);
        $file->saveResource();
        
    }catch(exception $e){
    $e->getMessage();
    }
    
    //retrieve upload and check correct values submitted
    $found = ['filename'=>$ext['filename']];
    $select = $this->Resourcefile->selectcol($found);
    $this->assertEquals($file->getFilesize(),$size);
    $this->assertEquals($file->getFilecontent(),$content);
    $this->assertEquals($file->getTitle(),$select[0]['title']);
    $this->assertEquals($file->getDescription(),$select[0]['description']);
    $this->assertEquals($file->getCategory_id(),$select[0]['category_id']);
    $this->assertEquals($file->getFiletype(),$select[0]['file_type']);

    //remove file from database
    $this->Resourcefile->remove($found);
    $select = $this->Resourcefile->selectcol($found);
    //check its been removed
    $this->assertEquals(0,sizeof($select));
}

public function testValidaudio(){
   // static::markTestSkipped('');
    $file = new resourcedocument();
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $in_mime = finfo_file($finfo, dirname(__DIR__)."/../test files/acceptaudio.wav");
    finfo_close($finfo);
    $content = file_get_contents(dirname(__DIR__)."/../test files/acceptaudio.wav");
    $size = filesize(dirname(__DIR__)."/../test files/acceptaudio.wav");
    $ext = pathinfo(dirname(__DIR__)."/../test files/acceptaudio.wav");
   
    $file->setConnection($this->Resourcefile);
    try{
        $file->setUser_id(79);
        $file->setCategory_id(13);
        $file->setTitle('title');
        $file->setDescription('description');
        $file->setFilename($ext['filename']);
        $file->setFilecontents($content);
        $file->setFiletype($ext['extension'],$in_mime);
        $file->setFilesize($size);
        $file->saveResource();
        
    }catch(exception $e){
    $error =  $e->getMessage();
    }

    $found = ['filename'=>$file->getFilename()];  
    $this->Resourcefile->remove($found);
    $select = $this->Resourcefile->selectcol($found);
    $this->assertEquals(0,sizeof($select));
}

public function testNonValidfile(){
    //static::markTestSkipped('');
    $error = null;
    $file = new resourcedocument();

     $finfo = finfo_open(FILEINFO_MIME_TYPE);
     $in_mime = finfo_file($finfo, dirname(__DIR__)."/../test files/failtype.mwb");
     finfo_close($finfo);
    $content = file_get_contents(dirname(__DIR__)."/../test files/failtype.mwb");
    $size = filesize(dirname(__DIR__)."/../test files/failtype.mwb");
    $ext = pathinfo(dirname(__DIR__)."/../test files/failtype.mwb");
    
    $file->setConnection($this->Resourcefile);
    try{
        $file->setUser_id(79);
        $file->setCategory_id(13);
        $file->setTitle('title');
        $file->setDescription('description');
        $file->setFilename($ext['filename']);
        $file->setFilecontents($content);
        $file->setFiletype($ext['extension'],$in_mime); //test this causes error due to wrong file extension
        $file->setFilesize($size);
        $file->saveResource();
        
    }catch(exception $e){
    $error =  $e->getMessage();
    }

     $this->assertEquals('File type not accepted '.$ext['extension'],$error);
}

public function testTooLargefile(){
    //static::markTestSkipped('');
    $error = null;
    $er=null;

    $file = new resourcedocument();

     $finfo = finfo_open(FILEINFO_MIME_TYPE);
     $in_mime = finfo_file($finfo, dirname(__DIR__)."/../test files/failesize.mp4");
    finfo_close($finfo);
    $content = file_get_contents(dirname(__DIR__)."/../test files/failesize.mp4");
    $size = filesize(dirname(__DIR__)."/../test files/failesize.mp4");
    $ext = pathinfo(dirname(__DIR__)."/../test files/failesize.mp4");
     
    $file->setConnection($this->Resourcefile);
    try{
        $file->setUser_id(79);
        $file->setCategory_id(13);
        $file->setTitle('title');
        $file->setDescription('description');
        $file->setFilename($ext['filename']);
        $file->setFilecontents($content);
        $file->setFiletype($ext['extension'],$in_mime);
        $file->setFilesize($size); // check this causes error due to file size too large.
        $file->saveResource();
        
    }catch(exception $e){
    $error =  $e->getMessage();
    }

     $this->assertEquals('Empty file or file larger than 200MB',$error);
}

}
?>