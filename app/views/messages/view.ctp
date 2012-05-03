<div class="messages view">
<h2><?php  __('Message');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $message['Message']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Sender Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $message['Message']['sender_id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Recipient Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $message['Message']['recipient_id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Title'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $message['Message']['title']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Body'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $message['Message']['body']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit Message', true), array('action' => 'edit', $message['Message']['id'])); ?> </li>
		<li><?php echo $html->link(__('Delete Message', true), array('action' => 'delete', $message['Message']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $message['Message']['id'])); ?> </li>
		<li><?php echo $html->link(__('List Messages', true), array('action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Message', true), array('action' => 'add')); ?> </li>
	</ul>
</div>
