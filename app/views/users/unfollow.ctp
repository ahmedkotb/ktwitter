<?php
    echo '<div class="followAction" id="follow_'.$id.'" >';
    echo '<img src="/ktwitter/img/check.png" width = "20px" height = "20px"></img>';
    echo $ajax->link('unfollow','/users/unfollow/'.$id,array('update'=>'follow_'.$id,'loading'=>"Element.show('loadingDiv')",'loaded'=>"Element.hide('loadingDiv')"),null,false);
    echo '</div>';               
?>
