<?php

namespace Atharva\FormGrid\Model\ResourceModel\Form;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection {

    protected $_idFieldName = 'form_id';

    protected function _construct()
    {
        $this->_init('Atharva\FormGrid\Model\Form', 'Atharva\FormGrid\Model\ResourceModel\Form');
    }
}