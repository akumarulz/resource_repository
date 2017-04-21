
<?php
if ($_SERVER['REQUEST_METHOD'] ==='POST'){
    //get pdo object and query class
    require_once 'email_function.php';
    require_once 'connect.php';
    require_once 'database_join_queries.php';

//variables sent from uploadResource script
$user_id = $_POST['user_id'];
$resource = $_POST['resource_id'];
$category_id = $_POST['category_id'];

//set connection, make array and retrieve results to send emails to.
$conn = new database_join_queries($pdo);
$array = [
    'subject_id'=>$category_id,
    'resource_id'=>$resource,
    'user_id'=>$user_id
];

$results = $conn->sendUploadNotification($array);

//if results send them an email. of new uploadResource
if($results){
        $i = 0;
    foreach($results as $result){

    $firstname = ucfirst(strtolower($result['first_name']));
    $surname = ucfirst(strtolower($result['surname']));
    
    $message = 'Dear '.$firstname.' '.$surname.' A new resource, <b>'.$result['title'].'</b> has been uploaded in a subject area you are interested in on the <b>Teacher Share</b> repository.';

        $email = [
            'firstname'=> $firstname,
            'surname'=> $surname,
            'email'=>$result['email'],
            'subject'=>'New Resource Available',
            'message'=> $message
        ];

        sendEmail($email);
        $i++;
    }
    echo 'Messages sent:'.$i;
}
}
?>