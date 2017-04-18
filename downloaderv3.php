<?php
require_once('connect.php');
require_once('autoload.php');
$var = new database_query($pdo,'document_resources');
$his = new database_query($pdo,'download_history');

if ($_SERVER['REQUEST_METHOD'] ==='GET'){

$user_id =  $_GET['user_id'];
$resourceId =  $_GET['resourceid'];

//add to download history
 $dl = new downloadhistoryobj();
        $dl->setConn($his);
        $dl->setUserid($user_id);
        $dl->setResourceId($resourceId);
        $dl->insert();
//find resource
    $array = ['resource_id'=>$resourceId];
    $result = $var->selectcol($array);
//increase downloaded counter by 1 and save back 
    $count = ['resource_id' => $result[0]['resource_id'], 'downloaded'=>($result[0]['downloaded']+1)];
    $counted = $var->save($count,'resource_id');

}else{

        $user_id = $_POST['user_id']; // use this to add to a down load history table
        $resourceId = $_POST['file'];
        $array = ['resource_id'=>$resourceId];
        $result = $var->selectcol($array);

        //insert into download history table
        $dl = new downloadhistoryobj();
        $dl->setConn($his);
        $dl->setUserid($user_id);
        $dl->setResourceId($resourceId);
        $dl->insert();
        //add one to download counter
        $count = ['resource_id' => $result[0]['resource_id'], 'downloaded'=>($result[0]['downloaded']+1)];
        $counted = $var->save($count,'resource_id');

        if($result){
        header('Pragma: public');
        header('Expires: -1');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Content-Disposition: attachment; filename='.$result[0]['filename'].'');
        header('Content-Transfer-Encoding: binary');
        header('Content-length: '.$result[0]['file_size'].'');
        header('Content-type: '.$result[0]['file_type'].'');
        ob_clean();
        flush();
        echo $result[0]['filecontent'];
        }
}
?>