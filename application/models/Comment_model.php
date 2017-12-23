<?php
defined('BASEPATH') or exit('No direct script access allowed');

class comment_model extends CI_Model
{
    public function create_comment($data, $post_id)
    {
        $arr_data = array(
            'post_id' => $post_id,
            'name' => $data['name'],
            'email' => $data['email'],
            'body' => $data['body']
        );
        return $this->db->insert('comments', $arr_data);
    }

    public function get_comments($post_id)
    {
        $query = $this->db->get_where('comments', array('post_id' => $post_id));
        return $query->result_array();
    }
}