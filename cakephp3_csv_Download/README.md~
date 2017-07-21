# Cakephp3 Csv files Plugin implemetation : 

```php
step1 : check composer.phar is running or not in your project folder using below command
        command : php composer.phar
        if it is working then below lines of code it will dispaly similar to below lines:
	   ______
	  / ____/___  ____ ___  ____  ____  ________  _____
	 / /   / __ \/ __ `__ \/ __ \/ __ \/ ___/ _ \/ ___/
	/ /___/ /_/ / / / / / / /_/ / /_/ (__  )  __/ /
	\____/\____/_/ /_/ /_/ .___/\____/____/\___/_/
		            /_/
	Composer version 1.1.1 2016-05-17 12:25:44

step1.1 : if composer is not installed in your project folder then need to follow below steps
       commands : curl -sS https://getcomposer.org/installer | php
		  php composer.phar install

step2 : if composer installed properly then we are ready for install csvview plugin using composer
        commnad : php composer.phar require friendsofcake/cakephp-csvview:~3.0

step3 : after installation of acl plugin Include the ACL plugin in app/config/bootstrap.php
```
## note : loading CsvView plugin is complusory for implementation of csv
```php
Plugin::load('CsvView');
```

## Implementation

## Usage process1 - csv+static data

```php
public function export()
{
    $data = [
        ['1', '2', '3'],
        ['sample1', 'sample2','sample3'],
        ['sample11', 'sample12', 'sample13'],
    ];
    $_serialize = 'data';

    $this->viewBuilder()->className('CsvView.Csv');
    $this->set(compact('data', '_serialize'));
}
```
$_serialize view variable.it will convert raw data into csv format data while downloading file. In above case file will download without extension(ex:export) whatever function it will take that name.

## Usage process2 - csv+static+header footer data
```php
public function export()
{
     $data = [
        ['1', '2', '3'],
        ['sample1', 'sample2','sample3'],
        ['sample11', 'sample12', 'sample13'],
    ];

    $_serialize = 'data';
    $_header = ['Column 1', 'Column 2', 'Column 3'];
    $_footer = ['Totals', '400', '$3000'];

    $this->viewBuilder()->className('CsvView.Csv');
    $this->set(compact('data', '_serialize', '_header', '_footer'));
}
``` 

## Usage process3 - csv+dynamic data(model data)
```php
public function exportCsv()
    {
        $posts = $this->Posts->find('all');
        $_serialize = 'posts';
        $this->viewBuilder()->className('CsvView.Csv');
        $this->set(compact('posts', '_serialize'));
    }
```

if we use static content no need to create ctp file but when we use model content inside our function we need to create ctp file for that.
other wise it will display error - ctp file missing.

```php
 View used will be in src/Template/Posts/csv/exportCsv.ctp (we have to create csv folder inside required template folder)
```

## Usage process4 - csv+model data + file name
```php
public function exportCsv()
    {
        $posts = $this->Posts->find('all');
        $_serialize = 'posts';
        $this->response->download('my_file.csv');
        $this->viewBuilder()->className('CsvView.Csv');
        $this->set(compact('posts', '_serialize'));
    }
```
we can modify required file name.

## Usage process5 - csv +model data + file name

```php
public function exportCsvHeader()
    {
        $posts = $this->Posts->find('all');
        $this->set(compact('posts'));
        $_serialize = 'posts';
        $_header = array('Post ID', 'Title', 'Decription');
        $_extract = array('id', 'title', 'description');

        $this->response->download('my_file.csv');
        $this->viewBuilder()->className('CsvView.Csv');
        $this->set(compact('_serialize', '_header', '_extract'));
    }
```
$_extract :extracting columns from model table (if we want specified columns then whatever present in table same name we have to specify)

## Usage process6 - csv+model data + file name +specified location

```php
use Cake\View\View;
use Cake\View\ViewBuilder;
## with out below 2 lines error will display (class file is missing)
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;

public function exportCsvBuilder()
    {
        $posts = $this->Posts->find('all')->toArray();
        $this->set(compact('posts'));
        $_serialize = 'posts';
        $_delimiter = ',';
        $_enclosure = '"';
        $_newline = '\r\n';

        $builder = new ViewBuilder;
        $builder->layout = false;
        $builder->setClassName('CsvView.Csv');

        $view = $builder->build($posts);
        $view->set(compact('posts', '_serialize', '_delimiter', '_enclosure', '_newline'));
        $targetPath = $_SERVER['DOCUMENT_ROOT'] . $this->request->webroot.'webroot/uploads/sample_csv.csv';

        $file = new File($targetPath, true, 0644);
        $file->write($view->render());
   
    }
```
result set we need to convert into (object to string) using toArray. and we need to create ctp file not in csv folder under main template folder only we need to create.

ex: template/posts/csv/export_csv_builder instead of this template/posts/export_csv_builder







