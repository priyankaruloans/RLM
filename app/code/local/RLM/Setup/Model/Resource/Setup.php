<?php
/**
 * You can put function used in migration scripts here
 *
 */
class RLM_Setup_Model_Resource_Setup
    extends Mage_Catalog_Model_Resource_Eav_Mysql4_Setup
{
    protected $_ioObject = null;
    protected $_destinationMediaDirectory = null;

    /**
     * Creates the IO object and optionally creates the directory.
     *
     * @return Varien_Io_File
     */
    protected function _getIoObject()
    {
        if ($this->_ioObject === null) {
            $this->_ioObject = new Varien_Io_File();
            $destDirectory = $this->_destinationMediaDirectory;
            try {

                $this->_ioObject->open(array('path' => $destDirectory));
            } catch (Exception $e) {

                    $this->_ioObject->mkdir($destDirectory, 0777, true);
                    $this->_ioObject->open(array('path' => $destDirectory));
            }
        }
        return $this->_ioObject;
    }

    /**
     * Gets the directory from which media files are copied.
     * @param string $package
     * @param string $skin
     */
    protected function _getSourceMediaDirectory($package, $theme)
    {
        $themePath = 'base' . DS . 'default';
        if ($package && $theme) {
            $themePath = $package . DS . $theme;
        }
        return Mage::getBaseDir('skin') . DS .
            'frontend'     . DS .
            $themePath     . DS .
            'images'       . DS .
            'temp_media'   . DS;
    }

    /**
     * Gets the directory in which media files are copied to.
     *
     * @param string $folderPath
     * @return string
     */
    protected function _getDestinationMediaDirectory($folderPath = 'wysiwyg')
    {
        if (!$folderPath) {
            return Mage::getBaseDir('media') . DS;
        }
        return Mage::getBaseDir('media') . DS . $folderPath . DS;
    }

    /**
     * Copies an array of files from a source to a destination media directory.
     *
     * @param string $folderPath
     * @param array $files
     * @return Scandi_Migrations_Model_Resource_Setup
     */
    public function copyMediaFiles($files, $package, $theme, $folderPath = null)
    {
        $sourceDirectory = $this->_getSourceMediaDirectory($package, $theme);
        $destDirectory   = $this->_getDestinationMediaDirectory($folderPath);
        $this->_destinationMediaDirectory = $destDirectory;
        foreach ($files as $file) {
            $sourceFile = $sourceDirectory . $file;
            if ($this->_getIoObject()->fileExists($sourceFile)) {
                $this->_getIoObject()->cp($sourceFile, $destDirectory . $file);
            }
        }
        return $this;
    }

    /**
     * Add or update existing static block
     *
     * @param string $identifier
     * @param string $name
     * @param string $content
     */
    public function addStaticBlock($identifier, $title, $content, $stores = array(0))
    {
        Mage::getModel('cms/block')
            ->load($identifier, 'identifier')
            ->setIdentifier($identifier)
            ->setContent($content)
            ->setTitle($title)
            ->setStores($stores)
            ->save();
    }

    /**
     * Add or update existing cms page
     *
     * @param string $identifier
     * @param string $name
     * @param string $content
     */
    public function addCmsPage($identifier, $title, $content, $template, $stores = array(0))
    {
        Mage::getModel('cms/page')
            ->load($identifier, 'identifier')
            ->setIdentifier($identifier)
            ->setContent($content)
            ->setTitle($title)
            ->setStores($stores)
            ->setRootTemplate($template)
            ->save();
    }

    /**
     * Easily recursively create categories. $parent is category you want
     * to attach your upper newly created categories. $children is an array
     * of category names that you wan't to creat, you can make subarrays to
     * create subcategories
     *
     * @param Mage_Catalog_Model_Category $parent
     * @param array $children
     * @return Drecomm_Migrations_Model_Resource_Setup
     */
    public function createCategories($parent, $children)
    {
        foreach ($children as $key => $child) {
            $cat = Mage::getModel('catalog/category');
            if (is_array($child)) {
                $cat->setName($key)
                    ->setIsActive(true)
                    ->setParent($parent->getId())
                    ->setPath($parent->getPath())
                    ->setAttributeSetId($cat->getDefaultAttributeSetId())
                    ->save();

                $this->createCategories($cat, $child);
            } else {
                $cat->setName($child)
                    ->setIsActive(true)
                    ->setParent($parent->getId())
                    ->setPath($parent->getPath())
                    ->setAttributeSetId($cat->getDefaultAttributeSetId())
                    ->save();
            }
        }
        return $this;
    }

    /**
     * Recursivelly creates menumanager items
     * @param $parent
     * @param $children
     * @return Redstage_Setup_Model_Resource_Setup
     */
    public function addMenuManagerItems($menu, $parent, $children)
    {
        foreach ($children as $key => $child) {
            $item = Mage::getModel('scandi_menumanager/item');
            if (is_array($child)) {
                $key = str_replace(' ', '-', strtolower($key));
                $item->load($key, 'identifier')
                    ->setIdentifier($key)
                    ->setMenuId($menu->getId())
                    ->setParentId($parent->getId())
                    ->setTitle(ucwords(str_replace('-', ' ', $key)))
                    ->setUrl($key . '.html')
                    ->setType('same_window')
                    ->setCssClass($key)
                    ->setIsActive(1)
                    ->save();

                $this->addMenuManagerItems($menu, $item, $child);
            } else {
                $child = str_replace(' ', '-', strtolower($child));
                $item->load($child, 'identifier')
                    ->setIdentifier($child)
                    ->setMenuId($menu->getId())
                    ->setParentId($parent->getId())
                    ->setTitle(ucwords(str_replace('-', ' ', $child)))
                    ->setUrl($child . '.html')
                    ->setType('same_window')
                    ->setCssClass($child)
                    ->setIsActive(1)
                    ->save();
            }
        }
        return $this;
    }
}