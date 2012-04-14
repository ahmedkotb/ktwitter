<h2>Welcome to KTwitter Alpha version</h2>
<?php
    echo $html->link('what is ktwitter ?',array('controller'=>'users','action'=>'about'));
    echo ' | ';
    echo $html->link('Register',array('controller'=>'users','action'=>'add'));
?>

<div class="login"> 
<h3>Login</h3>     
    <?php echo $form->create('User', array('action' => 'login'));?> 
        <?php echo $form->input('user_name');?> 
        <?php echo $form->input('password');?> 
    <?php echo $form->submit('Login');?> 
</div> 

<br />
<br />

