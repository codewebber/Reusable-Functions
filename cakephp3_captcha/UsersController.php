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
		//$this->Auth->allow(array('logout'));
	}
	
	public function initialize()
	{
		parent::initialize();
		/*** here we are loaing captcha component before this need to create component under Controller/Component 
		  note : paste mentioned fonts in fonts folder to webroot/fonts
		**/
		$this->loadComponent('Captcha', ['field'=>'securitycode']);
	}
	
	function captcha()	{
		$this->autoRender = false;
		$this->viewBuilder()->layout('ajax');
		$this->Captcha->create();
	}
   
   /**
	Here simple example function function i mentioned for understanding 
        we can use captcha code wherever we want(Other controller also) below line is main for comparision captcha 
        if($this->request->data['securitycode'] == $this->Captcha->getCode('securitycode'))
   **/

    public function add()
    {
    	$msg = "";
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
        	$user->email = $this->request->data['email'];
        	$user->password = $this->request->data['password'];
           if($this->request->data['securitycode'] == $this->Captcha->getCode('securitycode'))
           {
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->error(__('The user could not be saved. Please, try again.'));
            }
          }
         else
         {
         	 $msg = 'Invalid security code please try again';
         }
        }
        $this->set(compact('user','msg'));
        $this->set('_serialize', 'user');
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
