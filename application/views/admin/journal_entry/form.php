<a href="<?php echo site_url('admin/journal_entry/index'); ?>"
	class="btn btn-info"><i class="arrow_left"></i> List</a>
<h5 class="font-20 mt-15 mb-1"><?php if($id<0){echo "Save";}else { echo "Update";} echo " "; echo str_replace('_',' ','Journal_entry'); ?></h5>
<!--Form to save data-->
<?php echo form_open_multipart('admin/journal_entry/save/'.$journal_entry['id'],array("class"=>"form-horizontal")); ?>
<div class="card">
	<div class="card-body">
		<div class="form-group">
			<label for="Journal Head" class="col-md-4 control-label">Journal Head</label>
			<div class="col-md-8">
				<input type="text" name="journal_head"
					value="<?php echo ($this->input->post('journal_head') ? $this->input->post('journal_head') : $journal_entry['journal_head']); ?>"
					class="form-control" id="journal_head" />
			</div>
		</div>
		<div class="form-group">
			<label for="Debit" class="col-md-4 control-label">Debit</label>
			<div class="col-md-8">
				<input type="text" name="debit"
					value="<?php echo ($this->input->post('debit') ? $this->input->post('debit') : $journal_entry['debit']); ?>"
					class="form-control" id="debit" />
			</div>
		</div>
		<div class="form-group">
			<label for="Credit" class="col-md-4 control-label">Credit</label>
			<div class="col-md-8">
				<input type="text" name="credit"
					value="<?php echo ($this->input->post('credit') ? $this->input->post('credit') : $journal_entry['credit']); ?>"
					class="form-control" id="credit" />
			</div>
		</div>

	</div>
</div>
<div class="form-group">
	<div class="col-sm-offset-4 col-sm-8">
		<button type="submit" class="btn btn-success"><?php if(empty($journal_entry['id'])){?>Save<?php }else{?>Update<?php } ?></button>
	</div>
</div>
<?php echo form_close(); ?>
<!--End of Form to save data//-->
<!--JQuery-->
<script>
	$( ".datepicker" ).datepicker({
		dateFormat: "yy-mm-dd", 
		changeYear: true,
		changeMonth: true,
		showOn: 'button',
		buttonText: 'Show Date',
		buttonImageOnly: true,
		buttonImage: '<?php echo base_url(); ?>public/datepicker/images/calendar.gif',
	});
</script>
