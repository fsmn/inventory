<?php

class Code_model extends MY_Model{

	var $type;
	var $value;
	var $asset_id;

	function __construct()
	{
		parent::__construct();
	}

	function prepare_variables()
	{

	    $variables = array("type","value","asset_id");
	    foreach($variables as $variable){
	        if($this->input->post($variable)){
	            $this->$variable = $this->input->post($variable);
	        }
	    }

	}

	function insert()
	{
		$this->prepare_variables();
		return $this->_insert("code");
	}

	function update($id,$values = NULL)
	{
		$this->_update("code", $id, $values);

	}

	function delete($id)
	{
	    $this->_delete("code", $id);
	}

	function delete_code_by_asset( $asset_id )
	{
		$id_array = array('asset_id' => $asset_id );
		$this->db->delete('code', $id_array);
	}

	function get_for_asset($asset_id)
	{
		$this->db->where('asset_id', $asset_id);
		$this->db->from('code');
		$this->db->order_by('type');
		$result = $this->db->get()->result();
		return $result;
	}

	function get($id)
	{
	    return $this->_get("code",$id);
	}

}