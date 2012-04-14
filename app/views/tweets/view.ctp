<div class="tweets view">
<h2><?php  __('Tweet');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $tweet['Tweet']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('User Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $tweet['Tweet']['user_id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Date'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $tweet['Tweet']['date']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Content'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $tweet['Tweet']['content']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit Tweet', true), array('action' => 'edit', $tweet['Tweet']['id'])); ?> </li>
		<li><?php echo $html->link(__('Delete Tweet', true), array('action' => 'delete', $tweet['Tweet']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $tweet['Tweet']['id'])); ?> </li>
		<li><?php echo $html->link(__('List Tweets', true), array('action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Tweet', true), array('action' => 'add')); ?> </li>
	</ul>
</div>
