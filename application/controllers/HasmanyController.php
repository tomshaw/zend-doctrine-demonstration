<?php

class HasmanyController extends Zend_Controller_Action
{
    public function indexAction()
    {
        // Set the request once so we don't have to repeativly request it.
        $request = $this->getRequest();
        
        // Initializes the pagination page number.
        $page = (int) $this->_getParam('page');
        
        $query = Doctrine_Query::create()->from('Model_User u')->leftJoin('u.Comment c');
        
        // Initialise Zend Paginator with our adapter.	
        $paginator = new Zend_Paginator(new App_Doctrine_Adapter_Paginator($query));
        
        // Assigns the page number to the pagination object.
        $paginator->setCurrentPageNumber($page);
        
        // Sets a default items per page to the pagination object.
        $paginator->setItemCountPerPage(5);
        
        $this->view->total = count($query);
        
        // Assign the paginated results.
        $this->view->rows = $paginator;
    }
    
    public function addAction()
    {
        // Inits a new Zend Form user object.
        $form = new Form_Comment();
        
        // Sets the submit button label.
        $form->submit->setLabel('Save');
        
        // Sets the fieldset legend value.
        $form->getDecorator('fieldset')->setOption('legend', 'Add Comment');
        
        // Assigns the post action to controller hasone action add.
        $form->setAction('/hasmany/add');
        
        // Invokes and assigns all the commens data to tge add template.
        $this->initComments();
        
        // Initialise id var pre before our first control structure.
        $id = (int) $this->_getParam('id');
        
        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if ($form->isValid($formData)) {
                $user                     = Doctrine::getTable('Model_User')->findOneById($formData['id']);
                $user->Comment[]->comment = $formData['comment'];
                $user->save();
                $this->_helper->redirector->gotoUrl('/hasmany/add/id/' . $id);
            }
        } else {
            if ($id > 0) {
                // Finds the user data based on findOneBy<FieldValue>
                $query = Doctrine::getTable('Model_User')->findOneById($id);
                // Populates the form values.
                $form->populate($query->toArray());
                // Assign the name for posterity.
                $this->view->email = ($query->email) ? $query->email : '';
            }
        }
        
        $this->view->form = $form;
    }
    
    private function initComments()
    {
        // Set the request once so we don't have to repeativly request it.
        $request = $this->getRequest();
        
        // Initializes the pagination page number.
        $page = (int) $this->_getParam('page');
        
        // Initializes the pagination page number.
        $id = (int) $this->_getParam('id', 0);
        
        $query = Doctrine_Query::create()->from('Model_Comment c')->where('c.user_id = ?', $id);
        
        // Initialise Zend Paginator with our adapter.	
        $paginator = new Zend_Paginator(new App_Doctrine_Adapter_Paginator($query));
        
        // Assigns the page number to the pagination object.
        $paginator->setCurrentPageNumber($page);
        
        // Sets a default items per page to the pagination object.
        $paginator->setItemCountPerPage(5);
        
        $this->view->total = count($query);
        
        // Assign the paginated results.
        $this->view->rows = $paginator;
    }
    
    public function deleteAction()
    {
        $id = (int) $this->getRequest()->getParam('id');
        if ($id) {
            $query = Doctrine::getTable('Model_Comment')->findOneById($id);
            if (sizeof($query->toArray())) {
                $query->delete();
            }
        }
        $this->_redirect('/hasmany/add/id/' . $query->user_id);
    }
}