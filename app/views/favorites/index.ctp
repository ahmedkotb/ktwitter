<?=$html->css('tweet',null,null);?>
<?=$javascript->link(array('updatetweets'));?>
    
<div style='padding-left:10px;margin-left:200px;background-color:white;float:left'>

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
            <div class='reply'>
                <?php echo $html->link('like',array('controller'=>'favorites','action'=>'add_favorite',$tweet['tweets']['id'])) ?>
            </div>
            <?php } ?>
        </div>

<?        
    }
?>
</div> <!--end of tweets div-->


</div>


