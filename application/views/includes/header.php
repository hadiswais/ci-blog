<!DOCTYPE html>
<html lang="en">

<head>
  <title></title>
  <meta charset="UTF-8">
  <link href="https://bootswatch.com/4/flatly/bootstrap.min.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet">

</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="<?php echo site_url() ?>">CI Blog</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor02" aria-controls="navbarColor02"
      aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarColor02">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item">
          <a class="nav-link" href="<?php echo site_url("categories/ ") ?>">Categories</a>
        </li>
      </ul>

      <ul class="nav navbar-nav navbar-right">
         <?php if (!$this->session->userdata('logged_in')) : ?>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo site_url("users/login ") ?>">Login</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo site_url("users/register ") ?>">Register</a>
        </li>
         <?php endif; ?>
          <?php if ($this->session->userdata('logged_in')) : ?>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo site_url("posts/create ") ?>">Add Post</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo site_url("categories/create ") ?>">Create Category</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo site_url("users/logout ") ?>">Logout</a>
<?php endif; ?>
      </ul>
    </div>
  </nav>

  <div class="container">

    <!-- Flash messages -->
    <?php if ($this->session->flashdata('user_registered')) : ?>
    <?php echo '<p class="alert alert-success">' . $this->session->flashdata('user_registered') . '</p>'; ?>
    <?php endif; ?>

    <?php if ($this->session->flashdata('post_created')) : ?>
    <?php echo '<p class="alert alert-success">' . $this->session->flashdata('post_created') . '</p>'; ?>
    <?php endif; ?>

    <?php if ($this->session->flashdata('post_updated')) : ?>
    <?php echo '<p class="alert alert-success">' . $this->session->flashdata('post_updated') . '</p>'; ?>
    <?php endif; ?>

    <?php if ($this->session->flashdata('category_created')) : ?>
    <?php echo '<p class="alert alert-success">' . $this->session->flashdata('category_created') . '</p>'; ?>
    <?php endif; ?>

    <?php if ($this->session->flashdata('post_deleted')) : ?>
    <?php echo '<p class="alert alert-success">' . $this->session->flashdata('post_deleted') . '</p>'; ?>
    <?php endif; ?>

    <?php if ($this->session->flashdata('login_failed')) : ?>
    <?php echo '<p class="alert alert-danger">' . $this->session->flashdata('login_failed') . '</p>'; ?>
    <?php endif; ?>

    <?php if ($this->session->flashdata('user_loggedin')) : ?>
    <?php echo '<p class="alert alert-success">' . $this->session->flashdata('user_loggedin') . '</p>'; ?>
    <?php endif; ?>

    <?php if ($this->session->flashdata('user_loggedout')) : ?>
    <?php echo '<p class="alert alert-success">' . $this->session->flashdata('user_loggedout') . '</p>'; ?>
    <?php endif; ?>

    <?php if ($this->session->flashdata('category_deleted')) : ?>
    <?php echo '<p class="alert alert-success">' . $this->session->flashdata('category_deleted') . '</p>'; ?>
    <?php endif; ?>