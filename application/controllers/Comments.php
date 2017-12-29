<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Comments extends CI_Controller
{

    public function create($post_id)
    {
        $slug = $this->input->post('slug');
        $data['post'] = $this->post_model->get_posts($slug);

        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('body', 'Body', 'required');

        if ($this->form_validation->run() === false) {
            $data['comments'] = false;
            $data['main_content'] = 'posts/view';
            $this->load->view('includes/template', $data);
        } else {
            $clean = $this->security->xss_clean($this->input->post(null, true));
            $this->comment_model->create_comment($clean, $post_id);
            redirect('posts/' . $slug);
        }
    }
}