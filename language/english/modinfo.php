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

// ---------------- Admin Main ----------------
\define('_MI_WGFAKER_NAME', 'wgFaker');
\define('_MI_WGFAKER_DESC', 'This module generate faked test data and save them as yaml file');
// ---------------- Admin Menu ----------------
\define('_MI_WGFAKER_ADMENU1', 'Dashboard');
\define('_MI_WGFAKER_ADMENU2', 'Table');
\define('_MI_WGFAKER_ADMENU3', 'Field');
\define('_MI_WGFAKER_ADMENU4', 'Datatype');
\define('_MI_WGFAKER_ADMENU5', 'Clone');
\define('_MI_WGFAKER_ADMENU6', 'Feedback');
\define('_MI_WGFAKER_ABOUT', 'About');
// ---------------- Admin Nav ----------------
\define('_MI_WGFAKER_ADMIN_PAGER', 'Admin pager');
\define('_MI_WGFAKER_ADMIN_PAGER_DESC', 'Admin per page list');
// Config
\define('_MI_WGFAKER_EDITOR_MAXCHAR', 'Text max characters');
\define('_MI_WGFAKER_EDITOR_MAXCHAR_DESC', 'Max characters for showing text of a textarea or editor field in admin area');
\define('_MI_WGFAKER_NUMB_LINES', 'Number of lines');
\define('_MI_WGFAKER_NUMB_LINES_DESC', 'Define how many lines will be generated in the output dataset');
\define('_MI_WGFAKER_MAINTAINEDBY', 'Maintained By');
\define('_MI_WGFAKER_MAINTAINEDBY_DESC', 'Allow url of support site or community');
// ---------------- End ----------------
