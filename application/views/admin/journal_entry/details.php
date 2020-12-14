<a href="<?php echo site_url('admin/journal_entry/index'); ?>"
	class="btn btn-info"><i class="arrow_left"></i> List</a>
<h5 class="font-20 mt-15 mb-1"><?php echo str_replace('_',' ','Journal_entry'); ?></h5>
<!--Data display of journal_entry with id-->
<?php
$c = $journal_entry;
?>
<table class="table table-striped table-bordered">
	<tr>
		<td>Journal Head</td>
		<td><?php echo $c['journal_head']; ?></td>
	</tr>

	<tr>
		<td>Debit</td>
		<td><?php echo $c['debit']; ?></td>
	</tr>

	<tr>
		<td>Credit</td>
		<td><?php echo $c['credit']; ?></td>
	</tr>

	<tr>
		<td>Created At</td>
		<td><?php echo $c['created_at']; ?></td>
	</tr>

	<tr>
		<td>Updated At</td>
		<td><?php echo $c['updated_at']; ?></td>
	</tr>


</table>
<!--End of Data display of journal_entry with id//-->
