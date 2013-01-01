<?php

class Form_User extends App_Form
{
    public function init()
    {
        $this->setElementFilters(array(
            'StringTrim',
            'StripTags'
        ));
        
        $this->setName('edit_form')->setMethod('post');
        
        $id = new Zend_Form_Element_Hidden('id');
        $id->addFilter('Int')->setDecorators(array(
            array(
                'ViewHelper',
                array(
                    'helper' => 'formHidden'
                )
            )
        ));
        
        $email = new Zend_Form_Element_Text('email');
        $email->setLabel('Email address:')
            ->setRequired(true)
            ->addFilter('StripTags')
            ->addFilter('StringTrim')
            ->addValidator('NotEmpty')
            ->setDecorators($this->_elementDecorators);
        
        $password = new Zend_Form_Element_Password('password');
        $password->setLabel('Password:')
            ->setRequired(false)
            ->addErrorMessage('Please enter a password.')
            ->addFilter('StripTags')
            ->addFilter('StringTrim')
            ->setDecorators($this->_elementDecorators);
        
        $firstName = new Zend_Form_Element_Text('first_name');
        $firstName->setLabel('First name:')
            ->setRequired(true)
            ->addErrorMessage('Please enter a your first name.')
            ->addFilter('StripTags')
            ->addFilter('StringTrim')
            ->addValidator('NotEmpty')
            ->setDecorators($this->_elementDecorators);
        
        $lastName = new Zend_Form_Element_Text('last_name');
        $lastName->setLabel('Last name:')
            ->setRequired(true)
            ->addErrorMessage('Please enter your last name.')
            ->addFilter('StripTags')
            ->addFilter('StringTrim')
            ->addValidator('NotEmpty')
            ->setDecorators($this->_elementDecorators);
        
        $phone = new Zend_Form_Element_Text('phone');
        $phone->setLabel('Phone:')
            ->setRequired(true)
            ->addErrorMessage('Please enter a telephone number.')
            ->addFilter('StripTags')
            ->addFilter('StringTrim')
            ->addValidator('NotEmpty')
            ->setDecorators($this->_elementDecorators);
        
        $address = new Zend_Form_Element_Text('address');
        $address->setLabel('Home address:')
            ->setRequired(true)
            ->addErrorMessage('Please enter your address.')
            ->addFilter('StripTags')
            ->addFilter('StringTrim')
            ->addValidator('NotEmpty')
            ->setDecorators($this->_elementDecorators);
        
        $hash = new Zend_Form_Element_Hash('hash', 'foo_bar_baz', array(
            'salt' => 'unique'
        ));
        
        $hash->setDecorators(array(
            array(
                'ViewHelper',
                array(
                    'helper' => 'formHidden'
                )
            )
        ));
        
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setAttrib('id', 'submitbutton')->setDecorators($this->_buttonDecorators);
        
        $this->addElements(array($id,$email,$password,$firstName,$lastName,$phone,$address,$hash,$submit));
    }
    
}