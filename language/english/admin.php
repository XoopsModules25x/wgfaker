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
\define('_AM_WGFAKER_NOSELECTED_MODULE', 'No module selected');
\define('_AM_WGFAKER_NOSELECTED_TABLE', 'No table selected');
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
\define('_AM_WGFAKER_READ_LINES', 'Read number of lines of tables');
\define('_AM_WGFAKER_SELECT_MODULE', 'Select Module');
\define('_AM_WGFAKER_SELECT_TABLE', 'Select Table');
\define('_AM_WGFAKER_TESTDATA_GENERATE', 'Generate testdata');
\define('_AM_WGFAKER_TESTDATA_SHOW_TMP', 'Show testdata table');
\define('_AM_WGFAKER_TESTDATA_SHOW_YML', 'Show testdata yaml');
\define('_AM_WGFAKER_TESTDATA_COPY_YML', 'Copy yaml files to module testdata folder');
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
\define('_AM_WGFAKER_FIELD_PARAMS', 'Parameters');
\define('_AM_WGFAKER_FIELD_PARAM_TEXT', 'Enter text or value');
\define('_AM_WGFAKER_FIELD_PARAM_TEXT_RUNNING', 'Enter text');
\define('_AM_WGFAKER_FIELD_PARAM_TEXT_RUNNING_CB', 'Add blank space between your text and a running number');
\define('_AM_WGFAKER_FIELD_PARAM_TEXT_RUNNING_LABEL', 'After text a running number will be added');
\define('_AM_WGFAKER_FIELD_PARAM_INTRANGEFROM', 'Number range from');
\define('_AM_WGFAKER_FIELD_PARAM_INTRANGETO', 'to');
\define('_AM_WGFAKER_FIELD_PARAM_DATERANGEFROM', 'Date range from');
\define('_AM_WGFAKER_FIELD_PARAM_DATERANGETO', 'to');
\define('_AM_WGFAKER_FIELD_PARAM_TABLE_ID', 'Select table column');
\define('_AM_WGFAKER_FIELD_PARAM_CUSTOM_LIST', 'Enter values');
\define('_AM_WGFAKER_FIELD_PARAM_CUSTOM_LIST_LABEL', 'use | as delimiter');
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
// Description of Datatype
\define('_AM_WGFAKER_DATATYPE_AUTOINCREMENT', '{Id for table}');
\define('_AM_WGFAKER_DATATYPE_INTEGER', '{random Integer}');
\define('_AM_WGFAKER_DATATYPE_INT_RANGE', '{random integer within defined range}');
\define('_AM_WGFAKER_DATATYPE_INT_RUNNING', '{running integer, start with 1}');
\define('_AM_WGFAKER_DATATYPE_INT_FIXED', '{fixed defined number}');
\define('_AM_WGFAKER_DATATYPE_FLOAT', '{random Float}');
\define('_AM_WGFAKER_DATATYPE_TEXT', '{random Text}');
\define('_AM_WGFAKER_DATATYPE_TEXT_FIXED', '{fixed defined text}');
\define('_AM_WGFAKER_DATATYPE_TEXT_RUNNING', '{your defined text} {running number}');
\define('_AM_WGFAKER_DATATYPE_YES_NO', '{random 0 or 1}');
\define('_AM_WGFAKER_DATATYPE_FIRSTLASTNAME', '{random firstname + random lastname}');
\define('_AM_WGFAKER_DATATYPE_EMAIL', '{random firstname}.{random lastname}@domain.com');
\define('_AM_WGFAKER_DATATYPE_DATE', '{random date}');
\define('_AM_WGFAKER_DATATYPE_DATE_RANGE', '{random date within defined range}');
\define('_AM_WGFAKER_DATATYPE_DATE_NOW', '{current date}');
\define('_AM_WGFAKER_DATATYPE_UID', '{random uid of XOOPS users}');
\define('_AM_WGFAKER_DATATYPE_IP4', '{random IP4}');
\define('_AM_WGFAKER_DATATYPE_IP6', '{random IP6}');
\define('_AM_WGFAKER_DATATYPE_PHONE', '{random Phone number}');
\define('_AM_WGFAKER_DATATYPE_COUNTRY_CODE', '{random country code}');
\define('_AM_WGFAKER_DATATYPE_IMAGE', 'blank.gif');
\define('_AM_WGFAKER_DATATYPE_TABLE_ID', '{random id of selected table}');
\define('_AM_WGFAKER_DATATYPE_PARENT_ID', '{0 or random id of selected table}');
\define('_AM_WGFAKER_DATATYPE_FILE', 'myfile.txt');
\define('_AM_WGFAKER_DATATYPE_COLOR', '{random color}');
\define('_AM_WGFAKER_DATATYPE_UUID', '{random uuid}');
\define('_AM_WGFAKER_DATATYPE_LANG_CODE', '{random language}');
\define('_AM_WGFAKER_DATATYPE_CUSTOM_LIST', '{random value of custom list}');
// Table add/edit
\define('_AM_WGFAKER_TABLE_ADD', 'Add Table');
\define('_AM_WGFAKER_TABLE_EDIT', 'Edit Table');
// Elements of Table
\define('_AM_WGFAKER_TABLE_ID', 'Id');
\define('_AM_WGFAKER_TABLE_MID', 'Module Id');
\define('_AM_WGFAKER_TABLE_MOD_DIRNAME', 'Module');
\define('_AM_WGFAKER_TABLE_NAME', 'Name');
\define('_AM_WGFAKER_TABLE_SKIP', 'Skip');
\define('_AM_WGFAKER_TABLE_LINES', 'Number of lines');
\define('_AM_WGFAKER_TABLE_LINES_DESC', 'Decide how many lines sjhould be created for this table');
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
