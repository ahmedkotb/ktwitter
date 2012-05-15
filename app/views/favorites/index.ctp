<?=$html->css('tweet',null,null);?>
<?=$javascript->link(array('updatetweets'));?>
    
<div style='padding-left:10px;margin-left:200px;background-color:white;float:left'>

<h2>Favourite Ktweets</h2>
<div class= 'tweets' id = 'tweets'>

<?php
    #person here refers to each of the people that user is following
    if (count($data) == 0){
        echo "you haven't selected any ktweet as a favourite yet";
    }
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
            <?php } ?>
        </div>

<?
    }
?>
</div> <!--end of tweets div-->


</div>


