<div class="page-header">
	<h1>
		<?php echo HTML::chars($user->name); ?>
	</h1>
</div>

<div class="row">
	<div class="col-md-4">
		<h2>Member Info</h2>

		<ul class="list-group">
			<li class="list-group-item">Credits: <?php echo $balance; ?></li>
			<li class="list-group-item">Name: <?php echo HTML::chars($user->name); ?></li>
			<li class="list-group-item">Email: <?php echo HTML::mailto($user->email); ?></li>
			<li class="list-group-item">Contact: <?php echo ($user->contact_num) ? $user->contact_num : '-'; ?></li>
		</ul>
	</div><!-- Basic menber info -->

	<div class="col-md-2 col-md-offset-6">
		<h3>Operations</h3>

		<ul class="nav nav-pills nav-stacked">
			<li><?php echo HTML::anchor('transaction', 'Transaction History'); ?></li>
			<li><?php echo HTML::anchor('access', 'Access Log'); ?></li>
			<li><?php echo HTML::anchor('member/update', 'Update Info'); ?></li>
		</ul>
	</div><!-- Action menu -->
</div>

<h2>Last Access</h2>

<p>
	<?php if ($last_access == NULL): ?>
		<p class="alert alert-info">
			Make this the first checkin!
			<?php echo HTML::anchor('access/checkin', 'Checkin Now', array('class' => 'btn btn-success')); ?>
		</p>
	<?php elseif ( ! $last_access->checkout): ?>
		<p class="alert alert-warning">
			<?php echo HTML::chars($user->name); ?> has checkin since <?php echo date('Y-m-d H:i', $last_access->checkin); ?>
			<?php echo HTML::anchor('access/checkout', 'Checkin Out', array('class' => 'btn btn-warning')); ?>
		</p>
	<?php else: ?>
		<p class="alert alert-info">
			<?php echo HTML::chars($user->name); ?> last checkout at <?php echo date('Y-m-d H:i', $last_access->checkout); ?>
			<?php echo HTML::anchor('access/checkin', 'Checkin Now', array('class' => 'btn btn-success')); ?>
		</p>
	<?php endif;?>
</p>