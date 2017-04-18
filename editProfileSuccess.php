<<<<<<< HEAD
<script>
	$(document).ready(function () {
    // Handler for .ready() called.
    window.setTimeout(function () {
        location.href = "<?php echo 'index.php?page=profile';?>";
    }, 3000);
});
</script>
<div>
	<?php if(isset($_POST['reply'])) echo '<p>'.$_POST['reply'].'</p>'; else echo '<p>Profile Updated</p>'; ?>
=======
<script>
	$(document).ready(function () {
    // Handler for .ready() called.
    window.setTimeout(function () {
        location.href = "<?php echo 'index.php?page=profile';?>";
    }, 3000);
});
</script>
<div>
	<?php if(isset($_POST['reply'])) echo '<p>'.$_POST['reply'].'</p>'; else echo '<p>Profile Updated</p>'; ?>
>>>>>>> origin/master
</div>