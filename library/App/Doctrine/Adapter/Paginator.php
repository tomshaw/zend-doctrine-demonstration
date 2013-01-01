<?php

class App_Doctrine_Adapter_Paginator implements Zend_Paginator_Adapter_Interface
{
    protected $_query;
    
    public function __construct(Doctrine_Query_Abstract $query)
    {
        $this->_query = $query;
    }
    
    public function getItems($offset, $limit)
    {
        if ($offset) {
            $this->_query->offset($offset);
        }
        if ($limit) {
            $this->_query->limit($limit);
        }
        return $this->_query->execute();
    }
    
    public function count()
    {
        return $this->_query->count();
    }
}