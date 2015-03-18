<?php

defined('BASEPATH') or exit('No direct script access allowed');

// po.php Chris Dart Mar 6, 2015 7:12:38 PM chrisdart@cerebratorium.com
class PO extends MY_Controller
{

    function __construct ()
    {
        parent::__construct();
        $this->load->model("po_model", "po");
        $this->load->model("item_model", "item");
    }

    function index ()
    {
    }

    function view ($po)
    {
        $order = $this->po->get_by_po($po);
        $order->items = $this->item->get_by_po($order->id);
    }

    function create ($vendor_id = FALSE)
    {
        $this->load->model("vendor_model", "vendor");
        $vendors = $this->vendor->get_all("vendor");
        $data["vendors"] = get_keyed_pairs($vendors, array(
                "id",
                "name"
        ));
        $methods = $this->po->get_distinct("method");
        $data["methods"] = get_keyed_pairs($methods, array(
                "method",
                "method"
        ));
        $payment_types = $this->po->get_distinct("payment_type");
        $data["payment_types"] = get_keyed_pairs($payment_types, array(
                "payment_type",
                "payment_type"
        ));
        $categories = $this->po->get_distinct("category");
        $data["categories"] = get_keyed_pairs($categories, array(
                "category",
                "category"
        ));
        $data["target"] = "po/edit";
        $data["action"] = "insert";
        $data["po"] = FALSE;
        $data["vendor_id"] = $vendor_id;
        $this->load->view("page/index", $data);
    }

    function insert ()
    {

        $id = $this->po->insert();
        $po = $this->po->get($id)->po;

        redirect("po/view/$po");
    }
}