<table width="100%">
	<thead>
		<tr>
			<th>Montly Average</th>
			<th>Amount owed</th>
			<th>This month</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td align="center"><?php echo number_format((float) $monthly_average['total'], 2); ?></td>
			<td align="center"><?php echo number_format((float) $total_owed['total'], 2); ?></td>
			<td align="center"><?php echo number_format((float) $current_month['total'], 2); ?></td>
		</tr>
	</tbody>
</table>