![alt XOOPS CMS](https://xoops.org/images/logoXoops4GithubRepository.png)

![alt XOOPS CMS](https://xoops.org/images/logoXoopsPhp8.png)

## wgFaker version 1.x

[![Build Status](https://scrutinizer-ci.com/g/ggoffy/wgfaker/badges/build.png?b=master)](https://travis-ci.org/ggoffy/wgfaker)
[![Jenkins coverage](https://img.shields.io/jenkins/c/https/jenkins.qa.ubuntu.com/address-book-service-utopic-i386-ci.svg)](https://github.com/XoopsModules25x/wgfaker)
[![Software License](https://img.shields.io/badge/license-GPL-brightgreen.svg?style=flat)](docs/license.txt)
[![Quality Score](https://img.shields.io/scrutinizer/g/ggoffy/wgblocks.svg?style=flat)](https://scrutinizer-ci.com/g/ggoffy/wgfaker)
[![Gem](https://img.shields.io/gem/dt/rails.svg)](XoopsModules25x/wgfaker)
[![Latest Version](https://img.shields.io/github/release/XoopsModules25x/wgfaker.svg?style=flat)](https://github.com/XoopsModules25x/wgfaker/releases/latest)

# wgFaker

![module image](./assets/images/wgfaker.jpg)

A XOOPS module for generation of faked test data.

Features:
- Read tables and fields
- Based on field type the module makes a pre-selection of possible datatype (= output type)
- You can change the datatype in order to get the data you wish
  - examples of datatypes:
    - autoincrement of table
    - random integer
    - random integer within defined range
    - running integer, start with 1
    - fixed defined number
    - random float
    - random text
    - fixed defined text
    - your defined text with running number
    - random yes/no
    - random firstname
    - random lastname
    - random email
    - random date
    - random date within defined range
    - current date
    - random uid of XOOPS users
    - random IP4
    - random IP6
    - random phone number
    - random country code
    - random id of selected table
    - random color
    - random uuid
    - random language
    - random value of custom list
- Generate test data according the (pre)settings
- View test data as table or yaml
- Copy test data into 'modules/{modulename}/testdata/{language}' and load them in module
- Update date fields directly in the tables


## Support

If you like the wgFaker module and thanks to the long process for giving the opportunity to the new module to be created in a moment, consider making a donation to <a href="https://xoops.org/modules/xdonations/" target="_blank" title="Donate to Xoops">Xoops.org</a>

## Require:
- XOOPS 2.5.11;
- XOOPS Admin 1.2;
- PHP 7.4 or higher;
- MySQL 5.5; -> Minimum Recommended Using InnoDB Version 5.1 or Later

## Info

**wgFaker is ready for PHP 8.0**

### Tutorial:
For detailed tutorial see help section in module.

### Translation:
[![Translations on Transifex](https://xoops.org/images/translations-transifex-blue.svg)](https://www.transifex.com/xoops)

Please visit us on https://xoops.org

Current and upcoming "next generation" versions of XOOPS CMS are being crafted on GitHub at: https://github.com/XOOPS
