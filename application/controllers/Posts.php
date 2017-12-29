<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Posts extends CI_Controller
{

    public function index($offset = 0)
    {
        $config['base_url'] = base_url() . 'posts/index/';
        $config['total_rows'] = $this->db->count_all('posts');
        $config['per_page'] = 3;
        $config['uri_segment'] = 3;
        $config['attributes'] = array('class' => 'pagination-link');
        $this->pagination->initialize($config);

        $data['title'] = 'Latest Posts';
        $data['posts'] = $this->post_model->get_posts(false, $config['per_page'], $offset);
        $data['main_content'] = 'posts/index';
        $this->load->view('includes/template', $data);
    }

    public function view($slug = null)
    {
        $data['post'] = $this->post_model->get_posts($slug);
        $post_id = $data['post']['id'];
        $data['comments'] = $this->comment_model->get_comments($post_id);

        if (empty($data['post']))
            show_404();

        $data['title'] = $data['post']['title'];
        $data['main_content'] = 'posts/view';
        $this->load->view('includes/template', $data);
    }

    public function create()
    {
        if (!$this->session->userdata('logged_in')) {
            redirect('users/login');
        }

        $data['title'] = 'Create Post';
        $data['categories'] = $this->post_model->get_categories();

        $this->form_validation->set_rules('title', 'Title', 'trim|required|min_length[5]');
        $this->form_validation->set_rules('body', 'Body', 'trim|required|min_length[5]');

        if ($this->form_validation->run() === false) {
            $data['main_content'] = 'posts/create';
            $this->load->view('includes/template', $data);
        } else {
            $clean = $this->security->xss_clean($this->input->post(null, true));
            $config['upload_path'] = './uploads/images/posts';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size'] = '3048';
            $config['max_width'] = '2000';
            $config['max_height'] = '2000';

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload()) {
                $errors = array('error' => $this->upload->display_errors());
                $post_image = 'noimage.jpg';
            } else {
                $data = array('upload_data' => $this->upload->data());
                $post_image = $_FILES['userfile']['name'];
            }

            $this->post_model->create_post($clean, $post_image);
            $this->session->set_flashdata('post_created', 'Your post has been created');
            redirect('posts');
        }
    }

    public function delete($slug)
    {

        if (!$this->session->userdata('logged_in')) {
            redirect('posts/') . $slug;
        }

        $data['post'] = $this->post_model->get_posts($slug);

        if ($this->session->userdata('user_id') !== ($data['post']['user_id'])) {
            redirect('posts/') . $slug;
        }

        $this->post_model->delete_post($data['post']['id']);
        $this->session->set_flashdata('post_deleted', 'Your post has been deleted');
        redirect('posts');
    }

    public function edit($slug)
    {
        if (!$this->session->userdata('logged_in')) {
            redirect('posts/') . $slug;
        }

        $data['post'] = $this->post_model->get_posts($slug);

        if ($this->session->userdata('user_id') !== ($data['post']['user_id'])) {
            redirect('posts/') . $slug;
        }

        $data['categories'] = $this->post_model->get_categories();

        if (empty($data['post'])) {
            show_404();
        }
        $data['title'] = 'Edit Post';
        $data['main_content'] = 'posts/edit';
        $this->load->view('includes/template', $data);

    }

    public function update()
    {
        if (!$this->session->userdata('logged_in')) {
            redirect('users/login');
        }

        $clean = $this->security->xss_clean($this->input->post(null, true));
        $this->post_model->update_post($clean);
        $this->session->set_flashdata('post_updated', 'Your post has been updated');
        redirect('posts');
    }
}
