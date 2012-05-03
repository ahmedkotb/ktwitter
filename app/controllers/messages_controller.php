<?php
class MessagesController extends AppController {

	var $name = 'Messages';
	var $helpers = array('Html', 'Form');

	function index() {
		$this->Message->recursive = 0;
		$this->set('messages', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Message', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('message', $this->Message->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
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