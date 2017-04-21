 <h1>Search Resources</h1>	
<div class="resource_side_div">

	<div class="resource_panel">
		<form id="resource_sr" class="resource_search_form" action="<?php echo $_SERVER['PHP_SELF'].'&page=resources' ?>" method="GET">
			Search Title of Resources:<br>
			<input type="text" name="search[title]" value="<?php if(isset($search_criteria['search']['title'])) echo $search_criteria['search']['title']; ?>" />
		<br><br>
				Resource type:<br>
				<select name="search[type]">
				<option value="">All</option>
				<option value="application" <?php if (isset($search_criteria['search']['type']) && $search_criteria['search']['type']=='application') echo 'selected'; ?> >Document</option>
				<option value="text" <?php if (isset($search_criteria['search']['type']) && $search_criteria['search']['type']=='text') echo 'selected'; ?> >Plain Text</option>
				<option value="audio" <?php if (isset($search_criteria['search']['type']) && $search_criteria['search']['type']=='audio') echo 'selected'; ?> >Audio</option>
				<option value="video" <?php if (isset($search_criteria['search']['type']) && $search_criteria['search']['type']=='video') echo 'selected'; ?> >video</option>
				<option value="image" <?php if (isset($search_criteria['search']['type']) && $search_criteria['search']['type']=='image') echo 'selected'; ?> >Images</option>
				<option value="url" <?php if (isset($search_criteria['search']['type']) && $search_criteria['search']['type']=='url') echo 'selected'; ?> >Link</option>
				</select>
				<br><br>
				Categories:<br>
				<?php if(isset($subjects)) {
					//display the subject areas through class object
					//create an empty select item
					$temp =array();
					array_push($temp,$subjects[0]);
					$subjects[0]['speciality_id']='';
					$subjects[0]['specialist_area']='All';
					$n = count($subjects);
					$subjects[$n]['speciality_id']=$temp[0]['speciality_id'];
					$subjects[$n]['specialist_area']=$temp[0]['specialist_area'];
					
					$selectlist = new selectsubjectsobj($subjects,$search_criteria['resourcedoc']['subject']);
					echo $selectlist->getHTML();
					}
				?>
				
				<br><br>Favorite only:<br>
				<input type ="checkbox" name="search[favorite]" value="favorite" />
				<br><br>
				Search By Member Name:<br>
				<input id="searchName" type="text" name="search[user_search]" value = "<?php if (isset($search_criteria['search']['user_search'])) echo $search_criteria['search']['user_search']; ?>" autocomplete="off"/>
				<input id="searchID" type ="hidden" value="" name="search[user_id]"/>
				<ul id="livesearch" class="livesearch"></ul>
				<br><br>
				Search between dates:<br>
				From:<br>
				<input type="date" name="search[from_date]" value = "<?php if (isset($search_criteria['search']['from_date'])) echo $search_criteria['search']['from_date']; ?>" /><br>
				To:<br>
				<input type="date" name="search[to_date]" value = "<?php if (isset($search_criteria['search']['to_date'])) echo $search_criteria['search']['to_date']; ?>" />
				<br><br>
				Results per Page: <br>
				<input id="step" type="number" name="search[numResult]" min="1" max="100" step="1" value="<?php if (isset($search_criteria['search']['numResult'])) {echo $search_criteria['search']['numResult'];} else {echo 5;} ?>" /><br><br>
								
				<input id = "asc" type="hidden" name="search[asc]" value = "<?php if (isset($search_criteria['search']['asc'])) echo $search_criteria['search']['asc']; ?>" />
				
				
				<input class="submit" type="submit" />
		</form>
	

	</div>
<span id="test"></span>
</div>
<div class="resource_main_div">
<h2>Results</h2>
<?php echo $pageCtrl;?>
<!-- image reference:  https://www.iconfinder.com/icons/132465/arrow_go_move_push_raise_up_update_upload_icon#size=24 -->
<img class = "sortArrow" src = "images/Raise.png" alt = "results in ascending or descending order" />
	
	<?php 
	require_once('resource.php');
if(sizeof($docs)>0 ){
	
		foreach($docs as $rows){
			if ($rows['blocked_users'] == 'ARCHIVED'){continue;}
				
			$rows['resource_id'] = new resourceobj($rows,$connect,$userID,$dbconn);
			echo $rows['resource_id']->getHTML();
		}
}else{
	echo 'No Results';
}
	?>
</div>