<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

/**************** required for csv download ************/
use Cake\View\View;
use Cake\View\ViewBuilder;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;



/**
 * Posts Controller
 *
 * @property \App\Model\Table\PostsTable $Posts
 */
class PostsController extends AppController
{

    public function beforeFilter(Event $event)
  {
    parent::beforeFilter($event);
    // Load the Type using the 'Elastic' provider.
    //$this->loadModel('Posts', 'Elastic');
  }


    public function initialize()
    {
        parent::initialize();
	    //$this->loadModel('Posts','Elastic');
        $this->loadComponent('RequestHandler');
    }

    public function export()
    {
        $data = [
            ['a', 'b', 'c'],
            [1, 2, 3],
            ['you', 'and', 'me'],
        ];
        $_serialize = 'data';
        $this->response->download('my_file.csv');
        $this->viewBuilder()->className('CsvView.Csv');
        $this->set(compact('data', '_serialize'));
    }

    public function exportCsv()
    {
        $posts = $this->Posts->find('all');
        $_serialize = 'posts';
        $this->response->download('my_file.csv');
        $this->viewBuilder()->className('CsvView.Csv');
        $this->set(compact('posts', '_serialize'));
    }

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

}
