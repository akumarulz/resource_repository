	<h1><?php if (isset($editResource['resource_id'])) echo'Edit Resource'; else echo 'Add Resource'; ?></h1>
	<div class="resource-submit-form">

		<form id="<?php// if (isset($formName)) echo $formName; else echo 'documentupload'; ?>" action ="<?php echo htmlspecialchars($_SERVER["PHP_SELF"].'?page=upLoadResource');?>" method="POST" enctype="multipart/form-data" >
		<label for="selectedsubjectarea" >Subject Area: </label>
			<?php 
			$in_subject_id= null;
			if(isset($editResource['category_id'])){
				$in_subject_id = $editResource['category_id'];
			}elseif(isset($submitError['resourcedoc']['subject'])){
				$in_subject_id = $submitError['resourcedoc']['subject'];
			}else{
				$in_subject_id =1;
			}
			
			if(isset($subjects)) {
				//display the subject areas  through class
				$selectlist = new selectsubjectsobj($subjects, $in_subject_id);
				echo $selectlist->getHTML();
			}
			
			?>
			
				
				<input id="resourceiD" type="hidden" name="resourcedoc[resource_id]" value="<?php if(isset($editResource['resource_id'])) echo $editResource['resource_id'];?>" />
				<br><br><label for="title" >Title: </label><input id = "title" type="text" name="resourcedoc[title]" value="<?php if(isset($editResource['title'])) echo $editResource['title']; elseif (isset($submitError['resourcedoc']['title'])) echo $submitError['resourcedoc']['title']; ?>" /><br>
				<br><label for = "description">Description: </label><br>
				<textarea id = "description" rows="7" cols="70" name="resourcedoc[description]" ><?php if(isset($editResource['description'])) echo $editResource['description']; elseif (isset($submitError['resourcedoc']['description'])) echo $submitError['resourcedoc']['description'];?></textarea> <br>
				
				<?php if(isset($editResource)) echo '<p>Leave blank to keep the file you have already uploaded. 
				If you have uploaded a file in error, you can replace it by selecting it here.</p>'; ?>
				<input type="file" name="resourcedoc"  />
				<input type="submit" />
		</form>
		<span id="Reply" ><?php if(isset($error)) echo $error;?></span>
	</div>