<?php


use Vreasy\Models\TaskHistory;

class Vreasy_TaskHistoryController extends Vreasy_Rest_Controller
{
    protected $taskHistories;

    public function preDispatch()
    {
        parent::preDispatch();
        $req = $this->getRequest();
        $action = $req->getActionName();
        $contentType = $req->getHeader('Content-Type');
        $rawBody     = $req->getRawBody();
      
        if ($rawBody) {
           
            if (stristr($contentType, 'application/json')) {
                $req->setParams(['task' => Zend_Json::decode($rawBody)]);
            }
        }
        if($req->getParam('format') == 'json') {
            
            switch ($action) {
                case 'show':
                    
                    $this->taskHistories = TaskHistory::where(['task_id' => $req->getParams('id')]);
                   
                    break;
                
            }
        }
        
        
        if( !in_array($action, [
                'index',
                'new',
                'create',
                'update',
                'destroy'
            ]) && !$this->taskHistories ) {
            
            throw new Zend_Controller_Action_Exception('Resource not found', 404);
        }
        
    }

    public function indexAction()
    {
        }

    public function newAction()
    {
    }

    public function createAction()
    {
    }

    public function showAction()
    {
         $this->view->taskHistories = $this->taskHistories;
        $this->_helper->conditionalGet()->sendFreshWhen(['etag' => $this->taskHistories]);
   
    }

    public function updateAction()
    {
       
    }

    public function destroyAction()
    {
        
    }
    
}
