Cakephp3 Role management (Acl) implementation : 

step1 : check composer.phar is running or not in your project folder using below command
        command : php composer.phar
        if it is working then below lines of code it will dispaly similar to below lines:
	Composer version 1.1.1 2016-05-17 12:25:44

step1.1 : if composer is not installed in your project folder then need to follow below steps
       commands : curl -sS https://getcomposer.org/installer | php
		  php composer.phar install

step2 : if composer installed properly then we are ready for install acl plugin using composer follow below command
        commnad : php composer.phar composer require cakephp/acl

step3 : after installation of acl plugin Include the ACL plugin in app/config/bootstrap.php
        code : Plugin::load('Acl', ['bootstrap' => true]);

/********************* acl implementation code steps ***************************/

example : Here i'm explaining simple acl implementation with few tables 

CREATE TABLE users (
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL UNIQUE,
    password CHAR(60) NOT NULL,
    group_id INT(11) NOT NULL,
    created DATETIME,
    modified DATETIME
);

CREATE TABLE groups (
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    created DATETIME,
    modified DATETIME
);

CREATE TABLE posts (
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    user_id INT(11) NOT NULL,
    title VARCHAR(255) NOT NULL,
    body TEXT,
    created DATETIME,
    modified DATETIME
);

CREATE TABLE widgets (
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    part_no VARCHAR(12),
    quantity INT(11)
);

After the schema is created, proceed to "bake" the application.

bin/cake bake all groups
bin/cake bake all users
bin/cake bake all posts
bin/cake bake all widgets

Add UsersController::login function

public function login() {
	if ($this->request->is('post')) {
		$user = $this->Auth->identify();
		if ($user) {
			$this->Auth->setUser($user);
			return $this->redirect($this->Auth->redirectUrl());
		}
		$this->Flash->error(__('Your username or password was incorrect.'));
	}
}

Add UsersController::logout function

public function logout() {
	$this->Flash->success(__('Good-Bye'));
	$this->redirect($this->Auth->logout());
}
Add src/Templates/Users/login.ctp

<?= $this->Form->create() ?>
<fieldset>
	<legend><?= __('Login') ?></legend>
	<?= $this->Form->input('username') ?>
	<?= $this->Form->input('password') ?>
	<?= $this->Form->submit(__('Login')) ?>
</fieldset>
<?= $this->Form->end() ?>

Modify UsersTable::beforeSave to hash the password before saving

use Cake\Auth\DefaultPasswordHasher;
...
public function beforeSave(\Cake\Event\Event $event, \Cake\ORM\Entity $entity, 
	\ArrayObject $options)
{
	$hasher = new DefaultPasswordHasher;
	$entity->password = $hasher->hash($entity->password);
	return true;
}

Include and configure the AuthComponent and the AclComponent in the AppController

public $components = [
	'Acl' => [
		'className' => 'Acl.Acl'
	]
];
...
$this->loadComponent('Auth', [
	'authorize' => [
		'Acl.Actions' => ['actionPath' => 'controllers/']
	],
	'loginAction' => [
		'plugin' => false,
		'controller' => 'Users',
		'action' => 'login'
	],
	'loginRedirect' => [
		'plugin' => false,
		'controller' => 'Posts',
		'action' => 'index'
	],
	'logoutRedirect' => [
		'plugin' => false,
		'controller' => 'Users',
		'action' => 'login'
	],
	'unauthorizedRedirect' => [
		'controller' => 'Users',
		'action' => 'login',
		'prefix' => false
	],
	'authError' => 'You are not authorized to access that location.',
	'flash' => [
		'element' => 'error'
	]
]);


Temporarily allow access to UsersController and GroupsController so groups and users can be added. Add the following implementation of beforeFilter to src/Controllers/UsersController.php and src/Controllers/GroupsController.php:

public function initialize()
{
	parent::initialize();
	
	$this->Auth->allow();
}


Initialize Db Acl tables :

Create the ACL related tables by running bin/cake Migrations.migrations migrate -p Acl

Model setup:
Acting as a requester

Add the requester behavior to GroupsTable and UsersTable
Add $this->addBehavior('Acl.Acl', ['type' => 'requester']); to the initialize function in the files src/Model/Table/UsersTable.php and src/Model/Table/GroupsTable.php

Implement parentNode function in Group entity

Add the following implementation of parentNode to the file src/Model/Entity/Group.php:

public function parentNode()
{
	return null;
}

Implement parentNode function in User entity

Add the following implementation of parentNode to the file src/Model/Entity/User.php:

public function parentNode()
{
	if (!$this->id) {
		return null;
	}
	if (isset($this->group_id)) {
		$groupId = $this->group_id;
	} else {
		$Users = TableRegistry::get('Users');
		$user = $Users->find('all', ['fields' => ['group_id']])->where(['id' => $this->id])->first();
		$groupId = $user->group_id;
	}
	if (!$groupId) {
		return null;
	}
	return ['Groups' => ['id' => $groupId]];
}

Creating ACOs

Run bin/cake acl_extras aco_sync to automatically create ACOs.
ACOs and AROs can be managed manually using the ACL shell. Run bin/cake acl for more information.

Creating Users and Groups

Create Groups

Navigate to /groups/add and add the groups
For this example, we will create Administrator, Manager, and User
Create Users

Navigate to /users/add and add the users
For this example, we will create one user in each group
test-administrator is an Administrator
test-manager is a Manager
test-user is a User

Remove Temporary Auth Overrides

Remove the temporary auth overrides by removing the beforeFilter function or the call to $this->Auth->allow(); in src/Controllers/UsersController.php and src/Controllers/GroupsController.php.

Configuring Permissions

Configuring permissions using the ACL shell

First, find the IDs of each group you want to grant permissions on. There are several ways of doing this. Since we will be at the console anyway, the quickest way is probably to run bin/cake acl view aro to view the ARO tree. In this example, we will assume the Administrator, Manager, and User groups have IDs 1, 2, and 3 respectively.

Grant members of the Administrator group permission to everything
Run bin/cake acl grant Groups.1 controllers

Grant members of the Manager group permission to all actions in Posts and Widgets
Run bin/cake acl deny Groups.2 controllers
Run bin/cake acl grant Groups.2 controllers/Posts
Run bin/cake acl grant Groups.2 controllers/Widgets

Grant members of the User group permission to view Posts and Widgets
Run bin/cake acl deny Groups.3 controllers
Run bin/cake acl grant Groups.3 controllers/Posts/index
Run bin/cake acl grant Groups.3 controllers/Posts/view
Run bin/cake acl grant Groups.3 controllers/Widgets/index
Run bin/cake acl grant Groups.3 controllers/Widgets/view

Allow all groups to logout
Run bin/cake acl grant Groups.2 controllers/Users/logout
Run bin/cake acl grant Groups.3 controllers/Users/logout





       
