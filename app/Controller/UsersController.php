<?php
App::uses('AppController', 'Controller');
/**
 * Users Controller
 *
 * @property User $User
 * @property PaginatorComponent $Paginator
 */
App::uses('CakeEmail', 'Network/Email');

class UsersController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Payment');
	
	public function beforeFilter() {
		parent::beforeFilter();
		
		$this->Auth->allow('signup', 'login', 'logout', 'forgot_password', 'reset_password', 'activate');
	}		

	public function initDB() {
		$group = $this->User->Group;

		// Allow admins to everything
		$group->id = 1;
		$this->Acl->allow($group, 'controllers');

		// allow managers to posts and widgets
		$group->id = 2;
		$this->Acl->deny($group, 'controllers');
		$this->Acl->allow($group, 'controllers/Users');
		$this->Acl->allow($group, 'controllers/Articles');
		$this->Acl->deny($group, 'controllers/Articles/admin_change_status');
		$this->Acl->deny($group, 'controllers/Articles/admin_delete');
		$this->Acl->deny($group, 'controllers/Articles/admin_index');
		$this->Acl->deny($group, 'controllers/Articles/admin_edit');
		$this->Acl->deny($group, 'controllers/Users/admin_change_status');
		$this->Acl->deny($group, 'controllers/Users/admin_delete');
		$this->Acl->deny($group, 'controllers/Users/admin_index');

		// we add an exit to avoid an ugly "missing views" error message
		echo "all done";
		exit;

	}
	
	public function login() {
		if ($this->request->is('post')) {
			if ($this->Auth->login()) {
				if ($this->Auth->user('enabled')) {
					return $this->redirect($this->Auth->redirectUrl());
				} else {
					$this->Session->setFlash(__('Your email is suspended.'));
					return $this->redirect($this->Auth->logout());
				}
			}
			$this->Session->setFlash(__('Your email or password was incorrect.'));
		}
	}

	public function logout() {
		$this->redirect($this->Auth->logout());
	}	

/**
 * signup method
 *
 * @return void
 */
	public function signup() {
		if ($this->request->is('post')) {
		
			$this->User->create();
			$this->request->data['User']['code'] = md5(rand());
			$this->request->data['User']['group_id'] = 2;
			if ($this->User->save($this->request->data)) {
			
				//sending email 
				$Email = new CakeEmail();
				$Email->config('smtp');
				$Email->to($this->request->data['User']['email']);
				$Email->subject('Registered on Articles');
				$Email->template('signup', 'default');
				$Email->viewVars(array('url' => Router::url('/users/activate/' . $this->User->id . '/' . $this->request->data['User']['code'], true)));
				$Email->emailFormat('html');
				$Email->send();
				
				$this->Session->setFlash(__('You are registered. Please see your email to activate it.'));
				return $this->redirect(array('action' => 'login'));
			} else {
				$this->Session->setFlash(__('The user could not be registered. Please, try again.'));
			}
		}
	}
	
/**
 * forgot password method
 *
 * @return void
 */
	public function forgot_password() {
		if ($this->request->is('post')) {
			$user = $this->User->findByEmail($this->request->data['User']['email']);
			if(!empty($user)) {
				$this->User->id = $user['User']['id'];
				$this->request->data['User']['code'] = md5(rand());
				if ($this->User->saveField('code', $this->request->data['User']['code'], false)) {
				
					//sending email 
					$Email = new CakeEmail();
					$Email->config('smtp');
					$Email->to($this->request->data['User']['email']);
					$Email->subject('Forgot Password on Articles');
					$Email->template('forgot_password', 'default');
					$Email->viewVars(array('url' => Router::url('/users/reset_password/' . $this->User->id . '/' . $this->request->data['User']['code'], true)));
					$Email->emailFormat('html');
					$Email->send();
					
					$this->Session->setFlash(__('Please see your email to reset your password.'));

				}
			} else {
				$this->Session->setFlash(__('No user is registered by this email.'));
			}
		}
	}	

/**
 * activate method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function activate($id, $code) {
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		$user = $this->User->find('first', array(
			'conditions' => array(
				'User.id' => $id, 
				'User.code' => $code
			)
		));
		if (!empty($user)) {
			$this->User->id = $id;
			if ($this->User->saveField('enabled', true, false)) {
				$this->User->saveField('code', md5(rand()), false);
				$this->Session->setFlash(__('The user has been activated.'));
			} else {
				$this->Session->setFlash(__('The user could not be activated.'));
			}
		} else {
			$this->Session->setFlash(__('Invalid link'));
		}
		
		return $this->redirect(array('action' => 'login'));
	}
	
/**
 * reset password method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function reset_password($id, $code) {
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		$user = $this->User->find('first', array(
			'conditions' => array(
				'User.id' => $id, 
				'User.code' => $code
			)
		));
		if (!empty($user)) {
			if ($this->request->is('post')) {
				
				$this->User->id = $id;
				if ($this->User->save($this->request->data)) {
					$this->User->saveField('code', md5(rand()), false);
					$this->Session->setFlash(__('The password has been reset.'));
					return $this->redirect(array('action' => 'login'));
				} else {
					$this->Session->setFlash(__('The password could not be reset.'));
				}
			}
		} else {
			$this->Session->setFlash(__('Invalid link'));
			return $this->redirect(array('action' => 'login'));
		}
		
	}	
	
/**
 * edit password method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit_password() {
		$id = $this->Auth->user('id');
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->request->is(array('post', 'put'))) {
			$this->User->id = $id;
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The password has been changed.'));
				return $this->redirect(array('controller' => 'articles', 'action' => 'index'));
			} else {
				$this->Session->setFlash(__('The password could not be saved. Please, try again.'));
			}
		}
	}
	
/**
 * add balance method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function add_balance() {
		$id = $this->Auth->user('id');
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->request->is(array('post', 'put'))) {
			
			$cc = $this->request->data['User']['cc'];
			$cvc = $this->request->data['User']['cvc'];
			$expDate = $this->request->data['User']['exp_date'];
			$lastName = $this->request->data['User']['payment_last_name'];
			$firstName = $this->request->data['User']['payment_first_name'];
			$amount = $this->request->data['User']['amount'];
			if($this->Payment->charge($cc, $cvc, $expDate, $firstName, $lastName, $amount)) {
			
				$user = $this->User->findById($id);			
				$this->User->id = $id;
				$this->request->data['User']['balance'] = $user['User']['balance'] + $amount;
				if ($this->User->save($this->request->data)) {
					
					$data = array('User' => array('balance' => $this->request->data['User']['balance']));
					$this->Session->write(AuthComponent::$sessionKey, array_merge(
						$this->Session->read(AuthComponent::$sessionKey), $data['User']
					));
					
					$this->Session->setFlash(__('The payment has been done.'));
					return $this->redirect(array('controller' => 'articles', 'action' => 'index'));
				} else {
					$this->Session->setFlash(__('The payment could not be processed. Please, try again.'));
				}
			} else {
				$this->Session->setFlash(__('The payment could not be processed. Please, try again.'));
			}
		}
	}	

/** Admin Part**/
	
/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->User->recursive = 0;
		$this->Paginator->settings = array(
			'conditions' => array('Group.id' => 2)
		);		
		$this->set('users', $this->Paginator->paginate());
	}

/**
 * admin_change_status method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_change_status($id = null) {
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		$this->request->onlyAllow('post', 'change_status');
		$user = $this->User->findById($id);
		if ($this->User->saveField('enabled', !$user['User']['enabled'])) {
			$this->Session->setFlash(__('The user status has been changed.'));
		} else {
			$this->Session->setFlash(__('The user status could not be changed. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
	
/**
 * admin_delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->User->delete()) {
			$this->Session->setFlash(__('The user has been deleted.'));
		} else {
			$this->Session->setFlash(__('The user could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}	

	public function admin_logout() {
		$this->redirect($this->Auth->logout());
	}	
}
