<?//=debug($data);?>
<?//=debug($last_date);?>
<?//=debug($last_tweet);?>
<h2>Ktwitter</h2>
<?=$html->css('tweet',null,null);?>
<?=$javascript->link(array('updatetweets'));?>

    <div style='float:right'>
        <?=$html->link('Profile',array('controller'=>'users','action'=>'edit/'.$user_id));?>
        |
        <?=$html->link('Inbox',array('controller'=>'messages','action'=>'add'));?>
        |
        <?=$html->link('Favorites',array('controller'=>'favorites','action'=>'index'));?>
        |
        <?=$html->link('Logout',array('controller'=>'users','action'=>'logout'));?>
    </div>
    
<div style='padding-left:10px;margin-left:200px;background-color:white;float:left'>
<h3></h3>
<div style="width:500px">
    <div id="loadingDiv" style="display: none;">
        <?php echo $html->image('ajax-loader.gif'); ?> 
    </div>
    <?php 
        echo $form->create('Tweet',array('class'=>'NewTweetForm')); 

	    echo $form->input('content',array('class'=>'TweetContent','label'=>'What\'s happening?','type'=>'text','style'=>'float:left','rows'=>'2'));
	    
	    if (!empty($data))
          	echo '<div id="latest" ><b style="color:#999999">latest :</b>'.$last_tweet["Tweet"]["content"].'</div>';
        else
          	echo '<div id="latest" ></div>';
        echo $ajax->submit('update',
                               array('update'=>'tweet_add_result',
                                     'url'=>'add',
                                     'loading'=>"Element.show('loadingDiv')",
                                     'loaded'=>"Element.hide('loadingDiv');addNewTweet()",
                                     'style'=>'float:right'
                                     ));
        echo $form->end();
       	echo '<div id="error"></div>';
    ?>
    <div id="tweet_add_result" style="display:none">
        <div id="tweet_add_last_date" style="display:none"></div>
        <div id="tweet_add_content" style="display:none"></div>
    </div>    
</div>
<h3>latest ktweets</h3>
<?php
    echo $html->link('follow more ktwitters',array('controller'=>'users','action'=>'search'));
    echo ' | ';
    echo $html->link('My KTweets',array('controller'=>'tweets','action'=>'user/'.$user_id));
?>

<br />
<div id='new-tweets-label' class='count_label' onclick='showNewTweets()' style='display:none'></div>
<div id='old-tweets-count' style='display:none'>0</div>
<div id='old-tweets' style='display:none'></div>
<br/>

<div id='new-tweets' style='display:none'>
    <div id="count" style='display:none'></div>
    <div id= 'last_date' style='display:none'><?=strtotime($last_date);?></div>
    <div id='new-tweets-content' style='display:none'></div>
</div>

<div class= 'tweets' id = 'tweets'>

<?php
    #person here refers to each of the people that user is following
    foreach($data as $tweet){
        echo '<br />';
?>            

        <div class="tweet" >
            <p><b><?=$html->link($tweet["users"]["name"],'user/'.$tweet['users']['id']);?></b></p>
            <br />
            <?php
                echo '<p><img src="http://www.gravatar.com/avatar/'.md5($tweet["users"]["email"]).'?s=40&d=identicon" /></p>';
            ?>
            <?='&nbsp '.$tweet['tweets']['content'];?>
            <br />
            <p style="color:#999999"><?=$time->relativeTime($tweet['tweets']['date'],$format = 'j/n/y');?></p>
            <div class='del_link'>
            <?php 
                if ($user_id == $tweet['users']['id'])
                    echo $ajax->link('delete','delete/'.$tweet['tweets']['id'],array('update'=>'error','loading'=>"Element.show('loadingDiv')",'loaded'=>"Element.hide('loadingDiv');window.location.reload();"),null,false);
            ?>
            </div>
            <?php
                if ($user_id != $tweet['users']['id']){
            ?>           
            <div class='reply'>
                <?php
                    $n =str_replace(" ", "_", $tweet["users"]["name"]);
                    echo '<a onclick=document.getElementById(\'TweetContent\').value=\'@'.$n.':\'>reply</a>';
                ?>
            </div>
            <div class='like'>
                <?php echo $html->link('like',array('controller'=>'favorites','action'=>'add_favorite',$tweet['tweets']['id'])) ?>
            </div>
            <?php } ?>
        </div>

<?        
    }
?>
</div> <!--end of tweets div-->
        <div class="tweet" >
        </div>
<div id="moreTweetsLoadingDiv" style="display: none;">
    <?php echo $html->image('ajax-loader.gif'); ?> 
</div>

<div id='more-tweets' >
    <div id='more-tweets-oldest-tweet-date' style='display:none'></div>
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
</div>
</div>

<div style="float:right;width:300px">
    <h3><?=$name;?></h3>

    <b>Ktweets :</b> <?=$tweetsNum?>
    <br/>
    <b>Followers : </b><?=$followersNum?>
    <br/>
    <b>Following :</b> <?=$followingNum?>
   
</div>
