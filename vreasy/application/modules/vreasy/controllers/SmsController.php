<?php

use Vreasy\Models\Task;
use Vreasy\Models\Sms;

class Vreasy_SmsController extends Vreasy_Rest_Controller
{
    protected $task;

    public function preDispatch()
    {
        parent::preDispatch();
        $req = $this->getRequest();
        $action = $req->getActionName();
        $this->getHelper('Layout')->disableLayout();
        $this->getHelper('ViewRenderer')->setNoRender();
        $contentType = $req->getHeader('Content-Type');
      
        
            switch ($action) {
                case 'index':
                case 'create':
                    //get the last task sent to the number we just received from
                    $this->task = Task::findByPhone($req->getParam('From'));
                    
                    break;
               
            }
            
        
        
        if( !in_array($action, [
                'index',
                'create',
              
            ])) {
            
            throw new Zend_Controller_Action_Exception('Resource not found', 404);
        }
        
    }

    public function indexAction()
    {
        $req = $this->getRequest();
       
        
        if($this->task->id){
            
            Sms::instanceWith([
                'created_at' => date('Y-m-d H:i:s'),
                'task_id' => $this->task->id,
                'sid' => $req->getParam('MessageSid'),
                'from' => $req->getParam('From'),
                'to' => $req->getParam('To'),
                'body' => $req->getParam('Body')              
                
            ])->save();
             
            
            //check if pending
            if($this->task->status == 'pending'){
            //check task is accepted or refused
               
                $this->task->status = Sms::guessStatus($req->getParam('Body'));
                 
            
                $this->task->save();
                
                $this->getResponse()->setHttpResponseCode(200);
                
            }
           
        }
        else{
           // throw new Zend_Controller_Action_Exception('Task not found', 404);
        }
    }

    public function newAction()
    {
    }

    public function createAction()
    {
       $this->indexAction();
    }

    public function showAction()
    {
    }

    public function updateAction()
    {
       
    }

    public function destroyAction()
    {
       
    }
}
