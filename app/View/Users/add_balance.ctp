<?php echo $this->Form->create('User'); ?>
	<fieldset>
		<legend><?php echo __('Add Balance'); ?></legend>
	<?php
		echo $this->Form->input('payment_first_name', array('required', 'label' => 'First Name', 'value' => $this->Session->read('Auth.User.first_name')));
		echo $this->Form->input('payment_last_name', array('required', 'label' => 'Last Name', 'value' => $this->Session->read('Auth.User.last_name')));
		echo $this->Form->input('cc', array('required'));
		echo $this->Form->input('cvc', array('required'));
		echo $this->Form->input('exp_date', array('type' => 'date', 'required', 'label' => 'Expired Date'));
		echo $this->Form->input('amount', array('type' => 'number', 'required', 'step' => "0.01"));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
