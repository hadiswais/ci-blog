<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Categories extends CI_Controller
{

    public function index()
    {
        $data['title'] = 'Categories';
        $data['categories'] = $this->category_model->get_categories();

        $data['main_content'] = 'categories/index';
        $this->load->view('includes/template', $data);
    }

    public function create()
    {
        if (!$this->session->userdata('logged_in')) {
            redirect('users/login');
        }

        $data['title'] = 'Create Category';
        $this->form_validation->set_rules('name', 'Name', 'required');

        if ($this->form_validation->run() === false) {
            $data['main_content'] = 'categories/create';
            $this->load->view('includes/template', $data);
        } else {
            $clean = $this->security->xss_clean($this->input->post(null, true));
            $this->category_model->create_category($clean);

            $this->session->set_flashdata('category_created', 'Your category has been created');
            redirect('categories');
        }
    }

    public function delete($id)
    {
        if (!$this->session->userdata('logged_in')) {
            redirect('categories/');
        }

        $data['cat'] = $this->category_model->get_category($id);

        if ($this->session->userdata('user_id') !== ($data['cat']->user_id)) {
            redirect('categories/');
        }

        $this->category_model->delete_category($id);

        $this->session->set_flashdata('category_deleted', 'Your category has been deleted');
        redirect('categories');
    }

    public function posts($id)
    {
        $data['title'] = $this->category_model->get_category($id)->name;
        $data['posts'] = $this->post_model->get_posts_by_category($id);

        $data['main_content'] = 'posts/index';
        $this->load->view('includes/template', $data);
    }



}
