<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Jack
 * Date: 19/07/13
 * Time: 1:53 PM
 * To change this template use File | Settings | File Templates.
 */

$base_dir = DIRECTORY_SEPARATOR . 'xampp' . DIRECTORY_SEPARATOR . 'htdocs' . DIRECTORY_SEPARATOR . 'toolbox';
$lib_dir = $base_dir . DIRECTORY_SEPARATOR . 'library';
$pub_dir = $base_dir .DIRECTORY_SEPARATOR . 'public';
$app_dir = $base_dir .DIRECTORY_SEPARATOR . 'application';
$data_dir = $base_dir .DIRECTORY_SEPARATOR . 'data';
define('BASE_DIR', $base_dir);
define('LIB_DIR', $lib_dir);
define('PUB_DIR', $pub_dir);
define('APP_DIR', $app_dir);
define('DATA_DIR', $data_dir);
define('BASE_URL', '/toolbox');

ini_set('include_path', ini_get('include_path') . PATH_SEPARATOR . LIB_DIR);
require_once('Zend' . DIRECTORY_SEPARATOR . 'Loader.php');
Zend_Loader::registerAutoload();
require_once(APP_DIR . DIRECTORY_SEPARATOR . 'Bootstrap.php');