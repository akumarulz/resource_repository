<?php
require_once('connect.php');
require_once('database_query.php');
require_once('email_function.php');

$users = new database_query($pdo,'users');
$resourcetitle = $_GET['resourceTitle'];
$arr = ['user_id'=>$_GET['user_id']];
$found = $users->selectcols($arr);

$emails = explode(',',$_GET['emails']);
$i = 0;

foreach($emails as $email){
    $email = trim($email);
    $firstname = 'Sir/Madam';
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
			continue;
		}else{
            $message = 'Dear '.$firstname.' your friend or colleague '.ucfirst(strtolower($found['first_name'])).' '.ucfirst(strtolower($found['surname'])).' has recommended
            a resource you may be intereseted in <b>'.$resourcetitle.'</b> on <a href="" ><b>Teacher Share</b></a>';

            $msg = [
                'firstname' =>$firstname,
                'surname' =>$surname='',
                'email'=>$email,
                'subject'=>'Recommendation',
                'message'=>$message
            ];

            sendEmail($msg);
            $i++;
        }
}
echo "messages sent:".$i;

?>