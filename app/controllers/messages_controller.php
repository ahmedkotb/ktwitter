<?php
class MessagesController extends AppController {
	var $name = 'Messages';
	var $helpers = array('Html', 'Form');

	function index() {
        $this->set('user_id',$this->Session->read('User.id'));
		$this->Message->recursive = 0;
		$this->paginate = array('conditions'=> array('Message.recipient_id'=>$this->Session->read('User.id')));
		$this->set('messages', $this->paginate('Message'));
	}

	function view($id = null) {
        $this->set('user_id',$this->Session->read('User.id'));
		if (!$id) {
			$this->Session->setFlash(__('Invalid Message', true));
			$this->redirect(array('action' => 'index'));
		}
		$message = $this->Message->read(null, $id);
		$sender = ClassRegistry::init('User')->findById($message['Message']['sender_id']);

		$this->set('titles', $message['Message']['title']);
		$this->set('message', $message);
		$this->set('sender', $sender['User']['name']);
		$this->set('body', $message['Message']['body']);
	}

	function add() {

		if (!empty($this->data)) {
			$receiver = ClassRegistry::init('User')->findByUserName($this->data['Message']['recipient_id']);
			$this->data['Message']['recipient_id'] = $receiver['User']['id'];
			$this->data['Message']['sender_id'] = $this->Session->read('User.id');
			$this->Message->create();
			if ($this->Message->save($this->data)) {
				$this->Session->setFlash(__('The Message has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The Message could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Message', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Message->save($this->data)) {
				$this->Session->setFlash(__('The Message has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The Message could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Message->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Message', true));
			$this->redirect(array('action' => 'index'));
		}
		if ($this->Message->del($id)) {
			$this->Session->setFlash(__('Message deleted', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('The Message could not be deleted. Please, try again.', true));
		$this->redirect(array('action' => 'index'));
	}

}
?>
