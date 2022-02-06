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


/**
 * Class Object Handler Field
 */
class FieldHandler extends \XoopsPersistableObjectHandler
{
    /**
     * Constructor
     *
     * @param \XoopsDatabase $db
     */
    public function __construct(\XoopsDatabase $db)
    {
        parent::__construct($db, 'wgfaker_field', Field::class, 'id', 'tableid');
    }

    /**
     * @param bool $isNew
     *
     * @return object
     */
    public function create($isNew = true)
    {
        return parent::create($isNew);
    }

    /**
     * retrieve a field
     *
     * @param int $i field id
     * @param null fields
     * @return \XoopsObject|null reference to the {@link Get} object
     */
    public function get($i = null, $fields = null)
    {
        return parent::get($i, $fields);
    }

    /**
     * get inserted id
     *
     * @param null
     * @return int reference to the {@link Get} object
     */
    public function getInsertId()
    {
        return $this->db->getInsertId();
    }

    /**
     * Get Count Field in the database
     * @param int    $start
     * @param int    $limit
     * @param string $sort
     * @param string $order
     * @return int
     */
    public function getCountField($start = 0, $limit = 0, $sort = 'id ASC, tableid', $order = 'ASC')
    {
        $crCountField = new \CriteriaCompo();
        $crCountField = $this->getFieldCriteria($crCountField, $start, $limit, $sort, $order);
        return $this->getCount($crCountField);
    }

    /**
     * Get All Field in the database
     * @param int    $start
     * @param int    $limit
     * @param string $sort
     * @param string $order
     * @return array
     */
    public function getAllField($start = 0, $limit = 0, $sort = 'id ASC, tableid', $order = 'ASC')
    {
        $crAllField = new \CriteriaCompo();
        $crAllField = $this->getFieldCriteria($crAllField, $start, $limit, $sort, $order);
        return $this->getAll($crAllField);
    }



    public function readFields($mid, $tableid, $table, $overwrite = false) {
        $helper = \XoopsModules\Wgfaker\Helper::getInstance();
        $fieldHandler = $helper->getHandler('Field');
        $datatypeHandler = $helper->getHandler('Datatype');

        $sql    = 'SHOW COLUMNS FROM ' . $GLOBALS['xoopsDB']->prefix((string)$table);
        $result = $GLOBALS['xoopsDB']->queryf($sql);

        if (!$result instanceof \mysqli_result) {
            \trigger_error($GLOBALS['xoopsDB']->error());
        }
        $i = 0;
        while (false !== ($data = $GLOBALS['xoopsDB']->fetchBoth($result))) {
            $i++;
            $field = $data['Field'];
            $type  = $data['Type'];
            $h = \mb_strpos($type, '(');
            if (false !== $h) {
                $type = \mb_substr($type, 0, $h);
            }
            $crField = new \CriteriaCompo();
            $crField->add(new \Criteria('tableid', $tableid));
            $crField->add(new \Criteria('name', $field));
            $fieldCount = $fieldHandler->getCount($crField);
            if (1 == $fieldCount && $overwrite) {
                $fieldHandler->deleteAll($crField);
                $fieldCount = 0;
            }
            if (0 == $fieldCount) {
                $fieldObj = $fieldHandler->create();
                $fieldObj->setVar('mid', $mid);
                $fieldObj->setVar('tableid', $tableid);
                $fieldObj->setVar('name', $field);
                $fieldObj->setVar('type', $type);
                $fieldObj->setVar('datatypeid', $datatypeHandler->getDatatype($i, $field, $type));
                $fieldObj->setVar('datecreated', \time());
                $fieldObj->setVar('submitter', $GLOBALS['xoopsUser']->uid());
                // Insert Data
                $fieldHandler->insert($fieldObj);
                unset($fieldObj);
            }
        }
    }

    /**
     * Get Criteria Field
     * @param        $crField
     * @param int    $start
     * @param int    $limit
     * @param string $sort
     * @param string $order
     * @return int
     */
    private function getFieldCriteria($crField, $start, $limit, $sort, $order)
    {
        $crField->setStart($start);
        $crField->setLimit($limit);
        $crField->setSort($sort);
        $crField->setOrder($order);
        return $crField;
    }

    /**
     * @public function getForm
     * @param int $mid
     * @return \XoopsSimpleForm
     */
    public function getFormCombo($mid, $tableid)
    {
        $helper = \XoopsModules\Wgfaker\Helper::getInstance();
        $tableHandler = $helper->getHandler('Table');
        $action = $_SERVER['REQUEST_URI'];

        // Get Theme Form
        \xoops_load('XoopsFormLoader');
        $form = new Wgfaker\Forms\FormInline('', 'form', $action, 'post', true);
        $form->setExtra('enctype="multipart/form-data"');
        // Form Select Module
        $modulesHandler = \xoops_getHandler('module');
        $moduleSelect = new \XoopsFormSelect(\_AM_WGFAKER_SELECT_MODULE, 'mid', $mid, 5);
        $moduleSelect->addOption('');
        $moduleSelect->addOptionArray($modulesHandler->getList());
        $moduleSelect->setExtra(' onchange="submit();return true;"');
        $form->addElement($moduleSelect);

        $crTable = new \CriteriaCompo();
        $crTable->add(new \Criteria('mid', $mid));
        if ($tableHandler->getCount($crTable) > 0) {
            $tableSelect = new \XoopsFormSelect(\_AM_WGFAKER_SELECT_MODULE, 'tableid', $tableid, 5);
            $tableSelect->addOption('');
            $tableAll = $tableHandler->getAll($crTable);
            foreach (\array_keys($tableAll) as $t) {
                $tableSelect->addOption($t, $tableAll[$t]->getVar('name'));
            }
            $tableSelect->setExtra(' onchange="submit();return true;"');
            $form->addElement($tableSelect);
        }

        return $form;
    }
}
