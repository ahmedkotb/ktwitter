<?php
    class TweetsController extends AppController {
        var $name = 'Tweets';        
        var $helpers = array('paginator');
        
        function beforeFilter(){ 
            $this->__validateLoginStatus();
        }
     
        
        function index(){
        }
        
        function add(){
        }
        
        
        function __validateLoginStatus(){ 
            if($this->Session->check('User') == false){ 
                $this->Session->setFlash('you must be logged in to access this page');
                $this->redirect(array('controller'=>'users','action'=>'login'));             
            }
        }
        
    }
?>
