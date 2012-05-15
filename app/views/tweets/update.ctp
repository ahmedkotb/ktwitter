<div id= 'last_date' style='display:none'><?=strtotime($last_date);?></div>
<div id="count"><?=count($data);?></div>
<div id='new-tweets-content'>
<?php
    #person here refers to each of the people that user is following
    foreach($data as $tweet){
?>            
        <br />
        <div class="tweet" >
            <p><b><?=$html->link($tweet["users"]["name"],'user/'.$tweet['users']['id']);?></b></p>
            <?php
                echo '<p><img src="http://www.gravatar.com/avatar/'.md5($tweet["users"]["email"]).'?s=40&d=identicon" /></p>';
            ?>
                    <br />
            <?='&nbsp '.$tweet['tweets']['content'];?>
            <br />
            <p><?=$time->relativeTime($tweet['tweets']['date'],$format = 'j/n/y');?></p>
            
            <div class='del_link'>
            <?php 
                if ($user_id == $tweet['users']['id'])
                    echo $ajax->link('delete','delete/'.$tweet['tweets']['id'],array('update'=>'error','loading'=>"Element.show('loadingDiv')",'loaded'=>"Element.hide('loadingDiv');window.location.reload();"),null,false);
            ?>
            </div>
            <div class='reply'>
                <?php
                    $name =str_replace(" ", "_", $tweet["users"]["name"]);
                    echo '<a onclick=document.getElementById(\'TweetContent\').value=\'@'.$name.':\'>reply</a>';
                ?>
            </div>
            <?php
                //debug($tweet);
                if ($tweet["favorites"]["fav"] == ""){
                    echo $html->link('favorite',array('controller'=>'favorites','action'=>'add',$tweet['tweets']['id']),array('class'=>'like'));
                }else{
                    echo $html->link('un-favorite',array('controller'=>'favorites','action'=>'remove',$tweet['tweets']['id']),array('class'=>'unlike'));
                }
            ?>
        </div>

<?        
    }
?>
</div>
