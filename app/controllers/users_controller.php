<?php
    class UsersController extends AppController {
        var $name = 'Users';
        var $components = array('Email');

        function beforeFilter(){ 
            $this->__validateLoginStatus();
        }

        function __validateLoginStatus(){ 
           if ($this->action =='login' || $this->action =='logout' || $this->action =='add' ||$this->action =='about') return;
           if($this->Session->check('User') == false){ 
              $this->Session->setFlash('you must be logged in to access this page');
              $this->redirect(array('controller'=>'users','action'=>'login'));
           }
        }

        function sendMail(){
            //Only enabled for me .. (hardcoded id)
            $id = $this->Session->read('User.id');
            if ($id != 8) return;

            $users = $this->User->find('all',array('recursive' => 0));

            //$this->Email->delivery = 'debug';
            foreach ($users as $user){
                pr($user['User']['email']);
                $this->Email->to = $user['User']['email'];
                $this->Email->subject = 'Happy Feast';
                $this->Email->from = 'kotbcorp@gmail.com';
                $this->Email->template = 'happy_feast';
                $this->Email->sendAs = 'html';
                $this->Email->send();
            }
            //pr($this->Session->read('Message.email'));
        }
        function index(){
            $this->redirect(array('controller'=>'users','action'=>'search'));
            $id = $this->Session->read('User.id');
            $users = $this->User->find('all',array('recursive'=>0));

            $following = $this->User->Following->find('first',array('conditions'=>array('id'=>$id),'recursive'=>1));
            //$following = $following['Following'];

            foreach ($users as &$user){                
                if ($user['User']['id'] == $id) {
                    $user = null;
                    continue;
                }
                $found = false;       
                for ($i=0;$i<count($following)-6;$i++){
                    if ($following[$i]['id'] == $user['User']['id']){
                        $found = true;
                    }
                }        
                if ($found){
                    $user['User']['following'] = '1';
                }else{
                    $user['User']['following'] = '0';
                }
            }
            
            $this->set('data',$users);
            
        }
        
        function search(){
            if (!empty($this->data)){
                $criteria = mysql_real_escape_string($this->data['search']['criteria']);
                if (strlen($criteria) < 3){
                    echo 'please make search for names bigger than 2 letters';
                    exit();
                }
                $sql = '';
                if ($criteria == 'displayallusers')
                    $sql = 'SELECT id,name from users';
                else
                    $sql = 'SELECT id,name from users where upper(name) like upper("%'.$criteria.'%")';
                
                if ($criteria == 'email-test'){
                    //$this->Email->from = 'Somebody <ahmedkotb@ktwitter.com>';
                    //$this->Email->to = 'kotbcorp <kotbcorp@gmail.com>';
                    //$this->Email->subject = 'Test';
                    //$this->Email->send('Hello message body!');
                    //mail("kotbcorp@gmail.com", "Test E-Mail (This is the subject of the E-Mail)", "This is the body of the Email");
                    exit();                    
                }                    
                $results = $this->User->query($sql);
                
                $id = $this->Session->read('User.id');
           
                $following = $this->User->Following->find('first',array('conditions'=>array('id'=>$id),'recursive'=>1));
                $following = $following['Following'];
                
                foreach ($results as &$user){                
                    if ($user['users']['id'] == $id) {
                        $user = null;
                        continue;
                    }
                    $found = false;       
                    for ($i=0;$i<count($following)-6;$i++){
                        if ($following[$i]['id'] == $user['users']['id']){
                            $found = true;
                        }
                    }        
                    if ($found){
                        $user['users']['following'] = '1';
                    }else{
                        $user['users']['following'] = '0';
                    }
                }
                if (count($results) == 0){
                    echo 'nothing found';
                    exit();
                }
                $this->set('results',$results);
                $this->render('search-results','ajax');
            }
        }
        
        function about(){
                
        }
        
        function follow($id = null){
            $user_id = $this->Session->read('User.id');
            $this->set('id',$id);
            $this->render('unfollow','ajax');
            $this->User->followOrUnfollow(1,$id,$user_id);
        }
        
        function unfollow($id = null){
            $user_id = $this->Session->read('User.id');
            $this->set('id',$id);
            $this->render('follow','ajax');
            $this->User->followOrUnfollow(0,$id,$user_id);
        }
        
        function login(){
            if (!empty($this->data)){
                $user = $this->User->validateLoginData($this->data['User']);
                if ($user){
                    $this->Session->write('User', $user);
                    $this->redirect(array('controller'=>'tweets','action'=>'index'));
                }else{
                    $this->Session->setFlash('Sorry, the information you\'ve entered is incorrect.');
                }
            }
        }
        
        function logout(){
            $this->Session->destroy('user'); 
            $this->Session->setFlash('You\'ve successfully logged out.'); 
            $this->redirect('login');
        }
        
        function edit($id = null){
            if ($this->Session->read('User.id') != $id){
                $this->redirect('login');
            }
            $this->User->id =$id;
            if (empty($this->data)){
                $this->data = $this->User->read();
            }else{
                $this->User->id = $this->data['User']['id'];
                $newUser = $this->User->read();               
                $newUser['User']['name'] = $this->data['User']['name'];
                $newUser['User']['email'] = $this->data['User']['email'];
                $newUser['User']['site'] = $this->data['User']['site'];
            
                $this->set('u',$newUser);
                if ($this->User->save($newUser)) {
                    $this->Session->setFlash('Your profile has been updated.');
                    $this->redirect(array('controller'=>'tweets','action' => 'index'));        
                } else{
                    $this->Session->setFlash('there was a problem in updating your data');
                }             
            }
        }
        
        function add() {            
            if (!empty($this->data)) {
                $this->User->create();                
                #dont forget check for empty password after trim
                if ($this->data['User']['password'] != $this->data['User']['repeat password'] || $this->data['User']['password'] == ""){
                    $this->Session->setFlash(__('passwords dont match', true));                    
                }
                
                $newUser['User']=array();
                $newUser['User']['name'] = $this->data['User']['name'];
                $newUser['User']['email'] = $this->data['User']['email'];
                $newUser['User']['user_name'] = $this->data['User']['user_name'];
                $newUser['User']['hashed_password'] = md5($this->data['User']['password']);
                $newUser['User']['site'] = $this->data['User']['site'];
                                
                $this->set('u',$newUser);
                if ($this->User->save($newUser)) {
                    $this->Session->setFlash(__('thank you for registering', true));
                    
                    //make the user follow him self
            	    $sql = 'INSERT INTO followers_users VALUES ("",'.$this->User->id.','.$this->User->id.')';
            	    $this->User->query($sql);
                    
                    $this->redirect(array('action'=>'login'));
                } else {
                    $this->Session->setFlash(__('registeration failed', true));
                }
            }
        }    
    }
?>
