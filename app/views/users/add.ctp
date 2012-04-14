<?//=debug($data);?>
<?//=debug($u);?>
<h2>Register</h2>
<?php
    echo $form->create('User',array('action'=>'add'));
    echo $form->input('User.name');
    echo $form->input('User.user_name');
    echo $form->input('User.password');
    echo $form->input('User.repeat password',array('type'=> 'password'));
    echo $form->input('User.email');
    echo $form->input('User.site');
    echo $form->end('Register');
?>
