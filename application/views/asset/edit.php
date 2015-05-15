<?php
?>
<form id="asset_editor" class="editor" name="asset_editor"
	action="<? echo site_url("asset/$action"); ?>" method="post">
	<input type="hidden" name="id" id="id"
		value="<?=get_value($asset, 'id')?>" /> <input type="hidden"
		name="action" id="action" value="<?=$action?>" />
			<p>
		<label for="vendor_id">Developer&nbsp;</label> <span
			id='vendor_list'> <?=form_dropdown('vendor_id', $developers, get_value($asset, 'vendor_id',$vendor_id), 'id="vendor_id"')?>
		</span>
	</p>
	<p>
		<label for="product">Product Name&nbsp;</label> <input type="text"
			id="product" name="product" required value="<?=get_value($asset, 'product');?>" />
	</p>
	<p>
		<label for="name">Asset Name</label> <input type="text" id="name"
			name="name" value="<?=get_value($asset, 'name');?>" />
	</p>

	<p>
		<label for="version">Version&nbsp;</label> <input type="text"
			id="version" name="version" value="<?=get_value($asset, 'version');?>" />
	</p>

	<p>
		<label for="type">Type&nbsp;</label> <span id='type_field'> <?=form_dropdown('type', $types, get_value($asset, 'type'), 'id="type" required');?>
		</span>
	</p>
	<p>
		<label for="serial_number">Serial Number&nbsp;</label> <input
			type="text" name="serial_number"
			value="<?=get_value($asset,'serial_number');?>"
			id="serial_number-<?=get_value($asset,"id","0");?>"
			class="serial_number" />
	</p>
	<p>
		<label for="year_acquired">Year Acquired</label> <span
			id="year-acquired-field"> <input type="text" id="year_acquired"
			name="year_acquired" required value="<?=get_value($asset,"year_acquired");?>"
			size="5" />
		</span>
	</p>
	<p>
		<label for="source">Source</label> <span id="source"> <input
			type="text" id="source" name="source"
			value="<?=get_value($asset,"source");?>" />
		</span>
	</p>
	<p>
		<label for="status">Status&nbsp;</label> <span id='status'> <?=form_dropdown('status', $statuses, get_value($asset, 'status'), 'id="status"');?>
		</span>
	</p>
	<div id="year_removed_block"
	<? if(get_value($asset, 'status') != "Deacquisitioned" && get_value($asset, 'status') != "Destroyed" && get_value($asset, 'status') != "Stolen"){echo "style='display:none'";}?>>
		<label for="year_removed">Year Removed</label> <input type="text"
			id="year_removed" name="year_removed"
			value="<?=get_value($asset,"year_removed");?>" size="5" />
	</div>

	<p>
	<label for="po">Purchase Order</label>
	<span id="po-field"><input
			type="text" id="po" name="po" size="5"
			value="<?=get_value($asset,"po");?>" /></span>
	</p>
	<p>

		<p>

		<input type="submit" class="save_order <?=$action;?> <?=implode(" ",get_button_style($action));?>" value="<?=ucfirst($action);?>" />

		<input type="hidden" name="ajax" id="ajax" value="1" />

		<? if($action == "update"): ?>
		<a href="<?php echo site_url("asset/delete");?>"
			class="asset_delete delete <?=implode(" ",get_button_style("delete"));?>" id="delete-asset_<?php echo $asset->id; ?>">Delete</a>
		<? endif;?>

	</p>
</form>
