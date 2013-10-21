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
			<li class="list-group-item">Name: <?php echo HTML::chars($user->name); ?></li>
			<li class="list-group-item">Email: <?php echo HTML::mailto($user->email); ?></li>
			<li class="list-group-item">Contact: <?php echo ($user->contact_num) ? $user->contact_num : '-'; ?></li>
		</ul>
	</div><!-- Basic menber info -->

	<div class="col-md-2 col-md-offset-6">
		<h3>Operations</h3>

		<ul class="nav nav-pills nav-stacked">
			<li><?php echo HTML::anchor('admin/member/update/'.$user->id, 'Update Info'); ?></li>

			<?php if ($is_admin): ?>
				<li><?php echo HTML::anchor('admin/member/demote_admin/'.$user->id, 'Demote Admin'); ?></li>
			<?php else: ?>
				<li><?php echo HTML::anchor('admin/member/promote_admin/'.$user->id, 'Promote Admin'); ?></li>
			<?php endif; ?>
		</ul>
	</div><!-- Action menu -->
</div>