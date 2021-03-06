<?php
defined('BASEPATH') or exit ('No direct script access allowed');

// asset.php Chris Dart Mar 9, 2015 3:24:59 PM chrisdart@cerebratorium.com
class Asset extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model("asset_model", "asset");
    }

    function index()
    {
        $this->search();
    }

    function view($asset_id)
    {
        $this->load->model("code_model", "code");
        $this->load->model("file_model", "file");

        $asset = $this->asset->get($asset_id);
        $asset->codes = $this->code->get_for_asset($asset_id);
        $asset->files = $this->file->get_for_entity("asset", $asset_id);
        $data ["asset"] = $asset;
        $data ["target"] = "asset/view";
        $data ["title"] = "$asset->product $asset->version";
        $data ["is_inline"] = FALSE;
        if ($this->input->get("ajax") == 1) {
            $data ["is_inline"] = TRUE;
            $this->load->view($data ["target"], $data);
        } else {
            $this->load->view("page/index", $data);
        }
    }

    function po_list($po)
    {
        $data ["po"] = $po;
        $data ["assets"] = $this->asset->get_by_po($po);
        $data ["title"] = "Assets purchased with PO# $po";
        $data ["target"] = "asset/list";
        $this->load->view("page/index", $data);
    }

    function create($vendor_id = NULL)
    {
        $data ["asset"] = NULL;
        $data ["action"] = "insert";
        $data ["vendor_id"] = $vendor_id;
        $data ["target"] = "asset/edit";
        $data ["title"] = "Create an Asset";
        $data ["types"] = $this->_type_list();
        $data ["statuses"] = $this->_status_list();

        $data ["developers"] = $this->_developer_list();

        if ($this->input->get("ajax") == 1) {
            $this->load->view("page/modal", $data);
        } else {
            $this->load->view("page/index", $data);
        }
    }

    function edit($id)
    {
        $asset = $this->asset->get($id);

        $data ["asset"] = $asset;
        $data ["action"] = "update";
        $data ["vendor_id"] = $asset->vendor_id;
        $data ["target"] = "asset/edit";
        $data ["title"] = "Edit $asset->name";
        $data ["types"] = $this->_type_list();
        $data ["statuses"] = $this->_status_list();
        $data ["developers"] = $this->_developer_list();
        if ($this->input->get("ajax") == 1) {
            $this->load->view("page/modal", $data);
        } else {
            $this->load->view("page/index", $data);
        }
    }

    function insert()
    {
        $id = $this->asset->insert();
        redirect("asset/view/$id");
    }

    function update()
    {
        $id = $this->input->post("id");
        $this->asset->update($id);
        redirect("asset/view/$id");
    }

    function update_value()
    {
        $id = $this->input->post("id");
        $value = $this->input->post("value");
        if (is_array($value)) {
            $value = implode(",", $value);
        }
        $values = array(
            $this->input->post("field") => $value
        );
        $this->asset->update($id, $values);
        $asset = $this->asset->get($id);
        $title = sprintf("%s %s %s", $asset->product, $asset->version != '' ? $asset->version : "", $asset->name != '' ? "($asset->name)" : "");
        $extra = FALSE;
        if ($this->input->post("field") == "status" && $value != "Active" && $value != "Inactive") {
            $extra = $this->load->view("asset/status", array(
                "asset" => $asset
            ), TRUE);
        }
        echo json_encode(array(
            "asset" => $asset,
            "title" => $title,
            "extra" => $extra
        ));
    }

    function delete()
    {
        if ($id = $this->input->post("id")) {
            $vendor_id = $this->asset->delete($id);
            $this->load->model("vendor_model", "vendor");
            $data ["vendor"] = $this->vendor->get($vendor_id);
            $data ["title"] = "Asset Deleted";
            $data ["target"] = "asset/delete";
            if ($this->input->post("ajax")) {
                $this->load->view("page/modal", $data);
            } else {
                $this->load->view("page/index", $data);
            }
        }
    }

    function search()
    {
        $this->load->model("vendor_model", "vendor");
        $this->load->model("code_model","code");
        $data ["developers"] = $this->_developer_list(TRUE);
        $data ["statuses"] = $this->_status_list();
        $data ["types"] = $this->_type_list();

        $assets = array();
        $variables = array(
            "type",
            "status",
            "vendor_id",
            "name",
            "product",
            "version",
            "source",
            "po",
            "year_acquired",
            "year_removed",
            "serial_number",
            "has_attachment",
            "code",
        );
        $where = NULL;
        foreach ($variables as $variable) {
            if ($my_variable = $this->input->get($variable)) {
                $where [$variable] = $my_variable;
                bake_cookie($variable, $my_variable);
            } else {
                burn_cookie($variable, $my_variable);
            }
        }
        $data['assets'] = NULL;
        if ($this->input->get("is_search")) { // active search has been submitted
            $assets = $this->asset->search($where);
            $data ["refine"] = TRUE;
        }

        foreach($assets as $asset){
           $asset->codes = $this->code->get_for_asset($asset->id);
        }

        if (count($assets) > 0) {
            $data ['assets'] = $assets;
        }
        $data ["title"] = "Search Assets";
        if ($this->input->get("export")) {
            $this->load->helper("download");
            $this->load->view('asset/export', $data);
        } else {
            $data ['target'] = 'asset/search';
            $this->load->view('page/index', $data);
        }
    }

    function _developer_list($initial_blank = FALSE)
    {
        $this->load->model("vendor_model", "vendor");
        $developers = $this->vendor->get_all("developer");
        return get_keyed_pairs($developers, array(
            "id",
            "name"
        ), $initial_blank);
    }

    function _type_list()
    {
        return array(
            "" => "",
            "Hardware" => "Hardware",
            "Software" => "Software",
            "Website" => "Website"
        );
    }

    function _status_list()
    {
        $statuses = $this->asset->get_distinct("status");
        return get_keyed_pairs($statuses, array(
            "status",
            "status"
        ), TRUE);
    }
}