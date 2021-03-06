<?php
/**
 * @see       https://github.com/zendframework/ZendService_Amazon for the canonical source repository
 * @copyright Copyright (c) 2005-2017 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   https://github.com/zendframework/ZendService_Amazon/blob/master/LICENSE.md New BSD License
 */

/*
 * Set error reporting to the level to which Zend Framework code must comply.
 */
error_reporting(E_ALL | E_STRICT);


/**
 * Setup autoloading
 */
if (! file_exists(__DIR__ . '/../vendor/autoload.php')) {
    throw new RuntimeException('This component has dependencies that are unmet.

Please install composer (http://getcomposer.org), and run the following
command in the root of this project:

    php /path/to/composer.phar install

After that, you should be able to run tests.');
}

include_once __DIR__ . '/../vendor/autoload.php';

/*
 * Load the user-defined test configuration file, if it exists; otherwise, load
 * the default configuration.
 */
if (is_readable(__DIR__ . '/TestConfiguration.php')) {
    require_once __DIR__ . '/TestConfiguration.php';
} else {
    require_once __DIR__ . '/TestConfiguration.php.dist';
}
