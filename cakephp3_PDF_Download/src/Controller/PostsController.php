<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
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
  }


    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('RequestHandler');
    }

    /**
     * View method
     *
     * @param string|null $id Post id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $post = $this->Posts->get($id, [
            'contain' => []
        ]);
          $this->viewBuilder()->options([
                'pdfConfig' => [
                    'orientation' => 'portrait',
                    'filename' => 'Posts_' . $id
                ]
            ]);
        $this->set('post', $post);
        //$this->set('_serialize', ['post']);
    }

    public function examplePdf()
    {
       $this->autoRender = false;
       $posts = $this->Posts->find('all')->toArray();
       $this->set(compact('posts'));
       $targetPath = $_SERVER['DOCUMENT_ROOT'] . $this->request->webroot.'webroot/uploads/';
       $this->set(compact('targetPath'));

       $CakePdf = new \CakePdf\Pdf\CakePdf();
       $string = strtotime(date('Y-m-d H:i:s'));
       $CakePdf->template('samplepost', 'default');
       $CakePdf->viewVars($this->viewVars);
       //Get the PDF string returned
       $pdf = $CakePdf->output();
       // Or write it to file directly
       $pdf = $CakePdf->write($targetPath. 'newsletter_'.$string.'.pdf');
    }
}
