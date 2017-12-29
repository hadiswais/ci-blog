<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Post_model extends CI_Model
{
    public function get_posts($slug = false, $limit = false, $offset = false)
    {

        if ($limit) {
            $this->db->limit($limit, $offset);
        }

        if ($slug == false) {
            $this->db->order_by('posts.id', 'DESC');
            $this->db->join('categories', 'categories.id = posts.category_id');
            $query = $this->db->get('posts');
            return $query->result_array();
        }

        $query = $this->db->get_where('posts', array('slug' => $slug));
        return $query->row_array();
    }

    public function create_post($data, $post_image)
    {
        $slug = url_title($data['title']);
        $arr_data = array(
            'user_id ' => $this->session->userdata('user_id'),
            'category_id' => $data['category_id'],
            'title' => $data['title'],
            'slug' => $slug,
            'body' => $data['body'],
            'post_image' => $post_image,
        );
        return $this->db->insert('posts', $arr_data);
    }

    public function delete_post($post_id)
    {
        // TODO Move delete image to controller
        $image_file_name = $this->db->select('post_image')->get_where('posts', array('id' => $post_id))->row()->post_image;
        $cwd = getcwd();
        $image_file_path = $cwd . "\\uploads\\images\\posts\\";
        chdir($image_file_path);
        unlink($image_file_name);
        chdir($cwd);
        $this->db->where('id', $post_id);
        $this->db->delete('posts');
        return true;
    }

    public function update_post($data)
    {
        $slug = url_title($data['title']);
        $arr_data = array(
            'title' => $data['title'],
            'slug' => $slug,
            'body' => $data['body'],
            'category_id' => $data['category_id'],
            'post_image' => $post_image,
        );
        $this->db->where('id', $data['id']);
        return $this->db->update('posts', $arr_data);
    }

    public function get_posts_by_category($category_id)
    {
        $this->db->order_by('posts.id', 'DESC');
        $this->db->join('categories', 'categories.id = posts.category_id');
        $query = $this->db->get_where('posts', array('category_id' => $category_id));
        return $query->result_array();
    }

    public function get_categories()
    {
        $this->db->order_by('name');
        $query = $this->db->get('categories');
        return $query->result_array();
    }

}

