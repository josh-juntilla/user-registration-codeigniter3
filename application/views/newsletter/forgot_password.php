<?php $this->load->view('newsletter/header'); ?>

<p>Someone has requested that your account password be reset. If this was not you, please ignore the email and your password will not be changed. Otherwise please confirm this action by clicking the link below.</p>
<p><a href="<?php echo $forgot_url ?>"><?php echo $forgot_url ?></a></p>

<?php $this->load->view('newsletter/footer'); ?>