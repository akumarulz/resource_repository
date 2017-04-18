<div id="col1">
	<?php echo $todo; ?>
	
	<div class="friends_notifictions_div">
	<h3>Friend Requests</h3>
	<?php 
	if(sizeof($friendRequest) >0 ){
		
			foreach($friendRequest as $item){
				$n = 0;
				$item[$n] = new friendRequestobj($item);
				echo $item[$n]->getHTML();
				$n++;
			}
		
	}else{
		echo 'No Requests';
	}
		?>
		</div>
		<div class="friends_notifictions_div">
<h3>Friends</h3>
<?php 
if(sizeof($friends) > 0){
	 	$i = 0;
		foreach($friends as $friend){
			
			$user['user_id'] = new newuserobj($friend[$i][0],$friend[$i][1]);
			echo $user['user_id']->getHTML();
			$i++;
		}
	
}else{
	echo 'No Friends';
}
	?>
</div>

</div>

<!--</div>-->
	<div id="col2">
		<div class="notifications_messges_div">
		<h3>Notifications</h3>
			<?php 
			if(sizeof($summary) > 0){
				
					foreach($summary as $item){
						$n = 0;
						$item[$n] = new summaryobj($item);
						echo $item[$n]->getHTML();
						$n++;
					}
				
			}else{
				echo 'No Notifications';
			}
			?>
		
	</div>
</div>

<div id="col3">
	<div class="search_div">
		<h3>Search</h3>
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"].'?page=resources');?>" method="POST" class="summary_search">
			Search Resources
			<input type="text" name="search[title]" />
			<input class="submit" type="submit" />
			<input type="hidden" name="search[type]" />
			<input type="hidden" name="resourcedoc[subject]" />
			<input type="hidden" name="search[user_id]" />
			<input type="hidden" name="search[asc]" />
			<input type="hidden" name="search[from_date]" />
			<input type="hidden" name="search[to_date]" />
			<input type="hidden" name="search[numResults]" value="5" />
		</form>
	</div>

	<div class = "recommendations_div"> 
	<h3>Recommendations</h3>
	<ul>
	<?php
	
	if(sizeof($recommendations > 0) && $recommendations != null){
		foreach($recommendations as $items){
			
			foreach($items as $item){
				$id =  $item['resource_id'];
			$item['resource_id'] = new resource();
			$item['resource_id']->setTitle($item['title']);
			$item['resource_id']->setResource_id($id);
			$filename = ($item['filename'] != '') ? $item['filename'] : 'URL';
			$item['resource_id']->setDescription($filename);
			$item['resource_id']->setRating($item['rating']);
			echo $item['resource_id']->getHTML();
			}
		}
	}else{
		echo '<p>None</p>';
	}
	?>
	</ul>
	</div>

		<div class="new_users_div">
			<h3>New in the network</h3>
		<?php
			if(sizeof($newusers) > 0){

					foreach($newusers as $user){
						$user['user_id'] = new newuserobj($user);
						echo $user['user_id']->getHTML();
					}
				
			}else{
				echo 'No new users';
			}
		?>
	</div>
</div>
