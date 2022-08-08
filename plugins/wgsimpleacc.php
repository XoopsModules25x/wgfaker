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

/**
 * plugin to correct inconsistant data, created by generator
 *
 * @return bool
 */
function wgfaker_plugin_wgsimpleacc ()
{
    // correction 1: expenses should have only amount out
    $sql = 'UPDATE `' . $GLOBALS['xoopsDB']->prefix('wgsimpleacc_transactions') . "` SET `tra_amountin` = '0' WHERE `"  . $GLOBALS['xoopsDB']->prefix('wgsimpleacc_transactions') .  '`.`tra_class` = 2;';
    if (!$result = $GLOBALS['xoopsDB']->queryF($sql)) {
        \trigger_error($GLOBALS['xoopsDB']->error());
    }

    // correction 2: incomes should have only amount in
    $sql = 'UPDATE `' . $GLOBALS['xoopsDB']->prefix('wgsimpleacc_transactions') . "` SET `tra_amountout` = '0' WHERE `"  . $GLOBALS['xoopsDB']->prefix('wgsimpleacc_transactions') .  '`.`tra_class` = 3;';
    if (!$result = $GLOBALS['xoopsDB']->queryF($sql)) {
        \trigger_error($GLOBALS['xoopsDB']->error());
    }

    // correction 3: date of transaction should be ascending as transaction number
    // read all transactions in ascending order tra_datecreated
    $datesArr = [];
    $sql = 'SELECT `tra_datecreated`  FROM `' . $GLOBALS['xoopsDB']->prefix('wgsimpleacc_transactions') . '` ORDER BY `' . $GLOBALS['xoopsDB']->prefix('wgsimpleacc_transactions') . '`.`tra_datecreated` ASC';
    if ($result = $GLOBALS['xoopsDB']->queryF($sql)) {
        while (false !== ($data = $GLOBALS['xoopsDB']->fetchRow($result))) {
            $datesArr[] = $data[0];
        }
    } else {
        \trigger_error($GLOBALS['xoopsDB']->error());
    }
    // read all transactions in ascending order tra_id and set new dates
    $sql = 'SELECT `tra_id`  FROM `' . $GLOBALS['xoopsDB']->prefix('wgsimpleacc_transactions') . '` ORDER BY `' . $GLOBALS['xoopsDB']->prefix('wgsimpleacc_transactions') . '`.`tra_id` ASC';
    if ($result = $GLOBALS['xoopsDB']->queryF($sql)) {
        $counter = 0;
        while (false !== ($traId = $GLOBALS['xoopsDB']->fetchRow($result))) {
            $sql = 'UPDATE `' . $GLOBALS['xoopsDB']->prefix('wgsimpleacc_transactions') . "` SET `tra_date` = '" . $datesArr[$counter] . "', `tra_datecreated` = '" . $datesArr[$counter] . "' WHERE `"  . $GLOBALS['xoopsDB']->prefix('wgsimpleacc_transactions') .  '`.`tra_id` = ' . $traId[0] . ';';
            if (!$resultUpdate = $GLOBALS['xoopsDB']->queryF($sql)) {
                \trigger_error($GLOBALS['xoopsDB']->error());
            }
            $counter++;
        }
    } else {
        \trigger_error($GLOBALS['xoopsDB']->error());
    }
    // incomes should be higher than expenses
    $sql = 'UPDATE `' . $GLOBALS['xoopsDB']->prefix('wgsimpleacc_transactions') . "` SET `tra_amountin` = `tra_amountin` * 1.2 WHERE `"  . $GLOBALS['xoopsDB']->prefix('wgsimpleacc_transactions') .  '`.`tra_class` = 3;';
    if (!$result = $GLOBALS['xoopsDB']->queryF($sql)) {
        \trigger_error($GLOBALS['xoopsDB']->error());
    }
}