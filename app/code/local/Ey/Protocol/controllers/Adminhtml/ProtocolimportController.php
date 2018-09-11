<?php


class Ey_Protocol_Adminhtml_ProtocolimportController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $block = $this->getLayout()
            ->createBlock('ey_protocol/adminhtml_import');

        $this->loadLayout()
            ->_addContent($block)
            ->renderLayout();
    }

    public function postAction()
    {
        if(isset($_FILES['protocol_csv']['name']) && $_FILES['protocol_csv']['name'] != '') {
            try {
                $uploader = new Varien_File_Uploader(
                    array(
                        'name' => $_FILES['protocol_csv']['name'],
                        'type' => $_FILES['protocol_csv']['type'],
                        'tmp_name' => $_FILES['protocol_csv']['tmp_name'],
                        'error' => $_FILES['protocol_csv']['error'],
                        'size' => $_FILES['protocol_csv']['size']
                    )
                );

                $uploader->setAllowedExtensions(array('csv'));
                $uploader->setAllowRenameFiles(false);
                $uploader->setFilesDispersion(false);

                // Set media as the upload dir
                $media_path  = Mage::getBaseDir('media') . DS . 'protocol_csv' . DS;

                // Upload the image
                $uploadResult = $uploader->save($media_path, $_FILES['protocol_csv']['name']);

                $fileData = Mage::helper('ey_protocol')->getCsvData($media_path.$uploadResult['file']);
                if(is_array($fileData) && count($fileData) > 0){
                    $this->_processData($fileData);
                    $this->_getSession()->addSuccess(
                        $this->__('Import Successfully.')
                    );
                } else{
                    $this->_getSession()->addSuccess(
                        $this->__('No data has been found.')
                    );
                }
            } catch (Exception $e) {
                Mage::logException($e);
                $this->_getSession()->addError($e->getMessage());
            }
        }
    }

    protected function _processData($fileData)
    {
        try{
            foreach ($fileData as $dataRow){
                $protocol = Mage::getModel('ey_protocol/application');
                if(isset($dataRow['entity_id']) && $dataRow['entity_id']){
                    $protocol->load($dataRow['entity_id']);
                }
                foreach ($dataRow as $attribute => $data){
                    if($attribute == 'entity_id'){
                        // do nothing
                    } elseif($attribute == 'sample_type'){
                        $sampleType = Mage::getModel('ey_protocol/sampletype')->getCollection()
                            ->addFieldToFilter('name', array('eq' => $data))
                            ->getFirstItem();
                        if($sampleType->getId()){
                            $protocol->setData($attribute, $sampleType->getId());
                        }
                    } elseif($attribute == 'visibility'){
                        $visibility = $protocol->getVisibilityByName(strtolower($data));
                        $protocol->setData($attribute, $visibility);
                    } elseif($attribute == 'is_featured'){
                        $boolean = array(
                            'no' => 0,
                            'yes' => 1
                        );
                        $isFeatured = $boolean[strtolower($data)];
                        $protocol->setData($attribute, $isFeatured);
                    } elseif($data){
                        $protocol->setData($attribute, $data);
                    }
                }
                $protocol->save();
            }
        } catch (Exception $e) {
            Mage::logException($e);
            $this->_getSession()->addError($e->getMessage());
        }

        return $this->_redirect(
            '*/*/index'
        );
    }

    protected function _isAllowed()
    {
        $actionName = $this->getRequest()->getActionName();
        switch ($actionName) {
            case 'index':
            case 'post':
            default:
                $adminSession = Mage::getSingleton('admin/session');
                $isAllowed = $adminSession
                    ->isAllowed('ey_protocol/import');
                break;
        }

        return $isAllowed;
    }
}