<div class="page-header">
	<h1>
		<?php echo HTML::chars($user->name); ?>
		<?php if ($is_admin): ?>
			<span class="label label-warning">Admin</span>
		<?php endif; ?>
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
			<li>
				<?php echo HTML::anchor(
					'admin/transaction/history'.URL::query(array('user_id' => $user->id)),
					'Transaction History'); ?>
			</li>
			<li><?php echo HTML::anchor('admin/access'.URL::query(array('user_id' => $user->id)), 'Access Log'); ?></li>
			<li><?php echo HTML::anchor('admin/credit/purchase/'.$user->id, 'Purchase Credits'); ?></li>
			<li><?php echo HTML::anchor('admin/member/update/'.$user->id, 'Update Info'); ?></li>

			<?php if ($is_admin): ?>
				<li><?php echo HTML::anchor('admin/member/demote_admin/'.$user->id, 'Demote Admin'); ?></li>
			<?php else: ?>
				<li><?php echo HTML::anchor('admin/member/promote_admin/'.$user->id, 'Promote Admin'); ?></li>
			<?php endif; ?>

		</ul>
	</div><!-- Action menu -->
</div>

<h2>Last Access</h2>

<p>
	<?php if ($last_access == NULL): ?>
		<p class="alert alert-info">
			Make this the first checkin!
			<?php echo HTML::anchor('admin/access/checkin/'.$user->id, 'Checkin Now', array('class' => 'btn btn-success')); ?>
		</p>
	<?php elseif ( ! $last_access->checkout): ?>
		<p class="alert alert-warning">
			<?php echo HTML::chars($user->name); ?> has checkin since <?php echo date('Y-m-d H:i', $last_access->checkin); ?>
			<?php echo HTML::anchor('admin/access/checkout/'.$user->id, 'Checkin Out', array('class' => 'btn btn-warning')); ?>
		</p>
	<?php else: ?>
		<p class="alert alert-info">
			<?php echo HTML::chars($user->name); ?> last checkout at <?php echo date('Y-m-d H:i', $last_access->checkout); ?>
			<?php echo HTML::anchor('admin/access/checkin/'.$user->id, 'Checkin Now', array('class' => 'btn btn-success')); ?>
		</p>
	<?php endif;?>
</p>