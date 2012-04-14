<?//=debug($data);?>
<?=$html->css('tweet',null,null);?>
<?=$javascript->link(array('autorefresh'));?>
<h2>welcome <?=$name;?></h2>
<div style='float:right'>
    <?=$html->link('logout',array('controller'=>'users','action'=>'logout'));?>
</div>
<div id="loadingDiv" style="display: none;">
    <?php echo $html->image('ajax-loader.gif'); ?> 
</div> 
<?php 
    echo $form->create('Tweet'); 
    /*echo $ajax->form('tweets/add','post',
                           array('update'=>'comments',
                                 'loading'=>"Element.show('loadingDiv')",
                                 'loaded'=>"Element.hide('loadingDiv')"
                                 ));
    */
	echo $form->input('content',array('type'=>'text'));
    echo $ajax->submit('Update',
                           array('update'=>'error',
                                 'url'=>'add',
                                 'loading'=>"Element.show('loadingDiv')",
                                 'loaded'=>"Element.hide('loadingDiv');document.getElementById('TweetContent').value=''"
                                 ));
   echo $form->end();
   	echo '<div id="error"></div>';
?>

<h2>latest 10 KTweets per user</h2>
    <?=$html->link('see more users',array('controller'=>'users','action'=>'index'));?>
    <br />
    <?=$html->link('refresh Tweets (the page is autoRefreshed each 5 mins)',array('controller'=>'tweets','action'=>'index'));?>
<?php
    #person here refers to each of the people that user is following
    foreach($data as $person){
        echo '<br />';
        //echo '<div class="" ></div>';
        echo '<h3>'.$person['user']['name'].'</h3>';
        echo '<ul type="none">';
        foreach($person['Tweets'] as $tweet){
            //print_r($tweet);
            //print_r($person['user']);
?>            
            <li>
                <div class="tweet" >
                    <p><?=$tweet['Tweet']['date'];?></p>
                    <p><?=$tweet['Tweet']['content'];?></p>
                    
                    <div class='del_link'>
                    <?php 
                        if ($user_id == $person['user']['id'])
                            echo $ajax->link('delete','delete/'.$tweet['Tweet']['id'],array('update'=>'error','loading'=>"Element.show('loadingDiv')",'loaded'=>"Element.hide('loadingDiv');window.location.reload();"),null,false);
                    ?>
                    </div>
                    
                </div>
            </li>

<?        }
        echo '</ul>';
    }
?>
