<?php

namespace XoopsModules\Wgfaker;

/**
 *  WGFAKER - MODULE FOR XOOPS
 *  Copyright (c) 2007 - 2012
 *  Goffy ( wedega.com )
 *
 *  You may not change or alter any portion of this comment or credits
 *  of supporting developers from this source code or any supporting
 *  source code which is considered copyrighted (c) material of the
 *  original comment or credit authors.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *  ---------------------------------------------------------------------------
 * @copyright  Goffy ( wedega.com )
 * @license    GPL 2.0
 * @package    wgfaker
 * @author     Goffy ( webmaster@wedega.com )
 *
 * ****************************************************************************
 */

use XoopsModules\Wgfaker\Helper;

/**
 * Class Generator
 */
class Generator
{
    /**
     * @var int
     */
    private $type = 0;

    /**
     * @var int
     */
    private $rangeFrom = 0;

    /**
     * @var int
     */
    private $rangeTo = 0;

    //Constructor
    public function __construct($type, $rangeFrom = 0, $rangeTo = 0)
    {
        $this->type = $type;
        $this->rangeFrom = $rangeFrom;
        $this->rangeTo = $rangeTo;
    }

    /**
     * Render test data
     * @return mixed
     */
    public function renderer() {
        switch ($this->type) {
            case Constants::DATATYPE_TEXT:
                return $this->renderText();
            //case Constants::DATATYPE_AUTOINCREMENT:
            case Constants::DATATYPE_INTEGER:
                return $this->renderInteger();
            case Constants::DATATYPE_FLOAT:
                return $this->renderFloat();
            case Constants::DATATYPE_YESNO:
                return $this->renderYesNo();
            case Constants::DATATYPE_LOREMIPSUM:
                return $this->renderLoremIpsum();
            case Constants::DATATYPE_FIRSTNAME:
                return $this->renderFirstname();
            case Constants::DATATYPE_LASTNAME:
                return $this->renderLastname();
            case Constants::DATATYPE_FIRSTLASTNAME:
                return $this->renderFirstLastname();
            case Constants::DATATYPE_EMAIL:
                return $this->renderEmail();
            case Constants::DATATYPE_CITY:
                return $this->renderCity();
            case Constants::DATATYPE_STATE:
                return $this->renderState();
            case Constants::DATATYPE_DATE:
                $this->rangeFrom = (\time() - 365 * 24 * 60 * 60);
                $this->rangeTo = \time();
                return $this->renderDate();
            case Constants::DATATYPE_UID:
                return $this->renderUid();
            case Constants::DATATYPE_IP4:
                return $this->renderIP4();
            case Constants::DATATYPE_IP6:
                return $this->renderIP6();
            case Constants::DATATYPE_PHONE:
                return $this->renderPhone();
            case Constants::DATATYPE_ID_OF_TABLE:
                return $this->renderIdOfTable();
            case Constants::DATATYPE_INTEGER_1:
                return '1';
            case Constants::DATATYPE_COUNTRY_CODE:
                //return $this->renderCountryCode();
            case Constants::DATATYPE_IMAGE:
                //return $this->renderImage();
            case 0:
            default:
                return '{missing function}';
        }
    }

    /**
     * Get random Text
     * @param null
     * @return string
     */
    private function renderText()
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $ret = '';
        for ($i = 0; $i < 10; $i++) {
            $ret .= $characters[random_int(0, \strlen($characters))];
        }
        return "'" . $ret . "'";
    }

    /**
     * Get random Integer
     * @param null
     * @return int
     */
    private function renderInteger()
    {
        return random_int(1, 10000);
    }

    /**
     * Get random Float
     * @param null
     * @return int
     */
    private function renderFloat()
    {
        return random_int(1, 10000)/100;
    }

    /**
     * Get random yes/no
     * @param null
     * @return int
     */
    private function renderYesNo()
    {
        return random_int(0, 1);
    }

    /**
     * Get Lorem Impsum
     * @param null
     * @return string
     */
    private function renderLoremIpsum()
    {
        $helper = Helper::getInstance();
        $datatypeHandler = $helper->getHandler('Datatype');
        $ret = $datatypeHandler->get(Constants::DATATYPE_LOREMIPSUM)->getVar('values');

        return "'" . $ret . "'";
    }

    /**
     * Get random firstname
     * @param null
     * @return string
     */
    private function renderFirstname()
    {
        $helper = Helper::getInstance();
        $datatypeHandler = $helper->getHandler('Datatype');
        $firstNames = \explode('|', $datatypeHandler->get(Constants::DATATYPE_FIRSTNAME)->getVar('values'));
        $maxItems = \count($firstNames);
        $ret = $firstNames[random_int(1, $maxItems)];

        return "'" . $ret . "'";
    }

    /**
     * Get random firstname
     * @param null
     * @return string
     */
    private function renderLastname()
    {
        $helper = Helper::getInstance();
        $datatypeHandler = $helper->getHandler('Datatype');
        $lastNames = \explode('|', $datatypeHandler->get(Constants::DATATYPE_LASTNAME)->getVar('values'));
        $maxItems = \count($lastNames);
        $ret = $lastNames[random_int(1, $maxItems)];

        return "'" . $ret . "'";
    }

    /**
     * Get random firstname
     * @param null
     * @return string
     */
    private function renderFirstLastname()
    {
        $helper = Helper::getInstance();
        $datatypeHandler = $helper->getHandler('Datatype');

        $firstNames = \explode('|', $datatypeHandler->get(Constants::DATATYPE_FIRSTNAME)->getVar('values'));
        $maxItems = \count($firstNames);
        $ret = $firstNames[random_int(1, $maxItems)];

        $lastNames = \explode('|', $datatypeHandler->get(Constants::DATATYPE_LASTNAME)->getVar('values'));
        $maxItems = \count($lastNames);
        $ret .= ' ' . $lastNames[random_int(1, $maxItems)];

        return "'" . $ret . "'";
    }

    /**
     * Get random firstname
     * @param null
     * @return string
     */
    private function renderEmail()
    {
        $helper = Helper::getInstance();
        $datatypeHandler = $helper->getHandler('Datatype');

        $firstNames = \explode('|', $datatypeHandler->get(Constants::DATATYPE_FIRSTNAME)->getVar('values'));
        $maxItems = \count($firstNames);
        $firstname = \mb_strtolower($firstNames[random_int(1, $maxItems)]);

        $lastNames = \explode('|', $datatypeHandler->get(Constants::DATATYPE_LASTNAME)->getVar('values'));
        $maxItems = \count($lastNames);
        $lastname = \mb_strtolower($lastNames[random_int(1, $maxItems)]);

        $domain = $datatypeHandler->get(Constants::DATATYPE_EMAIL)->getVar('values', 'e');
        $ret = \str_replace(['{firstname}', '{lastname}'], [$firstname, $lastname], $domain);

        return "'" . $ret . "'";
    }

    /**
     * Get random city
     * @param null
     * @return string
     */
    private function renderCity()
    {
        $helper = Helper::getInstance();
        $datatypeHandler = $helper->getHandler('Datatype');
        $values = \explode('|', $datatypeHandler->get(Constants::DATATYPE_CITY)->getVar('values'));
        $maxItems = \count($values);
        $ret = $values[random_int(1, $maxItems)];

        return "'" . $ret . "'";
    }

    /**
     * Get random state
     * @param null
     * @return string
     */
    private function renderState()
    {
        $helper = Helper::getInstance();
        $datatypeHandler = $helper->getHandler('Datatype');
        $values = \explode('|', $datatypeHandler->get(Constants::DATATYPE_STATE)->getVar('values'));
        $maxItems = \count($values);
        $ret = $values[random_int(1, $maxItems)];

        return "'" . $ret . "'";
    }

    /**
     * Get random date
     * @param null
     * @return int
     */
    private function renderDate()
    {
        return random_int($this->rangeFrom, $this->rangeTo);
    }

    /**
     * Get random uid of existing uids
     * @param null
     * @return int
     */
    private function renderUid()
    {
        $sql = 'SELECT `uid` FROM `' . $GLOBALS['xoopsDB']->prefix('users') . '` WHERE `uid` < 100;';
        $result = $GLOBALS['xoopsDB']->queryf($sql);

        if (!$result instanceof \mysqli_result) {
            \trigger_error($GLOBALS['xoopsDB']->error());
        }
        $users = [];
        while (false !== (list($users[]) = $GLOBALS['xoopsDB']->fetchRow($result))) {}
        $maxItems = $GLOBALS['xoopsDB']->getRowsNum($result);

        return $users[random_int(0, $maxItems - 1)];
    }

    /**
     * Get random ip4
     * @param null
     * @return string
     */
    private function renderIP4()
    {
        $ret = random_int(1, 255) . '.' . random_int(1, 255) . '.' . random_int(1, 255);
        return "'" . $ret . "'";
    }

    /**
     * Get random ip6
     * @param null
     * @return string
     */
    private function renderIP6()
    {
        $prefix = "2a04:5200:8";
        $a = $this->generate_ipv6_block();
        $b = $this->generate_ipv6_block();
        $c = $this->generate_ipv6_block();
        $d = $this->generate_ipv6_block();
        $e = $this->generate_ipv6_block();

        return "'{$prefix}:{$a}:{$b}:{$c}:{$d}:{$e}'";
    }
    private function generate_ipv6_block() {
        $seed = \str_split('1234567890abcdef');
        \shuffle($seed);
        $block = \implode("", $seed); // Symbol array to string
        $block = \substr($block, 0, 4);
        return $block;
    }

    /**
     * Get random phone
     * @param null
     * @return string
     */
    private function renderPhone()
    {
        $ret = '+' . random_int(1, 9) . random_int(1, 9) . ' ' . random_int(1, 9) . random_int(1, 9) . random_int(1, 9) . random_int(1, 9) . random_int(1, 9) . random_int(1, 9) . random_int(1, 9) . random_int(1, 9);
        return "'" . $ret . "'";
    }

    /**
     * Get random integer between 1 and config value for 'numb_lines'
     * @param null
     * @return int
     */
    private function renderIdOfTable()
    {
        $helper = Helper::getInstance();

        return random_int(1, $helper->getConfig('numb_lines'));
    }

}
