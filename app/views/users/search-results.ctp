<?php
    $i=0;
    foreach ($results as $user){
        if ($user == null) continue;
        $i+=1;
?>
        <div class ='user'>
        <p><?='<b>'.$i.'</b>'.'-'.$user['users']['name'];?></p>
        <?php
            if ($user['users']['following']){                
                echo '<div class="followAction" id="follow_'.$user['users']['id'].'" >';
                echo '<img src="/ktwitter/img/check.png" width = "20px" height = "20px"></img>';
                echo $ajax->link('unfollow','/users/unfollow/'.$user['users']['id'],array('update'=>'follow_'.$user['users']['id'],'loading'=>"Element.show('loadingDiv')",'loaded'=>"Element.hide('loadingDiv')"),null,false);
                echo '</div>';
            }else{
                echo '<div class="followAction" id="follow_'.$user['users']['id'].'" >';
                echo '<img src="/ktwitter/img/x.png" width = "20px" height = "20px"></img>';
                echo $ajax->link('follow','/users/follow/'.$user['users']['id'],array('update'=>'follow_'.$user['users']['id'],'loading'=>"Element.show('loadingDiv')",'loaded'=>"Element.hide('loadingDiv')"),null,false);
                echo '</div>';
            }
        ?>
        </div>

<?php
    }
     echo '<div class="user"></div>';
?>
