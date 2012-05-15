<?php
class TweetsController extends AppController {
	var $name = 'Tweets';
	var $helpers = array('Time');
    
    function beforeFilter(){ 
        $this->__validateLoginStatus();
    }
    
    function __validateLoginStatus(){ 
       if($this->Session->check('User') == false){ 
          $this->Session->setFlash('you must be logged in to access this page');
          $this->redirect(array('controller'=>'users','action'=>'login'));             
       }
    }

	function index() {
		$this->Tweet->recursive = 0;
		//$this->set('tweets', $this->paginate());
		$this->set('name',$this->Session->read('User.name'));
		
		/*
		#testing ....
		#first get the user id
		$id = $this->Session->read('User.id');
		#second get all the people that the user's follow
		$user = $this->Tweet->User->find('first',array('conditions'=>array('id'=>$id)));

		#third get all their tweets
		
		#limit is last 10 tweets by each user
		$tweets = array();
		$i=0;		
		foreach ($user['Following'] as $person){		    
    		$tweets[]['Tweets'] = $this->Tweet->find('all',array('conditions'=>array('Tweet.user_id'=>$person['id']),'limit'=>'10','recursive'=>-1,'order'=>'Tweet.date Desc'));
    		$tweets[$i]['user']['name'] = $person['name'];
    		$tweets[$i]['user']['id'] = $person['id'];
    		$i+=1;
		}
		
  		$tweets[]['Tweets'] = $this->Tweet->find('all',array('conditions'=>array('Tweet.user_id'=>$id),'limit'=>'10','recursive'=>-1,'order'=>'Tweet.date Desc'));
   		$tweets[$i]['user']['name'] = 'me';
   		$tweets[$i]['user']['id'] = $id;
		*/
		$id = $this->Session->read('User.id');
		$limit = 20;
		$sql = "SELECT users.id ,users.name,users.email, tweets.date, tweets.content ,tweets.id from users join followers_users join tweets where users.id= follower_id  And tweets.user_id = follower_id AND followers_users.user_id=$id order by tweets.date DESC limit $limit";
		$tweets = $this->Tweet->query($sql);
		$last_tweet =$this->Tweet->find('first',array('conditions'=>array('Tweet.user_id'=>$id),'order'=>'Tweet.date Desc','recursive'=>-1));
		$this->set('last_tweet',$last_tweet);
		$this->set('data',$tweets);
		$this->set('user_id',$id);
		if (!empty($tweets)){
		    //last_date holds the most recent date
    		$this->set('last_date',$tweets[0]['tweets']['date']);
    		//oldest_tweet_date holds the oldest tweet date
    		$this->set('oldest_tweet_date',$tweets[count($tweets)-1]['tweets']['date']);
    	}else{
    	    $this->set('oldest_tweet_date',0);
    	}
    	
    	//get extra info
    	//number of tweets , followers , following
    	$tweetsNum = $this->Tweet->query("SELECT count(id) FROM tweets where user_id = $id");
    	$tweetsNum = $tweetsNum[0][0]['count(id)'];
    	$followersNum = $this->Tweet->query("select count(id) from followers_users where follower_id=$id");
    	$followersNum = $followersNum[0][0]['count(id)'] -1; 
    	$followingNum = $this->Tweet->query("select count(id) from followers_users where user_id=$id");
    	$followingNum = $followingNum[0][0]['count(id)'] -1;
  	    $this->set('tweetsNum',$tweetsNum);
 	    $this->set('followersNum',$followersNum);
  	    $this->set('followingNum',$followingNum);
  	    $this->Tweet->User->suggestedFriends(8);
	}
    
    /*function tempFunc(){
        $users = $this->Tweet->User->find('all',array('recursive'=>-1));
		foreach ($users as $person){		    
    	    //debug($person['User']['id']);
    	    $sql = 'INSERT INTO followers_users VALUES ("",'.$person['User']['id'].','.$person['User']['id'].')';
    	    $this->Tweet->User->query($sql);
		}        
    }*/
    
	function view($id = null) {
		if (!$id) {
			$this->flash(__('Invalid Tweet', true), array('action' => 'index'));
		}
		$this->set('tweet', $this->Tweet->read(null, $id));
	}
        
    #returns the tweets after the specfied date
    #should be called from ajax
    function update($date=null){
		$id = $this->Session->read('User.id');		
		$date = date('Y-m-d H:i:s',$date);
		$sql = "SELECT users.id ,users.name,users.email, tweets.date, tweets.content from users join followers_users join tweets where users.id= follower_id  And tweets.user_id = follower_id AND followers_users.user_id='$id' AND tweets.date > '$date' order by tweets.date DESC limit 100";
		$tweets = $this->Tweet->query($sql);
		$this->set('data',$tweets);
		$this->set('user_id',$id);
		if (!empty($tweets))
    		$this->set('last_date',$tweets[0]['tweets']['date']);
        else
            $this->set('last_date',$date);
        $this->render('update','ajax');
    }
    
    #returns the tweets before the specfied date
    #should be called from ajax
    function moretweets($date=null){
		$id = $this->Session->read('User.id');		
		$date = date('Y-m-d H:i:s',$date);
		$limit = 10;
		$sql = "SELECT users.id ,users.name,users.email, tweets.date, tweets.content from users join followers_users join tweets where users.id= follower_id  And tweets.user_id = follower_id AND followers_users.user_id='$id' AND tweets.date < '$date' order by tweets.date DESC limit $limit";
		$tweets = $this->Tweet->query($sql);
		$this->set('data',$tweets);
		$this->set('user_id',$id);
		if (!empty($tweets))
    		$this->set('oldest_tweet_date',$tweets[count($tweets)-1]['tweets']['date']);
        else
    	    $this->set('oldest_tweet_date',0);
        $this->render('moretweets','ajax');
    }
    
    #given a user id it returns its page
    function user($id = null){        
        $user = ClassRegistry::init('User')->find('first',array('conditions'=>array('User.id'=>$id),'recursive'=>-1));
        $tweets = $this->Tweet->find('all',array('conditions'=>array('Tweet.user_id'=>$id),'recursive'=>-1,'order'=>'Tweet.date Desc'));
        $this->set('data',$tweets);
        $this->set('user',$user);  
        $this->set('user_id',$this->Session->read('User.id'));
    }
    
    function search(){

     $tweets = $this->Tweet->query('select * from tweets where content like "%'.$this->data['Tweet']['content'].'%"');
     $this->set('tweets',$tweets);
    }
    #add a new tweet
	function add() {
		if (!empty($this->data)) {
			$this->Tweet->create();			           
			$this->data['Tweet']['user_id'] = $this->Session->read('User.id');
			$this->data['Tweet']['date'] = date("Y-m-d G:i:s");
			if ($this->Tweet->save($this->data)) {
				//$this->flash(__('Tweet added.', false), array('action' => 'index'));
         		$this->data['Tweet']['users']=array();
				$this->data['Tweet']['users']['name'] = $this->Session->read('User.name');
        		$this->data['Tweet']['users']['id'] = $this->Session->read('User.id');
        		$this->data['Tweet']['users']['email'] = $this->Session->read('User.email');
        		$this->data['Tweet']['id']=$this->Tweet->id;
   		        $this->set('user_id',$this->Session->read('User.id'));  		        
   		        $this->set('tweet',$this->data['Tweet']);
   		        $this->set('last_date',strtotime($this->data['Tweet']['date']));
   		        $this->render('mytweet','ajax');
			} else {
    			$this->flash(__('0', false), array('action' => 'index'));
    		}
		}
	}

	function delete($id = null) {
		if (!$id) {
			//$this->flash(__('Invalid Tweet', true), array('action' => 'index'));
			return;
		}
		if ($this->Tweet->del($id)) {
			//$this->flash(__('Tweet deleted', false), array('action' => 'index'));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>
