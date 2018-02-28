<?php $this->load->view('inc/header'); ?>

<div class="content">
  <div class="col-md-4 offset-md-4">
      <?php $this->load->view('_flash_message') ?>
      <h2>Please login</h2>
      <?php $fattr = array('class' => 'form-signin');
           echo form_open(base_url().'auth/login', $fattr); ?>
      <div class="form-group">
        <?php echo form_input(array(
            'name'=>'email', 
            'id'=> 'email', 
            'placeholder'=>'Email', 
            'class'=>'form-control', 
            'value'=> set_value('email'))); ?>
        <?php echo form_error('email') ?>
      </div>
      <div class="form-group">
        <?php echo form_password(array(
            'name'=>'password', 
            'id'=> 'password', 
            'placeholder'=>'Password', 
            'class'=>'form-control', 
            'value'=> set_value('password'))); ?>
        <?php echo form_error('password') ?>
      </div>
      <?php echo form_submit(array('value'=>'Let me in!', 'class'=>'btn btn-lg btn-primary btn-block')); ?>
      <?php echo form_close(); ?>
      <p>Don't have an account? Click to <a href="<?php echo base_url();?>auth/register">Register</a></p>
      <p>Click <a href="<?php echo base_url();?>auth/forgot">here</a> if you forgot your password.</p>
  </div>
</div>

<?php $this->load->view('inc/footer'); ?>