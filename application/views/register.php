<?php $this->load->view('inc/header'); ?>

<div class="content">
  <div class="col-md-4 offset-md-4">
      <h2>Hello There</h2>
      <h5>Please enter the required information below.</h5>     
  <?php 
      $fattr = array('class' => 'form-signin');
      echo form_open(site_url().'auth/register', $fattr); ?>
      <div class="form-group">
        <?php echo form_input(array('name'=>'firstname', 'id'=> 'firstname', 'placeholder'=>'First Name', 'class'=>'form-control', 'value' => set_value('firstname'))); ?>
        <?php echo form_error('firstname');?>
      </div>
      <div class="form-group">
        <?php echo form_input(array('name'=>'lastname', 'id'=> 'lastname', 'placeholder'=>'Last Name', 'class'=>'form-control', 'value'=> set_value('lastname'))); ?>
        <?php echo form_error('lastname');?>
      </div>
      <div class="form-group">
        <?php echo form_dropdown(array('name'=>'gender', 'id'=> 'gender', 'class'=>'form-control', 'value'=> set_value('male')), array(
          'm' => 'Male', 'f' => 'Female')); ?>
        <?php echo form_error('gender');?>
      </div>
      <div class="form-group">
        <?php echo form_input(array('name'=>'email', 'id'=> 'email', 'placeholder'=>'Email', 'class'=>'form-control', 'value'=> set_value('email'))); ?>
        <?php echo form_error('email');?>
      </div>
      <?php echo form_submit(array('value'=>'Sign up', 'class'=>'btn btn-lg btn-primary btn-block')); ?>
      <?php echo form_close(); ?>
  </div>
</div>

<?php $this->load->view('inc/footer'); ?>