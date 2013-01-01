<?php

class HasoneController extends Zend_Controller_Action
{
    public function indexAction()
    {
        // Set the request once so we don't have to repetitively request it.
        $request = $this->getRequest();
        
        // Initializes the pagination page number.
        $page = (int) $this->_getParam('page');
        
        // Select data using DQL.
        $query = Doctrine_Query::create()->from('Model_User u')->leftJoin('u.Contact c');
        
        // Initialise Zend Paginator with our adapter.    
        $paginator = new Zend_Paginator(new App_Doctrine_Adapter_Paginator($query));
        
        // Assigns the page number to the pagination object.
        $paginator->setCurrentPageNumber($page);
        
        // Sets a default items per page to the pagination object.
        $paginator->setItemCountPerPage(5);
        
        // Assign the total number of row for total count.
        $this->view->total = count($query);
        
        // Assign the paginated results.
        $this->view->rows = $paginator;
    }
    
    public function addAction()
    {
        // Inits a new Zend Form user object.
        $form = new Form_User();
        
        // Sets the submit button label.
        $form->submit->setLabel('Save');
        
        // Sets the fieldset legend value.
        $form->getDecorator('fieldset')->setOption('legend', 'Create New User');
        
        // Removes the id element since we are creating a new row.
        $form->removeElement('id');
        
        // Assigns the post action to controller hasone action add.
        $form->setAction('/hasone/add');
        
        // Assigns the form to the view layer.
        $this->view->form = $form;
        
        $errors = array();
        
        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if ($form->isValid($formData)) {
                // Initialise Doctrine's User Record Object.
                $user = new Model_User();
                
                // Saving user information to user table.
                
                $email = (string) $formData['email'];
                
                $password = (string) $formData['password'];
                
                if (!Zend_Validate::is(trim($password), 'NotEmpty')) {
                    $errors[] = 'You must choose a password.';
                }
                
                if (!Zend_Validate::is($email, 'EmailAddress')) {
                    $errors[] = 'The email address entered could not be validated.';
                }
                
                if (!Zend_Validate::is($password, 'StringLength', array('min' => 6))) {
                    $errors[] = 'Password must be atleast 6 characters or greater.';
                }
                
                if (sizeof($errors)) {
                    return $form->populate($formData);
                }
                
                $user->email    = $email;
                $user->password = md5($password);
                
                // Saving contact data to contact table.
                $user->Contact->first_name = $formData['first_name'];
                $user->Contact->last_name  = $formData['last_name'];
                $user->Contact->phone      = $formData['phone'];
                $user->Contact->address    = $formData['address'];
                
                // Adding user to table group id member.
                $user->UserGroups[0]->group_id = 2;
                
                // Save compiled data to all three tables!
                $user->save();
                
                $this->_helper->redirector('index');
            } else {
                $form->populate($formData);
            }
        }
    }
    
    public function editAction()
    {
        // Inits a new Zend Form user object.
        $form = new Form_User();
        
        // Sets the submit button label.
        $form->submit->setLabel('Save');
        
        // Sets the fieldset legend value.
        $form->getDecorator('fieldset')->setOption('legend', 'Edit User');
        
        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if ($form->isValid($formData)) {
                // Doctrine's Record Object updates the updated_at field. 
                $user = Doctrine::getTable('Model_User')->find($form->getValue('id'));
                
                // Update the email.
                $user->email = $form->getValue('email');
                
                // If there's a change in the password change it or use the presently loaded.
                $user->password = $form->getValue('password') ? md5($form->getValue('password')) : $user->password;
                
                // Update simple contact information.
                $user->Contact->first_name = $form->getValue('first_name');
                $user->Contact->last_name  = $form->getValue('last_name');
                $user->Contact->phone      = $form->getValue('phone');
                $user->Contact->address    = $form->getValue('address');
                
                // Let Doctrine do the rest!
                $user->save();
                
                // All procedures are done redirect.
                $this->_helper->redirector('index');
            } else {
                // Re-populates form values.
                $form->populate($formData);
            }
        } else {
            $id = (int) $this->_getParam('id', 0);
            if ($id > 0) {
                // Finds the user data based on findOneBy<FieldValue>
                $user = Doctrine::getTable('Model_User')->findOneById($id);
                
                // Populates the form values.
                $form->populate($user->Contact->toArray());
            }
        }
        
        $this->view->form = $form;
    }
    
    public function deleteAction()
    {
        $id = (int) $this->getRequest()->getParam('id');
        if ($id) {
            $user = Doctrine::getTable('Model_User')->findOneById($id);
            if (sizeof($user->toArray())) {
                $user->delete();
            }
        }
        $this->_helper->redirector('index');
    }
    
}