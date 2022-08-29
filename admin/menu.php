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

$dirname       = \basename(\dirname(__DIR__));
$moduleHandler = \xoops_getHandler('module');
$xoopsModule   = \XoopsModule::getByDirname($dirname);
$moduleInfo    = $moduleHandler->get($xoopsModule->getVar('mid'));
$sysPathIcon32 = $moduleInfo->getInfo('sysicons32');

$adminmenu[] = [
    'title' => \_MI_WGFAKER_ADMENU1,
    'link' => 'admin/index.php',
    'icon' => $sysPathIcon32.'/dashboard.png',
];
$adminmenu[] = [
    'title' => \_MI_WGFAKER_ADMENU2,
    'link' => 'admin/table.php',
    'icon' => 'assets/icons/32/table.png',
];
$adminmenu[] = [
    'title' => \_MI_WGFAKER_ADMENU3,
    'link' => 'admin/field.php',
    'icon' => 'assets/icons/32/field.png',
];
$adminmenu[] = [
    'title' => \_MI_WGFAKER_ADMENU5,
    'link' => 'admin/date.php',
    'icon' => 'assets/icons/32/date.png',
];
$adminmenu[] = [
    'title' => \_MI_WGFAKER_ADMENU4,
    'link' => 'admin/datatype.php',
    'icon' => 'assets/icons/32/datatype.png',
];
$adminmenu[] = [
    'title' => \_MI_WGFAKER_ADMENU20,
    'link' => 'admin/clone.php',
    'icon' => $sysPathIcon32.'/page_copy.png',
];
$adminmenu[] = [
    'title' => \_MI_WGFAKER_ADMENU21,
    'link' => 'admin/feedback.php',
    'icon' => $sysPathIcon32.'/mail_foward.png',
];
$adminmenu[] = [
    'title' => \_MI_WGFAKER_ABOUT,
    'link' => 'admin/about.php',
    'icon' => $sysPathIcon32.'/about.png',
];
