
<?php if(isset($editTopic) != null || (isset($forum['topic_id']) && $forum['topic_id'] > 0)) echo '<h1>Edit Topic</h1>'; else echo '<h1>New Topic</h1>' ?>
	<fieldset class="ResourceSubmissionForm">
		<?php if(isset($editTopic) != null || (isset($forum['topic_id']) && $forum['topic_id'] > 0)) echo '<legend>Edit Topic</legend>'; else echo '<legend>Start New Topic</legend>' ?>
			<form id="forumForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"].'?page=newtopic');?>" method="POST">
				<input type="hidden" name="forum[topic_id]" value="<?php if(isset($editTopic) != null) echo $editTopic->getTopicId(); if(isset($forum['topic_id'])) echo $forum['topic_id'];?>" />
				<label for="title">Title: </label><input id="title" name="forum[topic_title]" value="<?php if(isset($forum['topic_title'])) echo $forum['topic_title']; if(isset($editTopic) != null) echo $editTopic->getTitle();?>" maxlength="100" /> 100 Character Limit<br>
				<br><label for="topic_cat">Select A Category:</label><br>
						<select id="topic_cat" name="forum[category]">
							<option value="Programming" <?php if((isset($editTopic) != null && $editTopic->getCategory() == 'Programming') || (isset($forum['category']) && $forum['category'] == 'Programming')) echo 'selected';?> >Programming</option>
							<option value="HTML" <?php if((isset($editTopic) != null && $editTopic->getCategory() == 'HTML') || (isset($forum['category']) && $forum['category'] == 'HTML')) echo 'selected';?> >HTML & CSS</option>
							<option value="Design and Development" <?php if((isset($editTopic) != null && $editTopic->getCategory() == 'Design and Development') || (isset($forum['category']) && $forum['category'] == 'Design and Development')) echo 'selected';?> >Design and Development</option>
							<option value="General Computing" <?php if((isset($editTopic) != null && $editTopic->getCategory() == 'General Computing') || (isset($forum['category']) && $forum['category'] == 'General Computing')) echo 'selected';?> >General IT</option>
							<option value="Databases" <?php if((isset($editTopic) != null && $editTopic->getCategory() == 'Databases') || (isset($forum['category']) && $forum['category'] == 'Databases')) echo 'selected';?> >Databases</option>
							<option value="Systems" <?php if((isset($editTopic) != null && $editTopic->getCategory() == 'Systems') || (isset($forum['category']) && $forum['category'] == 'Systems')) echo 'selected';?> >Computer Systems</option>
						</select>
						<br><br>
				
				<label for="desc">Topic Description: </label><br>
				<textarea id="desc" name="forum[topic_description]" rows="5" cols="60" maxlength="2000" ><?php if(isset($forum['topic_description'])) echo trim($forum['topic_description']); if(isset($editTopic) != null) echo $editTopic->getDesc();?></textarea><br>
				<p>2000 character limit</p> <br>
				<input type="submit" />
			</form>
			<p>All fields are required</p>
			<span><?php if (isset($Emessage)) echo $Emessage; ?> </span>
	</fieldset>
	
