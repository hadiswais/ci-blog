<?php
defined('BASEPATH') or exit('No direct script access allowed');

class category_model extends CI_Model
{
    public function get_categories()
    {
        $this->db->order_by('name');
        $query = $this->db->get('categories');
        return $query->result_array();
    }

    public function get_category($id)
    {
        $query = $this->db->get_where('categories', array('id' => $id));
        return $query->row();
    }

    public function create_category($data)
    {
        $arr_data = array(
            'name' => $data['name'],
        );
        return $this->db->insert('categories', $arr_data);
    }

    public function delete_category($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('categories');
        return true;
    }
}