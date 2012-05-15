<div class="tweets index">
<h2><?php __('Tweets Search results');?></h2>
    <div style='float:right'>
            <?=$html->link('Profile',array('controller'=>'tweets','action'=>'index'));?>
        <?=$html->link('logout',array('controller'=>'users','action'=>'logout'));?>
    </div>

<table >
<?php
foreach ($tweets as $tweet):
?>
<tr>
<td>
<font color="black">
            <br />
		<?php echo $tweet['tweets']['content']; ?>
</font>
</td>
</tr>


<?php endforeach; ?>
</table>
</div>
