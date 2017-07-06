<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Validation\Validation;
use Cake\Event\Event;
use Cake\Core\Configure;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends AppController
{
	public function beforeFilter(Event $event) {
		$this->viewBuilder()->layout('admin');
		parent::beforeFilter($event);
		$this->Auth->allow(array('login','logout'));
	}
	
	public function initialize()
	{
		parent::initialize();
		//$this->Auth->allow();
		$this->loadComponent('Captcha', ['field'=>'securitycode']);
	}
	
	function captcha()	{
		$this->autoRender = false;
		$this->viewBuilder()->layout('ajax');
		$this->Captcha->create();
	}
    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Groups']
        ];
        $this->set('users', $this->paginate($this->Users));
        $this->set('_serialize', ['users']);
    }

   /**
     * View method
     *
     * @param string|null $id User id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => ['Groups', 'Posts']
        ]);
        $this->set('user', $user);
        $this->set('_serialize', ['user']);
    }

   /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
	$msg = "";
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user->email = $this->request->data['username'];
            $user->password = $this->request->data['password'];
	    $user->group_id = $this->request->data['group_id'];
           // $user = $this->Users->patchEntity($user, $this->request->data);
           if($this->request->data['securitycode'] == $this->Captcha->getCode('securitycode'))
           {
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The user could not be saved. Please, try again.'));
            }
	   }
	   else
           {
         	// $this->Flash->error(__('Invalid security code please try again'));
         	 $msg = 'Invalid security code please try again';
           }
        }
        $groups = $this->Users->Groups->find('list', ['limit' => 200]);
        $this->set(compact('user', 'groups','msg'));
        $this->set('_serialize', ['user']);
    }

 /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->data);
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The user could not be saved. Please, try again.'));
            }
        }
        $groups = $this->Users->Groups->find('list', ['limit' => 200]);
        $this->set(compact('user', 'groups'));
        $this->set('_serialize', ['user']);
    }
    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
    
 public function login()
    {
        if ($this->request->is('post')) {
            /*if (Validation::email($this->request->data['email'])) {*/
                $this->Auth->config('authenticate', [
                    'Form' => [
                        'fields' => ['username' => 'email']
                    ]
                ]);
                $this->Auth->constructAuthenticate();
                $this->request->data['email'] = $this->request->data['username'];
                //unset($this->request->data['email']);
           /* } */
           // echo $this->request->data['email'];exit;
            $user = $this->Auth->identify();

            if ($user) {
                $this->Auth->setUser($user);
                $session = $this->request->session();
                $session->write('name',$this->request->data['username']);
                return $this->redirect($this->Auth->redirectUrl());
            }

            $this->Flash->error(__('Invalid username or password, try again'));
        }
    }
    
    public function logout()
    {
    	$this->Flash->success('You are now logged out.');
    	$session = $this->request->session();
    	$session->destroy();
    	return $this->redirect($this->Auth->logout());
    }
    
    public function validationCaptcha()
    {
    	extract($_POST);
    	if($captcha == $this->Captcha->getCode('securitycode'))
    	{
    		 echo 0;
    	}
    	else
    	{
    		echo 1;
    	}
    }
    
}
