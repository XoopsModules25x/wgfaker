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
 * Class Object Table
 */
class Table extends \XoopsObject
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
     * Constructor
     *
     * @param null
     */
    public function __construct()
    {
        $this->initVar('id', \XOBJ_DTYPE_INT);
        $this->initVar('mid', \XOBJ_DTYPE_INT);
        $this->initVar('mod_dirname', \XOBJ_DTYPE_TXTBOX);
        $this->initVar('name', \XOBJ_DTYPE_TXTBOX);
        $this->initVar('skip', \XOBJ_DTYPE_INT);
        $this->initVar('lines', \XOBJ_DTYPE_INT);
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
    public function getNewInsertedIdTable()
    {
        return $GLOBALS['xoopsDB']->getInsertId();
    }

    /**
     * @public function getForm
     * @param bool $action
     * @return \XoopsThemeForm
     */
    public function getFormTable($action = false)
    {
        if (!$action) {
            $action = $_SERVER['REQUEST_URI'];
        }
        // Title
        $title = $this->isNew() ? \_AM_WGFAKER_TABLE_ADD : \_AM_WGFAKER_TABLE_EDIT;
        // Get Theme Form
        \xoops_load('XoopsFormLoader');
        $form = new \XoopsThemeForm($title, 'form', $action, 'post', true);
        $form->setExtra('enctype="multipart/form-data"');
        // Form Text Mid
        $form->addElement(new \XoopsFormText(\_AM_WGFAKER_TABLE_MID, 'mid', 50, 255, $this->getVar('mid')));
        // Form Text Module
        $form->addElement(new \XoopsFormText(\_AM_WGFAKER_TABLE_MOD_DIRNAME, 'mod_dirname', 50, 255, $this->getVar('mod_dirname')));
        // Form Text Name
        $form->addElement(new \XoopsFormText(\_AM_WGFAKER_TABLE_NAME, 'name', 50, 255, $this->getVar('name')));
        // Form Text Name
        $lines = $this->isNew() ? 20 : $this->getVar('lines');
        $linesText = new \XoopsFormText(\_AM_WGFAKER_TABLE_LINES, 'lines', 50, 255, $lines);
        $linesText->setDescription(\_AM_WGFAKER_TABLE_LINES_DESC);
        $form->addElement($linesText);
        // Form Radio Yes/No Skip
        //$Skip = $this->isNew() ?: $this->getVar('skip');
        //$form->addElement(new \XoopsFormRadioYN(\_AM_WGFAKER_TABLE_SKIP, 'skip', $Skip));
        // Form Text Date Select Datecreated
        $Datecreated = $this->isNew() ? \time() : $this->getVar('datecreated');
        $form->addElement(new \XoopsFormTextDateSelect(\_AM_WGFAKER_TABLE_DATECREATED, 'datecreated', '', $Datecreated));
        // Form Select User Submitter
        $uidCurrent = \is_object($GLOBALS['xoopsUser']) ? $GLOBALS['xoopsUser']->uid() : 0;
        $Submitter = $this->isNew() ? $uidCurrent : $this->getVar('submitter');
        $form->addElement(new \XoopsFormSelectUser(\_AM_WGFAKER_TABLE_SUBMITTER, 'submitter', false, $Submitter));
        // To Save
        $form->addElement(new \XoopsFormHidden('op', 'save'));
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
    public function getValuesTable($keys = null, $format = null, $maxDepth = null)
    {
        $ret = $this->getValues($keys, $format, $maxDepth);
        $ret['skip_text']        = (int)$this->getVar('skip') > 0 ? _YES : _NO;
        $ret['datecreated_text'] = \formatTimestamp($this->getVar('datecreated'), 'm');
        $ret['submitter_text']   = \XoopsUser::getUnameFromId($this->getVar('submitter'));
        return $ret;
    }

    /**
     * Returns an array representation of the object
     *
     * @return array
     */
    public function toArrayTable()
    {
        $ret = [];
        $vars = $this->getVars();
        foreach (\array_keys($vars) as $var) {
            $ret[$var] = $this->getVar($var);
        }
        return $ret;
    }
}
