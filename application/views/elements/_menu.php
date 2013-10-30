<?php if (ACL::is_admin()): ?>
	<li><?php echo HTML::anchor('admin/member', 'Members'); ?></li>
	<li><?php echo HTML::anchor('admin/transaction', 'Transactions'); ?></li>
	<li><?php echo HTML::anchor('admin/access', 'Access'); ?></li>
<?php elseif (Auth::instance()->logged_in()): ?>
	<li><?php echo HTML::anchor('transaction', 'Transactions'); ?></li>
	<li><?php echo HTML::anchor('access', 'Access'); ?></li>
<?php endif; ?>