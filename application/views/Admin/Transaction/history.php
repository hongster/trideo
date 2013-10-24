<div class="page-header"><h1>Transaction History</h1></div>

<table class="table table-hover">
	<thead>
		<tr>
			<th>Date</th>
			<th>Member</th>
			<th>Increment (credits)</th>
			<th>Description</th>
		</tr>
	</thead>

	<tbody>
		<?php foreach ($pager->result() as $transaction): ?>
			<tr>
				<td><?php echo date('Y-m-d H:i:s', $transaction->created_at); ?></td>
				<td><?php echo HTML::anchor('admin/member/info/'.$transaction->user->id, $transaction->user->name); ?></td>
				<td><?php echo $transaction->adjustment;  ?></td>
				<td><?php echo HTML::chars($transaction->description);  ?></td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<?php echo $pager->render(); ?>