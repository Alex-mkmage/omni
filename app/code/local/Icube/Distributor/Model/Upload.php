<?php
class Icube_Distributor_Model_Upload extends Mage_Core_Model_Abstract
{

	const FIELD_NAME_SOURCE_FILE = 'upload_file';
    
    protected function _construct()
    {
        $this->_init('distributor/upload');
    }
	
	public function getWorkingDir()
    {
        return Mage::getBaseDir('var') . DS . 'icube' . DS;
    }
    
	public function uploadFile()
    {	
    	Mage::getConfig()->createDirIfNotExists(self::getWorkingDir());
        $uploader  = Mage::getModel('core/file_uploader', self::FIELD_NAME_SOURCE_FILE);
        $uploader->skipDbProcessing(true);
        $result    = $uploader->save(self::getWorkingDir());
        $extension = pathinfo($result['file'], PATHINFO_EXTENSION);

        $uploadedFile = $result['path'] . $result['file'];
        if (!$extension) {
            unlink($uploadedFile);
            Mage::throwException(Mage::helper('distributor')->__('Uploaded file has no extension'));
        }
        else if($extension != 'csv'){
	        unlink($uploadedFile);
            Mage::throwException(Mage::helper('distributor')->__('Uploaded file is not CSV file'));
        }
     
        $sourceFile = self::getWorkingDir().'distributor';
        $sourceFile .= '.' . $extension;
        
        if(strtolower($uploadedFile) != strtolower($sourceFile)) {
            if (file_exists($sourceFile)) {
                unlink($sourceFile);
            }

            if (!@rename($uploadedFile, $sourceFile)) {
                Mage::throwException(Mage::helper('distributor')->__('Source file moving failed'));
            }
        }
        
        return $sourceFile;
    
        }
    
}
	 