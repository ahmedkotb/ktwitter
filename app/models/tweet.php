<?php
    class Tweet extends AppModel {
        var $name = 'Tweet';
        var $belongsTo = 'User';
        var $validate = array(
             'content'=>array('rule'=>array('between',6,140),
                          'message'=>'Tweet content length must be > 6 and < 140',
                          'required'=>true             
              ),
        );
    }
?>
