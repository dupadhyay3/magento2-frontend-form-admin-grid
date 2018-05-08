<?php

namespace Atharva\FormGrid\Controller\Form;

use Atharva\FormGrid\Model\ResourceModel\Form\CollectionFactory;

class Post extends \Magento\Framework\App\Action\Action
{
    protected $_pageFactory;
    protected $request;
    protected $_moduleFactory;
    protected $_filesystem;
    protected $_fileUploaderFactory;

	public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\Filesystem $fileSystem,
        \Magento\MediaStorage\Model\File\UploaderFactory $fileUploaderFactory,
        CollectionFactory $moduleFactory)
	{
        $this->_moduleFactory = $moduleFactory;
        $this->_filesystem = $fileSystem;
        $this->_fileUploaderFactory = $fileUploaderFactory;
		parent::__construct($context);
    }
    
    /**
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $resultRedirect->setUrl($this->_redirect->getRefererUrl());

        $post = $this->getRequest()->getPostValue();
        if (!$post) {
            $this->messageManager->addError( __('‘We can\’t process your request right now. Sorry, that\’s all we know.’') );
            return $resultRedirect;
        }

        $model = $this->_moduleFactory->create();
        $data = $this->getRequest()->getPost();
        $result = array();
        if ($_FILES['image']['name']) {
            try {
                // init uploader model.
                $uploader = $this->_fileUploaderFactory->create(['fileId' => 'image']);
                $uploader->setAllowedExtensions(['jpg', 'jpeg', 'gif', 'png']);
                $uploader->setAllowRenameFiles(true);
                $uploader->setFilesDispersion(true);
                // get media directory
                $mediaDirectory = $this->_filesystem->getDirectoryRead(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA);
                // save the image to media directory
                $result = $uploader->save($mediaDirectory->getAbsolutePath('image/'));

            } catch (Exception $e) {
                \Zend_Debug::dump($e->getMessage());
            }
        }
        $data['image']=$result['file'];
        // echo "<pre>"; print_r($data); print_r($_FILES['image']['name']);
        // exit;
        $obj = $this->_objectManager->create("Atharva\FormGrid\Model\Form");
        $obj->setData('name',$data['firstname']);
        $obj->setData('email',$data['email']);
        $obj->setData('mobile',$data['telephone']);
        $obj->setData('image',$data['image']);
        /*$model->addData([
			"name" => $data['firstname'],
			"email" => $data['email'],
			"mobile" => $data['telephone'],
			"image" => $data['image']
            ]);*/
        $resultSave = $obj->save();
        if($resultSave){
            $this->messageManager->addSuccess( __('Insert Record Successfully !') );
            return $resultRedirect;
        }else{
            $this->messageManager->addError( __('‘We can\’t process your request right now. Sorry, that\’s all we know.’') );
            return $resultRedirect;
        }
    }
}
