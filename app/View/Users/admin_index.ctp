<h2><?php echo __('Users'); ?></h2>
<table cellpadding="0" cellspacing="0">
<tr>
		<th><?php echo $this->Paginator->sort('id'); ?></th>
		<th><?php echo $this->Paginator->sort('first_name'); ?></th>
		<th><?php echo $this->Paginator->sort('last_name'); ?></th>
		<th><?php echo $this->Paginator->sort('email'); ?></th>
		<th><?php echo $this->Paginator->sort('balance'); ?></th>
		<th><?php echo $this->Paginator->sort('enabled', 'Status'); ?></th>
		<th><?php echo $this->Paginator->sort('created'); ?></th>
		<th><?php echo $this->Paginator->sort('modified'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
</tr>
<?php foreach ($users as $user): ?>
<tr>
	<td><?php echo h($user['User']['id']); ?>&nbsp;</td>
	<td><?php echo h($user['User']['first_name']); ?>&nbsp;</td>
	<td><?php echo h($user['User']['last_name']); ?>&nbsp;</td>
	<td><?php echo h($user['User']['email']); ?>&nbsp;</td>
	<td><?php echo h($user['User']['balance']); ?>&nbsp;</td>
	<td><?php echo ($user['User']['enabled']) ? 'Active' : 'Suspended'; ?>&nbsp;</td>
	<td><?php echo h($user['User']['created']); ?>&nbsp;</td>
	<td><?php echo h($user['User']['modified']); ?>&nbsp;</td>
	<td class="actions">
		<?php echo $this->Form->postLink(__('Change Status'), array('action' => 'change_status', $user['User']['id']), null, __('Are you sure you want to change status # %s?', $user['User']['id'])); ?>
		<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $user['User']['id']), null, __('Are you sure you want to delete # %s?', $user['User']['id'])); ?>
	</td>
</tr>
<?php endforeach; ?>
</table>
<p>
<?php
echo $this->Paginator->counter(array(
'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
));
?>	</p>
<div class="paging">
<?php
	echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
	echo $this->Paginator->numbers(array('separator' => ''));
	echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
?>
</div>

