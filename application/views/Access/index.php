<div class="page-header"><h1>Access Log</h1></div>

<table class="table table-hover">
	<thead>
		<tr>
			<th>Check In</th>
			<th>Check Out</th>
		</tr>
	</thead>

	<tbody>
		<?php foreach ($pager->result() as $access): ?>
			<tr<?php if ( ! $access->checkout) echo ' class="alert-success"'?>>
				<td><?php echo date('Y-m-d H:i:s', $access->checkin); ?></td>
				
				<td>
					<?php if ($access->checkout): ?>
						<?php echo date('Y-m-d H:i:s', $access->checkout); ?>
					<?php else: ?>
						-
					<?php endif; ?>
				</td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<?php echo $pager->render(); ?>