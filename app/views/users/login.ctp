<h2>Welcome to KTwitter</h2>
<?php
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

