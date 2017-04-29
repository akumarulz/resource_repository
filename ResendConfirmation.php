<?php
 require_once('email_function.php');
 require_once('connect.php');
 require_once('database_query.php');

if(strtoupper($_SERVER['REQUEST_METHOD']) === 'GET'){
$email = $_GET['email'];
$users = new database_query($pdo,'users');
$var = ['email'=>$email];
$id = $users->selectcols($var);
    if($id){

    $message = '<p>Please follow this link to confirm your account <a href = 
                        "http://127.0.0.1:8000/edsa-new%20dissertation%20folder/index.php?page=login&user_id='.$id['user_id'].'&confirmed=xy42plu">Confirm</a></p>';
            
                        $msg = [
                        'firstname' => $id['first_name'],
                        'surname'=>$id['surname'],
                        'email'=>$id['email'],
                        'subject'=> 'Confirm Account',
                        'message'=> $message
                        ];
                            
                        sendEmail($msg);
                    echo 'sent';
    }
}
?>