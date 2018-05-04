<?php 

namespace Atharva\FormGrid\Model;

use Magento\Framework\Model\AbstractModel;

class Form extends AbstractModel
{
    protected function _construct() {
        $this->_init('Atharva\FormGrid\Model\ResourceModel\Form');
    }     
}