<?php $this->load->view('inc/header'); ?>

<div class="content">
  <div class="col-md-4 offset-md-4">
      <h2>Almost There!</h2>
      <h5>Hello <span><?php echo $firstName; ?></span>. Your username is <span><?php echo $email;?></span></h5>
      <small>Please enter a password to begin using the site.</small>
  <?php 
      $fattr = array('class' => 'form-signin');
      echo form_open(site_url().'auth/complete/token/'.$token, $fattr); ?>
      <div class="form-group">
        <?php echo form_password(array('name'=>'password', 'id'=> 'password', 'placeholder'=>'Password', 'class'=>'form-control', 'value' => set_value('password'))); ?>
        <?php echo form_error('password') ?>
      </div>
      <div class="form-group">
        <?php echo form_password(array('name'=>'passconf', 'id'=> 'passconf', 'placeholder'=>'Confirm Password', 'class'=>'form-control', 'value'=> set_value('passconf'))); ?>
        <?php echo form_error('passconf') ?>
      </div>
      <?php echo form_hidden('user_id', $user_id);?>
      <?php echo form_submit(array('value'=>'Complete', 'class'=>'btn btn-lg btn-primary btn-block')); ?>
      <?php echo form_close(); ?>
     
  </div>
</div>

<?php $this->load->view('inc/footer'); ?>