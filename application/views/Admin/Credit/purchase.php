<div class="page-header"><h1>Purchase Credits <small><?php echo HTML::chars($user->name); ?></small></h1></div>

<?php
$selections = array('' => '');
foreach ($price_options as $price => $c)
{
	$selections[$price] = "RM {$price} for {$c} credits";
}
?>

<div class="row">
	<div class="col-md-3">
		<?php echo Form::open(NULL, array('role' => 'form')); ?>
			
			<div class="form-group">
				<label>Current credit balance:</label>
				<span><?php echo $credit->balance; ?></span>
			</div>

			<?php echo My_Form::select(array(
				'name' => 'amount',
				'label' => 'Prices*',
				'selections' => $selections,
				'data' => $data,
				'errors' => $errors,
			)); ?>

			<div class="form-group">
				<button type="submit" class="btn btn-primary">Purchase</button>

				<?php echo HTML::anchor('admin/member/info/'.$user->id, 'Back', array('class' => 'btn btn-default col-md-offset-1')); ?>
			</div>

		<?php echo Form::close(); ?>
	</div>
</div>