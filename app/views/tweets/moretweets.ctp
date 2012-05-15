<div id= 'more-tweets-oldest-tweet-date' style='display:none'><?=strtotime($oldest_tweet_date);?></div>
<div id= 'more-tweets-content' style='display:none'>
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
            <p style="color:#999999"><?=$time->relativeTime($tweet['tweets']['date'],$format = 'j/n/y');?></p>
            
            <div class='del_link'>
            <?php 
                if ($user_id == $tweet['users']['id'])
                    echo $ajax->link('delete','delete/'.$tweet['users']['id'],array('update'=>'error','loading'=>"Element.show('loadingDiv')",'loaded'=>"Element.hide('loadingDiv');window.location.reload();"),null,false);
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
<?php
    if ($oldest_tweet_date == 0)
        echo '<button  type = "button" style = "width:500px" disabled> More </button>';
    else{
        echo $form->create('moreTweets');
        echo $ajax->submit('More',
                               array('update'=>'more-tweets',
                                     'url'=>'moretweets/'.strtotime($oldest_tweet_date),
                                     'loading'=>"Element.show('moreTweetsLoadingDiv')",
                                     'loaded'=>"Element.hide('moreTweetsLoadingDiv');addedMoreTweets()",
                                     'id'=>'moreTweetsButton',
                                     'style'=>'width:500px'
                                     ));
   }
?>
