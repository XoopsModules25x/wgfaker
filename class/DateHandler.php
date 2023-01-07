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
class DateHandler extends \XoopsPersistableObjectHandler
{

    /**
     * Constructor
     *
     * @param null
     */
    public function __construct()
    {
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
     * @param int $mid
     * @param int $tableid
     * @param int $period
     * @return \XoopsThemeForm
     */
    public function getFormDate($mid = 0, $tableid = 0, $period = Constants::DATE_ONEYEAR)
    {
        $helper = \XoopsModules\Wgfaker\Helper::getInstance();
        $action = $_SERVER['REQUEST_URI'];
        // Get Theme Form
        \xoops_load('XoopsFormLoader');
        $form = new \XoopsThemeForm(\_AM_WGFAKER_DATE_FORMTITLE, 'form', $action, 'post', true);
        $form->setExtra('enctype="multipart/form-data"');
        // Form Select dateFieldKey
        $dateFieldKeyArr = [];
        $fieldHandler = $helper->getHandler('Field');
        $datatypeHandler = $helper->getHandler('Datatype');
        $crField = new \CriteriaCompo();
        $crField->add(new \Criteria('mid', $mid));
        $crField->add(new \Criteria('tableid', $tableid));
        $fieldAll = $fieldHandler->getAll($crField);
        $counter = 0;
        foreach (\array_keys($fieldAll) as $f) {
            if ($counter < 1) {
                $dateFieldKey = $fieldAll[$f]->getVar('name');
            }
            $counter++;
            $dateFieldKeyArr[$fieldAll[$f]->getVar('name')] = $fieldAll[$f]->getVar('name');
        }
        $dateFieldKeySelect = new \XoopsFormSelect(\_AM_WGFAKER_DATE_FIELDKEY, 'date_keyfield', $dateFieldKey, 5);
        $dateFieldKeySelect->addOptionArray($dateFieldKeyArr);
        $form->addElement($dateFieldKeySelect);
        // Form Select dateField
        $dateFieldArr = [];
        $dateFieldPreselect = [];
        foreach (\array_keys($fieldAll) as $f) {
            $datatypeId = (int)$fieldAll[$f]->getVar('datatypeid');
            $datatypeObj = $datatypeHandler->get($datatypeId);
            $datatypeText = 'invalid datatype';
            if (\is_object($datatypeObj)) {
                $datatypeText = $datatypeObj->getVar('name');
                if (Constants::DATATYPE_DATE === $datatypeId || Constants::DATATYPE_DATE_NOW === $datatypeId || Constants::DATATYPE_DATE_RANGE === $datatypeId) {
                    $dateFieldPreselect[$fieldAll[$f]->getVar('name')] = $fieldAll[$f]->getVar('name');
                }
            }
            $dateFieldArr[$fieldAll[$f]->getVar('name')] = $fieldAll[$f]->getVar('name') . '     (' . $datatypeText . ')';
        }
        $dateFieldSelect = new \XoopsFormSelect(\_AM_WGFAKER_DATE_FIELD, 'date_field', $dateFieldPreselect, 15, true);
        $dateFieldSelect->addOptionArray($dateFieldArr);
        $dateFieldSelect->setDescription(\_AM_WGFAKER_DATE_FIELD_DESC);
        $form->addElement($dateFieldSelect);
        // Form Radio datePeriod
        $datePeriodSelect = new \XoopsFormRadio(\_AM_WGFAKER_DATE_PERIOD, 'date_period', $period);
        $datePeriodSelect->addOption(Constants::DATE_ONEMONTH, \_AM_WGFAKER_DATE_ONEMONTH);
        $datePeriodSelect->addOption(Constants::DATE_SIXMONTH, \_AM_WGFAKER_DATE_SIXMONTH);
        $datePeriodSelect->addOption(Constants::DATE_ONEYEAR, \_AM_WGFAKER_DATE_ONEYEAR);
        $form->addElement($datePeriodSelect);
        $form->addElement(new \XoopsFormLabel('<span style="font-weight:700;color:#ff0000">' . \_AM_WGFAKER_DATE_INFO_1 . '</span>', '<span style="font-weight:700;color:#ff0000">' . \_AM_WGFAKER_DATE_INFO_2 . '</span>'));
        // To Save
        $form->addElement(new \XoopsFormHidden('op', 'generate'));
        $form->addElement(new \XoopsFormHidden('mid', $mid));
        $form->addElement(new \XoopsFormHidden('tableid', $tableid));
        $form->addElement(new \XoopsFormButton('', 'generate', \_AM_WGFAKER_DATE_GENERATE, 'submit'));
        return $form;
    }
}
