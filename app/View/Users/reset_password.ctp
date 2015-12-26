<?php echo $this->Form->create('User'); ?>
	<fieldset>
		<legend><?php echo __('Reset Password'); ?></legend>
	<?php
		echo $this->Form->input('password');
		echo $this->Form->input('confirm_password', array('type' => 'password'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
