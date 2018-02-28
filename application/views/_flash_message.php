<?php $arr = $this->session->flashdata(); 
if(!empty($arr['flash_message'])): ?>
<div class="alert alert-info">
	<?php echo $arr['flash_message'] ?> 
</div>
<?php endif; ?>