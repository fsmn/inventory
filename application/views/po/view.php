<?php 

$order_buttons[] = array("text"=>"Edit","style"=>"edit","class"=>"edit-po btn-sm","href"=>site_url("po/edit"));
$order_buttons[] = array("text"=>"Delete Order","style"=>"delete","class"=>"delete-order btn-sm","id"=>"delete-po_$order->id","href"=>site_url("po/delete"));
?>
<h1>
	Purchase Order: <?=$order->po; ?>
</h1>
<?=create_button(array("text"=>"Print Order","style"=>"print","class"=>"print-order","id"=>"print-order_$order->id")); ?>
<div id="page-box">
	<div class="address-row clearfix">
		<div class="left-box">
		<? $this->load->view('vendor/view'); ?>
		</div>
		<div class="right-box">
			<fieldset>
				<legend>Order Details</legend>
				<?=create_button_bar($order_buttons); ?>
				<div id="order-info">
					<p>
						Order Date: <b><?=$order->po_date; ?> </b> <br /> Order Method: <b>
						<?=$order->method?>
						</b> <br /> Payment Type:<b> <?=$order->payment_type; ?>
						</b> <br /> Ordered By: <b><?=$order->ordered_by; ?> </b> <br />
						Billing Contact: <b><?=$order->billing_contact; ?> </b> <br />
						Budget Category: <b><?=$order->category; ?> </b> <br />
						Quote/Order Number: <b><?=$order->quote; ?> </b>
					</p>
				</div>

			</fieldset>
		</div>
	</div>
</div>
<div class="items">
<? $item_buttons[] = array("text"=>"Add Item","style"=>"new","class"=>"btn-xs add-item","id"=>"add-item_$order->id","href"=>site_url("item/create/$order->id")); 
echo create_button_bar($item_buttons,"toolbar");?>
<div id='item-table'>
<?php $this->load->view('item/table',array("items"=>$order->items));?>
</div>
</div>