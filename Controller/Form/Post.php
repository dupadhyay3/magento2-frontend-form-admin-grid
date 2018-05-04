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
        \Magento\Framework\View\Result\PageFactory $pageFactory,
        \Atharva\FormGrid\Model\FormFactory $postFactory,
        \Magento\Framework\Filesystem $fileSystem,
        \Magento\MediaStorage\Model\File\UploaderFactory $fileUploaderFactory,
        CollectionFactory $moduleFactory)
	{
        $this->_pageFactory = $pageFactory;
        $this->_postFactory = $postFactory;
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
        echo "<pre>"; print_r($data); echo $mediaDirectory->getAbsolutePath('image/');print_r($_FILES['image']['name']);exit;
    }
}
