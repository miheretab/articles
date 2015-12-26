<?php echo $this->Form->create('User'); ?>
	<fieldset>
		<legend><?php echo __('Forgot Password'); ?></legend>
	<?php
		echo $this->Form->input('email');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
