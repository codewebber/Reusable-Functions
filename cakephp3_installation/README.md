# Cakephp3 installation : 

CakePHP is an open source PHP 5.5+ framework, helps to building both small and complex systems. 
It follows the Model-View-Controller (MVC) approach. 

# prerequisite : 

```php
HTTP Server.
PHP 5.6.0 or greater (including PHP 7.1).
Mbstring PHP extension
intl PHP extension
```
##Mbstring PHP extension : 
Mbstring is an extension of php used to manage non-ASCII strings,
Mbstring extension needs to be installed on the server
when configuring a website to work with different languages on a 
Linux server for website functionality. 
The mbstring extension in PHP uses to parse different language encoding’s.

## Mbstring installation steps

```php
   sudo apt-get install php5.6-mbstring
```

Then add the following line to the bottom of your php.ini file:

```php
   extension=php5.6-mbstring.so
   sudo service apache2 restart

   <?php phpinfo(); ?>
```

## intl PHP extension :
this extension used for internationlization.
if we install automatically (numberformatter,locale folder for po files,date formatter)

## intl installation steps
sudo apt-get install php5-intl

## support db drivers :

MySQL (5.1.10 or greater)
PostgreSQL
Microsoft SQL Server (2008 or higher)
SQLite 3

## How to install cakephp3 :

1. check php version  command is  -  “php -v” 

2. download composer follow below steps :

```php

php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('SHA384', 'composer-setup.php') === '669656bab3166a7aff8a7506b8cb2d1c292f042046c5a994c43155c0be6190fa0355160742ab2e1c88d40d5be660b410') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php composer-setup.php
php -r "unlink('composer-setup.php');"

```

reference link : https://getcomposer.org/download/


cakephp downloads : https://github.com/cakephp/cakephp/tags

you can download latest version of cakephp check in above link release notes&zip folder will be available.

Extract in your root folder and rename (your project name) 

## configuration

We need to configure database   in  config/app.php
by default debug ->true  if  dont want to show errors u can disable it use fasle value.

## commands for cake bake :

We can bake models,controllers,views 

go upto project folder in command prompt  and type below command 

```php

bin/cake bake
ex : /var/www/html/projectName$ bin/cake bake

it will show  list  what we can bake :
Available bake commands:
- all
- behavior
- cell
- component
- controller
- fixture
- form
- helper
- mailer
- migration
- migration_diff
- migration_snapshot
- model
- plugin
- seed
- shell
- shell_helper
- task
- template
- test

what we want to bake we can bake using 
ex: bin/cake bake model (before baking model database should have tables  all table names shoud be plural and primary key  id) it will display table names as below

/*****************************************************/
 Welcome to CakePHP v3.4.5 Console
---------------------------------------------------------------
App : src
Path: /var/www/html/projectName/src/
PHP : 5.6.21-1+donate.sury.org~precise+4
---------------------------------------------------------------
Choose a model to bake from the following:
- Posts
- Users
/****************************************************/

from that we can  select particular table.

/var/www/html/projectName/src/Model/Table/PostsTable.php
/var/www/html/projectName/src/Model/Entity/Post.php
/var/www/html/projectName/tests/Fixture/PostsFixture.php

```

what entity will do extactly : 

```php
cakephp2 : 

$user = $this->User->find('first');
echo $user['User']['name'];

You can do run-time modification of result sets using entity.

Cakephp3:
$user = $this->Users->find('first');
echo $user->name;

```

Cake TestFixture is responsible for building and destroying tables to be used during testing.

Same way we can bake controllers and views also.

## Rest API Json result :
```php
 routes.php :
	Router::extensions('json');

controller :

 	$this->set('_serialize', ['posts']);
 
 url : http://localhost/projectName/posts/index.json

```
## How to create components :
controllers/components

example :  creating global component &how to call model inside component  in below code 

```php
  <?php

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\ORM\TableRegistry;

class GlobalComponent extends Component {

	public function changeStatus($modelName = null, $id = null, $status = null)
	{
		$this->ModelName = TableRegistry::get($modelName);
		$data = $this->ModelName->get($id);
		
		$data->status = $status;
		if ($this->ModelName->save($data)) {
			return true;
		} else {
			return false;
		}
	}
	
}

?>

how to call component  in controller

 $this->loadComponent('Global');
 $this->Global->changeStatus('tableName',$id,$status);

```

## How to create  plugins in cakephp3 

```php
bin/cake bake plugin pluginName

bin/cake bake controller --plugin pluginname tablename

Plugin::load('pluginname', ['autoload' => true, 'bootstrap' => false, 'routes' => true]);

url : http://localhost/projectname/pluginname/controller(tablename)/index 

```


