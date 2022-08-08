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
 * Class Object Handler Table
 */
class TableHandler extends \XoopsPersistableObjectHandler
{
    /**
     * Constructor
     *
     * @param \XoopsDatabase $db
     */
    public function __construct(\XoopsDatabase $db)
    {
        parent::__construct($db, 'wgfaker_table', Table::class, 'id', 'mod_dirname');
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
     * @param int $id field id
     * @param null fields
     * @return \XoopsObject|null reference to the {@link Get} object
     */
    public function get($id = null, $fields = null)
    {
        return parent::get($id, $fields);
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
     * Get Count Table in the database
     * @param int    $start
     * @param int    $limit
     * @param string $sort
     * @param string $order
     * @return int
     */
    public function getCountTable($start = 0, $limit = 0, $sort = 'id ASC, module', $order = 'ASC')
    {
        $crCountTable = new \CriteriaCompo();
        $crCountTable = $this->getTableCriteria($crCountTable, $start, $limit, $sort, $order);
        return $this->getCount($crCountTable);
    }

    /**
     * Get All Table in the database
     * @param int    $start
     * @param int    $limit
     * @param string $sort
     * @param string $order
     * @return array
     */
    public function getAllTable($start = 0, $limit = 0, $sort = 'id ASC, module', $order = 'ASC')
    {
        $crAllTable = new \CriteriaCompo();
        $crAllTable = $this->getTableCriteria($crAllTable, $start, $limit, $sort, $order);
        return $this->getAll($crAllTable);
    }

    /**
     * Get Criteria Table
     * @param        $crTable
     * @param int    $start
     * @param int    $limit
     * @param string $sort
     * @param string $order
     * @return int
     */
    private function getTableCriteria($crTable, $start, $limit, $sort, $order)
    {
        $crTable->setStart($start);
        $crTable->setLimit($limit);
        $crTable->setSort($sort);
        $crTable->setOrder($order);
        return $crTable;
    }

    /**
     * @public function getForm
     * @param int $mid
     * @return \XoopsSimpleForm
     */
    public function getFormSelect($mid)
    {
        $action = $_SERVER['REQUEST_URI'];

        // Get Theme Form
        \xoops_load('XoopsFormLoader');
        $form = new Wgfaker\Forms\FormInline('', 'form', $action, 'post', true);
        $form->setExtra('enctype="multipart/form-data"');
        // Form Select Module
        $modulesHandler = \xoops_getHandler('module');
        $moduleSelect = new \XoopsFormSelect(\_AM_WGFAKER_SELECT_MODULE, 'mid', $mid);
        $moduleSelect->addOption('');
        $modulesArr = $modulesHandler->getObjects();
        foreach ($modulesArr as $module) {
            if (1 === (int)$module->getVar('isactive')) {
                $moduleSelect->addOption($module->getVar('mid'), $module->getVar('dirname'));
            }
        }
        $moduleSelect->setExtra(' onchange="submit();return true;"');
        $form->addElement($moduleSelect);
        $cbReadLines = new \XoopsFormCheckBox(\_AM_WGFAKER_READ_LINES, 'read_lines', true);
        $cbReadLines->addOption(1, ' ');
        $form->addElement($cbReadLines);

        // To Save
        $form->addElement(new \XoopsFormHidden('op', 'list'));
        //$form->addElement(new \XoopsFormButton('', 'submit',  \_SUBMIT, 'submit'));
        $form->addElement(new \XoopsFormButton('', 'read',  \_AM_WGFAKER_READ_TABLES, 'submit'));
        return $form;
    }


    /**
     * @param $table
     *
     * @return bool
     */
    public function tableExists($table)
    {
        $table = \trim($table);
        $ret   = false;
        if ($table != '') {
            $this->db->connect();
            $sql = 'SELECT COUNT(*) FROM ' . $GLOBALS['xoopsDB']->prefix($table);
            $ret = $GLOBALS['xoopsDB']->query($sql);
            $ret = !empty($ret);  //return false on error or $table not found
        }

        return $ret;
    }
}
