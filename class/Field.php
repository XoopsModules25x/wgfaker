<?php

declare(strict_types=1);


namespace XoopsModules\Wgfaker;

/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/

/**
 * wgFaker module for xoops
 *
 * @copyright    2021 XOOPS Project (https://xoops.org)
 * @license      GPL 2.0 or later
 * @package      wgfaker
 * @since        1.0.0
 * @min_xoops    2.5.11 Beta1
 * @author       Goffy - Wedega - Email:webmaster@wedega.com - Website:https://xoops.wedega.com
 */

use XoopsModules\Wgfaker;

\defined('XOOPS_ROOT_PATH') || die('Restricted access');

/**
 * Class Object Field
 */
class Field extends \XoopsObject
{
    /**
     * @var int
     */
    public $start = 0;

    /**
     * @var int
     */
    public $limit = 0;

    /**
     * @var int
     */
    public $mid = 0;

    /**
     * Constructor
     *
     * @param null
     */
    public function __construct()
    {
        $this->initVar('id', \XOBJ_DTYPE_INT);
        $this->initVar('mid', \XOBJ_DTYPE_INT);
        $this->initVar('tableid', \XOBJ_DTYPE_INT);
        $this->initVar('name', \XOBJ_DTYPE_TXTBOX);
        $this->initVar('type', \XOBJ_DTYPE_TXTBOX);
        $this->initVar('datatypeid', \XOBJ_DTYPE_INT);
        $this->initVar('datecreated', \XOBJ_DTYPE_INT);
        $this->initVar('submitter', \XOBJ_DTYPE_INT);
    }

    /**
     * @static function &getInstance
     *
     * @param null
     */
    public static function getInstance()
    {
        static $instance = false;
        if (!$instance) {
            $instance = new self();
        }
    }

    /**
     * The new inserted $Id
     * @return inserted id
     */
    public function getNewInsertedIdField()
    {
        return $GLOBALS['xoopsDB']->getInsertId();
    }

    /**
     * @public function getForm
     * @param bool $action
     * @return \XoopsThemeForm
     */
    public function getFormField($action = false)
    {
        $helper = \XoopsModules\Wgfaker\Helper::getInstance();
        if (!$action) {
            $action = $_SERVER['REQUEST_URI'];
        }
        // Title
        $title = $this->isNew() ? \_AM_WGFAKER_FIELD_ADD : \_AM_WGFAKER_FIELD_EDIT;
        // Get Theme Form
        \xoops_load('XoopsFormLoader');
        $form = new \XoopsThemeForm($title, 'form', $action, 'post', true);
        $form->setExtra('enctype="multipart/form-data"');
        $form->addElement(new \XoopsFormHidden('mid', $this->getVar('mid')));
        // Form Table TableId
        $tableHandler = $helper->getHandler('Table');
        $TableidSelect = new \XoopsFormSelect(\_AM_WGFAKER_FIELD_TABLEID, 'tableid', $this->getVar('tableid'));
        $TableidSelect->addOptionArray($tableHandler->getList());
        $form->addElement($TableidSelect);
        // Form Text Name
        $form->addElement(new \XoopsFormText(\_AM_WGFAKER_FIELD_NAME, 'name', 50, 255, $this->getVar('name')));
        // Form Select type
        $form->addElement(new \XoopsFormText(\_AM_WGFAKER_FIELD_TYPE, 'type', 50, 255, $this->getVar('type')));
        // Field Handler
        $datatypeHandler = $helper->getHandler('Datatype');
        // Form Select Datatypeid
        $DatatypeidSelect = new \XoopsFormSelect(\_AM_WGFAKER_FIELD_DATATYPEID, 'datatypeid', $this->getVar('datatypeid'), 5);
        $DatatypeidSelect->addOptionArray($datatypeHandler->getList());
        $form->addElement($DatatypeidSelect);
        // Form Text Date Select Datecreated
        $Datecreated = $this->isNew() ? \time() : $this->getVar('datecreated');
        $form->addElement(new \XoopsFormTextDateSelect(\_AM_WGFAKER_FIELD_DATECREATED, 'datecreated', '', $Datecreated));
        // Form Select User Submitter
        $uidCurrent = \is_object($GLOBALS['xoopsUser']) ? $GLOBALS['xoopsUser']->uid() : 0;
        $Submitter = $this->isNew() ? $uidCurrent : $this->getVar('submitter');
        $form->addElement(new \XoopsFormSelectUser(\_AM_WGFAKER_FIELD_SUBMITTER, 'submitter', false, $Submitter));
        // To Save
        $form->addElement(new \XoopsFormHidden('op', 'save'));
        $form->addElement(new \XoopsFormHidden('mid', $this->mid));
        $form->addElement(new \XoopsFormHidden('start', $this->start));
        $form->addElement(new \XoopsFormHidden('limit', $this->limit));
        $form->addElement(new \XoopsFormButtonTray('', \_SUBMIT, 'submit', '', false));
        return $form;
    }

    /**
     * Get Values
     * @param null $keys
     * @param null $format
     * @param null $maxDepth
     * @return array
     */
    public function getValuesField($keys = null, $format = null, $maxDepth = null)
    {
        $helper  = \XoopsModules\Wgfaker\Helper::getInstance();
        $ret = $this->getValues($keys, $format, $maxDepth);
        $tableHandler = $helper->getHandler('Table');
        $datatypeHandler = $helper->getHandler('Datatype');
        $tableObj = $tableHandler->get($this->getVar('tableid'));
        $ret['tablename']     = $tableObj->getVar('name');
        $datatypeObj = $datatypeHandler->get($this->getVar('datatypeid'));
        $datatypeText = 'invalid datatype';
        if (\is_object($datatypeObj)) {
            $datatypeText = $datatypeObj->getVar('name');
        }
        $ret['datatype_text']  = $datatypeText;
        $ret['datecreated'] = \formatTimestamp($this->getVar('datecreated'), 's');
        $ret['submitter']   = \XoopsUser::getUnameFromId($this->getVar('submitter'));
        return $ret;
    }

    /**
     * Returns an array representation of the object
     *
     * @return array
     */
    public function toArrayField()
    {
        $ret = [];
        $vars = $this->getVars();
        foreach (\array_keys($vars) as $var) {
            $ret[$var] = $this->getVar($var);
        }
        return $ret;
    }
}
