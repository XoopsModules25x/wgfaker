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
$op    = Request::getCmd('op', 'list');
$fieldId = Request::getInt('id');
$mid = Request::getInt('mid');
$tableid = Request::getInt('tableid');

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
                    $targetFolder = \WGFAKER_UPLOAD_YAML_PATH . '/' . $tableAll[$t]->getVar('module');
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
            $GLOBALS['xoopsTpl']->assign('error', \_AM_WGFAKER_THEREARENT_FIELD);
        }
        break;
    case 'reread':
        $tableObj = $tableHandler->get($tableid);
        $fieldHandler->readFields($mid, $tableid, $tableObj->getVar('name'), true);
        \redirect_header('field.php?op=list&amp;mid=' . $mid, 2, \_AM_WGFAKER_FORM_OK);
        break;
    case 'generate':
        $tableObj = $tableHandler->get($tableid);
        $moduleName = $tableObj->getVar('module');
        $tableName = $tableObj->getVar('name');
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
        foreach (\array_keys($fieldAll) as $f) {
            $fields[$f] = ['name' => $fieldAll[$f]->getVar('name'), 'datatypeid' => $fieldAll[$f]->getVar('datatypeid')];
        }
        $yamlLines = [];
        $intend = '    ';
        for ($i = 1; $i <= 20; $i++) {
            $yamlLines[] = '-' . PHP_EOL;
            foreach($fields as $field) {
                if (Constants::DATATYPE_AUTOINCREMENT == $field['datatypeid']) {
                    $yamlLines[] = $intend . $field['name'] . ': ' . $i . PHP_EOL;
                } else {
                    $generator = new Generator($field['datatypeid']);
                    $yamlLines[] = $intend . $field['name'] . ': ' . $generator->renderer() . PHP_EOL;
                }

            }
        }

        // create new file and write array into this file
        $yaml = new Common\Yaml($targetYaml);
        if ($yaml->createFile($yamlLines)) {
            \redirect_header('field.php?op=list&amp;mid=' . $mid . '&amp;tableid=' . $tableid, 2, \_AM_WGFAKER_FORM_OK);
        }
        break;
    case 'show_yml':
    case 'show_table':
        $tableObj = $tableHandler->get($tableid);
        $tableName = $tableObj->getVar('name');
        $targetFolder = \WGFAKER_UPLOAD_YAML_PATH . '/' . $tableObj->getVar('module');
        // target yaml file/path
        $yamlFile = $targetFolder . '/' . $tableName . '.yml';
        if ('show_yml' == $op) {
            if (\file_exists($yamlFile)) {
                $content = \file_get_contents($yamlFile);
                echo \str_replace(PHP_EOL, '<br>', $content);
            } else {
                echo 'ERROR: file ' . $yamlFile . ' not foud!';
            }
            exit;
        } else {
            $templateMain = 'wgfaker_admin_field.tpl';
            $table['name'] = $tableName;
            // read data of yaml file
            $yaml = new Common\Yaml($yamlFile);
            $table = $yaml->parseFileToArray();

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
        $fieldObj->setVar('datatypeid', Request::getInt('datatypeid'));
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
