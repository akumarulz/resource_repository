
<?php
require 'session.php';
require 'autoload.php';
require 'connect.php';
require 'template_loader.php';

//for landing on the page, set the first page to the 
//home page
if(!isset($_GET['page'])){
	require $_GET['page'] = 'login.php';
}else{
	require $_GET['page'].'.php';
}

//check if a user is logged in 
$logged_in = (isset($_SESSION['logged_in'])== true) ? true : false ;

//if logged in, check if they have admin priviledges
$_SESSION['is_admin'] = null;
if($logged_in){
$var = new database_query($pdo,'users');
$search =['user_id'=>$_SESSION['user_id']];
$result = $var->selectcols($search);
$_SESSION['is_admin']=$result['is_admin'];	
}

$templateVars = [
'logged_in'=>$logged_in,
'is_admin'=>$_SESSION['is_admin'],
'title' => $title,
'content'=> $content
];

echo loadTemplate('main.php', $templateVars);

?>