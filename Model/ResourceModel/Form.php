<?php

namespace Atharva\FormGrid\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Form extends AbstractDb {

    public function __construct(
		\Magento\Framework\Model\ResourceModel\Db\Context $context
	)
	{
		parent::__construct($context);
	}

    protected function _construct() {
        $this->_init('atharva_storeformadmingrid', 'form_id');
    }

}