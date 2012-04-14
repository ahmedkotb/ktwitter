<div class="tweets form">
<?php echo $form->create('Tweet');?>
	<fieldset>
 		<legend><?php __('Edit Tweet');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('user_id');
		echo $form->input('date');
		echo $form->input('content');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action' => 'delete', $form->value('Tweet.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('Tweet.id'))); ?></li>
		<li><?php echo $html->link(__('List Tweets', true), array('action' => 'index'));?></li>
	</ul>
</div>
