<?php
class Welcome_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

	public function get_data(){
        $query=$this->db->query("SELECT st.*
                                 FROM story st 
                                 ORDER BY st.id ASC");
        return $query->result_array();
    }


}