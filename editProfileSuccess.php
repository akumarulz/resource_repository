<script>
	$(document).ready(function () {
    // Handler for .ready() called.
    window.setTimeout(function () {
        location.href = "<?php echo 'index.php?page=profile';?>";
    }, 3000);
});
</script>
<div class="confirm_box">
	<?php if(isset($_POST['reply'])) echo '<p>'.$_POST['reply'].'</p>'; else echo '<p>Profile Updated</p>'; ?>
    <img src="images/tick_16.png" alt="confirmation tick" />
</div>