<?php // debug($tweet);?>
<div id="tweet_add_last_date" style="display:none"><?=$last_date?></div>
<div id="tweet_add_content" style="display:none">
    <div class="tweet" >
        <p><b><?=$html->link($tweet["users"]["name"],'user/'.$tweet['users']['id']);?></b></p>
        <br />
        <?php
            echo '<p><img src="http://www.gravatar.com/avatar/'.md5($tweet["users"]["email"]).'?s=40&d=identicon" /></p>';
        ?>
        <?='&nbsp '.$tweet['content'];?>
        <br />
        <p style="color:#999999"><?=$time->relativeTime($tweet['date'],$format = 'j/n/y');?></p>
        <div class='del_link'>
        <?php 
            if ($user_id == $tweet['users']['id'])
                //echo $ajax->link('delete','delete/'.$tweet['id'],array('update'=>'error','loading'=>"Element.show('loadingDiv')",'loaded'=>"Element.hide('loadingDiv');window.location.reload();"),null,false);
                echo $html->link('delete','delete/'.$tweet['id']);
        ?>
        </div>
    </div>
</div>
