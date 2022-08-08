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
use XoopsModules\Wgfaker\Constants;
use XoopsModules\Wgfaker\Common;

require __DIR__ . '/header.php';
// Get all request values
$op          = Request::getCmd('op', 'list');
$tableId     = Request::getInt('id');
$mid         = Request::getInt('mid');
$mod_dirname = Request::getString('mod_dirname');
$start       = Request::getInt('start');
$limit       = Request::getInt('limit', $helper->getConfig('adminpager'));

$GLOBALS['xoopsTpl']->assign('start', $start);
$GLOBALS['xoopsTpl']->assign('limit', $limit);
if (Request::hasVar('read')) {
    $op = 'read';
}

switch ($op) {
    case 'list':
    default:
        $formSelect = $tableHandler->getFormSelect($mid);
        $GLOBALS['xoopsTpl']->assign('formSelect', $formSelect->render());
        // Define Stylesheet
        $GLOBALS['xoTheme']->addStylesheet($style, null);
        $templateMain = 'wgfaker_admin_table.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('table.php'));
        $crTable = new \CriteriaCompo();
        $crTable->add(new \Criteria('mid', $mid));
        $tableCount = $tableHandler->getCount($crTable);

        $GLOBALS['xoopsTpl']->assign('table_count', $tableCount);
        $GLOBALS['xoopsTpl']->assign('wgfaker_url', \WGFAKER_URL);
        $GLOBALS['xoopsTpl']->assign('wgfaker_upload_url', \WGFAKER_UPLOAD_URL);
        // Table view table
        if ($tableCount > 0) {
            $crTable->setStart($start);
            $crTable->setLimit($limit);
            $tableAll = $tableHandler->getAll($crTable);
            foreach (\array_keys($tableAll) as $i) {
                $table = $tableAll[$i]->getValuesTable();
                $GLOBALS['xoopsTpl']->append('table_list', $table);
                unset($table);
            }
            // Display Navigation
            if ($tableCount > $limit) {
                require_once \XOOPS_ROOT_PATH . '/class/pagenav.php';
                $pagenav = new \XoopsPageNav($tableCount, $limit, $start, 'start', 'op=list&limit=' . $limit . '&mid=' . $mid);
                $GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav());
            }
        } else {
            if ($mid > 0) {
                $GLOBALS['xoopsTpl']->assign('error', \_AM_WGFAKER_THEREARENT_TABLE);
            } else {
                $GLOBALS['xoopsTpl']->assign('error', \_AM_WGFAKER_NOSELECTED_MODULE);
            }
        }
        break;
    case 'read':
        $readLines = Request::getBool('read_lines');
        $modulesHandler = \xoops_getHandler('module');
        $moduleObj = $modulesHandler->get($mid);
        foreach ($moduleObj->getInfo('tables') as $table) {
            $numRows = 20; //default value for number of lines
            if ($readLines) {
                $check   = $GLOBALS['xoopsDB']->queryF('SELECT * FROM ' .  $GLOBALS['xoopsDB']->prefix($table));
                $numRows = $GLOBALS['xoopsDB']->getRowsNum($check);
            }
            //write data into wgfaker_table
            $crTable = new \CriteriaCompo();
            $crTable->add(new \Criteria('mid', $mid));
            $crTable->add(new \Criteria('name', $table));
            $tableCount = $tableHandler->getCount($crTable);
            if (0 == $tableCount) {
                $tableObj = $tableHandler->create();
                $tableObj->setVar('mid', $mid);
                $tableObj->setVar('mod_dirname', $moduleObj->getVar('dirname'));
                $tableObj->setVar('name', $table);
                $tableObj->setVar('lines', $numRows);
                $tableObj->setVar('skip', 0);
                $tableObj->setVar('datecreated', \time());
                $tableObj->setVar('submitter', $GLOBALS['xoopsUser']->uid());
                // Insert Data
                if ($tableHandler->insert($tableObj)) {
                    $fieldHandler->readFields($mid, $tableHandler->getInsertId(), $table);
                }
                unset($tableObj);
            } else {
                $tableAll = $tableHandler->getAll($crTable);
                foreach (\array_keys($tableAll) as $tableId) {
                    $tableObj = $tableHandler->get($tableId);
                    $tableObj->setVar('lines', $numRows);
                    $tableObj->setVar('datecreated', \time());
                    $tableObj->setVar('submitter', $GLOBALS['xoopsUser']->uid());
                    if ($tableHandler->insert($tableObj)) {
                        $fieldHandler->readFields($mid, $tableId, $tableAll[$tableId]->getVar('name'));
                    }
                }
            }

        }
        \redirect_header('table.php?op=list&amp;mid=' . $mid . '&amp;start=' . $start . '&amp;limit=' . $limit . '&mid=' . $mid, 2, \_AM_WGFAKER_FORM_OK);
        break;
    case 'new':
        $templateMain = 'wgfaker_admin_table.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('table.php'));
        $adminObject->addItemButton(\_AM_WGFAKER_LIST_TABLE, 'table.php', 'list');
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
        // Form Create
        $tableObj = $tableHandler->create();
        $form = $tableObj->getFormTable();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;
    case 'clone':
        $templateMain = 'wgfaker_admin_table.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('table.php'));
        $adminObject->addItemButton(\_AM_WGFAKER_LIST_TABLE, 'table.php', 'list');
        $adminObject->addItemButton(\_AM_WGFAKER_ADD_TABLE, 'table.php?op=new');
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
        // Request source
        $IdSource = Request::getInt('id_source');
        // Get Form
        $tableObjSource = $tableHandler->get($IdSource);
        $tableObj = $tableObjSource->xoopsClone();
        $form = $tableObj->getFormTable();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;
    case 'save':
        // Security Check
        if (!$GLOBALS['xoopsSecurity']->check()) {
            \redirect_header('table.php', 3, \implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        if ($tableId > 0) {
            $tableObj = $tableHandler->get($tableId);
        } else {
            $tableObj = $tableHandler->create();
        }
        // Set Vars
        $tableObj->setVar('mid', Request::getString('mid'));
        $tableObj->setVar('mod_dirname', Request::getString('mod_dirname'));
        $tableObj->setVar('name', Request::getString('name'));
        $tableObj->setVar('lines', Request::getInt('lines'));
        $tableObj->setVar('skip', Request::getInt('skip'));
        $tableDatecreatedObj = \DateTime::createFromFormat(\_SHORTDATESTRING, Request::getString('datecreated'));
        $tableObj->setVar('datecreated', $tableDatecreatedObj->getTimestamp());
        $tableObj->setVar('submitter', Request::getInt('submitter'));
        // Insert Data
        if ($tableHandler->insert($tableObj)) {
            \redirect_header('table.php?op=list&amp;start=' . $start . '&amp;limit=' . $limit . '&mid=' . $mid, 2, \_AM_WGFAKER_FORM_OK);
        }
        // Get Form
        $GLOBALS['xoopsTpl']->assign('error', $tableObj->getHtmlErrors());
        $form = $tableObj->getFormTable();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;
    case 'edit':
        $templateMain = 'wgfaker_admin_table.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('table.php'));
        $adminObject->addItemButton(\_AM_WGFAKER_ADD_TABLE, 'table.php?op=new');
        $adminObject->addItemButton(\_AM_WGFAKER_LIST_TABLE, 'table.php', 'list');
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
        // Get Form
        $tableObj = $tableHandler->get($tableId);
        $tableObj->start = $start;
        $tableObj->limit = $limit;
        $form = $tableObj->getFormTable();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;
    case 'delete':
        $templateMain = 'wgfaker_admin_table.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('table.php'));
        $tableObj = $tableHandler->get($tableId);
        if (isset($_REQUEST['ok']) && 1 == $_REQUEST['ok']) {
            if (!$GLOBALS['xoopsSecurity']->check()) {
                \redirect_header('table.php', 3, \implode(', ', $GLOBALS['xoopsSecurity']->getErrors()));
            }
            if ($tableHandler->delete($tableObj)) {
                \redirect_header('table.php', 3, \_AM_WGFAKER_FORM_DELETE_OK);
            } else {
                $GLOBALS['xoopsTpl']->assign('error', $tableObj->getHtmlErrors());
            }
        } else {
            $customConfirm = new Common\Confirm(
                ['ok' => 1, 'id' => $tableId, 'start' => $start, 'limit' => $limit, 'op' => 'delete'],
                $_SERVER['REQUEST_URI'],
                \sprintf(\_AM_WGFAKER_FORM_SURE_DELETE, $tableObj->getVar('mod_dirname')));
            $form = $customConfirm->getFormConfirm();
            $GLOBALS['xoopsTpl']->assign('form', $form->render());
        }
        break;
}
require __DIR__ . '/footer.php';
