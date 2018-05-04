<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Atharva\FormGrid\Block\frontend;

/**
 * Product options text type block
 *
 * @api
 * @since 100.0.2
 */
class Form extends \Magento\Catalog\Block\Product\View\Options\AbstractOptions
{
    /**
     * Returns info of file
     *
     * @return string
     */
    public function getFileInfo()
    {
        /*$info = $this->getProduct()->getPreconfiguredValues()->getData('options/' . $this->getOption()->getId());*/
        $info = $this->getProduct()->getPreconfiguredValues()->getData($this->getOption()->getId());
        if (empty($info)) {
            $info = new \Magento\Framework\DataObject();
        } elseif (is_array($info)) {
            $info = new \Magento\Framework\DataObject($info);
        }
        return $info;
    }

}