<li class="active">
	<?php if(Auth::instance()->logged_in()): ?>
		<?php echo HTML::anchor('logout', 'Logout'); ?>
	<?php else: ?>
		<?php echo HTML::anchor('login', 'Login'); ?>
	<?php endif; ?>
</li>