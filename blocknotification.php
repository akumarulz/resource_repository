<<<<<<< HEAD
<?php
require_once('connect.php');
require_once ('autoload.php');
if ($_SERVER['REQUEST_METHOD'] ==='GET'){
$ar = explode('-',$_GET['id']);
    $var = new notificationobj();
    $var->setNotificationId($ar[0]);
    $var->setConn(new database_query($pdo,'notifications'));
    $result = $var->block();
        if($result){
            echo '1';
        }
}
=======
<?php
require_once('connect.php');
require_once ('autoload.php');
if ($_SERVER['REQUEST_METHOD'] ==='GET'){
$ar = explode('-',$_GET['id']);
    $var = new notificationobj();
    $var->setNotificationId($ar[0]);
    $var->setConn(new database_query($pdo,'notifications'));
    $result = $var->block();
        if($result){
            echo '1';
        }
}
>>>>>>> origin/master
?>