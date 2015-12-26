<h2><?php echo $this->Session->check('Auth.User') ? __('My Articles') : __('Articles'); ?></h2>
<table cellpadding="0" cellspacing="0">
<tr>
		<th><?php echo $this->Paginator->sort('title'); ?></th>
		<?php if($this->Session->check('Auth.User')) { ?>
		<th><?php echo $this->Paginator->sort('enabled', 'Status'); ?></th>
		<?php } ?>
		<th class="actions"><?php echo __('Actions'); ?></th>
</tr>
<?php foreach ($articles as $article): ?>
<tr>
	<td><?php echo h($article['Article']['title']); ?>&nbsp;</td>
	<?php if($this->Session->check('Auth.User')) { ?>
	<td><?php echo ($article['Article']['enabled']) ? 'Active' : 'Suspended'; ?>&nbsp;</td>
	<?php } ?>
	<td class="actions">
		<?php echo $this->Html->link(__('View'), array('action' => 'view', $article['Article']['id'])); ?>
		<?php if($this->Session->check('Auth.User')) { ?>
		<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $article['Article']['id'])); ?>
		<?php echo $this->Form->postLink(__('Suspend/Activate'), array('action' => 'change_status', $article['Article']['id']), null, __('Are you sure you want to change status of %s?', $article['Article']['title'])); ?>
		<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $article['Article']['id']), null, __('Are you sure you want to delete %s?', $article['Article']['title'])); ?>
		<?php } ?>
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

