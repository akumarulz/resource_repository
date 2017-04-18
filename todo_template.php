<?php

require_once('autoload.php');
$var = new database_query($pdo,'users');
$find = ['user_id'=>$user_id];
$found1 = $var->selectcol($find);

$var2 = new database_query($pdo,'workhistory');
$found2= $var2 -> selectcol($find);

$var3 = new database_query($pdo,'has_specialist_subject');
$found3 = $var3->selectcol($find);
	$completed = 0;
    echo '<ul class="to_do" >
    <li>
            <strong>Things to do</strong>
    </li>';

        if($found1[0]['personalSummary'] == ""){
			$completed = 1;
          echo   '<li>
                   <a href="'.htmlspecialchars($_SERVER["PHP_SELF"].'?page=editProfile&edit=Edit Summary').'" > <p>Finish profile summary</p></a>
                  </li>';
        }

        if(sizeof($found2) < 1){
			$completed = 1;
          echo  '<li>
                    <a href="'.htmlspecialchars($_SERVER["PHP_SELF"].'?page=editProfile&edit=Add Work history').'" ><p>Finish work history</p></a>
                </li>';
        }

        if(sizeof($found3) < 1){
			$completed = 1;
             echo  '<li>
                    <a href="'.htmlspecialchars($_SERVER["PHP_SELF"].'?page=editProfile&edit=Edit Interests').'" ><p>Add specialist area</p></a>
                </li>';
        }
		
		if($completed == 0){
			echo   '<li>
					<p>Nothing to do</p>
                  </li>';
		}

    echo '</ul>'; 


?>