<div class="page-header"><h1>Update Info</h1></div>

<div class="row">
	<div class="col-md-6">
		<?php echo Form::open(NULL, array('role' => 'form')); ?>
			
			<?php echo My_Form::input(array(
				'name' => 'name',
				'label' => 'Name*',
				'data' => $data,
				'errors' => $errors,
			)); ?>

			<?php echo My_Form::input(array(
				'name' => 'email',
				'label' => 'Email*',
				'data' => $data,
				'errors' => $errors,
			)); ?>

			<?php echo My_Form::password(array(
				'name' => 'password',
				'label' => 'Password',
				'data' => $data,
				'errors' => $errors,
				'help_msg' => 'Leave blank if you do not want to change password',
			)); ?>

			<?php echo My_Form::input(array(
				'name' => 'contact_num',
				'label' => 'Contact Number',
				'data' => $data,
				'errors' => $errors,
			)); ?>

			<div class="form-group">
				<button type="submit" class="btn btn-primary">Save</button>

				<?php echo HTML::anchor('member', 'Back', array('class' => 'btn btn-default col-md-offset-1')); ?>
			</div>

		<?php echo Form::close(); ?>
	</div>
</div>