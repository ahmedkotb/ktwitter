<?php

App::import('Controller', 'Tweets');
App::import('Model','Tweet');

class FavoritesController extends AppController {
	var $name = 'Favorites';
	var $helpers = array('Html', 'Form');
	var $Tweets;
	var $Tweet;

	function index() {
	Classregistry::init('Tweet');
		$this->Tweets =& new TweetsController; /*Loads the class*/
		$this->Tweets->constructClasses(); /*Loads the model associations, components, etc. of the Pages controller*/

		$this->Tweet->recursive = 0;
		$this->set('name',$this->Session->read('User.name'));
		
		$id = $this->Session->read('User.id');
		$limit = 20;
		$sql = "SELECT users.id ,users.name,users.email, tweets.date, tweets.content ,tweets.id 
from users join followers_users join tweets join favorites
where users.id= follower_id And tweets.id = favorites.tweet_id  And tweets.user_id = follower_id AND followers_users.user_id=$id order by tweets.date DESC limit $limit";

		$tweets = $this->Tweets->Tweet->query($sql);
		$last_tweet =$this->Tweets->Tweet->find('first',array('conditions'=>array('Tweet.user_id'=>$id),'order'=>'Tweet.date Desc','recursive'=>-1));
		$this->set('last_tweet',$last_tweet);
		$this->set('data',$tweets);
		$this->set('user_id',$id);
		//last_date holds the most recent date
    		$this->set('last_date',$tweets[0]['tweets']['date']);
    		//oldest_tweet_date holds the oldest tweet date
    		$this->set('oldest_tweet_date',$tweets[count($tweets)-1]['tweets']['date']);
    	
    		//get extra info
    		//number of tweets , followers , following
    		$tweetsNum =
 			$this->Tweets->Tweet->query("SELECT count(id) FROM tweets where user_id = $id");
    		$tweetsNum = $tweetsNum[0][0]['count(id)'];
    		$followersNum = $this->Tweets->Tweet->query("select count(id) from followers_users where follower_id=$id");
    		$followersNum = $followersNum[0][0]['count(id)'] -1; 
    		$followingNum = $this->Tweets->Tweet->query("select count(id) from followers_users where user_id=$id");
    		$followingNum = $followingNum[0][0]['count(id)'] -1;
  	    	$this->set('tweetsNum',$tweetsNum);
 	    	$this->set('followersNum',$followersNum);
  	    	$this->set('followingNum',$followingNum);
  	    	$this->Tweets->Tweet->User->suggestedFriends(8);

	}

	function add_favorite($id = null) {
		$this->data['Favorite']['user_id'] = $this->Session->read('User.id');
		$this->data['Favorite']['tweet_id'] = $id;
                $this->Favorite->save($this->data);
		$this->redirect(array('controller'=>'tweets','action'=>'index'));
	}
}
?>
