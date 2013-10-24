<div class="page-header"><h1>Purchase Confirmation</h1></div>

<div class="row">
	<div class="col-md-6">
		<table class="table table-bordered">
			<tr>
				<th>Member</th>
				<td><?php echo HTML::chars($name); ?></td>
			</tr>

			<tr>
				<th>Payment amount</th>
				<td>RM <?php echo $amount; ?></td>
			</tr>

			<tr>
				<th>Credit balance before purchase</th>
				<td><?php echo $balance_before; ?></td>
			</tr>

			<tr>
				<th>Credit balance after purchase</th>
				<td class="alert-info"><strong><?php echo $balance_after; ?></strong></td>
			</tr>
		</table>
	</div>
</div>

<?php echo Form::open(); ?>
	<div class="form-group">
		<button type="submit" name="confirm" value="1" class="btn btn-primary">Confirm</button>

		<?php echo HTML::anchor('admin/credit/purchase/'.$user_id, 'Back', array('class' => 'btn btn-default col-md-offset-1')); ?>
	</div>
<?php echo Form::close(); ?>