<?php

namespace Atharva\FormGrid\Controller\Adminhtml\Post;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Backend\App\Action;

class Delete extends Action
{
    protected $_model;
    
    /**
     * @param Action\Context $context
     * @param \Atharva\FormGrid\Model\Form $model
     */
    public function __construct(
        Action\Context $context,
        \Atharva\FormGrid\Model\Form $model
    ) {
        parent::__construct($context);
        $this->_model = $model;
    }

    /**
     * @return \Magento\Framework\Controller\Result\Redirect
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $formId = $this->getRequest()->getParam('form_id');
        if ($formId) {
            try {
                $model = $this->_model;
                $model->load($formId);
                $model->delete();
                $this->messageManager->addSuccessMessage(__('Form Details has been deleted.'));
                $resultRedirect->setPath('adminformgrid/post/index');
                return $resultRedirect;
            } catch (NoSuchEntityException $e) {
                $this->messageManager->addErrorMessage(__('Details no longer exists.'));
                return $resultRedirect->setPath('adminformgrid/post/index');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                return $resultRedirect->setPath('adminformgrid/post/index', ['form_id' => $formId]);
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(__('There was a problem deleting the details'));
                return $resultRedirect->setPath('adminformgrid/post/index', ['form_id' => $formId]);
            }
        }
        $this->messageManager->addErrorMessage(__('We can\'t find details to delete.'));
        return $resultRedirect->setPath('adminformgrid/post/index');
    }
}
