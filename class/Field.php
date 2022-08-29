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
        $this->initVar('params', \XOBJ_DTYPE_TXTBOX);
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
        $form->addElement(new \XoopsFormHidden('tableid', $this->getVar('tableid')));
        $form->addElement(new \XoopsFormLabel(\_AM_WGFAKER_FIELD_TABLEID, $tableHandler->get($this->getVar('tableid'))->getVar('name')));
        // Form Text Name
        $form->addElement(new \XoopsFormText(\_AM_WGFAKER_FIELD_NAME, 'name', 50, 255, $this->getVar('name')));
        // Form Select type
        $form->addElement(new \XoopsFormText(\_AM_WGFAKER_FIELD_TYPE, 'type', 50, 255, $this->getVar('type')));
        // Field Handler
        $datatypeHandler = $helper->getHandler('Datatype');
        // Form Select Datatypeid
        $datatypeid = (int)$this->getVar('datatypeid');
        $DatatypeidSelect = new \XoopsFormSelect(\_AM_WGFAKER_FIELD_DATATYPEID, 'datatypeid', $datatypeid, 5);
        $datatypes = $datatypeHandler->getAllDatatype();
        foreach ($datatypes as $datatype) {
            $DatatypeidSelect->addOption($datatype->getVar('id'), $datatype->getVar('name'));
        }
        $DatatypeidSelect->setExtra(" onchange='toogleFieldParams()' ");
        $form->addElement($DatatypeidSelect);
        // Form Tray Params
        $paramsValue = $this->getVar('params');
        $paramTray = new \XoopsFormElementTray(\_AM_WGFAKER_FIELD_PARAMS, '<br>');
        // Form Tray Params - simple text
        $paramTextVal = '';
        if (Constants::DATATYPE_TEXT_FIXED === $datatypeid || Constants::DATATYPE_INT_FIXED === $datatypeid) {
            $paramTextVal = $paramsValue;
        }
        $paramText = new \XoopsFormText(\_AM_WGFAKER_FIELD_PARAM_TEXT, 'param_text', 50, 255, $paramTextVal);
        // Form Tray Params - Title
        $paramTrayTitle = new \XoopsFormElementTray(\_AM_WGFAKER_FIELD_PARAM_TEXT_RUNNING, '');
        $paramTextRunningVal = '';
        $paramTextRunningBlankVal = 0;
        if (Constants::DATATYPE_TEXT_RUNNING === $datatypeid) {
            $paramTextRunningVal = $paramsValue;
            $paramsArr = \explode('|', $paramsValue);
            if (\count($paramsArr) > 1) {
                $paramTextRunningVal = $paramsArr[0];
                $paramTextRunningBlankVal = $paramsArr[1];
            }
        }
        $paramTextRunning = new \XoopsFormText('', 'param_text_running', 50, 255, $paramTextRunningVal);
        $paramTextRunningCb = new \XoopsFormCheckBox(\_AM_WGFAKER_FIELD_PARAM_TEXT_RUNNING_CB, 'param_text_running_blank', $paramTextRunningBlankVal);
        $paramTextRunningCb->addOption(1, ' ');
        $paramTextRunningLabel = new \XoopsFormLabel(\_AM_WGFAKER_FIELD_PARAM_TEXT_RUNNING_LABEL, '');
        $paramTrayTitle->addElement($paramTextRunning);
        $paramTrayTitle->addElement($paramTextRunningCb);
        $paramTrayTitle->addElement($paramTextRunningLabel);
        // Form Tray Params - Number range
        $paramTrayNumberRange = new \XoopsFormElementTray('', '');
        $paramIntRangeFromVal = 1;
        $paramIntRangeToVal = 10;
        if (Constants::DATATYPE_INT_RANGE === $datatypeid) {
            $paramsArr = \explode('|', $paramsValue);
            if (\count($paramsArr) > 1) {
                $paramIntRangeFromVal = $paramsArr[0];
                $paramIntRangeToVal = $paramsArr[1];
            }
        }
        $paramIntRangeFrom = new \XoopsFormText(\_AM_WGFAKER_FIELD_PARAM_INTRANGEFROM, 'param_intrangefrom', 10, 255, $paramIntRangeFromVal);
        $paramIntRangeTo = new \XoopsFormText(\_AM_WGFAKER_FIELD_PARAM_INTRANGETO, 'param_intrangeto', 10, 255, $paramIntRangeToVal);
        $paramTrayNumberRange->addElement($paramIntRangeFrom);
        $paramTrayNumberRange->addElement($paramIntRangeTo);
        // Form Tray Params - Date range
        $paramTrayDateRange = new \XoopsFormElementTray('', '');
        $paramDateRangeFromVal = (\time() - 365 * 24 * 60 * 60);;
        $paramDateRangeToVal = \time();
        if (Constants::DATATYPE_DATE_RANGE === $datatypeid) {
            $paramsArr = \explode('|', $paramsValue);
            if (\count($paramsArr) > 1) {
                $paramDateRangeFromVal = $paramsArr[0];
                $paramDateRangeToVal = $paramsArr[1];
            }
        }
        $paramDateRangeFrom = new \XoopsFormTextDateSelect(\_AM_WGFAKER_FIELD_PARAM_DATERANGEFROM, 'param_daterangefrom', '', $paramDateRangeFromVal);
        $paramDateRangeTo = new \XoopsFormTextDateSelect(\_AM_WGFAKER_FIELD_PARAM_DATERANGETO, 'param_daterangeto', '', $paramDateRangeToVal);
        $paramTrayDateRange->addElement($paramDateRangeFrom);
        $paramTrayDateRange->addElement($paramDateRangeTo);
        // Form Select Table Field
        $paramsTableIdVal = ' ';
        if (Constants::DATATYPE_TABLE_ID === $datatypeid) {
            $paramsTableIdVal = $paramsValue;
        }
        $modulesHandler = \xoops_getHandler('module');
        $moduleObj = $modulesHandler->get($this->getVar('mid'));

        $tableidSelect = new \XoopsFormSelect(\_AM_WGFAKER_FIELD_PARAM_TABLE_ID, 'param_table_id', $paramsTableIdVal);
        $tableidSelect->addOption(' ',' ');
        foreach ($moduleObj->getInfo('tables') as $table) {
            //get all fields of each table
            $tableidSelect->addOption($table, $table);
        }
        // Form Tray Params - Custom list
        $paramTrayCustomList = new \XoopsFormElementTray(\_AM_WGFAKER_FIELD_PARAM_CUSTOM_LIST, '');
        $paramCustomListVal = '';
        if (Constants::DATATYPE_CUSTOM_LIST === $datatypeid) {
            $paramCustomListVal = $paramsValue;
        }
        $paramCustomList = new \XoopsFormText('', 'param_custom_list', 100, 255, $paramCustomListVal);
        $paramCustomListLabel = new \XoopsFormLabel(\_AM_WGFAKER_FIELD_PARAM_CUSTOM_LIST_LABEL, '');
        $paramTrayCustomList->addElement($paramCustomList);
        $paramTrayCustomList->addElement($paramCustomListLabel);

        $disabled = ' disabled="disabled" style="background-color:#d4d5d6"';
        switch ($datatypeid) {
            case Constants::DATATYPE_TEXT_RUNNING:
                $paramText->setExtra($disabled);
                $paramIntRangeFrom->setExtra($disabled);
                $paramIntRangeTo->setExtra($disabled);
                $paramDateRangeFrom->setExtra($disabled);
                $paramDateRangeTo->setExtra($disabled);
                $tableidSelect->setExtra($disabled);
                $paramCustomList->setExtra($disabled);
                break;
            case Constants::DATATYPE_INT_RANGE:
                $paramText->setExtra($disabled);
                $paramTextRunning->setExtra($disabled);
                $paramTextRunningCb->setExtra($disabled);
                $paramDateRangeFrom->setExtra($disabled);
                $paramDateRangeTo->setExtra($disabled);
                $tableidSelect->setExtra($disabled);
                $paramCustomList->setExtra($disabled);
                break;
            case Constants::DATATYPE_INT_FIXED:
            case Constants::DATATYPE_TEXT_FIXED:
                $paramTextRunning->setExtra($disabled);
                $paramTextRunningCb->setExtra($disabled);
                $paramIntRangeFrom->setExtra($disabled);
                $paramIntRangeTo->setExtra($disabled);
                $paramDateRangeFrom->setExtra($disabled);
                $paramDateRangeTo->setExtra($disabled);
                $tableidSelect->setExtra($disabled);
                $paramCustomList->setExtra($disabled);
                break;
            case Constants::DATATYPE_DATE_RANGE:
                $paramText->setExtra($disabled);
                $paramTextRunning->setExtra($disabled);
                $paramTextRunningCb->setExtra($disabled);
                $paramTextRunningLabel->setExtra($disabled);
                $paramIntRangeFrom->setExtra($disabled);
                $paramIntRangeTo->setExtra($disabled);
                $tableidSelect->setExtra($disabled);
                $paramCustomList->setExtra($disabled);
                break;
            case Constants::DATATYPE_TABLE_ID:
                $paramText->setExtra($disabled);
                $paramTextRunning->setExtra($disabled);
                $paramTextRunningCb->setExtra($disabled);
                $paramIntRangeFrom->setExtra($disabled);
                $paramIntRangeTo->setExtra($disabled);
                $paramDateRangeFrom->setExtra($disabled);
                $paramDateRangeTo->setExtra($disabled);
                $paramCustomList->setExtra($disabled);
                break;
            case Constants::DATATYPE_CUSTOM_LIST:
                $paramText->setExtra($disabled);
                $paramTextRunning->setExtra($disabled);
                $paramTextRunningCb->setExtra($disabled);
                $paramIntRangeFrom->setExtra($disabled);
                $paramIntRangeTo->setExtra($disabled);
                $paramDateRangeFrom->setExtra($disabled);
                $paramDateRangeTo->setExtra($disabled);
                $tableidSelect->setExtra($disabled);
                break;
            case 0:
            default:
                $paramText->setExtra($disabled);
                $paramTextRunning->setExtra($disabled);
                $paramTextRunningCb->setExtra($disabled);
                $paramIntRangeFrom->setExtra($disabled);
                $paramIntRangeTo->setExtra($disabled);
                $paramDateRangeFrom->setExtra($disabled);
                $paramDateRangeTo->setExtra($disabled);
                $tableidSelect->setExtra($disabled);
                $paramCustomList->setExtra($disabled);
                break;
        }
        $paramTray->addElement($paramText);
        $paramTray->addElement($paramTrayTitle);
        $paramTray->addElement($paramTrayNumberRange);
        $paramTray->addElement($paramTrayDateRange);
        $paramTray->addElement($tableidSelect);
        $paramTray->addElement($paramTrayCustomList);
        $form->addElement($paramTray);
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
}
