<?php

class Form_Comment extends App_Form
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
        
        $comment = new Zend_Form_Element_Textarea('comment');
        $comment->setLabel('Comment:')
            ->setRequired(true)
            ->setAttrib('COLS', '30')
            ->setAttrib('ROWS', '5')
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
        
        $this->addElements(array(
            $id,
            $comment,
            $hash,
            $submit
        ));
    }
    
}