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

/**
 * Interface  Constants
 */
interface Constants
{
    // Constants for tables
    public const TABLE_FIELD = 0;
    public const TABLE_DATATYPE = 1;
    public const TABLE_TABLE = 2;

    // Constants for status
    public const STATUS_NONE      = 0;
    public const STATUS_OFFLINE   = 1;
    public const STATUS_SUBMITTED = 2;
    public const STATUS_APPROVED  = 3;
    public const STATUS_BROKEN    = 4;

    // Constants for status
    public const DATATYPE_NONE          = 0;
    public const DATATYPE_AUTOINCREMENT = 1;
    public const DATATYPE_INTEGER       = 2;
    public const DATATYPE_FLOAT         = 3;
    public const DATATYPE_TEXT          = 4;
    public const DATATYPE_YESNO         = 5;
    public const DATATYPE_LOREMIPSUM    = 6;
    public const DATATYPE_FIRSTNAME     = 7;
    public const DATATYPE_LASTNAME      = 8;
    public const DATATYPE_FIRSTLASTNAME = 9;
    public const DATATYPE_EMAIL         = 10;
    public const DATATYPE_CITY          = 11;
    public const DATATYPE_STATE         = 12;
    public const DATATYPE_DATE          = 13;
    public const DATATYPE_UID           = 14;
    public const DATATYPE_IP4           = 15;
    public const DATATYPE_IP6           = 16;
    public const DATATYPE_PHONE         = 17;
    public const DATATYPE_COUNTRY_CODE  = 18;
    public const DATATYPE_IMAGE         = 19;
    public const DATATYPE_ID_OF_TABLE   = 20;
    //public const DATATYPE_ID_OF_MODULE  = 21;
    public const DATATYPE_INTEGER_1     = 22;



}
