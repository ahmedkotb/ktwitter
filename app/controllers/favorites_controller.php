<?php
class FavoritesController extends AppController {
	var $name = 'Favorites';
	var $helpers = array('Html', 'Form');

	function index2() {

		$this->Tweet->recursive = 0;
		//$this->set('tweets', $this->paginate());
		$this->set('name',$this->Session->read('User.name'));
		
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
    	$tweetsNum =
 $this->Tweet->query("SELECT count(id) FROM tweets where user_id = $id");
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

	function index() {
		$this->set('favorites',$this->Favorite->find('all'));
	}


	function add_favorite($id = null) {
		$this->data['Favorite']['user_id'] = $this->Session->read('User.id');
		$this->data['Favorite']['tweet_id'] = $id;
                $this->Favorite->save($this->data);
		$this->redirect(array('controller'=>'tweets','action'=>'index'));
	}
}
?>
