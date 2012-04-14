<?php
    class User extends AppModel {
        var $name = 'User';      

        var $validate = array(
             'name'=>array('rule'=>array('between',6,40),
                          'message'=>'name field must have more than 6 characters and less than 40 characters',
                          'required'=>true             
                         ),
		     'user_name'=>array(
			    'style'=>array(					
			        'rule'=>array('custom','/^[a-z][a-z0-9\._]+$/'),
			        'required'=>true,
			        'message'=>'The user name may only contain a-z , dot and underscore'
					),
			    'Length'=>array(
			        'rule'=>array('between',5,32),
			        'message'=>'invalid user name length'
				   	)
				),
             'email'=>array('rule'=>'email',
                          'message'=>'please specify a valid email',
                          'required'=>true
                         ),
             'site'=>array('rule'=>'url',
                          'message'=>'please specify a valid url',
                          'required'=>false
                         ),                         
        );
        
        var $hasAndBelongsToMany = array(
            'Following' =>
                array(
                    'className'              => 'User',
                    'joinTable'              => 'followers_users',
                    'foreignKey'             => 'user_id',
                    'associationForeignKey'  => 'follower_id',
                    'unique'                 => true,
                    'conditions'             => '',
                    'fields'                 => '',
                    'order'                  => '',
                    'limit'                  => '',
                    'offset'                 => '',
                    'finderQuery'            => '',
                    'deleteQuery'            => '',
                    'insertQuery'            => ''
                )
        );

        #return the user info if found or false if the user doesnt exists
        function validateLoginData($data){
            $user = $this->find(array('user_name' => $data['user_name'], 'hashed_password' => md5($data['password'])), array('id', 'user_name','name','email'));
            if(!empty($user))
                return $user['User'];
            return false; 
        }
        
        function suggestedFriends($id){
            #first get the user Followings
            $following = $this->query("select follower_id from followers_users where user_id = $id and follower_id != $id");
            #debug($following);
            
            $limit = 20;
            
            #second get all the followings of the each person that the user follows
            $indirect = $this->query("select follower_id from followers_users where user_id in 
                                      (select follower_id from followers_users where user_id = $id and follower_id!=$id)
                                      and follower_id != $id limit $limit");
                                     
            #third remove the people that already are my friends and sort by number of occurance
            
        }
        
        function followOrUnfollow($type,$id,$userID){
            #i didnt know how to make this in a cake way so i did it in
            #using raw mysql query...which i think is more optimized
            if ($type ==1){ #follow
                $sql = 'INSERT INTO followers_users VALUES ("",'.$userID.','.$id.')';
                return $this->query($sql);
            }else{
                $sql = 'DELETE FROM followers_users WHERE user_id='.$userID.' and follower_id='.$id;
                return $this->query($sql);            
            }
        }
    }
?>
