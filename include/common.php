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
if (!\defined('XOOPS_ICONS32_PATH')) {
    \define('XOOPS_ICONS32_PATH', \XOOPS_ROOT_PATH . '/Frameworks/moduleclasses/icons/32');
}
if (!\defined('XOOPS_ICONS32_URL')) {
    \define('XOOPS_ICONS32_URL', \XOOPS_URL . '/Frameworks/moduleclasses/icons/32');
}
\define('WGFAKER_DIRNAME', 'wgfaker');
\define('WGFAKER_PATH', \XOOPS_ROOT_PATH . '/modules/' . \WGFAKER_DIRNAME);
\define('WGFAKER_URL', \XOOPS_URL . '/modules/' . \WGFAKER_DIRNAME);
\define('WGFAKER_ICONS_PATH', \WGFAKER_PATH . '/assets/icons');
\define('WGFAKER_ICONS_URL', \WGFAKER_URL . '/assets/icons');
\define('WGFAKER_IMAGE_PATH', \WGFAKER_PATH . '/assets/images');
\define('WGFAKER_IMAGE_URL', \WGFAKER_URL . '/assets/images');
\define('WGFAKER_UPLOAD_PATH', \XOOPS_UPLOAD_PATH . '/' . \WGFAKER_DIRNAME);
\define('WGFAKER_UPLOAD_URL', \XOOPS_UPLOAD_URL . '/' . \WGFAKER_DIRNAME);
\define('WGFAKER_UPLOAD_FILES_PATH', \WGFAKER_UPLOAD_PATH . '/files');
\define('WGFAKER_UPLOAD_FILES_URL', \WGFAKER_UPLOAD_URL . '/files');
\define('WGFAKER_UPLOAD_IMAGE_PATH', \WGFAKER_UPLOAD_PATH . '/images');
\define('WGFAKER_UPLOAD_IMAGE_URL', \WGFAKER_UPLOAD_URL . '/images');
\define('WGFAKER_UPLOAD_YAML_PATH', \WGFAKER_UPLOAD_PATH . '/yaml');
\define('WGFAKER_UPLOAD_YAML_URL', \WGFAKER_UPLOAD_URL . '/yaml');
\define('WGFAKER_ADMIN', \WGFAKER_URL . '/admin/index.php');
$localLogo = \WGFAKER_IMAGE_URL . '/goffy-wedega_logo.png';
// Module Information
$copyright = "<a href='https://xoops.wedega.com' title='XOOPS Project on Wedega' target='_blank'><img src='" . $localLogo . "' alt='XOOPS Project on Wedega' ></a>";
require_once \XOOPS_ROOT_PATH . '/class/xoopsrequest.php';
require_once \WGFAKER_PATH . '/include/functions.php';
