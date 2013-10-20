<?php if (isset($flash_error)): ?>
	<div class="alert alert-danger"><?php echo $flash_error; ?></div>
<?php endif; ?>

<?php if (isset($flash_success)): ?>
	<div class="alert alert-success"><?php echo $flash_success; ?></div>
<?php endif; ?>

<?php if (isset($flash_info)): ?>
	<div class="alert alert-info"><?php echo $flash_info; ?></div>
<?php endif; ?>