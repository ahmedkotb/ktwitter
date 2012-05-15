<?=$html->css('tweet',null,null);?>
<h2><?php __('KTweets Search results');?></h2>
<div style='float:right'>
    <?=$html->link('Home',array('controller'=>'tweets','action'=>'index'));?>
    |
    <?=$html->link('Profile',array('controller'=>'users','action'=>'edit/'.$user_id));?>
    |
    <?=$html->link('Inbox',array('controller'=>'messages','action'=>'add'));?>
    |
    <?=$html->link('Favorites',array('controller'=>'favorites','action'=>'index'));?>
    |
    <?=$html->link('Logout',array('controller'=>'users','action'=>'logout'));?>
</div>

<div class="tweets">

    <?php foreach($tweets as $tweet): ?>
        <br/>
        <div class="tweet" >
            <p><b><?=$html->link($tweet["users"]["name"],'user/'.$tweet['users']['id']);?></b></p>
            <br />
            <?php
                echo '<p><img src="http://www.gravatar.com/avatar/'.md5($tweet["users"]["email"]).'?s=40&d=identicon" /></p>';
            ?>
            <?='&nbsp '.$tweet['tweets']['content'];?>
            <br />
            <p style="color:#999999"><?=$time->relativeTime($tweet['tweets']['date'],$format = 'j/n/y');?></p>
        </div>

    <?php endforeach; ?>

</div>
