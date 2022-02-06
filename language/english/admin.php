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

require_once __DIR__ . '/common.php';

// ---------------- Admin Index ----------------
\define('_AM_WGFAKER_STATISTICS', 'Statistics');
// There are
\define('_AM_WGFAKER_THEREARE_FIELD', "There are <span class='bold'>%s</span> field in the database");
\define('_AM_WGFAKER_THEREARE_DATATYPE', "There are <span class='bold'>%s</span> datatype in the database");
\define('_AM_WGFAKER_THEREARE_TABLE', "There are <span class='bold'>%s</span> table in the database");
// ---------------- Admin Files ----------------
// There aren't
\define('_AM_WGFAKER_THEREARENT_FIELD', "There aren't fields");
\define('_AM_WGFAKER_THEREARENT_DATATYPE', "There aren't datatypes");
\define('_AM_WGFAKER_THEREARENT_TABLE', "There are currently no tables processed for selected module. Please press 'Read tables'");
// Save/Delete
\define('_AM_WGFAKER_FORM_OK', 'Successfully saved');
\define('_AM_WGFAKER_FORM_DELETE_OK', 'Successfully deleted');
\define('_AM_WGFAKER_FORM_SURE_DELETE', "Are you sure to delete: <b><span style='color : Red;'>%s </span></b>");
// Buttons
\define('_AM_WGFAKER_ADD_FIELD', 'Add New Field');
\define('_AM_WGFAKER_ADD_DATATYPE', 'Add New Datatype');
\define('_AM_WGFAKER_DATATYPE_CREATEDEFAULT', 'Create default datatype set');
\define('_AM_WGFAKER_DATATYPE_SURE_DELETE', 'Pay attention! All exising question types will be delete! Are you sure to delete?');
\define('_AM_WGFAKER_ADD_TABLE', 'Add New Table');
\define('_AM_WGFAKER_READ_TABLES', 'Read tables and fields');
\define('_AM_WGFAKER_READ_FIELDS', 'Read fields once more');
\define('_AM_WGFAKER_SELECT_MODULE', 'Select Module');
\define('_AM_WGFAKER_SELECT_TABLE', 'Select Table');
\define('_AM_WGFAKER_TESTDATA_GENERATE', 'Generate testdata');
\define('_AM_WGFAKER_TESTDATA_SHOW_TMP', 'Show testdata table');
\define('_AM_WGFAKER_TESTDATA_SHOW_YML', 'Show testdata yaml');
// Lists
\define('_AM_WGFAKER_LIST_FIELD', 'List of Field');
\define('_AM_WGFAKER_LIST_DATATYPE', 'List of Datatype');
\define('_AM_WGFAKER_LIST_TABLE', 'List of Table');
// ---------------- Admin Classes ----------------
// Field add/edit
\define('_AM_WGFAKER_FIELD_ADD', 'Add Field');
\define('_AM_WGFAKER_FIELD_EDIT', 'Edit Field');
// Elements of Field
\define('_AM_WGFAKER_FIELD_ID', 'Id');
\define('_AM_WGFAKER_FIELD_TABLEID', 'Table');
\define('_AM_WGFAKER_FIELD_NAME', 'Name');
\define('_AM_WGFAKER_FIELD_TYPE', 'Type');
\define('_AM_WGFAKER_FIELD_DATATYPEID', 'Datatype');
\define('_AM_WGFAKER_FIELD_DATECREATED', 'Datecreated');
\define('_AM_WGFAKER_FIELD_SUBMITTER', 'Submitter');
// Datatype add/edit
\define('_AM_WGFAKER_DATATYPE_ADD', 'Add Datatype');
\define('_AM_WGFAKER_DATATYPE_EDIT', 'Edit Datatype');
// Elements of Datatype
\define('_AM_WGFAKER_DATATYPE_ID', 'Id');
\define('_AM_WGFAKER_DATATYPE_NAME', 'Name');
\define('_AM_WGFAKER_DATATYPE_VALUES', 'Values');
\define('_AM_WGFAKER_DATATYPE_WEIGHT', 'Weight');
\define('_AM_WGFAKER_DATATYPE_DATECREATED', 'Datecreated');
\define('_AM_WGFAKER_DATATYPE_SUBMITTER', 'Submitter');
// Table add/edit
\define('_AM_WGFAKER_TABLE_ADD', 'Add Table');
\define('_AM_WGFAKER_TABLE_EDIT', 'Edit Table');
// Elements of Table
\define('_AM_WGFAKER_TABLE_ID', 'Id');
\define('_AM_WGFAKER_TABLE_MID', 'Module Id');
\define('_AM_WGFAKER_TABLE_MODULE', 'Module');
\define('_AM_WGFAKER_TABLE_NAME', 'Name');
\define('_AM_WGFAKER_TABLE_SKIP', 'Skip');
\define('_AM_WGFAKER_TABLE_DATECREATED', 'Datecreated');
\define('_AM_WGFAKER_TABLE_SUBMITTER', 'Submitter');
// General
\define('_AM_WGFAKER_FORM_ACTION', 'Action');
\define('_AM_WGFAKER_FORM_DELETE', 'Clear');
// Clone feature
\define('_AM_WGFAKER_CLONE', 'Clone');
\define('_AM_WGFAKER_CLONE_DSC', 'Cloning a module has never been this easy! Just type in the name you want for it and hit submit button!');
\define('_AM_WGFAKER_CLONE_TITLE', 'Clone %s');
\define('_AM_WGFAKER_CLONE_NAME', 'Choose a name for the new module');
\define('_AM_WGFAKER_CLONE_NAME_DSC', 'Do not use special characters! <br>Do not choose an existing module dirname or database table name!');
\define('_AM_WGFAKER_CLONE_INVALIDNAME', 'ERROR: Invalid module name, please try another one!');
\define('_AM_WGFAKER_CLONE_EXISTS', 'ERROR: Module name already taken, please try another one!');
\define('_AM_WGFAKER_CLONE_CONGRAT', 'Congratulations! %s was sucessfully created!<br>You may want to make changes in language files.');
\define('_AM_WGFAKER_CLONE_IMAGEFAIL', 'Attention, we failed creating the new module logo. Please consider modifying assets/images/logo_module.png manually!');
\define('_AM_WGFAKER_CLONE_FAIL', 'Sorry, we failed in creating the new clone. Maybe you need to temporally set write permissions (CHMOD 777) to modules folder and try again.');
// ---------------- Admin Others ----------------
\define('_AM_WGFAKER_ABOUT_MAKE_DONATION', 'Submit');
\define('_AM_WGFAKER_DONATION_AMOUNT', 'Donation Amount');
\define('_AM_WGFAKER_MAINTAINEDBY', ' is maintained by ');
// ---------------- End ----------------
