<div class="messages index">
<h2><?php __('Messages');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('title');?></th>
	<th><?php echo $paginator->sort('body');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($messages as $message):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
		<font color="black">
			<?php echo $message['Message']['title']; ?>
		</font>
		</td>
		<td>
		<font color="black">
			<?php echo $message['Message']['body']; ?>
		</font>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action' => 'view', $message['Message']['id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action' => 'edit', $message['Message']['id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action' => 'delete', $message['Message']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $message['Message']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>
<div class="paging">
	<?php echo $paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
 | 	<?php echo $paginator->numbers();?>
	<?php echo $paginator->next(__('next', true).' >>', array(), null, array('class' => 'disabled'));?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('New Message', true), array('action' => 'add')); ?></li>
	</ul>
</div>
