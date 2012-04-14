<?//=debug($data);?>
<?//=debug($user);?>
<?=$html->css('tweet',null,null);?>
<?=$html->link('back',array('controller'=>'tweets','action'=>'index'));?>
<div style='float:right'>
    <?=$html->link('logout',array('controller'=>'users','action'=>'logout'));?>
</div>
<?php
    if ($user_id == $user['User']['id'])
        echo "<h2>My ktweets</h2>";
    else
        echo "<h2>".$user['User']['name']." ktweets</h2>";
    
    echo '<p><img src="http://www.gravatar.com/avatar/'.md5($user["User"]["email"]).'?d=identicon" /></p>';        
    echo '<div id="loadingDiv" style="display: none;">';
    echo $html->image('ajax-loader.gif');
    echo '</div>';
     
    foreach($data as $tweet){
        echo '<br />';
?>            

        <div class="tweet" >            
            <?=$tweet['Tweet']['content'];?>
            </br>
            <p style="color:#999999"><?=$time->relativeTime($tweet['Tweet']['date'],$format = 'j/n/y');?></p>
            <div class='del_link'>
                <?php 
                    if ($user_id == $user['User']['id'])
                        echo $ajax->link('delete','delete/'.$tweet['Tweet']['id'],array('update'=>'error','loading'=>"Element.show('loadingDiv')",'loaded'=>"Element.hide('loadingDiv');window.location.reload();"),null,false);
                ?>
            </div>
        </div>

<?        
    }
?>
