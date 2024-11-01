<h3>Drafts</h3>
<table class="wp-list-table widefat fixed">
	<thead>
		<tr>
			<th>Date</th>
			<th>Client</th>
			<th>Amount</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($drafts as $invoice): ?>
			<tr>
				<td>
					<?php echo $invoice->find('due_date')->text() ?>
					<p><a target="_blank" href="<?php echo $invoice->find('permalink')->text() ?>">draft</a></p>
				</td>
				<td><?php echo $invoice->find('client name')->text() ?></td>
				<td align="right"><?php echo number_format((float) $invoice->find('total')->text(), 2) ?></td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<h3>Pending Payment</h3>
<table class="wp-list-table widefat fixed">

	<thead>
		<tr>
			<th>Date</th>
			<th>Client</th>
			<th>Amount</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($pending as $invoice): ?>
			<tr>
				<td>
					<?php echo $invoice->find('due_date')->text() ?>
					<p><a target="_blank" href="<?php echo $invoice->find('permalink')->text() ?>"><?php echo $invoice->find('sequence_number')->text() ?></a></p>
				</td>
				<td><?php echo $invoice->find('client name')->text() ?></td>
				<td align="right"><?php echo number_format((float) $invoice->find('total')->text(), 2) ?></td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>