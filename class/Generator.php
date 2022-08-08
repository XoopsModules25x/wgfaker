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

    /**
     * @var string
     */
    private $param = '';

    /**
     * @var int
     */
    private $id = 0;

    //Constructor
    public function __construct()
    {
    }

    /**
     * Set private var
     * @param $type
     * @return null
     */
    public function setType ($type) {
        $this->type = $type;
    }

    /**
     * Set private var
     * @param $param
     * @return null
     */
    public function setParam ($param) {
        $this->param = $param;
    }

    /**
     * Set private var
     * @param $id
     * @return null
     */
    public function setId ($id) {
        $this->id = $id;
    }

    /**
     * Render test data
     * @return mixed
     */
    public function renderer() {
        //reset ranges
        $this->rangeFrom = 0;
        $this->rangeTo = 0;
        //check type and render data
        switch ($this->type) {
            case Constants::DATATYPE_TEXT:
                return $this->renderText();
            case Constants::DATATYPE_INTEGER:
                if (0 === $this->rangeFrom) {
                    $this->rangeFrom = 1;
                }
                if (0 === $this->rangeTo) {
                    $this->rangeTo = 2000;
                }
                return $this->renderInteger();
            case Constants::DATATYPE_INT_RANGE:
                $paramsArr = \explode('|', $this->param);
                if (\count($paramsArr) > 1) {
                    $this->rangeFrom = $paramsArr[0];
                    $this->rangeTo = $paramsArr[1];
                }
                return $this->renderInteger();
            case Constants::DATATYPE_FLOAT:
                if (0 === $this->rangeFrom) {
                    $this->rangeFrom = 100;
                }
                if (0 === $this->rangeTo) {
                    $this->rangeTo = 100000;
                }
                return $this->renderFloat();
            case Constants::DATATYPE_YESNO:
                return $this->renderYesNo();
            case Constants::DATATYPE_LOREMIPSUM:
                return $this->renderLoremIpsum();
            case Constants::DATATYPE_LOREMIPSUM_SHORT:
                return $this->renderLoremIpsumShort();
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
                if (0 === $this->rangeFrom) {
                    $this->rangeFrom = (\time() - 365 * 24 * 60 * 60);
                }
                if (0 === $this->rangeTo) {
                    $this->rangeTo = \time();
                }
                return $this->renderDate();
            case Constants::DATATYPE_DATE_RANGE:
                $paramsArr = \explode('|', $this->param);
                if (\count($paramsArr) > 1) {
                    $this->rangeFrom = $paramsArr[0];
                    $this->rangeTo = $paramsArr[1];
                }
                return $this->renderDate();
            case Constants::DATATYPE_DATE_NOW:
                return \time();
            case Constants::DATATYPE_UID:
                return $this->renderUid();
            case Constants::DATATYPE_IP4:
                return $this->renderIP4();
            case Constants::DATATYPE_IP6:
                return $this->renderIP6();
            case Constants::DATATYPE_PHONE:
                return $this->renderPhone();
            case Constants::DATATYPE_TABLE_ID:
                return $this->renderTableId();
            case Constants::DATATYPE_PARENT_ID:
                return $this->renderParentId();
            case Constants::DATATYPE_INT_FIXED:
            case Constants::DATATYPE_TEXT_FIXED:
                return $this->param;
            case Constants::DATATYPE_TEXT_RUNNING:
                return $this->param . ' ' . $this->id;
            case Constants::DATATYPE_COUNTRY_CODE:
                return $this->renderCountryCode();
            case Constants::DATATYPE_IMAGE:
                return "'blank.gif'";
            case Constants::DATATYPE_FILE:
                return "'myfile.txt'";
            case Constants::DATATYPE_COLOR:
                return $this->renderColor();
            case Constants::DATATYPE_LANG_CODE:
                return $this->renderLangCode();
            case Constants::DATATYPE_UUID:
                return "'" . \Xmf\Uuid::generate() . "'";
            case Constants::DATATYPE_CUSTOM_LIST:
                return $this->renderCustomList();
            case Constants::DATATYPE_AUTOINCREMENT:
            case Constants::DATATYPE_INT_RUNNING:
                return $this->id;
            case 0:
            default:
                return '{missing function ' . $this->type . '}';
        }
    }

    /**
     * Get random country code
     * @param null
     * @return string
     */
    private function renderCountryCode()
    {
        $countryArray = \XoopsLists::getCountryList();

        return "'" . array_rand($countryArray) . "'";
    }

    /**
     * Get random language
     * @param null
     * @return string
     */
    private function renderLangCode()
    {
        $langArray = \XoopsLists::getLangList();

        return "'" . array_rand($langArray) . "'";
    }

    /**
     * Get random color
     * @param null
     * @return string
     */
    private function renderColor()
    {
        $colors = [];
        $colors[] = '#ffff00'; //yellow
        $colors[] = '#ff9900'; //orange
        $colors[] = '#ff0000'; //red
        $colors[] = '#0033ff'; //blue
        $colors[] = '#00ff00'; //green

        return "'" . $colors[\random_int(0, 4)] . "'";
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
            $ret .= $characters[\random_int(0, \strlen($characters)-1)];
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
        return \random_int($this->rangeFrom, $this->rangeTo);
    }

    /**
     * Get random Float
     * @param null
     * @return float
     */
    private function renderFloat()
    {
        return \random_int($this->rangeFrom, $this->rangeTo)/100;
    }

    /**
     * Get random yes/no
     * @param null
     * @return int
     */
    private function renderYesNo()
    {
        return \random_int(0, 1);
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
     * Get short Lorem Impsum
     * @param null
     * @return string
     */
    private function renderLoremIpsumShort()
    {
        $helper = Helper::getInstance();
        $datatypeHandler = $helper->getHandler('Datatype');
        $ret = $datatypeHandler->get(Constants::DATATYPE_LOREMIPSUM_SHORT)->getVar('values');

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
        $ret = $firstNames[\random_int(0, $maxItems - 1)];

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
        $ret = $lastNames[\random_int(0, $maxItems - 1)];

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
        $ret = $firstNames[\random_int(0, $maxItems - 1)];

        $lastNames = \explode('|', $datatypeHandler->get(Constants::DATATYPE_LASTNAME)->getVar('values'));
        $maxItems = \count($lastNames);
        $ret .= ' ' . $lastNames[\random_int(0, $maxItems - 1)];

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
        $firstname = \mb_strtolower($firstNames[\random_int(0, $maxItems - 1)]);

        $lastNames = \explode('|', $datatypeHandler->get(Constants::DATATYPE_LASTNAME)->getVar('values'));
        $maxItems = \count($lastNames);
        $lastname = \mb_strtolower($lastNames[\random_int(0, $maxItems - 1)]);

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
        $maxItems = \count($values) ;
        $ret = $values[\random_int(0, $maxItems - 1)];

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
        $ret = $values[\random_int(0, $maxItems - 1)];

        return "'" . $ret . "'";
    }

    /**
     * Get random date
     * @param null
     * @return int
     */
    private function renderDate()
    {
        return \random_int($this->rangeFrom, $this->rangeTo);
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
        $count = 0;
        while (false !== (list($users[]) = $GLOBALS['xoopsDB']->fetchRow($result))) {
            $count++;
        }

        return $users[\random_int(0, $count - 1)];
    }

    /**
     * Get random ip4
     * @param null
     * @return string
     */
    private function renderIP4()
    {
        $ret = \random_int(1, 255) . '.' . \random_int(1, 255) . '.' . \random_int(1, 255) . '.' . \random_int(1, 255);
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
        $ret = '+' . \random_int(1, 9) . \random_int(1, 9) . ' ' . \random_int(1, 9) . \random_int(1, 9) . \random_int(1, 9) . \random_int(1, 9) . \random_int(1, 9) . \random_int(1, 9) . \random_int(1, 9) . \random_int(1, 9);
        return "'" . $ret . "'";
    }

    /**
     * Get random value of table field
     * @param null
     * @return int
     */
    private function renderTableId()
    {
        $helper = Helper::getInstance();
        $tableHandler = $helper->getHandler('Table');
        $crTable = new \CriteriaCompo();
        $crTable->add(new \Criteria('name', $this->param));
        if ($tableHandler->getCount($crTable) > 0) {
            $tableAll = $tableHandler->getAll($crTable);
            foreach ($tableAll as $table) {
                return \random_int(1, $table->getVar('lines'));
            }
        }
        unset($crTable, $tableAll);
        
        return 0;
    }

    /**
     * Get random value of table field
     * @param null
     * @return int
     */
    private function renderParentId()
    {
        $helper = Helper::getInstance();
        $tableHandler = $helper->getHandler('Table');
        $crTable = new \CriteriaCompo();
        $crTable->add(new \Criteria('name', $this->param));
        if ($tableHandler->getCount($crTable) > 0) {
            $tableAll = $tableHandler->getAll($crTable);
            foreach ($tableAll as $table) {
                //minimum each second item should be top level
                if (0 === (int)\fmod($this->id, 2)){
                    return 0;
                }
                return \random_int(0, $table->getVar('lines'));
            }
        }
        unset($crTable, $tableAll);

        return 0;
    }

    /**
     * Get random value of custom list
     * @param null
     * @return string
     */
    private function renderCustomList()
    {
        $paramsArr = \explode('|', $this->param);
        if (\count($paramsArr) > 1) {
            $maxItems = \count($paramsArr);
            $ret = $paramsArr[\random_int(0, $maxItems - 1)];
            return "'" . $ret . "'";
        }
        return '';
    }

}
