<<<<<<< HEAD
 <h1>Search Forum</h1>
<div class="resource_side_div">
<!--<a href="newtopic">New topic</a>-->
	<div class="resource_panel">
		<form id = "forum_search" class="resource_search_form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"].'&page=forums');?>" method="GET">
			<label for="topic">Search Forum titles :</label><br>
			<input id="topic" type="text" name="search[title]" value="<?php if(isset($criteria['search']['title'])) echo $criteria['search']['title']; ?>" /><br><br>
			
			<label for="name">Search Member Name: </label><br>
				<input id="searchName" type="input" name="search[user_search]" value="<?php if(isset($criteria['search']['user_search'])) echo $criteria['search']['user_search']; ?>" autocomplete="off" />			
			<input id="searchID" type ="hidden" value="<?php if(isset($criteria['search']['user_id'])) echo $criteria['search']['user_id']; ?>" name="search[user_id]"/>
			<ul id="livesearch" class="livesearch"></ul>
			<br><br>
			<label for="topic_cat">Categories:</label><br>
				<select id="topic_cat" name="search[category]">
					<option value="">ALL</option>
					<option value="Programming" <?php if(isset($criteria['search']['category']) && $criteria['search']['category'] == 'programming') echo 'selected'; ?> >Programming</option>
					<option value="HTML" <?php if(isset($criteria['search']['category']) && $criteria['search']['category'] == 'HTML') echo 'selected'; ?> >HTML & CSS</option>
					<option value="Design and Development" <?php if(isset($criteria['search']['category']) && $criteria['search']['category'] == 'Design and Development') echo 'selected'; ?> >Design and Development</option>
					<option value="General" <?php if(isset($criteria['search']['category']) && $criteria['search']['category'] == 'general') echo 'selected'; ?> >General IT</option>
					<option value="Databases" <?php if(isset($criteria['search']['category']) && $criteria['search']['category'] == 'databases') echo 'selected'; ?> >Databases</option>
					<option value="Systems" <?php if(isset($criteria['search']['category']) && $criteria['search']['category'] == 'systems') echo 'selected'; ?> >Computer Systems</option>
				</select>
				<br><br>
				
				Favorite only:<br>
				<input type ="checkbox" name="favorite" value="favorite" />
				<br><br>
				
				Search between dates:<br>
				<label for="fdate">From:</label><br>
				<input id="fdate" type="date"  name="search[from_date]" value="<?php if(isset($criteria['search']['from_date'])) echo $criteria['search']['from_date']; ?>" /><br>
				<label for="tdate">To:</label><br>
				<input id="tdate" type="date" name="search[to_date]" value="<?php if(isset($criteria['search']['to_date'])) echo $criteria['search']['to_date']; ?>" />
				<br><br>
					Results per Page: <br>
					<input id="step" type="number" name="search[numResult]" min="1" max="100" step="1" value="<?php if (isset($criteria['search']['numResult'])) {echo $criteria['search']['numResult'];} else {echo 5;} ?>" /><br><br>

				<input id="asc" type="hidden" name="search[asc]" value="" />
				<input class="submit" type="submit" />
				<input type="hidden" name="search[query]" value="<?php if (isset($query)) echo $query; ?>"/>
		</form>
	</div>


</div>
<div class="resource_main_div">
 <h3>Results</h3>
<?php echo $pageCtrl;?>
	<!-- image reference:  https://www.iconfinder.com/icons/132465/arrow_go_move_push_raise_up_update_upload_icon#size=24 -->
	<img class = "sortArrow"src = "images/Raise.png" alt = "results in ascending or descending order" />
	<?php 
	if(sizeof($topics) > 0){
		
			foreach($topics as $topic){
				if ($topic['blocked_users'] == 'ARCHIVED'){continue;}
				$topic['topic_id'] = new topicobj($topic);
				
				$topic['topic_id']->setConn($users);
				$topic['topic_id']->setNum($dbconn);
				echo $topic['topic_id'] ->getHTML();
			}
		
	}else{
		echo 'No Results';
	}
		
		?>
	
	</div>
=======
 <h1>Search Forum</h1>
<div class="resource_side_div">
<!--<a href="newtopic">New topic</a>-->
	<div class="resource_panel">
		<form id = "forum_search" class="resource_search_form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"].'&page=forums');?>" method="GET">
			<label for="topic">Search Forum titles :</label><br>
			<input id="topic" type="text" name="search[title]" value="<?php if(isset($criteria['search']['title'])) echo $criteria['search']['title']; ?>" /><br><br>
			
			<label for="name">Search Member Name: </label><br>
				<input id="searchName" type="input" name="search[user_search]" value="<?php if(isset($criteria['search']['user_search'])) echo $criteria['search']['user_search']; ?>" autocomplete="off" />			
			<input id="searchID" type ="hidden" value="<?php if(isset($criteria['search']['user_id'])) echo $criteria['search']['user_id']; ?>" name="search[user_id]"/>
			<ul id="livesearch" class="livesearch"></ul>
			<br><br>
			<label for="topic_cat">Categories:</label><br>
				<select id="topic_cat" name="search[category]">
					<option value="">ALL</option>
					<option value="Programming" <?php if(isset($criteria['search']['category']) && $criteria['search']['category'] == 'programming') echo 'selected'; ?> >Programming</option>
					<option value="HTML" <?php if(isset($criteria['search']['category']) && $criteria['search']['category'] == 'HTML') echo 'selected'; ?> >HTML & CSS</option>
					<option value="Design and Development" <?php if(isset($criteria['search']['category']) && $criteria['search']['category'] == 'Design and Development') echo 'selected'; ?> >Design and Development</option>
					<option value="General" <?php if(isset($criteria['search']['category']) && $criteria['search']['category'] == 'general') echo 'selected'; ?> >General IT</option>
					<option value="Databases" <?php if(isset($criteria['search']['category']) && $criteria['search']['category'] == 'databases') echo 'selected'; ?> >Databases</option>
					<option value="Systems" <?php if(isset($criteria['search']['category']) && $criteria['search']['category'] == 'systems') echo 'selected'; ?> >Computer Systems</option>
				</select>
				<br><br>
				
				Favorite only:<br>
				<input type ="checkbox" name="favorite" value="favorite" />
				<br><br>
				
				Search between dates:<br>
				<label for="fdate">From:</label><br>
				<input id="fdate" type="date"  name="search[from_date]" value="<?php if(isset($criteria['search']['from_date'])) echo $criteria['search']['from_date']; ?>" /><br>
				<label for="tdate">To:</label><br>
				<input id="tdate" type="date" name="search[to_date]" value="<?php if(isset($criteria['search']['to_date'])) echo $criteria['search']['to_date']; ?>" />
				<br><br>
					Results per Page: <br>
					<input id="step" type="number" name="search[numResult]" min="1" max="100" step="1" value="<?php if (isset($criteria['search']['numResult'])) {echo $criteria['search']['numResult'];} else {echo 5;} ?>" /><br><br>

				<input id="asc" type="hidden" name="search[asc]" value="" />
				<input class="submit" type="submit" />
				<input type="hidden" name="search[query]" value="<?php if (isset($query)) echo $query; ?>"/>
		</form>
	</div>


</div>
<div class="resource_main_div">
 <h3>Results</h3>
<?php echo $pageCtrl;?>
	<!-- image reference:  https://www.iconfinder.com/icons/132465/arrow_go_move_push_raise_up_update_upload_icon#size=24 -->
	<img class = "sortArrow"src = "images/Raise.png" alt = "results in ascending or descending order" />
	<?php 
	if(sizeof($topics) > 0){
		
			foreach($topics as $topic){
				if ($topic['blocked_users'] == 'ARCHIVED'){continue;}
				$topic['topic_id'] = new topicobj($topic);
				
				$topic['topic_id']->setConn($users);
				$topic['topic_id']->setNum($dbconn);
				echo $topic['topic_id'] ->getHTML();
			}
		
	}else{
		echo 'No Results';
	}
		
		?>
	
	</div>
>>>>>>> origin/master
	