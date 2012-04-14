<?php
    echo '<div class="followAction" id="follow_'.$id.'" >';
    echo '<img src="/ktwitter/img/x.png" width = "20px" height = "20px"></img>';
    echo $ajax->link('follow','/users/follow/'.$id,array('update'=>'follow_'.$id,'loading'=>"Element.show('loadingDiv')",'loaded'=>"Element.hide('loadingDiv')"),null,false);
    echo '</div>';
?>
