<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Jack
 * Date: 19/07/13
 * Time: 1:51 PM
 * To change this template use File | Settings | File Templates.
 */
$config = new Zend_Config_Ini(APP_DIR . DS . 'Configs' . DS . 'application.ini', APPLICATION_ENV);
Zend_Registry::set('config', $config);

$master_db = Zend_Db::factory($config->database);
Zend_Db_Table_Abstract::setDefaultAdapter($master_db);
Zend_Registry::set('master_db', $master_db);

Zend_Layout::startMvc(array(
    'layout' => 'layout',
    'layoutPath' => APP_DIR . DS . 'Layouts' . DS . 'Scripts',
    'contentKey' => 'content',
));
$router     = new Zend_Controller_Router_Rewrite();
$front      = Zend_Controller_Front::getInstance();
$front->setControllerDirectory(APP_DIR . DS .'Controllers')
    ->setRouter($router)
    ->setBaseUrl(BASE_URL)
    ->setParam('useDefaultControllerAlways', false);
$front->throwExceptions(true);
$front->dispatch();