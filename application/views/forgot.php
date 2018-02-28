<?php $this->load->view('inc/header'); ?>

<div class="content">
  <div class="col-md-4 offset-md-4">
      <h2>Forgot Password</h2>
      <p>Please enter your email address and we'll send you instructions on how to reset your password</p>
      <?php $fattr = array('class' => 'form-signin');
           echo form_open(site_url().'auth/forgot/', $fattr); ?>
      <div class="form-group">
        <?php echo form_input(array(
            'name'=>'email', 
            'id'=> 'email', 
            'placeholder'=>'Email', 
            'class'=>'form-control', 
            'value'=> set_value('email'))); ?>
        <?php echo form_error('email') ?>
      </div>
      <?php echo form_submit(array('value'=>'Submit', 'class'=>'btn btn-lg btn-primary btn-block')); ?>
      <?php echo form_close(); ?>    
  </div>
</div>

<?php $this->load->view('inc/footer'); ?>