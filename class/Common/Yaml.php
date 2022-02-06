<?php

namespace XoopsModules\Wgfaker\Common;

/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

/**
 * Class to compare current DB table structure with sql/mysql.sql
 *
 * @category  Yaml
 * @author    Goffy <webmmaster@wedega.com>
 * @copyright 2021 XOOPS Project (https://xoops.org)
 * @license   GNU GPL 2 or later (https://www.gnu.org/licenses/gpl-2.0.html)
 * @link      https://xoops.org
 */

class Yaml
{

    /**
     * @var string
     */
    private $fileYaml;


    /**
     * @param string $fileYaml
     */
    public function __construct(string $fileYaml)
    {
        $this->fileYaml = $fileYaml;
    }

    /**
     * Create a yaml file based on an array
     *
     * @param array $yamlLines
     * @return bool
     */
    public function createFile($yamlLines)
    {
        // create new file and write schema array into this file
        $yamlFile = \fopen($this->fileYaml, "w");
        if (false == $yamlFile || \is_null($yamlFile)) {
            \xoops_error('Error: Unable to open yaml file!');
            return false;
        }
        foreach ($yamlLines as $line) {
            \fwrite($yamlFile, $line);
        }
        \fclose($yamlFile);

        return true;
    }

    /**
     * Create a yaml file based on a sql file
     *
     * @param null
     * @return array|bool
     */
    public function parseFileToArray()
    {
        if (!\file_exists($this->fileYaml)) {
            \xoops_error('Error: Yaml file not found!');
            return false;
        }

        $values    = [];

        // read yaml file
        $lines = \file($this->fileYaml);

        // remove unnecessary lines
        foreach ($lines as $key => $value) {
            $line = \trim($value);
            // remove blank lines
            if ('' === $line) {
                unset($lines[$key]);
            }
        }

        // read lines
        $i = 0;
        foreach ($lines as $value) {
            $line = \trim($value);
            // remove blank lines
            if ('-' === $line) {
                $i++;
            } else {
                $lineArr = $this->splitLine($line);
                if (\is_array($lineArr)) {
                    if (1 == $i) {
                        $values['columns'][] = $lineArr['column'];
                    }
                    $values['values'][$i][$lineArr['column']] = $lineArr['value'];
                }
            }

        }

        return $values;
    }

    /**
     * Extract columns and value from given line
     *
     * @param  string $line
     * @return array|bool
     */
    private function splitLine (string $line)
    {
        $arrValue = [];
        $lineArr = \explode( ':', $line);
        if (\count($lineArr) > 0) {
            $arrValue['column'] = $lineArr[0];
            $arrValue['value'] = $lineArr[1];
            return $arrValue;
        }

        return false;

    }
}
