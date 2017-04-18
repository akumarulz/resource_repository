<?php
$users = new database_query($pdo, 'users');
$UH = new database_query($pdo, 'userhistorytable');
//$setup = new database_join_queries($pdo);
$valid = false;
$user = null;
$response = null;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST['user']['checker'] == 1) {
        //check to make sure the email address is not already used
        $array=['email'=>$_POST['user']['email']];
        $result = $users->selectcols($array);
        
        //if no matching email found-->
        if (!$result) {
            // validate and enter new user details
                    
            try {
                $member = new memberobj();
                
                $member->setTitle($_POST['user']['title']);
                $member->setFirstname($_POST['user']['first_name']);
                if ($_POST['user']['middle_name'] != '') {
                    $member->setMiddlename($_POST['user']['middle_name']);
                }
                $member->setSurname($_POST['user']['surname']);
                $member->setEmail($_POST['user']['email']);
                $member->setLocation($_POST['user']['location']);
                $member->setSchool($_POST['user']['school_name']);
                $member->setPassword($_POST['user']['password']);
                
                $valid = $member->savenew($users);
				if(!$valid){
					throw new Exception("Error completing request please try again");
					}
            } catch (Exception $e) {
                $response = $e->getMessage();
            }
        
            
            if ($valid) {
                require_once('email_function.php');
                //if valid get user id and create new tables
                $array = ['email'=>$_POST['user']['email']];
                    $id = $users->selectcols($array);
                if ($id) {
                    $var = ['user_id'=>$id['user_id']];
                    $UH->save($var, '');
                        
                   //send email to new registered member
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
                }
            }

            $user = $_POST['user'];
        } else {
            $response='Email address already registered';
        }
    } else {
        $response='passwords do not match';
    }
}

if ($valid) {
    //load success page with instructions to new member
    $templateVars = [
        'page'=>'login',
        'reply'=>'Thank you for registering. Activate account by following the link sent to your email address'
        ];
        
        $title = 'Thank you';
        $content = loadTemplate('user_thankyou_template.php', $templateVars);
} else {
    //load register page with error message or just load page when user first opens page.
    $templateVars = [
    'user'=>$user,
    'response'=>$response
    ];
    $title = 'Register';
    $content = loadTemplate('register_template.php', $templateVars);
}
?>