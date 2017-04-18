<<<<<<< HEAD
<?php
require_once ('connect.php');
require_once('autoload.php');
if ($_SERVER['REQUEST_METHOD'] ==='GET'){
    $remove = new friendsobj();
    $remove->setConn(new database_query($pdo,'friends'));
    $remove->setRowId($_GET['id']);
    $result = $remove->unfriend();
    if($result){
        echo '1';
    }
}
=======
<?php
require_once ('connect.php');
require_once('autoload.php');
if ($_SERVER['REQUEST_METHOD'] ==='GET'){
    $remove = new friendsobj();
    $remove->setConn(new database_query($pdo,'friends'));
    $remove->setRowId($_GET['id']);
    $result = $remove->unfriend();
    if($result){
        echo '1';
    }
}
>>>>>>> origin/master
?>