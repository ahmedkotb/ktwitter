<?//=debug($u);?>
<?=$html->link('back',array('controller'=>'tweets','action'=>'index'));?>
<h2>Edit Profile</h2>
<?php
	echo $form->create('User', array('action' => 'edit'));
	echo $form->input('id',array('type'=>'hidden'));
    echo $form->input('User.name');
    echo $form->input('User.email');
    echo $form->input('User.site');
    echo $form->end('edit profile');
?>
