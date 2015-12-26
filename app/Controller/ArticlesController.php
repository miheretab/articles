<?php
App::uses('AppController', 'Controller');
/**
 * Articles Controller
 *
 * @property Article $Article
 * @property PaginatorComponent $Paginator
 */
class ArticlesController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');
	
	public function beforeFilter() {
		parent::beforeFilter();
		
		$this->Auth->allow('index', 'view');
	}	
/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Article->recursive = 0;
		if($this->Auth->user('id')) {
			$this->Paginator->settings = array(
				'conditions' => array('User.id' => $this->Auth->user('id'))
			);
		} else {
			$this->Paginator->settings = array(
				'conditions' => array('Article.enabled' => true)
			);
		}
		$this->set('articles', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Article->exists($id)) {
			throw new NotFoundException(__('Invalid article'));
		}
		$conditions = array('Article.' . $this->Article->primaryKey => $id);
		if(!$this->Auth->user('id')) {
			$conditions['Article.enabled'] = true;
		}
		$options = array('conditions' => $conditions);
		$article = $this->Article->find('first', $options);
		if(empty($article)){
			throw new NotFoundException(__('Invalid article'));
		}
		$this->set('article', $article);
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Article->create();
			$this->request->data['Article']['user_id'] = $this->Auth->user('id');
			if ($this->Article->save($this->request->data)) {
				$this->Session->setFlash(__('The article has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The article could not be saved. Please, try again.'));
			}
		}
		$users = $this->Article->User->find('list');
		$this->set(compact('users'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Article->exists($id)) {
			throw new NotFoundException(__('Invalid article'));
		}

		$options = array('conditions' => array(
			'Article.' . $this->Article->primaryKey => $id,
			'User.id' => $this->Auth->user('id')
		));
		$article = $this->Article->find('first', $options);		
		if(empty($article)){
			throw new NotFoundException(__('Invalid article'));
		}		
		
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Article->save($this->request->data)) {
				$this->Session->setFlash(__('The article has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The article could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $article;
		}
		$users = $this->Article->User->find('list');
		$this->set(compact('users'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Article->id = $id;
		if (!$this->Article->exists()) {
			throw new NotFoundException(__('Invalid article'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Article->delete()) {
			$this->Session->setFlash(__('The article has been deleted.'));
		} else {
			$this->Session->setFlash(__('The article could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
	
/**
 * change_status method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function change_status($id = null) {
		$this->Article->id = $id;
		if (!$this->Article->exists()) {
			throw new NotFoundException(__('Invalid article'));
		}
		$this->request->onlyAllow('post', 'change_status');
		$article = $this->Article->findById($id);
		if ($this->Article->saveField('enabled', !$article['Article']['enabled'])) {
			$this->Session->setFlash(__('The article status has been changed.'));
		} else {
			$this->Session->setFlash(__('The article status could not be changed. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
	
/** Admin Part**/

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Article->recursive = 0;
		$this->set('articles', $this->Paginator->paginate());
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		if (!$this->Article->exists($id)) {
			throw new NotFoundException(__('Invalid article'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Article->save($this->request->data)) {
				$this->Session->setFlash(__('The article has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The article could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Article.' . $this->Article->primaryKey => $id));
			$this->request->data = $this->Article->find('first', $options);
		}
		$users = $this->Article->User->find('list');
		$this->set(compact('users'));
	}
/**
 * admin_change_status method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_change_status($id = null) {
		$this->Article->id = $id;
		if (!$this->Article->exists()) {
			throw new NotFoundException(__('Invalid article'));
		}
		$this->request->onlyAllow('post', 'change_status');
		$article = $this->Article->findById($id);
		if ($this->Article->saveField('enabled', !$article['Article']['enabled'])) {
			$this->Session->setFlash(__('The article status has been changed.'));
		} else {
			$this->Session->setFlash(__('The article status could not be changed. Please, try again.'));
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
		$this->Article->id = $id;
		if (!$this->Article->exists()) {
			throw new NotFoundException(__('Invalid article'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Article->delete()) {
			$this->Session->setFlash(__('The article has been deleted.'));
		} else {
			$this->Session->setFlash(__('The article could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
