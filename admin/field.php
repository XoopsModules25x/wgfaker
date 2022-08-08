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
$op      = Request::getCmd('op', 'list');
$fieldId = Request::getInt('id');
$mid     = Request::getInt('mid');
$tableid = Request::getInt('tableid');
$start   = Request::getInt('start');
$limit   = Request::getInt('limit', $helper->getConfig('adminpager'));

switch ($op) {
    case 'list':
    default:
        $formSelect = $fieldHandler->getFormCombo($mid, $tableid);
        $GLOBALS['xoopsTpl']->assign('formSelect', $formSelect->render());
        // Define Stylesheet
        $GLOBALS['xoTheme']->addStylesheet($style, null);
        $templateMain = 'wgfaker_admin_field.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('field.php'));
        $crField = new \CriteriaCompo();
        $crField->add(new \Criteria('mid', $mid));
        $crField->add(new \Criteria('tableid', $tableid));
        $fieldCount = $fieldHandler->getCount($crField);
        unset($crField);
        $GLOBALS['xoopsTpl']->assign('field_count', $fieldCount);
        $GLOBALS['xoopsTpl']->assign('wgfaker_url', \WGFAKER_URL);
        $GLOBALS['xoopsTpl']->assign('wgfaker_upload_url', \WGFAKER_UPLOAD_URL);
        $GLOBALS['xoopsTpl']->assign('mid', $mid);
        $GLOBALS['xoopsTpl']->assign('tableid', $tableid);
        // Table view field
        if ($fieldCount > 0) {
            $crTable = new \CriteriaCompo();
            $crTable->add(new \Criteria('mid', $mid));
            $crTable->add(new \Criteria('id', $tableid));
            if ($tableHandler->getCount($crTable) > 0) {
                $tableAll = $tableHandler->getAll($crTable);
                foreach (\array_keys($tableAll) as $t) {
                    $tableName = $tableAll[$t]->getVar('name');
                    $targetFolder = \WGFAKER_UPLOAD_YAML_PATH . '/' . $tableAll[$t]->getVar('mod_dirname');
                    // target yaml file/path
                    $targetYaml = $targetFolder . '/' . $tableName . '.yml';
                    $table['id'] = $t;
                    $table['mid'] = $mid;
                    $table['name'] = $tableName;
                    //$table['tmp_exist'] = 'wgfaker_tmp_ . ' . $tableHandler->tableExist($table);
                    $table['yml_exist'] = \file_exists($targetYaml);
                    // get fields of this table
                    $crField = new \CriteriaCompo();
                    $crField->add(new \Criteria('mid', $mid));
                    $crField->add(new \Criteria('tableid', $t));
                    $fieldAll = $fieldHandler->getAll($crField);
                    foreach (\array_keys($fieldAll) as $f) {
                        $field = $fieldAll[$f]->getValuesField();
                        $table['field_list'][] = $field;
                        unset($field);
                    }
                    $GLOBALS['xoopsTpl']->append('table_list', $table);
                    unset($table);
                }
            }
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
    case 'reread':
        $tableObj = $tableHandler->get($tableid);
        $fieldHandler->readFields($mid, $tableid, $tableObj->getVar('name'), true);
        \redirect_header('field.php?op=list&amp;mid=' . $mid, 2, \_AM_WGFAKER_FORM_OK);
        break;
    case 'generate':
        $tableObj   = $tableHandler->get($tableid);
        $moduleName = $tableObj->getVar('mod_dirname');
        $tableName  = $tableObj->getVar('name');
        $tableLines = $tableObj->getVar('lines');
        // create target folder
        $targetFolder = \WGFAKER_UPLOAD_YAML_PATH . '/' . $moduleName;
        if (!\file_exists($targetFolder . '/')) {
            Utility::createFolder($targetFolder . '/');
        }
        // target yaml file/path
        $targetYaml = $targetFolder . '/' . $tableName . '.yml';

        // get fields of this table
        $fields = [];
        $crField = new \CriteriaCompo();
        $crField->add(new \Criteria('tableid', $tableid));
        $fieldAll = $fieldHandler->getAll($crField);
        $yamlLines = [];
        $intend = '    ';
        $generator = new Generator();
        for ($i = 1; $i <= $tableLines; $i++) {
            $yamlLines[] = '-' . PHP_EOL;
            foreach(\array_keys($fieldAll) as $f) {
                $generator->setType($fieldAll[$f]->getVar('datatypeid'));
                if (Constants::DATATYPE_PARENT_ID === $fieldAll[$f]->getVar('datatypeid')) {
                    $generator->setParam($tableName);
                } else {
                    $generator->setParam($fieldAll[$f]->getVar('params'));
                }
                $generator->setId($i);
                $yamlLines[] = $intend . $fieldAll[$f]->getVar('name') . ': ' . $generator->renderer() . PHP_EOL;
            }
        }

        // create new file and write array into this file
        $yaml = new Common\Yaml($targetYaml);
        if ($yaml->createFile($yamlLines)) {
            \redirect_header('field.php?op=list&amp;mid=' . $mid . '&amp;tableid=' . $tableid, 2, \_AM_WGFAKER_FORM_OK);
        }
        break;
    case 'plugin':
        $name = Request::getString('name');
        // plugins can make corrections of created data
        $pluginFile = \WGFAKER_PATH . '/plugins/' . $name . '.php';
        if (\file_exists($pluginFile)) {
            require_once($pluginFile);
            $pluginFunc = 'wgfaker_plugin_' . $name;
            if (function_exists($pluginFunc)) {
                call_user_func($pluginFunc);
            }
        }
        break;
    case 'copy_yml':
        $tableObj = $tableHandler->get($tableid);
        $tableName = $tableObj->getVar('name');
        $modDirname = $tableObj->getVar('mod_dirname');
        $sourceFile = \WGFAKER_UPLOAD_YAML_PATH . '/' . $tableObj->getVar('mod_dirname') . '/' . $tableName . '.yml';
        $targetFolder = \XOOPS_ROOT_PATH .  '/modules/'. $modDirname . '/testdata/';
        if (!\file_exists($targetFolder)) {
            \mkdir($targetFolder, '777');
            \chmod($targetFolder, '777');
        }
        $targetFolder .= $GLOBALS['xoopsConfig']['language'] . '/';
        if (!\file_exists($targetFolder)) {
            \mkdir($targetFolder, '777');
            \chmod($targetFolder, '777');
        }
        $targetFile = $targetFolder . $tableName . '.yml';

        \copy($sourceFile, $targetFile);

        \redirect_header('field.php?op=list&amp;mid=' . $mid . '&amp;tableid=' . $tableid, 2, \_AM_WGFAKER_FORM_OK);

        break;
    case 'show_yml':
    case 'show_table':
        $tableObj = $tableHandler->get($tableid);
        $tableName = $tableObj->getVar('name');
        $targetFolder = \WGFAKER_UPLOAD_YAML_PATH . '/' . $tableObj->getVar('mod_dirname');
        // target yaml file/path
        $yamlFile = $targetFolder . '/' . $tableName . '.yml';
        if ('show_yml' == $op) {
            if (\file_exists($yamlFile)) {
                $content = \file_get_contents($yamlFile);
                echo \str_replace(PHP_EOL, '<br>', $content);
            } else {
                echo 'ERROR: file ' . $yamlFile . ' not found!';
            }
            exit;
        } else {
            $templateMain = 'wgfaker_admin_field.tpl';
            $table['name'] = $tableName;
            // read data of yaml file
            $yaml = new Common\Yaml($yamlFile);
            $table = $yaml->parseFileToArray();
            foreach ($table['values'] as $lkey => $lvalue) {
                foreach ($lvalue as $fkey => $fvalue) {
                    if (\strlen($fvalue) > 50) {
                        $table['values'][$lkey][$fkey] = \substr($fvalue, 1, 50) . '...';
                    };
                }
            }

            $GLOBALS['xoopsTpl']->assign('table_yaml', $table);
        }
        break;
    case 'save':
        // Security Check
        if (!$GLOBALS['xoopsSecurity']->check()) {
            \redirect_header('field.php', 3, \implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        if ($fieldId > 0) {
            $fieldObj = $fieldHandler->get($fieldId);
        } else {
            $fieldObj = $fieldHandler->create();
        }
        // Set Vars
        $fieldObj->setVar('tableid', Request::getInt('tableid'));
        $fieldObj->setVar('field', Request::getString('field'));
        $fieldObj->setVar('type', Request::getString('type'));
        $datatypeid = Request::getInt('datatypeid');
        $paramValue = '';
        $fieldObj->setVar('datatypeid', $datatypeid);
        switch ($datatypeid) {
            case Constants::DATATYPE_TEXT_RUNNING:
                $paramValue = \implode('|', [Request::getString('param_text_running'), (int)Request::hasVar('param_text_running_blank')]);
                break;
            case Constants::DATATYPE_INT_RANGE:
                $paramValue = \implode('|', [Request::getString('param_intrangefrom'), Request::getString('param_intrangeto')]);
                break;
            case Constants::DATATYPE_INT_FIXED:
            case Constants::DATATYPE_TEXT_FIXED:
                $paramValue = Request::getString('param_text');
                break;
            case Constants::DATATYPE_DATE_RANGE:
                $daterangefromObj = \DateTime::createFromFormat(\_SHORTDATESTRING, Request::getString('param_daterangefrom'));
                $daterangetoObj = \DateTime::createFromFormat(\_SHORTDATESTRING, Request::getString('param_daterangeto'));
                $paramValue = \implode('|', [$daterangefromObj->getTimestamp(), $daterangetoObj->getTimestamp()]);
                break;
            case Constants::DATATYPE_TABLE_ID:
                $paramValue = Request::getString('param_table_id');
                break;
            case Constants::DATATYPE_CUSTOM_LIST:
                $paramValue = Request::getString('param_custom_list');
                break;
            case 0:
            default:
                break;
        }
        $fieldObj->setVar('params', $paramValue);
        $fieldDatecreatedObj = \DateTime::createFromFormat(\_SHORTDATESTRING, Request::getString('datecreated'));
        $fieldObj->setVar('datecreated', $fieldDatecreatedObj->getTimestamp());
        $fieldObj->setVar('submitter', Request::getInt('submitter'));
        // Insert Data
        if ($fieldHandler->insert($fieldObj)) {
            \redirect_header('field.php?op=list&amp;mid=' . $mid . '&amp;tableid=' . $tableid, 2, \_AM_WGFAKER_FORM_OK);
        }
        // Get Form
        $GLOBALS['xoopsTpl']->assign('error', $fieldObj->getHtmlErrors());
        $form = $fieldObj->getFormField();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;
    case 'edit':
        $templateMain = 'wgfaker_admin_field.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('field.php'));
        $adminObject->addItemButton(\_AM_WGFAKER_ADD_FIELD, 'field.php?op=new');
        $adminObject->addItemButton(\_AM_WGFAKER_LIST_FIELD, 'field.php', 'list');
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
        // Get Form
        $fieldObj = $fieldHandler->get($fieldId);
        $fieldObj->start = $start;
        $fieldObj->limit = $limit;
        $fieldObj->mid = $mid;
        $form = $fieldObj->getFormField();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());

        $GLOBALS['xoopsTpl']->assign('constFixedText', Constants::DATATYPE_TEXT_FIXED);
        $GLOBALS['xoopsTpl']->assign('constFixedNumber', Constants::DATATYPE_INT_FIXED);
        $GLOBALS['xoopsTpl']->assign('constTextRunning', Constants::DATATYPE_TEXT_RUNNING);
        $GLOBALS['xoopsTpl']->assign('constIntRange', Constants::DATATYPE_INT_RANGE);
        $GLOBALS['xoopsTpl']->assign('constDateRange', Constants::DATATYPE_DATE_RANGE);
        $GLOBALS['xoopsTpl']->assign('constTableId', Constants::DATATYPE_TABLE_ID);
        $GLOBALS['xoopsTpl']->assign('constCustomList', Constants::DATATYPE_CUSTOM_LIST);

        break;
    case 'delete':
        $templateMain = 'wgfaker_admin_field.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('field.php'));
        $fieldObj = $fieldHandler->get($fieldId);
        $Tableid = $fieldObj->getVar('tableid');
        if (isset($_REQUEST['ok']) && 1 == $_REQUEST['ok']) {
            if (!$GLOBALS['xoopsSecurity']->check()) {
                \redirect_header('field.php', 3, \implode(', ', $GLOBALS['xoopsSecurity']->getErrors()));
            }
            if ($fieldHandler->delete($fieldObj)) {
                \redirect_header('field.php', 3, \_AM_WGFAKER_FORM_DELETE_OK);
            } else {
                $GLOBALS['xoopsTpl']->assign('error', $fieldObj->getHtmlErrors());
            }
        } else {
            $customConfirm = new Common\Confirm(
                ['ok' => 1, 'id' => $fieldId, 'start' => $start, 'limit' => $limit, 'op' => 'delete'],
                $_SERVER['REQUEST_URI'],
                \sprintf(\_AM_WGFAKER_FORM_SURE_DELETE, $fieldObj->getVar('tableid')));
            $form = $customConfirm->getFormConfirm();
            $GLOBALS['xoopsTpl']->assign('form', $form->render());
        }
        break;
}
require __DIR__ . '/footer.php';
