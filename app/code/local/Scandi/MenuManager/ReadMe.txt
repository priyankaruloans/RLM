------------------------------------------------------------------------------------------------------------------------
DESCRIPTION:
------------------------------------------------------------------------------------------------------------------------

Allows user to create multiple menus and add to site. Supports active menu item feature, multiple stores. Easy to use.
3 default menu types are available - vertical, horizontal and plain output - no style. Developer friendly.

Module Files:
    app/code/local/Scandi/MenuManager/Block/Adminhtml/Menu.php
    app/code/local/Scandi/MenuManager/Block/Adminhtml/Menu/Edit.php
    app/code/local/Scandi/MenuManager/Block/Adminhtml/Menu/Edit/Form.php
    app/code/local/Scandi/MenuManager/Block/Adminhtml/Menu/Edit/Tab/Items.php
    app/code/local/Scandi/MenuManager/Block/Adminhtml/Menu/Edit/Tab/Main.php
    app/code/local/Scandi/MenuManager/Block/Adminhtml/Menu/Edit/Tab/Renderer/Parent.php
    app/code/local/Scandi/MenuManager/Block/Adminhtml/Menu/Edit/Tabs.php
    app/code/local/Scandi/MenuManager/Block/Adminhtml/Menu/Grid.php
    app/code/local/Scandi/MenuManager/Block/Adminhtml/Menu/Item/Edit.php
    app/code/local/Scandi/MenuManager/Block/Adminhtml/Menu/Item/Edit/Form.php
    app/code/local/Scandi/MenuManager/Block/Menu.php
    app/code/local/Scandi/MenuManager/Helper/Data.php
    app/code/local/Scandi/MenuManager/Model/Item.php
    app/code/local/Scandi/MenuManager/Model/Menu.php
    app/code/local/Scandi/MenuManager/Model/Resource/Item.php
    app/code/local/Scandi/MenuManager/Model/Resource/Item/Collection.php
    app/code/local/Scandi/MenuManager/Model/Resource/Menu.php
    app/code/local/Scandi/MenuManager/Model/Resource/Menu/Collection.php
    app/code/local/Scandi/MenuManager/controllers/Adminhtml/IndexController.php
    app/code/local/Scandi/MenuManager/etc/adminhtml.xml
    app/code/local/Scandi/MenuManager/etc/config.xml
    app/code/local/Scandi/MenuManager/sql/scandi_menumanager_setup/install-0.1.0.php
    app/design/adminhtml/default/default/layout/scandi_menumanager.xml
    app/design/frontend/base/default/layout/scandi_menumanager.xml
    app/design/frontend/base/default/template/scandi/menumanager/menu.phtml
    app/etc/modules/Scandi_MenuManager.xml
    skin/frontend/base/default/scandi/menumanager/css/menumanager.css


------------------------------------------------------------------------------------------------------------------------
USAGE:
------------------------------------------------------------------------------------------------------------------------

Menu Addition Using XML:

<block type="scandi_menumanager/menu" name="menu_name">
    <action method="setMenuId">
        <menu_id>menu_identifier</menu_id>
    </action>
</block>


Menu Addition Using Magento Shortcode:

{{block type="scandi_menumanager/menu" name="menu_name" menu_id="menu_identifier"}}


Menu Addition From Template:

<?php echo $this->getLayout()->createBlock('scandi_menumanager/menu')->setMenuId('menu_identifier')->toHtml(); ?>


1 Menu - Multiple Types:

<!-- Menu 1 displayed in header as horizontal menu -->
<reference name="header">
    <block type="scandi_menumanager/menu" name="menu1">
        <action method="setMenuId">
            <menu_id>menu_id_1</menu_id>
        </action>
    </block>
</reference>

<!-- We use same menu but will use as vertical type -->
<reference name="right">
    <block type="scandi_menumanager/menu" name="menu2">
        <action method="setMenuId">
            <menu_id>menu_id_1</menu_id>
        </action>

        <!-- Set new type like this -->
        <action method="setCustomType">
            <custom_type>vertical</custom_type>
        </action>
    </block>
</reference>


------------------------------------------------------------------------------------------------------------------------
MIGRATION:
------------------------------------------------------------------------------------------------------------------------

<?php
    //Create Menu
    $menu = Mage::getModel('scandi_menumanager/menu')->load('menu_identifier')
        ->setIdentifier('menu_identifier')
        ->setTitle('Menu Title')            //menu title
        ->setStores(array(0))               //array of store ids - 0 for all stores
        ->setType('none')                   //none, vertical or horizontal - 'none' used by default
        ->setCssClass('menu-class')         //ignore this line if you do not need to add css classes
        ->setIsActive('1')                  //menu will be active by default, add this line if you want it disabled
        ->save();

    //Add Menu Item
    Mage::getModel('scandi_menumanager/item')->load('item_identifier')
        ->setIdentifier('item_identifier')  //items are identified by identifiers, attribute is not visible in admin
        ->setMenuId($menu->getId())         //set previously created menu as item's parent, we need to know the id
        ->setParentId('0')                  //set item's parent item, 0 stands for root level, 0 used by default
        ->setTitle('Item Title')
        ->setUrl('/')                       //item's url, ignore for item w/o url, add '/' for base url item.
        ->setType('same_window')            //link type - same_window or new_window, default same_window
        ->setCssClass('item-class')         //ignore this line if you do not need to add css classes
        ->setPosition('0')                  //item's position depending of its parent, 0 default
        ->setIsActive(1)                    //menu item will be active by default
        ->save();
?>


------------------------------------------------------------------------------------------------------------------------
VIDEO OVERVIEW:
------------------------------------------------------------------------------------------------------------------------

http://www.screencast.com/t/pIUmRe9gM
