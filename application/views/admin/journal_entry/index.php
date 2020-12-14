<h5 class="font-20 mt-15 mb-1"><?php echo str_replace('_',' ','Journal_entry'); ?></h5>
<?php
echo $this->session->flashdata('msg');
?>
<!--Action-->
<div class="card">
	<div class="card-body">    
        <?php echo form_open_multipart('admin/journal_entry/import/',array("class"=>"form-horizontal")); ?>
          <div class="form-group">
			<label for="import" class="col-md-4 control-label">Import</label>
			<div class="col-md-8">
				<input type="file" name="file" class="form-control" id="file" />
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-offset-4 col-sm-8">
				<button type="submit" class="btn btn-success">Import</button>
			</div>
		</div>
        <?php echo form_close(); ?>
   </div>
</div>
<div>
	<div class="float_left padding_10">
		<a href="<?php echo site_url('admin/journal_entry/save'); ?>"
			class="btn btn-success">Add</a>
	</div>
	<div class="float_left padding_10">
		<i class="fa fa-download"></i> Export <select name="xeport_type"
			class="select"
			onChange="window.location='<?php echo site_url('admin/journal_entry/export'); ?>/'+this.value">
			<option>Select..</option>
			<option>XLS</option>
		</select>
	</div>
	<div class="float_right padding_10">
		<ul class="left-side-navbar d-flex align-items-center">
			<li class="hide-phone app-search mr-15">
                <?php echo form_open_multipart('admin/journal_entry/search/',array("class"=>"form-horizontal")); ?>
                    <input name="key" type="text"
				value="<?php echo isset($key)?$key:'';?>" placeholder="Search..."
				class="form-control">
				<button type="submit" class="mr-0">
					<i class="fa fa-search"></i>
				</button>
                <?php echo form_close(); ?>
            </li>
		</ul>
	</div>
</div>
<!--End of Action//-->

<!--Data display of journal_entry-->
<table class="table table-striped table-bordered">
	<tr>
		<th>Journal Head</th>
		<th>Debit</th>
		<th>Credit</th>

		<th>Actions</th>
	</tr>
	<?php foreach($journal_entry as $c){ ?>
    <tr>
		<td><?php echo $c['journal_head']; ?></td>
		<td><?php echo $c['debit']; ?></td>
		<td><?php echo $c['credit']; ?></td>

		<td><a
			href="<?php echo site_url('admin/journal_entry/details/'.$c['id']); ?>"
			class="action-icon"> <i class="zmdi zmdi-eye"></i></a> <a
			href="<?php echo site_url('admin/journal_entry/save/'.$c['id']); ?>"
			class="action-icon"> <i class="zmdi zmdi-edit"></i></a> <a
			href="<?php echo site_url('admin/journal_entry/remove/'.$c['id']); ?>"
			onClick="return confirm('Are you sure to delete this item?');"
			class="action-icon"> <i class="zmdi zmdi-delete"></i></a></td>
	</tr>
	<?php } ?>
</table>
<!--End of Data display of journal_entry//-->

<!--No data-->
<?php
if (count($journal_entry) == 0) {
    ?>
<div align="center">
	<h3>Data is not exists</h3>
</div>
<?php
}
?>
<!--End of No data//-->

<!--Pagination-->
<?php
echo $link;
?>
<!--End of Pagination//-->
