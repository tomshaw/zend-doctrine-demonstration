<?php

class Form_UserGroup extends App_Form
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
        
        $groupId = new Zend_Form_Element_Multiselect('group_id');
        $groupId->setLabel('Parent group:')
            ->setRequired(true)
            ->addErrorMessage('Selection required.')
            ->setDecorators($this->_elementDecorators);
        
        foreach (Doctrine_Query::create()->from('Model_Group g')->execute() as $row) {
            $groupId->addMultiOption($row->id, $row->name);
        }
        
        $groupId->setValue($this->findSelectValues());
        
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
        
        $this->addElements(array($id,$groupId,$hash,$submit));
    }
    
    private function findSelectValues()
    {
        $id       = (int) Zend_Controller_Front::getInstance()->getRequest()->getParam('id');
        $query    = Doctrine_Query::create()->from('Model_UserGroup ug')->where('ug.user_id = ?', $id);
        $rows     = $query->fetchArray();
        $selected = array();
        foreach ($rows as $row) {
            $selected[] = $row['group_id'];
        }
        return $selected;
    }
    
}