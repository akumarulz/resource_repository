<h1><?php if ($resource != null) echo'Edit Resource'; else echo 'Add Link'; ?></h1>
<div class="link-submit-form">
	
	<form id="urlSubmitForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"].'?page=linkresource_upload');?>" method="POST">
		<label for="selectedsubjectarea">Subject Area </label>
			<?php 
			$in_subject_id= null;
			if(isset($editResource['category_id'])){
				$in_subject_id = $editResource['category_id'];
			}elseif(isset($postedResource['resourcedoc']['subject'])){
				$in_subject_id = $postedResource['resourcedoc']['subject'];
			}else{
				$in_subject_id = 1;
			}
			
			if(isset($subjects)) {
							//display the subject areas  through class
							$selectlist = new selectsubjectsobj($subjects,$in_subject_id);
							echo $selectlist->getHTML();
							}
						?>
				<input id= "resourceId" type="hidden" name="link[resource_id]" value="<?php if(isset($resource[0]['resource_id'])) echo $resource[0]['resource_id']; if(isset($postedResource['link']['resource_id'])) echo $postedResource['link']['resource_id'];?>" />
				<br><br><label for="title">Link Resource Title </label><input id="title" type="text" name="link[title]" value="<?php if(isset($resource[0]['title'])) echo $resource[0]['title']; if(isset($postedResource['link']['title'])) echo $postedResource['link']['title']; ?>" /><br><br>
				<label for="linkdesc">Link Description </label><br><textarea id="linkdesc" cols="50" rows="8" name="link[description]" ><?php if(isset($resource[0]['description'])) echo $resource[0]['description'];  if(isset($postedResource['link']['description'])) echo $postedResource['link']['description']; ?></textarea><br>
				<br><label for="url">URL </label><input id="url" type="url" name="link[url_address]" value="<?php if(isset($resource[0]['url_address'])) echo $resource[0]['url_address']; else echo"https://" ;  if(isset($postedResource['link']['url_address'])) echo $postedResource['link']['url_address']; ?>"/><br>
				<input id = "user_id" type="hidden" name="link[user_id]" value="<?php if(isset($userID)) echo $userID;?>" />
				<input type="submit" value="submit" />

	</form>
	<span id="output" ><?php if(isset($msg)) echo $msg; ?></span>
	<div class="tooltip tooltip_wh"><img src="images/questionmark.png" alt="a question mark for a tool tip"/> <span class="tooltiptext">The description should briefly describe what the URL is about and how it can benefit a teacher who may use it. Only submit URL's pertaining to computing or they may be removed.</span></div>
	
</div>


