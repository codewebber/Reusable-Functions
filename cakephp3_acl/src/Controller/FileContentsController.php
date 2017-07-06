<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

/**
 * FileContents Controller
 *
 * @property \App\Model\Table\FileContentsTable $FileContents
 */
class FileContentsController extends AppController
{

	public function initialize() {
		parent::initialize();
		$this->loadComponent('File'); // for uploading documents
		$this->loadComponent('Audio');
		$this->loadComponent('Video');
		$this->loadComponent('Global');
	}
	
    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
    	echo $this->Global->changeStatus();exit;
        $fileContents = $this->paginate($this->FileContents);

        $this->set(compact('fileContents'));
        $this->set('_serialize', ['fileContents']);
    }

    /**
     * View method
     *
     * @param string|null $id File Content id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $fileContent = $this->FileContents->get($id, [
            'contain' => []
        ]);

        $this->set('fileContent', $fileContent);
        $this->set('_serialize', ['fileContent']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $fileContent = $this->FileContents->newEntity();
        if ($this->request->is('post')) {
        	if(!empty($this->request->data['filename']))
        	{
        		$type_arr = explode('/',$this->request->data['filename']['type']);
        		$filename     = $this->request->data['filename']['name'];
        		$append = explode('.',$filename);
        		$filename_time = strtotime(date('Y-m-d H:i:s')).'$'.trim(str_replace(" ","",$append[0])).'.'.$append[1];
        		$wroot = WWW_ROOT.'uploads';
        		$uploadfile = $wroot.DS;
        		$upload        = $this->Video->upload($this->request->data['filename']['tmp_name'], $uploadfile,$filename_time,$type_arr[0]);
        		if ($upload == 'Success') {
        			$this->request->data['attachment'] = $filename_time;
        			echo "File uploaded successfully";exit;
        		}
        		else
        		{
        			echo $upload;exit;
        		}
        	}
        	else
        	{
        		echo "not";exit;
        	}
        	
        	
            $fileContent = $this->FileContents->patchEntity($fileContent, $this->request->data);
            if ($this->FileContents->save($fileContent)) {
                $this->Flash->success(__('The file content has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The file content could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('fileContent'));
        $this->set('_serialize', ['fileContent']);
    }

    /**
     * Edit method
     *
     * @param string|null $id File Content id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $fileContent = $this->FileContents->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $fileContent = $this->FileContents->patchEntity($fileContent, $this->request->data);
            if ($this->FileContents->save($fileContent)) {
                $this->Flash->success(__('The file content has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The file content could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('fileContent'));
        $this->set('_serialize', ['fileContent']);
    }

    /**
     * Delete method
     *
     * @param string|null $id File Content id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $fileContent = $this->FileContents->get($id);
        if ($this->FileContents->delete($fileContent)) {
            $this->Flash->success(__('The file content has been deleted.'));
        } else {
            $this->Flash->error(__('The file content could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
