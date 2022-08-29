<?php

declare(strict_types=1);

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

use Xmf\Request;
use XoopsModules\Wgfaker;
use XoopsModules\Wgfaker\{
    Constants,
    Common,
    Utility,
    Generator
};

require __DIR__ . '/header.php';
// Get all request values
$op         = Request::getCmd('op', 'list');
$fieldId   = Request::getInt('id');
$mid        = Request::getInt('mid');
$tableid    = Request::getInt('tableid');
$datePeriod = Request::getInt('date_period');

switch ($op) {
    case 'list':
    default:
        $formSelect = $fieldHandler->getFormCombo($mid, $tableid);
        $GLOBALS['xoopsTpl']->assign('formSelect', $formSelect->render());
        // Define Stylesheet
        $GLOBALS['xoTheme']->addStylesheet($style, null);
        $templateMain = 'wgfaker_admin_date.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('date.php'));
        $crField = new \CriteriaCompo();
        $crField->add(new \Criteria('mid', $mid));
        $crField->add(new \Criteria('tableid', $tableid));
        $fieldCount = $fieldHandler->getCount($crField);
        unset($crField);
        $GLOBALS['xoopsTpl']->assign('mid', $mid);
        $GLOBALS['xoopsTpl']->assign('tableid', $tableid);
        // Table view field
        if ($fieldCount > 0) {
            $form = $dateHandler->getFormDate($mid, $tableid, $datePeriod);
            $GLOBALS['xoopsTpl']->assign('formDate', $form->render());
        } else {
            if (0 === $mid) {
                $GLOBALS['xoopsTpl']->assign('error', \_AM_WGFAKER_NOSELECTED_MODULE);
                break;
            }
            if (0 === $tableid) {
                $GLOBALS['xoopsTpl']->assign('error', \_AM_WGFAKER_NOSELECTED_TABLE);
                break;
            }
            $GLOBALS['xoopsTpl']->assign('error', \_AM_WGFAKER_THEREARENT_FIELD);
        }
        break;
    case 'generate':
        $tableObj    = $tableHandler->get($tableid);
        $tableName   = $tableObj->getVar('name');
        $fieldKey   = Request::getString('date_keyfield');
        $fieldArr   = Request::getArray('date_field');
        $fieldCount = 0;
        $linesCount  = 0;
        $errorsCount = 0;
        if (Constants::DATE_ONEYEAR === $datePeriod) {
            $datePeriodValue = 365*24*60*60;
        } elseif (Constants::DATE_ONEMONTH === $datePeriod) {
            $datePeriodValue = 30*24*60*60;
        } else {
            $datePeriodValue = 30*6*24*60*60;
        }
        foreach ($fieldArr as $col) {
            $fieldCount++;
            $result = $GLOBALS['xoopsDB']->queryF('SELECT * FROM ' . $GLOBALS['xoopsDB']->prefix($tableName));
            while ($row = $GLOBALS['xoopsDB']->fetchArray($result)) {
                $id = $row[$fieldKey];
                $valueOld = $row[$col];
                if ($valueOld > 0) {
                    $sql = 'UPDATE `' . $GLOBALS['xoopsDB']->prefix($tableName) . "` SET `" . $col . "` = '" . ($valueOld + $datePeriodValue) . "' WHERE `" . $GLOBALS['xoopsDB']->prefix($tableName) . '`.`' . $fieldKey . '` = ' . $id;
                    if ($GLOBALS['xoopsDB']->queryF($sql)) {
                        $linesCount++;
                    } else {
                        $errorsCount++;
                    }
                    $linesCount++;
                }
            }
        }
        \redirect_header('date.php?op=list&amp;mid=' . $mid . '&amp;tableid=' . $tableid . '&amp;date_period=' . $datePeriod, 2, \sprintf(\_AM_WGFAKER_FORM_OK_GENERATE, $linesCount, $fieldCount, $errorsCount));
}
require __DIR__ . '/footer.php';
