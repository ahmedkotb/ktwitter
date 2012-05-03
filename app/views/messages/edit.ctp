<div class="messages form">
<?php echo $form->create('Message');?>
	<fieldset>
 		<legend><?php __('Edit Message');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('sender_id');
		echo $form->input('recipient_id');
		echo $form->input('title');
		echo $form->input('body');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action' => 'delete', $form->value('Message.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('Message.id'))); ?></li>
		<li><?php echo $html->link(__('List Messages', true), array('action' => 'index'));?></li>
	</ul>
</div>
