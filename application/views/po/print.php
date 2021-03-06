<?php 
?>
<div id="page-box" class="purchase-order">
	<div id="header-row">
		<div id="logo-box">
			<img src="<?php echo base_url("images/logo.jpg"); ?>" alt="" height="111" width="111" align="left" border="0" />
		</div>
		<div id="po-box">e-<?php print $order->po; ?></div>
		<div id="fsm-box">
			<p id='school-address'>
				<span id='school-name'>FRIENDS SCHOOL OF MINNESOTA</span>
				<br /> 1365 Englewood Avenue<br /> Saint Paul, MN 55104<br /> Phone: 651.917.0636 Fax: 651.917.0708
			</p>
			<p id="tax-exempt">
				<strong>Tax Exempt Number: ES-31606</strong>
			</p>
		</div>
	</div>
	<div id="address-row">
		<div class="left-box">
			<div>VENDOR</div>
<?php $this->load->view("vendor/print",array("vendor"=>$order->vendor));?>
</div>
		<div class="right-box">
			<div>
				DATE: <strong><?php print $order->po_date; ?></strong>
			</div>
			<div>
				ORDER METHOD:<strong> <?php print strtolower($order->method); ?></strong>
			</div>
			<div>
				PAYMENT METHOD:<strong> <?php print strtolower($order->payment_type); ?></strong>
<?php if (get_value ( $order, 'billing_contact' )):?>
	<div>BILLING CONTACT: <?php echo $order->billing_contact;?></div>
<?php endif; //billing_contact ?>
<div>SHIPPING CONTACT: <?php echo $order->first_name . " " . $order->last_name;?></div></div>

			<div>
				VENDOR QUOTE#: <strong><?php print $order->quote; ?></strong>
			</div>
		</div>
	</div>

	<div id="details-row">
		<div class="left-box">
			<em>Ordered By:</em> <?php print $order->first_name . ' ' . $order->last_name; ?>
<p>
				<em>Confirmation #:</em>
			</p>
			<p>
				<em>Date Received:</em>
			</p>
		</div>
		<div class="right-box">
			<p>
				<em>Budget Category:</em> <?php print $order->category; ?></p>
			<p><?php echo $order->approved?"<strong><em>Digitally Approved by $order->approver</em></strong>":"<em>Approved By:_______________</em>";?></p>
			<p>
				<em>Received By:_______________________</em>
			</p>
		</div>
	</div>
	<div id="form-row">
<?php $this->load->view('item/table', array("items"=>$order->items,"approved"=>$order->approved));?>
</div>
</div>