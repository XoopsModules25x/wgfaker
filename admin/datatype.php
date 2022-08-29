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
$op    = Request::getCmd('op', 'list');
$Id    = Request::getInt('id');
$start = Request::getInt('start');
$limit = Request::getInt('limit', $helper->getConfig('adminpager'));

$GLOBALS['xoopsTpl']->assign('start', $start);
$GLOBALS['xoopsTpl']->assign('limit', $limit);

switch ($op) {
    case 'list':
    default:
        // Define Stylesheet
        $GLOBALS['xoTheme']->addStylesheet($style, null);
        $templateMain = 'wgfaker_admin_datatype.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('datatype.php'));
        $adminObject->addItemButton(\_AM_WGFAKER_ADD_DATATYPE, 'datatype.php?op=new');
        $adminObject->addItemButton(\_AM_WGFAKER_DATATYPE_CREATEDEFAULT, 'datatype.php?op=default_set');
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
        $datatypeCount = $datatypeHandler->getCountDatatype();
        $GLOBALS['xoopsTpl']->assign('datatype_count', $datatypeCount);
        $GLOBALS['xoopsTpl']->assign('wgfaker_url', \WGFAKER_URL);
        $GLOBALS['xoopsTpl']->assign('wgfaker_upload_url', \WGFAKER_UPLOAD_URL);
        // Table view datatype
        if ($datatypeCount > 0) {
            $datatypeAll = $datatypeHandler->getAllDatatype($start, $limit);
            foreach (\array_keys($datatypeAll) as $i) {
                $datatype = $datatypeAll[$i]->getValuesDatatype();
                $GLOBALS['xoopsTpl']->append('datatype_list', $datatype);
                unset($datatype);
            }
            // Display Navigation
            if ($datatypeCount > $limit) {
                require_once \XOOPS_ROOT_PATH . '/class/pagenav.php';
                $pagenav = new \XoopsPageNav($datatypeCount, $limit, $start, 'start', 'op=list&limit=' . $limit);
                $GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav());
            }
        } else {
            $GLOBALS['xoopsTpl']->assign('error', \_AM_WGFAKER_THEREARENT_DATATYPE);
        }
        break;
    case 'default_set':
        $templateMain = 'wgfaker_admin_datatype.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('datatype.php'));
        if (isset($_REQUEST['ok']) && 1 == $_REQUEST['ok']) {
            if (!$GLOBALS['xoopsSecurity']->check()) {
                \redirect_header('datatype.php', 3, \implode(', ', $GLOBALS['xoopsSecurity']->getErrors()));
            }
            if ($datatypeHandler->getCount() > 0) {
                if (!$datatypeHandler->deleteAll()) {
                    $GLOBALS['xoopsTpl']->assign('error', $datatypeHandler->getHtmlErrors());
                }
            }
            $datatypeHandler->createDefaultSet();

            \redirect_header('datatype.php', 3, \_AM_WGFAKER_FORM_OK);
        } else {
            $customConfirm = new Common\Confirm(
                ['ok' => 1, 'op' => 'default_set'],
                $_SERVER['REQUEST_URI'],
                \_AM_WGFAKER_DATATYPE_SURE_DELETE);
            $form = $customConfirm->getFormConfirm();
            $GLOBALS['xoopsTpl']->assign('form', $form->render());
        }
        break;
    case 'new':
        $templateMain = 'wgfaker_admin_datatype.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('datatype.php'));
        $adminObject->addItemButton(\_AM_WGFAKER_LIST_DATATYPE, 'datatype.php', 'list');
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
        // Form Create
        $datatypeObj = $datatypeHandler->create();
        $form = $datatypeObj->getFormDatatype();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;
    case 'clone':
        $templateMain = 'wgfaker_admin_datatype.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('datatype.php'));
        $adminObject->addItemButton(\_AM_WGFAKER_LIST_DATATYPE, 'datatype.php', 'list');
        $adminObject->addItemButton(\_AM_WGFAKER_ADD_DATATYPE, 'datatype.php?op=new');
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
        // Request source
        $IdSource = Request::getInt('id_source');
        // Get Form
        $datatypeObjSource = $datatypeHandler->get($IdSource);
        $datatypeObj = $datatypeObjSource->xoopsClone();
        $form = $datatypeObj->getFormDatatype();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;
    case 'save':
        // Security Check
        if (!$GLOBALS['xoopsSecurity']->check()) {
            \redirect_header('datatype.php', 3, \implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        if ($Id > 0) {
            $datatypeObj = $datatypeHandler->get($Id);
        } else {
            $datatypeObj = $datatypeHandler->create();
        }
        // Set Vars
        $datatypeObj->setVar('name', Request::getString('name'));
        $values = \str_replace(['<br', "\r\n", "\n", "\n"],'|', Request::getText('values'));
        $datatypeObj->setVar('values', $values);
        $datatypeObj->setVar('rangefrom', Request::getInt('rangefrom'));
        $datatypeObj->setVar('rangeto', Request::getInt('rangeto'));
        $datatypeObj->setVar('weight', Request::getInt('weight'));
        $datatypeDatecreatedObj = \DateTime::createFromFormat(\_SHORTDATESTRING, Request::getString('datecreated'));
        $datatypeObj->setVar('datecreated', $datatypeDatecreatedObj->getTimestamp());
        $datatypeObj->setVar('submitter', Request::getInt('submitter'));
        // Insert Data
        if ($datatypeHandler->insert($datatypeObj)) {
            \redirect_header('datatype.php?op=list&amp;start=' . $start . '&amp;limit=' . $limit, 2, \_AM_WGFAKER_FORM_OK);
        }
        // Get Form
        $GLOBALS['xoopsTpl']->assign('error', $datatypeObj->getHtmlErrors());
        $form = $datatypeObj->getFormDatatype();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;
    case 'edit':
        $templateMain = 'wgfaker_admin_datatype.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('datatype.php'));
        $adminObject->addItemButton(\_AM_WGFAKER_ADD_DATATYPE, 'datatype.php?op=new');
        $adminObject->addItemButton(\_AM_WGFAKER_LIST_DATATYPE, 'datatype.php', 'list');
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
        // Get Form
        $datatypeObj = $datatypeHandler->get($Id);
        $datatypeObj->start = $start;
        $datatypeObj->limit = $limit;
        $form = $datatypeObj->getFormDatatype();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;
    case 'delete':
        $templateMain = 'wgfaker_admin_datatype.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('datatype.php'));
        $datatypeObj = $datatypeHandler->get($Id);
        $Name = $datatypeObj->getVar('name');
        if (isset($_REQUEST['ok']) && 1 == $_REQUEST['ok']) {
            if (!$GLOBALS['xoopsSecurity']->check()) {
                \redirect_header('datatype.php', 3, \implode(', ', $GLOBALS['xoopsSecurity']->getErrors()));
            }
            if ($datatypeHandler->delete($datatypeObj)) {
                \redirect_header('datatype.php', 3, \_AM_WGFAKER_FORM_DELETE_OK);
            } else {
                $GLOBALS['xoopsTpl']->assign('error', $datatypeObj->getHtmlErrors());
            }
        } else {
            $customConfirm = new Common\Confirm(
                ['ok' => 1, 'id' => $Id, 'start' => $start, 'limit' => $limit, 'op' => 'delete'],
                $_SERVER['REQUEST_URI'],
                \sprintf(\_AM_WGFAKER_FORM_SURE_DELETE, $datatypeObj->getVar('name')));
            $form = $customConfirm->getFormConfirm();
            $GLOBALS['xoopsTpl']->assign('form', $form->render());
        }
        break;
}
require __DIR__ . '/footer.php';
