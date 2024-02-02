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
 * @author       Goffy - Wedega - Email:webmaster@wedega.com - Website:https://xoops.wedega.com
 */

// 
$moduleDirName      = \basename(__DIR__);
$moduleDirNameUpper = \mb_strtoupper($moduleDirName);
// ------------------- Informations ------------------- //
$modversion = [
    'name'                => \_MI_WGFAKER_NAME,
    'version'             => '1.0.3',
    'release'             => '14.03.2023',
    'release_date'        => '2023/02/28', // format: yyyy/mm/dd
    'module_status'       => 'RC1',
    'description'         => \_MI_WGFAKER_DESC,
    'author'              => 'Goffy - Wedega',
    'author_mail'         => 'webmaster@wedega.com',
    'author_website_url'  => 'https://xoops.wedega.com',
    'author_website_name' => 'XOOPS Project on Wedega',
    'credits'             => 'Goffy, XOOPS Development Team',
    'license'             => 'GPL 2.0 or later',
    'license_url'         => 'https://www.gnu.org/licenses/gpl-3.0.en.html',
    'help'                => 'page=help',
    'release_info'        => 'release_info',
    'release_file'        => \XOOPS_URL . '/modules/wgfaker/docs/release_info file',
    'manual'              => 'link to manual file',
    'manual_file'         => \XOOPS_URL . '/modules/wgfaker/docs/install.txt',
    'min_php'             => '7.4',
    'min_xoops'           => '2.5.11 Stable',
    'min_admin'           => '1.2',
    'min_db'              => ['mysql' => '5.5', 'mysqli' => '5.5'],
    'image'               => 'assets/images/logoModule.png',
    'dirname'             => \basename(__DIR__),
    'dirmoduleadmin'      => 'Frameworks/moduleclasses/moduleadmin',
    'sysicons16'          => '../../Frameworks/moduleclasses/icons/16',
    'sysicons32'          => '../../Frameworks/moduleclasses/icons/32',
    'modicons16'          => 'assets/icons/16',
    'modicons32'          => 'assets/icons/32',
    'demo_site_url'       => 'https://xoops.org',
    'demo_site_name'      => 'XOOPS Demo Site',
    'support_url'         => 'https://xoops.org/modules/newbb',
    'support_name'        => 'Support Forum',
    'module_website_url'  => 'www.xoops.org',
    'module_website_name' => 'XOOPS Project',
    'system_menu'         => 1,
    'hasAdmin'            => 1,
    'hasMain'             => 0,
    'adminindex'          => 'admin/index.php',
    'adminmenu'           => 'admin/menu.php',
    'onInstall'           => 'include/install.php',
    'onUninstall'         => 'include/uninstall.php',
    'onUpdate'            => 'include/update.php',
];
// ------------------- Templates ------------------- //
$modversion['templates'] = [
    // Admin templates
    ['file' => 'wgfaker_admin_about.tpl', 'description' => '', 'type' => 'admin'],
    ['file' => 'wgfaker_admin_header.tpl', 'description' => '', 'type' => 'admin'],
    ['file' => 'wgfaker_admin_index.tpl', 'description' => '', 'type' => 'admin'],
    ['file' => 'wgfaker_admin_clone.tpl', 'description' => '', 'type' => 'admin'],
    ['file' => 'wgfaker_admin_footer.tpl', 'description' => '', 'type' => 'admin'],
    ['file' => 'wgfaker_admin_date.tpl', 'description' => '', 'type' => 'admin'],
    ['file' => 'wgfaker_admin_datatype.tpl', 'description' => '', 'type' => 'admin'],
    ['file' => 'wgfaker_admin_field.tpl', 'description' => '', 'type' => 'admin'],
    ['file' => 'wgfaker_admin_table.tpl', 'description' => '', 'type' => 'admin'],

];
// ------------------- Mysql ------------------- //
$modversion['sqlfile']['mysql'] = 'sql/mysql.sql';
// Tables
$modversion['tables'] = [
    'wgfaker_field',
    'wgfaker_datatype',
    'wgfaker_table',
];
// ------------------- Config ------------------- //
// Editor : max characters admin area
$modversion['config'][] = [
    'name'        => 'editor_maxchar',
    'title'       => '\_MI_WGFAKER_EDITOR_MAXCHAR',
    'description' => '\_MI_WGFAKER_EDITOR_MAXCHAR_DESC',
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'default'     => 50,
];
// Admin pager
$modversion['config'][] = [
    'name'        => 'adminpager',
    'title'       => '\_MI_WGFAKER_ADMIN_PAGER',
    'description' => '\_MI_WGFAKER_ADMIN_PAGER_DESC',
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'default'     => 50,
];
// Number field
$modversion['config'][] = [
    'name'        => 'numb_lines',
    'title'       => '\_MI_WGFAKER_NUMB_LINES',
    'description' => '\_MI_WGFAKER_NUMB_LINES_DESC',
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'default'     => 20,
];
// Make Sample button visible?
$modversion['config'][] = [
    'name'        => 'displaySampleButton',
    'title'       => 'CO_' . $moduleDirNameUpper . '_' . 'SHOW_SAMPLE_BUTTON',
    'description' => 'CO_' . $moduleDirNameUpper . '_' . 'SHOW_SAMPLE_BUTTON_DESC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 1,
];
// Maintained by
$modversion['config'][] = [
    'name'        => 'maintainedby',
    'title'       => '\_MI_WGFAKER_MAINTAINEDBY',
    'description' => '\_MI_WGFAKER_MAINTAINEDBY_DESC',
    'formtype'    => 'textbox',
    'valuetype'   => 'text',
    'default'     => 'https://xoops.org/modules/newbb',
];
