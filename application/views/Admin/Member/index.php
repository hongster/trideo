<div class="page-header"><h1>Members</h1></div>

<div class="row" id="member-search">
	<div class="col-md-6">
		<?php echo HTML::anchor('admin/member/create', 'Add Member', array('class' => 'btn btn-success')); ?>
	</div>

	<div class="col-md-6 text-right">
		<?php echo Form::open(NULL, array('method' => 'GET', 'class' => 'form-inline', 'role' => 'form')) ?>
			<div class="form-group">
				<?php echo My_Form::input(array(
					'name' => 'q',
					'input_attrs' => array('placeholder' => 'Search members'),
					'data' => Request::current()->query(),
				)); ?>
			</div>

			<button type="submit" class="btn btn-primary">Search</button>
		<?php echo Form::close(); ?>
	</div>
</div><!-- #member-search -->

<table class="table table-hover">
	<thead>
		<tr>
			<th>Name</th>
			<th>Email</th>
			<th>Contact</th>
		</tr>
	</thead>

	<tbody>
		<?php foreach ($pager->result() as $user): ?>
			<tr>
				<td><?php echo HTML::anchor('admin/member/info'.$user->id, $user->name); ?></td>
				<td><?php echo HTML::mailto($user->email); ?></td>
				<td><?php echo ($user->contact_num) ? $user->contact_num : '-'; ?></td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<?php echo $pager->render(); ?>