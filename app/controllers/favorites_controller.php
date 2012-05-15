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
where users.id= follower_id And tweets.id = favorites.tweet_id  And favorites.user_id = $id And tweets.user_id = follower_id AND followers_users.user_id=$id order by tweets.date DESC limit $limit";

		$tweets = $this->Tweets->Tweet->query($sql);
		$last_tweet =$this->Tweets->Tweet->find('first',array('conditions'=>array('Tweet.user_id'=>$id),'order'=>'Tweet.date Desc','recursive'=>-1));
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

	}

	function add($id = null) {
		$this->data['Favorite']['user_id'] = $this->Session->read('User.id');
		$this->data['Favorite']['tweet_id'] = $id;
        $this->Favorite->save($this->data);
		$this->redirect(array('controller'=>'tweets','action'=>'index'));
	}

	function remove($id = null) {
		if (!$id)
			return;
        $user_id = $this->Session->read('User.id');
        $sql = "delete from favorites where user_id = $user_id and tweet_id = $id";
        Classregistry::init('Tweet');
		$this->Tweets =& new TweetsController; /*Loads the class*/
		$this->Tweets->constructClasses(); /*Loads the model associations, components, etc. of the Pages controller*/
		$this->Tweets->Tweet->query($sql);
		$this->redirect(array('controller'=>'tweets','action'=>'index'));
	}
}
?>
