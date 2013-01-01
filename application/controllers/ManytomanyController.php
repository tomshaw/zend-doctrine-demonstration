<?php

class ManytomanyController extends Zend_Controller_Action
{
    public function indexAction()
    {
        // Set the request once so we don't have to repeativly request it.
        $request = $this->getRequest();
        
        // Initializes the pagination page number.
        $page = (int) $this->_getParam('page');
        
        // Query the database and join Groups and Group/User Relationships.
        $query = Doctrine_Query::create()
            ->from('Model_User u')
            ->leftJoin('u.Group g')
            ->leftJoin('g.UserGroups ug');
        
        // Initialise Zend Paginator with our adapter.	
        $paginator = new Zend_Paginator(new App_Doctrine_Adapter_Paginator($query));
        
        // Assigns the page number to the pagination object.
        $paginator->setCurrentPageNumber($page);
        
        // Sets a default items per page to the pagination object.
        $paginator->setItemCountPerPage(5);
        
        // Assigns the total row count.
        $this->view->total = count($query);
        
        // Assign the paginated results.
        $this->view->rows = $paginator;
    }
    
    public function editAction()
    {
        // Inits a new Zend Form user object.
        $form = new Form_UserGroup();
        
        // Sets the submit button label.
        $form->submit->setLabel('Assign Selected');
        
        // Sets the fieldset legend value.
        $form->getDecorator('fieldset')->setOption('legend', 'Assign Groups');
        
        $this->view->form = $form;
        
        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if ($form->isValid($formData)) {
                $id = (int) $form->getValue('id');
                if (is_array($formData['group_id'])) {
                    $user = Doctrine::getTable('Model_User')->find($id);
                    $user->UserGroups->delete();
                    foreach ($formData['group_id'] as $key => $val) {
                        $user->UserGroups[]->group_id = $val;
                    }
                    $user->save();
                }
                $this->_helper->redirector('index');
            } else {
                $form->populate($formData);
            }
        } else {
            $id = (int) $this->_getParam('id', 0);
            if ($id > 0) {
                $form->populate(array(
                    'id' => $id
                ));
            } else {
                $this->_helper->redirector('index');
            }
        }
    }
}