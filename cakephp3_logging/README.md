# Cakephp3 Logging

setup datasources :

```php
	in config/app.php
default sources will be 

	'Log' => [
    'debug' => [
        'className' => 'Cake\Log\Engine\FileLog',
        'path' => LOGS,
        'file' => 'debug',
        'levels' => ['notice', 'info', 'debug'],
        'scopes' => true,
        'url' => env('LOG_DEBUG_URL', null),
    ],
    'error' => [
        'className' => 'Cake\Log\Engine\FileLog',
        'path' => LOGS,
        'file' => 'error',
        'levels' => ['warning', 'error', 'critical', 'alert', 'emergency'],
        'scopes' => true,
        'url' => env('LOG_ERROR_URL', null),
    ],
],

```

Above configuration  we mentioned two loggers debug,error these will handle different types of levels.

## List of levels :
```php
   Emergency: system is unusable
   Alert: action must be taken immediately
   Critical: critical conditions
   Error: error conditions
   Warning: warning conditions
   Notice: normal but significant condition
   Info: informational messages
   Debug: debug-level messages

```

If we want to customize log file.setup new file like below in config/app.php

```php

   'Log' => [
    'debug' => [
        'className' => 'Cake\Log\Engine\FileLog',
        'path' => LOGS,
        'file' => 'debug',
        'levels' => ['notice', 'info', 'debug'],
        'scopes' => true,
        'url' => env('LOG_DEBUG_URL', null),
    ],
    'error' => [
        'className' => 'Cake\Log\Engine\FileLog',
        'path' => LOGS,
        'file' => 'error',
        'levels' => ['warning', 'error', 'critical', 'alert', 'emergency'],
        'scopes' => true,
        'url' => env('LOG_ERROR_URL', null),
    ],
    'posts' => [
        'className' => 'File',
        'path' => LOGS,
        'file' => 'error',
        'levels' => [],
        'scopes' => ['posts'],
        'file' => 'posts.log',
    ]
],
```
'levels' => [], it will accept all levels.

Particular controller :
Wherever we want we can write our own message

```php

Log::Emergency('post added successfully', ['scope' => ['posts']]);
syntax : level('message',scope)
level - can pick any level from above 7 types
message - required message
scope- whatever we configured in config/app.php (ex:'scopes' => ['posts'])

```

we can check one file created in src/logs/posts.log in that whatever message we write with date display.

## cakephp3 logging with plugin implementation

install via composer
```php
   php composer.phar require daoandco/cakephp-logging
```

config/bootstrap.php

```php
   Plugin::load('Logging', ['bootstrap' => true, 'routes' => false]);
```
if want to create logs database level
```php
CREATE TABLE `logs` (
    `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    `created` DATETIME NOT NULL,
    `level` VARCHAR(50) NOT NULL,
    `scope` VARCHAR(50) NULL DEFAULT NULL,
    `user_id` INT(10) UNSIGNED NULL DEFAULT NULL,
    `message` TEXT NULL,
    `context` TEXT NULL,
    PRIMARY KEY (`id`),
    INDEX `user_id` (`user_id`),
    INDEX `scope` (`scope`),
    INDEX `level` (`level`)
)
COLLATE='utf8_general_ci'
;
```
```php 
in config/app.php

'Log' => [
    'debug' => [
        'className' => 'Cake\Log\Engine\FileLog',
        'path' => LOGS,
        'file' => 'debug',
        'levels' => ['notice', 'info', 'debug'],
        'scopes' => false,
        'url' => env('LOG_DEBUG_URL', null),
    ],
    'error' => [
        'className' => 'Cake\Log\Engine\FileLog',
        'path' => LOGS,
        'file' => 'error',
        'levels' => ['warning', 'error', 'critical', 'alert', 'emergency'],
        'scopes' => false,
        'url' => env('LOG_ERROR_URL', null),
    ],
    'app' => [
        'className'     => 'Logging.Database',
        'requiredScope' => true,
    ],
],

```

in particular controller :

```php
	$this->loadComponent('Logging.Log');
	keep below line where want create log message
	$this->Log->write('debug', 'customized scope(scope is optional)', 'Something did not work');
```
it will create log record in database and scope log file also if we mention scope.

examples :

```php
	$this->Log->emergency('scope', 'message');
	$this->Log->alert('scope', 'message');
	$this->Log->critical('scope', 'message');
	$this->Log->error('scope', 'message');
	$this->Log->warning('scope', 'message');
	$this->Log->notice('scope', 'message');
	$this->Log->debug('scope', 'message');
	$this->Log->info('scope', 'message');

```

