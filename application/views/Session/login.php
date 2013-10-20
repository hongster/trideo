<div class="row">
	<div class="col-md-4 col-md-offset-4">
		<h1>Login</h1>

		<?php if ($login_failed): ?>
			<p class="alert alert-danger">Login failed. Please check that both email and password are correct.</p>
		<?php endif; ?>

		<?php echo Form::open(Route::url('login'), array('role' => 'form')); ?>
			<?php echo My_Form::input(array(
				'name' => 'email',
				'label' => 'Email*',
				'input_attrs' => array('autofocus' => 'autofocus'),
				'data' => $data,
			)); ?>

			<?php echo My_Form::password(array(
				'name' => 'password',
				'label' => 'Password*',
			)); ?>

			<?php echo Form::submit(NULL, 'Login', array('class' => 'btn btn-primary')); ?>
		<?php echo Form::close();?>
	</div>
</div>