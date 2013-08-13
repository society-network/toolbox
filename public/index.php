<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Jack
 * Date: 19/07/13
 * Time: 1:53 PM
 * To change this template use File | Settings | File Templates.
 */

date_default_timezone_set('Australia/Sydney');

defined('APPLICATION_ENV') || define('APPLICATION_ENV', (
    getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production')
);
define('DS', DIRECTORY_SEPARATOR);
$base_dir = DS . 'xampp' . DS . 'htdocs' . DS . 'toolbox';
$lib_dir = $base_dir . DS . 'library';
$pub_dir = $base_dir .DS . 'public';
$app_dir = $base_dir .DS . 'application';
$data_dir = $base_dir .DS . 'data';
define('BASE_DIR', $base_dir);
define('LIB_DIR', $lib_dir);
define('PUB_DIR', $pub_dir);
define('APP_DIR', $app_dir);
define('DATA_DIR', $data_dir);
define('BASE_URL', '/toolbox');

ini_set('include_path', ini_get('include_path') . PATH_SEPARATOR . LIB_DIR);
require_once('Zend' . DS . 'Loader.php');
Zend_Loader::registerAutoload();
require_once(APP_DIR . DS . 'Bootstrap.php');