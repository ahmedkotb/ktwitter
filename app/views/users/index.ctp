<?//=debug($data);?>
<?=$html->css('user',null,null);?>
<?=$html->link('back',array('controller'=>'tweets','action'=>'index'));?>
<div style='float:right'>
    <?=$html->link('logout',array('controller'=>'users','action'=>'logout'));?>

</div>

<h2>ktwitters :</h2>
<div id="loadingDiv" style="display: none;">
    <?php echo $html->image('ajax-loader.gif'); ?> 
</div> 
<?php
    $i=0;
    foreach ($data as $user){
        if ($user == null) continue;
        $i+=1;
?>
        <div class ='user'>
        <p><?='<b>'.$i.'</b>'.'-'.$user['User']['name'];?></p>
        <?php
            if ($user['User']['following']){                
                echo '<div class="followAction" id="follow_'.$user['User']['id'].'" >';
                echo '<img src="img/check.png" width = "20px" height = "20px"></img>';
                echo $ajax->link('unfollow','/users/unfollow/'.$user['User']['id'],array('update'=>'follow_'.$user['User']['id'],'loading'=>"Element.show('loadingDiv')",'loaded'=>"Element.hide('loadingDiv')"),null,false);
                echo '</div>';
            }else{
                echo '<div class="followAction" id="follow_'.$user['User']['id'].'" >';
                echo '<img src="img/x.png" width = "20px" height = "20px"></img>';
                echo $ajax->link('follow','/users/follow/'.$user['User']['id'],array('update'=>'follow_'.$user['User']['id'],'loading'=>"Element.show('loadingDiv')",'loaded'=>"Element.hide('loadingDiv')"),null,false);
                echo '</div>';
            }
        ?>
        </div>

<?php
    }
     echo '<div class="user"></div>';
?>
